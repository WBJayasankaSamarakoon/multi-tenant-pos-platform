<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class AdminController extends Controller
{
    public function dashboard(): View
    {
        $tenantRows = $this->tenantRows();
        $subscriptionRows = $this->subscriptionRows();
        $subscriptionCollection = collect($subscriptionRows);
        $ownerCount = DB::table('users')->where('role', 'owner')->count();
        $monthlyRevenue = DB::table('owner_subscription_payments')
            ->whereYear('paid_at', now()->year)
            ->whereMonth('paid_at', now()->month)
            ->sum('amount');

        return view('admin.dashboard', [
            'stats' => [
                'totalTenants' => $ownerCount,
                'activeSubscriptions' => $subscriptionCollection->where('status', 'Active')->count(),
                'monthlyRevenue' => $monthlyRevenue,
                'systemHealth' => $ownerCount > 0
                    ? round(($subscriptionCollection->where('status', 'Active')->count() / $ownerCount) * 100, 1)
                    : 0,
            ],
            'subscriptionStats' => [
                'monthlyRevenue' => $monthlyRevenue,
                'activePlans' => $subscriptionCollection->where('status', 'Active')->count(),
                'expiringSoon' => DB::table('owner_subscriptions')
                    ->whereNotNull('renews_at')
                    ->whereBetween('renews_at', [now()->toDateString(), now()->addDays(30)->toDateString()])
                    ->count(),
                'avgRevenuePerTenant' => $ownerCount > 0
                    ? round($subscriptionCollection->sum('amount') / $ownerCount, 2)
                    : 0,
            ],
            'tenantGrowth' => $this->tenantGrowth(),
            'planDistribution' => $this->planDistribution(),
            'revenueByPlan' => $this->revenueByPlan(),
            'recentRegistrations' => collect($tenantRows)->take(5)->values(),
        ]);
    }

    public function tenants(): View
    {
        return view('admin.tenants', [
            'tenants' => $this->tenantRows(),
        ]);
    }

    public function subscriptions(): View
    {
        $subscriptions = $this->subscriptionRows();
        $subscriptionCollection = collect($subscriptions);
        $ownerCount = DB::table('users')->where('role', 'owner')->count();
        $monthlyRevenue = DB::table('owner_subscription_payments')
            ->whereYear('paid_at', now()->year)
            ->whereMonth('paid_at', now()->month)
            ->sum('amount');

        return view('admin.subscriptions', [
            'subscriptions' => $subscriptions,
            'subscriptionStats' => [
                'monthlyRevenue' => $monthlyRevenue,
                'activePlans' => $subscriptionCollection->where('status', 'Active')->count(),
                'expiringSoon' => DB::table('owner_subscriptions')
                    ->whereNotNull('renews_at')
                    ->whereBetween('renews_at', [now()->toDateString(), now()->addDays(30)->toDateString()])
                    ->count(),
                'avgRevenuePerTenant' => $ownerCount > 0
                    ? round($subscriptionCollection->sum('amount') / $ownerCount, 2)
                    : 0,
            ],
            'revenueByPlan' => $this->revenueByPlan(),
        ]);
    }

    public function logs(): View
    {
        $logs = collect();

        foreach (DB::table('owner_sales')->orderByDesc('sold_at')->limit(5)->get() as $sale) {
            $logs->push([
                'timestamp' => Carbon::parse($sale->sold_at)->format('Y-m-d H:i:s'),
                'user' => $sale->customer_name ?? 'Walk-in Customer',
                'action' => 'Sale Completed',
                'details' => $sale->invoice_number . ' - LKR ' . number_format($sale->total),
                'type' => 'Transaction',
                'ip' => 'System',
            ]);
        }

        foreach (DB::table('owner_products')->orderByDesc('updated_at')->limit(5)->get() as $product) {
            $logs->push([
                'timestamp' => Carbon::parse($product->updated_at)->format('Y-m-d H:i:s'),
                'user' => 'Inventory Sync',
                'action' => 'Product Updated',
                'details' => $product->name . ' - ' . ($product->category ?? 'Uncategorized'),
                'type' => 'Inventory',
                'ip' => 'System',
            ]);
        }

        foreach (DB::table('owner_companies')->orderByDesc('created_at')->limit(5)->get() as $company) {
            $logs->push([
                'timestamp' => Carbon::parse($company->created_at)->format('Y-m-d H:i:s'),
                'user' => 'Platform Admin',
                'action' => 'Tenant Registered',
                'details' => $company->name,
                'type' => 'Admin',
                'ip' => 'System',
            ]);
        }

        return view('admin.system-logs', [
            'logs' => $logs->sortByDesc('timestamp')->values(),
            'types' => ['All', 'Transaction', 'Admin', 'Inventory'],
        ]);
    }

    private function tenantRows(): array
    {
        $employeesByOwner = DB::table('owner_employees')
            ->select('owner_user_id', DB::raw('count(*) as employees_count'))
            ->groupBy('owner_user_id')
            ->pluck('employees_count', 'owner_user_id');

        $productsByOwner = DB::table('owner_products')
            ->select('owner_user_id', DB::raw('count(*) as products_count'))
            ->groupBy('owner_user_id')
            ->pluck('products_count', 'owner_user_id');

        $tenants = DB::table('users')
            ->join('owner_companies', 'owner_companies.owner_user_id', '=', 'users.id')
            ->leftJoin('owner_subscriptions', 'owner_subscriptions.owner_user_id', '=', 'users.id')
            ->where('users.role', 'owner')
            ->orderByDesc('owner_companies.created_at')
            ->get([
                'users.id',
                'users.name as owner_name',
                'owner_companies.name as company_name',
                'owner_companies.address',
                'owner_companies.created_at',
                'owner_subscriptions.plan',
                'owner_subscriptions.status',
            ]);

        return $tenants->map(function ($tenant) use ($employeesByOwner, $productsByOwner) {
            return [
                'id' => 'T' . str_pad((string) $tenant->id, 3, '0', STR_PAD_LEFT),
                'name' => $tenant->company_name ?: $tenant->owner_name,
                'plan' => $tenant->plan ?? 'N/A',
                'status' => $tenant->status ?? 'Inactive',
                'users' => 1 + (int) ($employeesByOwner[$tenant->id] ?? 0),
                'products' => (int) ($productsByOwner[$tenant->id] ?? 0),
                'created' => Carbon::parse($tenant->created_at)->toDateString(),
                'location' => $tenant->address ?: '-',
            ];
        })->all();
    }

    private function subscriptionRows(): array
    {
        $rows = DB::table('owner_subscriptions')
            ->join('users', 'users.id', '=', 'owner_subscriptions.owner_user_id')
            ->join('owner_companies', 'owner_companies.owner_user_id', '=', 'users.id')
            ->orderByDesc('owner_subscriptions.updated_at')
            ->get([
                'owner_companies.name as company',
                'owner_subscriptions.plan',
                'owner_subscriptions.price',
                'owner_subscriptions.status',
                'owner_subscriptions.renews_at',
                'owner_subscriptions.created_at',
            ]);

        return $rows->map(function ($row) {
            return [
                'company' => $row->company,
                'plan' => $row->plan,
                'amount' => $row->price,
                'status' => $row->status,
                'nextBilling' => $row->renews_at ? Carbon::parse($row->renews_at)->toDateString() : '-',
                'startDate' => Carbon::parse($row->created_at)->toDateString(),
            ];
        })->all();
    }

    private function tenantGrowth(): array
    {
        $months = collect(range(5, 0))->map(function (int $offset) {
            $month = now()->subMonthsNoOverflow($offset);

            return [
                'label' => $month->format('M'),
                'value' => DB::table('owner_companies')
                    ->whereYear('created_at', $month->year)
                    ->whereMonth('created_at', $month->month)
                    ->count(),
            ];
        })->all();

        return $months;
    }

    private function planDistribution(): array
    {
        return DB::table('owner_subscriptions')
            ->select('plan', DB::raw('count(*) as total'))
            ->groupBy('plan')
            ->orderBy('plan')
            ->get()
            ->map(fn ($item) => [
                'name' => $item->plan,
                'value' => (int) $item->total,
                'color' => match ($item->plan) {
                    'Basic' => 'bg-gray-400',
                    'Pro' => 'bg-blue-500',
                    'Enterprise' => 'bg-purple-500',
                    default => 'bg-emerald-500',
                },
            ])
            ->all();
    }

    private function revenueByPlan(): array
    {
        return DB::table('owner_subscriptions')
            ->select('plan', DB::raw('sum(price) as revenue'))
            ->groupBy('plan')
            ->orderBy('plan')
            ->get()
            ->map(fn ($item) => [
                'plan' => $item->plan,
                'revenue' => (int) $item->revenue,
            ])
            ->all();
    }
}
