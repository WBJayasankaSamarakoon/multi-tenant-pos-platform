<?php

namespace App\Http\Controllers;

use App\Support\TenantContext;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class ManagerController extends Controller
{
    /**
     * Display the manager operational dashboard.
     */
    public function dashboard(): View
    {
        $ownerId = TenantContext::ownerId(Auth::user());
        abort_unless($ownerId, 403, 'Unauthorized tenant access.');

        $company = DB::table('owner_companies')->where('owner_user_id', $ownerId)->first();
        $sales = DB::table('owner_sales')->where('owner_user_id', $ownerId)->orderByDesc('sold_at')->get();

        return view('pos.manager.dashboard', [
            'company' => $company,
            'stats' => [
                'salesToday' => DB::table('owner_sales')->where('owner_user_id', $ownerId)->whereDate('sold_at', today())->sum('total'),
                'productsCount' => DB::table('owner_products')->where('owner_user_id', $ownerId)->count(),
                'lowStockItems' => DB::table('owner_products')->where('owner_user_id', $ownerId)->whereColumn('stock', '<=', 'low_stock_threshold')->count(),
                'ordersToday' => DB::table('owner_sales')->where('owner_user_id', $ownerId)->whereDate('sold_at', today())->count(),
            ],
            'salesSeries' => collect(range(6, 0))->map(function ($daysAgo) use ($sales) {
                $date = now()->subDays($daysAgo)->toDateString();
                return $sales->filter(fn ($sale) => Carbon::parse($sale->sold_at)->toDateString() === $date)->sum('total');
            }),
            'lowStockItems' => DB::table('owner_products')->where('owner_user_id', $ownerId)->whereColumn('stock', '<=', 'low_stock_threshold')->orderBy('stock')->limit(4)->get(),
            'recentSales' => $sales->take(3),
        ]);
    }

    /**
     * Display manager inventory list.
     */
    public function inventory(): View
    {
        $ownerId = TenantContext::ownerId(Auth::user());
        abort_unless($ownerId, 403, 'Unauthorized tenant access.');

        $company = DB::table('owner_companies')->where('owner_user_id', $ownerId)->first();
        $products = DB::table('owner_products')->where('owner_user_id', $ownerId)->orderBy('name')->get();

        return view('pos.manager.inventory', [
            'company' => $company,
            'products' => $products,
            'suppliers' => DB::table('owner_products')
                ->where('owner_user_id', $ownerId)
                ->select('supplier')
                ->whereNotNull('supplier')
                ->distinct()
                ->orderBy('supplier')
                ->pluck('supplier')
                ->values(),
        ]);
    }

    /**
     * Store new inventory item from manager view.
     */
    public function storeProduct(Request $request): RedirectResponse
    {
        $ownerId = TenantContext::ownerId(Auth::user());
        abort_unless($ownerId, 403, 'Unauthorized tenant access.');

        $data = $request->validate([
            'sku' => ['nullable', 'string', 'max:50'],
            'name' => ['required', 'string', 'max:255'],
            'category' => ['required', 'string', 'max:255'],
            'price' => ['required', 'numeric', 'min:0'],
            'stock' => ['required', 'integer', 'min:0'],
            'supplier' => ['nullable', 'string', 'max:255'],
        ]);

        DB::table('owner_products')->insert([
            'owner_user_id' => $ownerId,
            'sku' => $data['sku'] ?: 'P' . now()->timestamp,
            'name' => $data['name'],
            'category' => $data['category'],
            'price' => $data['price'],
            'stock' => $data['stock'],
            'low_stock_threshold' => 10,
            'supplier' => $data['supplier'] ?? null,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return back()->with('status', 'Product added successfully.');
    }

    /**
     * Display manager analytics and sales reports.
     */
    public function reports(): View
    {
        $ownerId = TenantContext::ownerId(Auth::user());
        abort_unless($ownerId, 403, 'Unauthorized tenant access.');

        $company = DB::table('owner_companies')->where('owner_user_id', $ownerId)->first();
        $sales = DB::table('owner_sales')->where('owner_user_id', $ownerId)->orderByDesc('sold_at')->get();

        return view('pos.manager.reports', [
            'company' => $company,
            'weeklyRevenue' => $sales->sum('total'),
            'avgDailySales' => $sales->count() ? $sales->avg('total') : 0,
            'itemsSold' => $sales->sum('items_count'),
            'salesSeries' => collect(range(6, 0))->map(function ($daysAgo) use ($sales) {
                $date = now()->subDays($daysAgo)->toDateString();
                return $sales->filter(fn ($sale) => Carbon::parse($sale->sold_at)->toDateString() === $date)->sum('total');
            }),
            'topProducts' => DB::table('owner_products')->where('owner_user_id', $ownerId)->orderByDesc('stock')->limit(5)->get(),
        ]);
    }

    /**
     * Display customer registry for manager view.
     */
    public function customers(): View
    {
        $ownerId = TenantContext::ownerId(Auth::user());
        abort_unless($ownerId, 403, 'Unauthorized tenant access.');

        $company = DB::table('owner_companies')->where('owner_user_id', $ownerId)->first();
        $customers = DB::table('owner_customers')
            ->where('owner_user_id', $ownerId)
            ->orderBy('name')
            ->get()
            ->map(function ($customer) use ($ownerId) {
                $salesStats = DB::table('owner_sales')
                    ->where('owner_user_id', $ownerId)
                    ->where('customer_name', $customer->name)
                    ->selectRaw('COUNT(*) as visit_count, SUM(total) as purchase_total')
                    ->first();

                if ($salesStats && $salesStats->visit_count > 0) {
                    $customer->visits = max((int) $customer->visits, (int) $salesStats->visit_count);
                    $customer->total_purchases = max((float) $customer->total_purchases, (float) $salesStats->purchase_total);
                }

                return $customer;
            });

        return view('pos.manager.customers', [
            'company' => $company,
            'customers' => $customers,
        ]);
    }
}
