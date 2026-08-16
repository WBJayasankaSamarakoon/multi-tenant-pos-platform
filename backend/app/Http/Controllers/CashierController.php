<?php

namespace App\Http\Controllers;

use App\Support\TenantContext;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class CashierController extends Controller
{
    /**
     * Display the main POS billing screen for cashiers.
     */
    public function pos(): View
    {
        $ownerId = TenantContext::ownerId(Auth::user());
        abort_unless($ownerId, 403, 'Unauthorized tenant access.');

        return view('pos.cashier.pos', [
            'company' => DB::table('owner_companies')->where('owner_user_id', $ownerId)->first(),
            'products' => DB::table('owner_products')->where('owner_user_id', $ownerId)->orderBy('name')->get(),
            'customers' => DB::table('owner_customers')->where('owner_user_id', $ownerId)->orderBy('name')->get(),
        ]);
    }

    /**
     * Display recent sales history for the cashier.
     */
    public function history(): View
    {
        $ownerId = TenantContext::ownerId(Auth::user());
        abort_unless($ownerId, 403, 'Unauthorized tenant access.');

        $sales = DB::table('owner_sales')
            ->where('owner_user_id', $ownerId)
            ->orderByDesc('sold_at')
            ->get();

        return view('pos.cashier.history', [
            'company' => DB::table('owner_companies')->where('owner_user_id', $ownerId)->first(),
            'sales' => $sales,
            'salesStats' => [
                'totalSales' => $sales->sum('total'),
                'count' => $sales->count(),
                'average' => $sales->count() ? $sales->avg('total') : 0,
            ],
        ]);
    }

    /**
     * Process POS transaction checkout.
     */
    public function checkout(Request $request): RedirectResponse
    {
        $ownerId = TenantContext::ownerId(Auth::user());
        abort_unless($ownerId, 403, 'Unauthorized tenant access.');

        $data = $request->validate([
            'cart_payload' => ['required', 'string'],
            'payment_method' => ['required', 'in:Cash,Card,Mobile'],
            'discount' => ['nullable', 'numeric', 'min:0', 'max:100'],
            'customer_name' => ['nullable', 'string', 'max:255'],
        ]);

        $items = json_decode($data['cart_payload'], true);

        if (! is_array($items) || empty($items)) {
            return back()->withErrors(['cart_payload' => 'Add at least one product before completing payment.']);
        }

        $company = DB::table('owner_companies')->where('owner_user_id', $ownerId)->first();
        $taxRate = (float) ($company?->tax_rate ?? 15);
        $discountRate = (float) ($data['discount'] ?? 0);

        $invoiceNumber = DB::transaction(function () use ($items, $ownerId, $data, $taxRate, $discountRate) {
            $productIds = collect($items)->pluck('id')->filter()->values()->all();
            $products = DB::table('owner_products')
                ->where('owner_user_id', $ownerId)
                ->whereIn('id', $productIds)
                ->lockForUpdate()
                ->get()
                ->keyBy('id');

            if ($products->count() !== count($productIds)) {
                abort(422, 'One or more selected products are unavailable.');
            }

            $subtotal = 0;
            $itemCount = 0;

            foreach ($items as $item) {
                $productId = (int) ($item['id'] ?? 0);
                $quantity = max(1, (int) ($item['qty'] ?? 0));
                $product = $products->get($productId);

                if (! $product || $product->stock < $quantity) {
                    abort(422, 'Insufficient stock available for ' . ($product?->name ?? 'selected item') . '.');
                }

                $subtotal += $product->price * $quantity;
                $itemCount += $quantity;

                DB::table('owner_products')
                    ->where('id', $productId)
                    ->where('owner_user_id', $ownerId)
                    ->update([
                        'stock' => $product->stock - $quantity,
                        'updated_at' => now(),
                    ]);
            }

            $discountedSubtotal = $subtotal * (1 - ($discountRate / 100));
            $total = $discountedSubtotal + ($discountedSubtotal * ($taxRate / 100));
            $invNum = 'INV-' . now()->format('YmdHis') . '-' . random_int(100, 999);

            $custName = ! empty($data['customer_name']) ? trim($data['customer_name']) : 'Walk-in Customer';

            DB::table('owner_sales')->insert([
                'owner_user_id' => $ownerId,
                'invoice_number' => $invNum,
                'customer_name' => $custName,
                'items_count' => $itemCount,
                'total' => round($total, 2),
                'payment_method' => $data['payment_method'],
                'status' => 'Completed',
                'sold_at' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            if ($custName !== 'Walk-in Customer') {
                $existingCustomer = DB::table('owner_customers')
                    ->where('owner_user_id', $ownerId)
                    ->where('name', $custName)
                    ->first();

                if ($existingCustomer) {
                    DB::table('owner_customers')
                        ->where('id', $existingCustomer->id)
                        ->increment('visits', 1, [
                            'total_purchases' => DB::raw('total_purchases + ' . round($total, 2)),
                            'updated_at' => now(),
                        ]);
                } else {
                    DB::table('owner_customers')->insert([
                        'owner_user_id' => $ownerId,
                        'customer_code' => 'C' . now()->timestamp,
                        'name' => $custName,
                        'total_purchases' => round($total, 2),
                        'visits' => 1,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
            }

            return $invNum;
        });

        return back()->with('payment_success', [
            'invoice' => $invoiceNumber,
        ]);
    }
}
