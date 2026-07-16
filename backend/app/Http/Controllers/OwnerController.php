<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class OwnerController extends Controller
{
    private function ownerId(): int
    {
        $user = Auth::user();
        abort_unless($user && $user->role === 'owner', 403);
        return $user->id;
    }

    private function company(): object
    {
        $ownerId = $this->ownerId();
        $user = Auth::user();

        DB::table('owner_companies')->updateOrInsert(
            ['owner_user_id' => $ownerId],
            [
                'name' => DB::table('owner_companies')->where('owner_user_id', $ownerId)->value('name') ?? $user?->name ?? 'Business',
                'email' => DB::table('owner_companies')->where('owner_user_id', $ownerId)->value('email') ?? $user?->email,
                'phone' => DB::table('owner_companies')->where('owner_user_id', $ownerId)->value('phone'),
                'address' => DB::table('owner_companies')->where('owner_user_id', $ownerId)->value('address'),
                'currency' => DB::table('owner_companies')->where('owner_user_id', $ownerId)->value('currency') ?? 'LKR',
                'tax_rate' => DB::table('owner_companies')->where('owner_user_id', $ownerId)->value('tax_rate') ?? 15,
                'invoice_template' => DB::table('owner_companies')->where('owner_user_id', $ownerId)->value('invoice_template') ?? 'standard',
                'updated_at' => now(),
                'created_at' => now(),
            ]
        );

        return DB::table('owner_companies')->where('owner_user_id', $ownerId)->first();
    }

    private function currentSubscription(): object
    {
        return DB::table('owner_subscriptions')->where('owner_user_id', $this->ownerId())->first() ?? (object) [
            'plan' => 'Pro',
            'status' => 'Active',
            'price' => 5000,
            'renews_at' => now()->addMonth()->toDateString(),
            'user_limit' => 5,
            'product_limit' => 1000,
            'transaction_limit' => null,
        ];
    }

    public function dashboard(): View
    {
        $ownerId = $this->ownerId();

        return view('pos.owner.dashboard', [
            'company' => $this->company(),
            'subscription' => $this->currentSubscription(),
            'stats' => [
                'salesToday' => DB::table('owner_sales')->where('owner_user_id', $ownerId)->whereDate('sold_at', today())->sum('total'),
                'monthlyRevenue' => DB::table('owner_sales')->where('owner_user_id', $ownerId)->whereMonth('sold_at', now()->month)->whereYear('sold_at', now()->year)->sum('total'),
                'productsCount' => DB::table('owner_products')->where('owner_user_id', $ownerId)->count(),
                'employeesCount' => DB::table('owner_employees')->where('owner_user_id', $ownerId)->where('status', 'Active')->count(),
            ],
            'lowStockItems' => DB::table('owner_products')
                ->where('owner_user_id', $ownerId)
                ->whereColumn('stock', '<=', 'low_stock_threshold')
                ->orderBy('stock')
                ->limit(4)
                ->get(),
            'transactions' => DB::table('owner_sales')
                ->where('owner_user_id', $ownerId)
                ->orderByDesc('sold_at')
                ->limit(5)
                ->get(),
        ]);
    }

    public function sales(): View
    {
        $salesRecords = DB::table('owner_sales')->where('owner_user_id', $this->ownerId())->orderByDesc('sold_at')->get();

        return view('pos.owner.sales', [
            'company' => $this->company(),
            'salesRecords' => $salesRecords,
            'salesStats' => [
                'today' => $salesRecords->where('sold_at', '>=', now()->startOfDay())->sum('total'),
                'count' => $salesRecords->count(),
                'average' => $salesRecords->avg('total') ?? 0,
            ],
        ]);
    }

    public function inventory(): View
    {
        return view('pos.owner.inventory', [
            'company' => $this->company(),
            'products' => DB::table('owner_products')->where('owner_user_id', $this->ownerId())->orderBy('name')->get(),
        ]);
    }

    public function storeProduct(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'sku' => ['nullable', 'string', 'max:50'],
            'name' => ['required', 'string', 'max:255'],
            'category' => ['required', 'string', 'max:255'],
            'price' => ['required', 'numeric', 'min:0'],
            'stock' => ['required', 'integer', 'min:0'],
            'supplier' => ['nullable', 'string', 'max:255'],
            'low_stock_threshold' => ['nullable', 'integer', 'min:0'],
        ]);

        DB::table('owner_products')->insert([
            'owner_user_id' => $this->ownerId(),
            'sku' => $data['sku'] ?: 'P' . now()->timestamp,
            'name' => $data['name'],
            'category' => $data['category'],
            'price' => $data['price'],
            'stock' => $data['stock'],
            'low_stock_threshold' => $data['low_stock_threshold'] ?? 10,
            'supplier' => $data['supplier'] ?? null,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return back();
    }

    public function updateProduct(Request $request, int $productId): RedirectResponse
    {
        $data = $request->validate([
            'sku' => ['nullable', 'string', 'max:50'],
            'name' => ['required', 'string', 'max:255'],
            'category' => ['required', 'string', 'max:255'],
            'price' => ['required', 'numeric', 'min:0'],
            'stock' => ['required', 'integer', 'min:0'],
            'supplier' => ['nullable', 'string', 'max:255'],
            'low_stock_threshold' => ['nullable', 'integer', 'min:0'],
        ]);

        DB::table('owner_products')
            ->where('id', $productId)
            ->where('owner_user_id', $this->ownerId())
            ->update([
                'sku' => $data['sku'] ?? null,
                'name' => $data['name'],
                'category' => $data['category'],
                'price' => $data['price'],
                'stock' => $data['stock'],
                'low_stock_threshold' => $data['low_stock_threshold'] ?? 10,
                'supplier' => $data['supplier'] ?? null,
                'updated_at' => now(),
            ]);

        return back();
    }

    public function deleteProduct(int $productId): RedirectResponse
    {
        DB::table('owner_products')
            ->where('id', $productId)
            ->where('owner_user_id', $this->ownerId())
            ->delete();

        return back();
    }

    public function employees(): View
    {
        return view('pos.owner.employees', [
            'company' => $this->company(),
            'employees' => DB::table('owner_employees')->where('owner_user_id', $this->ownerId())->orderBy('name')->get(),
        ]);
    }

    public function storeEmployee(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:owner_employees,email'],
            'role' => ['required', 'string', 'max:255'],
            'password' => ['required', 'string', 'min:8'],
            'phone' => ['nullable', 'string', 'max:50'],
            'status' => ['required', 'in:Active,Inactive'],
            'joined_at' => ['nullable', 'date'],
        ]);

        $userRole = strtolower($data['role']) === 'manager' ? 'manager' : 'cashier';

        DB::table('users')->updateOrInsert(
            ['email' => $data['email']],
            [
                'name' => $data['name'],
                'email' => $data['email'],
                'role' => $userRole,
                'password' => Hash::make($data['password']),
                'updated_at' => now(),
                'created_at' => now(),
            ]
        );

        DB::table('owner_employees')->insert([
            'owner_user_id' => $this->ownerId(),
            'name' => $data['name'],
            'email' => $data['email'],
            'role' => $data['role'],
            'phone' => $data['phone'] ?? null,
            'status' => $data['status'],
            'joined_at' => $data['joined_at'] ?? now()->toDateString(),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return back();
    }

    public function updateEmployee(Request $request, int $employeeId): RedirectResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'role' => ['required', 'string', 'max:255'],
            'password' => ['nullable', 'string', 'min:8'],
            'phone' => ['nullable', 'string', 'max:50'],
            'status' => ['required', 'in:Active,Inactive'],
            'joined_at' => ['nullable', 'date'],
        ]);

        if (! empty($data['password'])) {
            $userRole = strtolower($data['role']) === 'manager' ? 'manager' : 'cashier';

            DB::table('users')
                ->where('email', $data['email'])
                ->update([
                    'name' => $data['name'],
                    'role' => $userRole,
                    'password' => Hash::make($data['password']),
                    'updated_at' => now(),
                ]);
        }

        DB::table('owner_employees')
            ->where('id', $employeeId)
            ->where('owner_user_id', $this->ownerId())
            ->update([
                'name' => $data['name'],
                'email' => $data['email'],
                'role' => $data['role'],
                'phone' => $data['phone'] ?? null,
                'status' => $data['status'],
                'joined_at' => $data['joined_at'] ?? null,
                'updated_at' => now(),
            ]);

        return back();
    }

    public function deleteEmployee(int $employeeId): RedirectResponse
    {
        DB::table('owner_employees')
            ->where('id', $employeeId)
            ->where('owner_user_id', $this->ownerId())
            ->delete();

        return back();
    }

    public function customers(): View
    {
        return view('pos.owner.customers', [
            'company' => $this->company(),
            'customers' => DB::table('owner_customers')->where('owner_user_id', $this->ownerId())->orderBy('name')->get(),
        ]);
    }

    public function storeCustomer(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'customer_code' => ['nullable', 'string', 'max:50'],
            'name' => ['required', 'string', 'max:255'],
            'email' => ['nullable', 'email', 'max:255'],
            'phone' => ['nullable', 'string', 'max:50'],
        ]);

        $customerCode = $data['customer_code'] ?? null;

        DB::table('owner_customers')->insert([
            'owner_user_id' => $this->ownerId(),
            'customer_code' => $customerCode ?: 'C' . now()->timestamp,
            'name' => $data['name'],
            'email' => $data['email'] ?? null,
            'phone' => $data['phone'] ?? null,
            'total_purchases' => 0,
            'visits' => 0,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return back();
    }

    public function updateCustomer(Request $request, int $customerId): RedirectResponse
    {
        $data = $request->validate([
            'customer_code' => ['nullable', 'string', 'max:50'],
            'name' => ['required', 'string', 'max:255'],
            'email' => ['nullable', 'email', 'max:255'],
            'phone' => ['nullable', 'string', 'max:50'],
        ]);

        DB::table('owner_customers')
            ->where('id', $customerId)
            ->where('owner_user_id', $this->ownerId())
            ->update([
                'customer_code' => $data['customer_code'] ?? null,
                'name' => $data['name'],
                'email' => $data['email'] ?? null,
                'phone' => $data['phone'] ?? null,
                'updated_at' => now(),
            ]);

        return back();
    }

    public function deleteCustomer(int $customerId): RedirectResponse
    {
        DB::table('owner_customers')
            ->where('id', $customerId)
            ->where('owner_user_id', $this->ownerId())
            ->delete();

        return back();
    }

    public function settings(): View
    {
        return view('pos.owner.settings', [
            'company' => $this->company(),
        ]);
    }

    public function updateSettings(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['nullable', 'email', 'max:255'],
            'phone' => ['nullable', 'string', 'max:50'],
            'address' => ['nullable', 'string', 'max:255'],
            'currency' => ['required', 'in:LKR,USD'],
            'tax_rate' => ['required', 'numeric', 'between:0,100'],
            'invoice_template' => ['required', 'in:standard,compact,detailed'],
        ]);

        DB::table('owner_companies')->updateOrInsert(
            ['owner_user_id' => $this->ownerId()],
            [
                'name' => $data['name'],
                'email' => $data['email'],
                'phone' => $data['phone'],
                'address' => $data['address'],
                'currency' => $data['currency'],
                'tax_rate' => $data['tax_rate'],
                'invoice_template' => $data['invoice_template'],
                'updated_at' => now(),
                'created_at' => now(),
            ]
        );

        return back()->with('status', 'Settings updated.');
    }

    public function subscription(): View
    {
        return view('pos.owner.subscription', [
            'company' => $this->company(),
            'subscription' => $this->currentSubscription(),
            'billingHistory' => DB::table('owner_subscription_payments')->where('owner_user_id', $this->ownerId())->orderByDesc('paid_at')->get(),
        ]);
    }
}
