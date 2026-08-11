<?php

use App\Http\Controllers\AdminController;
use App\Models\User;
use App\Http\Controllers\OwnerController;
use App\Support\TenantContext;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

// Route::view('/', 'welcome')->name('home');
// Route::view('/pricing', 'public.pricing')->name('pricing');
// Route::get('/features', fn () => redirect('/#features'));
// Route::get('/about', fn () => redirect('/#about'));

Route::view('/login', 'public.login')->name('login');
Route::view('/register', 'public.register')->name('register');

Route::post('/login', function (Request $request) {
    $credentials = $request->validate([
        'email' => ['required', 'email'],
        'password' => ['required', 'string'],
    ]);

    if (! Auth::attempt($credentials, $request->boolean('remember'))) {
        return back()->withErrors([
            'email' => 'Invalid credentials.',
        ])->onlyInput('email');
    }

    $request->session()->regenerate();
    $user = Auth::user();

    return match ($user?->role) {
        'admin' => redirect('/admin'),
        'manager' => redirect('/manager'),
        'cashier' => redirect('/cashier'),
        default => redirect('/owner'),
    };
})->name('login.submit');

Route::post('/register', function (Request $request) {
    $data = $request->validate([
        'company_name' => ['nullable', 'string', 'max:255'],
        'owner_name' => ['required', 'string', 'max:255'],
        'owner_email' => ['required', 'email', 'max:255', 'unique:users,email'],
        'password' => ['required', 'string', 'confirmed', 'min:8'],
    ]);

    $user = User::create([
        'name' => $data['owner_name'],
        'email' => $data['owner_email'],
        'password' => Hash::make($data['password']),
        'role' => 'owner',
    ]);

    DB::table('owner_companies')->updateOrInsert(
        ['owner_user_id' => $user->id],
        [
            'name' => $data['company_name'] ?: $data['owner_name'],
            'currency' => 'LKR',
            'tax_rate' => 15,
            'invoice_template' => 'standard',
            'created_at' => now(),
            'updated_at' => now(),
        ]
    );

    return redirect('/login')->with('status', 'Registration complete. Please sign in.');
});

Route::prefix('owner')->controller(OwnerController::class)->group(function () {
    Route::get('/', 'dashboard');
    Route::get('/sales', 'sales');
    Route::get('/inventory', 'inventory');
    Route::post('/inventory', 'storeProduct');
    Route::put('/inventory/{productId}', 'updateProduct');
    Route::delete('/inventory/{productId}', 'deleteProduct');
    Route::get('/employees', 'employees');
    Route::post('/employees', 'storeEmployee');
    Route::put('/employees/{employeeId}', 'updateEmployee');
    Route::delete('/employees/{employeeId}', 'deleteEmployee');
    Route::get('/customers', 'customers');
    Route::post('/customers', 'storeCustomer');
    Route::put('/customers/{customerId}', 'updateCustomer');
    Route::delete('/customers/{customerId}', 'deleteCustomer');
    Route::get('/settings', 'settings');
    Route::post('/settings', 'updateSettings');
    Route::get('/subscription', 'subscription');
});

Route::prefix('cashier')->group(function () {
    Route::get('/', function () {
        $ownerId = TenantContext::ownerId(Auth::user());

        abort_unless($ownerId, 403);

        return view('pos.cashier.pos', [
            'company' => DB::table('owner_companies')->where('owner_user_id', $ownerId)->first(),
            'products' => DB::table('owner_products')->where('owner_user_id', $ownerId)->orderBy('name')->get(),
            'customers' => DB::table('owner_customers')->where('owner_user_id', $ownerId)->orderBy('name')->get(),
        ]);
    });
    Route::get('/history', function () {
        $ownerId = TenantContext::ownerId(Auth::user());

        abort_unless($ownerId, 403);

        $sales = DB::table('owner_sales')->where('owner_user_id', $ownerId)->orderByDesc('sold_at')->get();

        return view('pos.cashier.history', [
            'company' => DB::table('owner_companies')->where('owner_user_id', $ownerId)->first(),
            'sales' => $sales,
            'salesStats' => [
                'totalSales' => $sales->sum('total'),
                'count' => $sales->count(),
                'average' => $sales->avg('total') ?? 0,
            ],
        ]);
    });
});

Route::prefix('manager')->group(function () {
    Route::get('/', function () {
        $ownerId = TenantContext::ownerId(Auth::user());

        abort_unless($ownerId, 403);

        $owner = DB::table('owner_companies')->where('owner_user_id', $ownerId)->first();
        $sales = DB::table('owner_sales')->where('owner_user_id', $ownerId)->orderByDesc('sold_at')->get();

        return view('pos.manager.dashboard', [
            'company' => $owner,
            'stats' => [
                'salesToday' => DB::table('owner_sales')->where('owner_user_id', $ownerId)->whereDate('sold_at', today())->sum('total'),
                'productsCount' => DB::table('owner_products')->where('owner_user_id', $ownerId)->count(),
                'lowStockItems' => DB::table('owner_products')->where('owner_user_id', $ownerId)->whereColumn('stock', '<=', 'low_stock_threshold')->count(),
                'ordersToday' => DB::table('owner_sales')->where('owner_user_id', $ownerId)->whereDate('sold_at', today())->count(),
            ],
            'salesSeries' => collect(range(6, 0))->map(function ($daysAgo) use ($sales) {
                $date = now()->subDays($daysAgo)->toDateString();
                return $sales->filter(fn ($sale) => \Illuminate\Support\Carbon::parse($sale->sold_at)->toDateString() === $date)->sum('total');
            }),
            'lowStockItems' => DB::table('owner_products')->where('owner_user_id', $ownerId)->whereColumn('stock', '<=', 'low_stock_threshold')->orderBy('stock')->limit(4)->get(),
            'recentSales' => $sales->take(3),
        ]);
    });
    Route::post('/inventory', function (Request $request) {
        $ownerId = TenantContext::ownerId(Auth::user());

        abort_unless($ownerId, 403);

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

        return back()->with('status', 'Product added.');
    });
    Route::get('/inventory', function () {
        $ownerId = TenantContext::ownerId(Auth::user());

        abort_unless($ownerId, 403);

        $owner = DB::table('owner_companies')->where('owner_user_id', $ownerId)->first();
        $products = DB::table('owner_products')->where('owner_user_id', $ownerId)->orderBy('name')->get();

        return view('pos.manager.inventory', [
            'company' => $owner,
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
    });
    Route::get('/reports', function () {
        $ownerId = TenantContext::ownerId(Auth::user());

        abort_unless($ownerId, 403);

        $owner = DB::table('owner_companies')->where('owner_user_id', $ownerId)->first();
        $sales = DB::table('owner_sales')->where('owner_user_id', $ownerId)->orderByDesc('sold_at')->get();

        return view('pos.manager.reports', [
            'company' => $owner,
            'weeklyRevenue' => $sales->sum('total'),
            'avgDailySales' => $sales->count() ? $sales->avg('total') : 0,
            'itemsSold' => $sales->sum('items_count'),
            'salesSeries' => collect(range(6, 0))->map(function ($daysAgo) use ($sales) {
                $date = now()->subDays($daysAgo)->toDateString();
                return $sales->filter(fn ($sale) => \Illuminate\Support\Carbon::parse($sale->sold_at)->toDateString() === $date)->sum('total');
            }),
            'topProducts' => DB::table('owner_products')->where('owner_user_id', $ownerId)->orderByDesc('stock')->limit(5)->get(),
        ]);
    });
    Route::get('/customers', function () {
        $ownerId = TenantContext::ownerId(Auth::user());

        abort_unless($ownerId, 403);

        $owner = DB::table('owner_companies')->where('owner_user_id', $ownerId)->first();

        return view('pos.manager.customers', [
            'company' => $owner,
            'customers' => DB::table('owner_customers')->where('owner_user_id', $ownerId)->orderBy('name')->get(),
        ]);
    });
});

Route::prefix('admin')->group(function () {
    Route::redirect('/', '/admin/dashboard');
    Route::get('/dashboard', [AdminController::class, 'dashboard']);
    Route::get('/tenants', [AdminController::class, 'tenants']);
    Route::get('/subscriptions', [AdminController::class, 'subscriptions']);
    Route::get('/logs', [AdminController::class, 'logs']);
    Route::redirect('/system-logs', '/admin/logs');
});

Route::post('/cashier/checkout', function (Request $request) {
    $ownerId = TenantContext::ownerId(Auth::user());

    abort_unless($ownerId, 403);

    $data = $request->validate([
        'cart_payload' => ['required', 'string'],
        'payment_method' => ['required', 'in:Cash,Card,Mobile'],
        'discount' => ['nullable', 'numeric', 'min:0', 'max:100'],
        'customer_name' => ['nullable', 'string', 'max:255'],
    ]);

    $items = json_decode($data['cart_payload'], true);

    if (! is_array($items) || empty($items)) {
        return back()->withErrors(['cart_payload' => 'Add at least one product before payment.']);
    }

    $company = DB::table('owner_companies')->where('owner_user_id', $ownerId)->first();
    $taxRate = (float) ($company?->tax_rate ?? 15);
    $discountRate = (float) ($data['discount'] ?? 0);

    $sale = DB::transaction(function () use ($items, $ownerId, $data, $taxRate, $discountRate) {
        $productIds = collect($items)->pluck('id')->filter()->values()->all();
        $products = DB::table('owner_products')
            ->where('owner_user_id', $ownerId)
            ->whereIn('id', $productIds)
            ->lockForUpdate()
            ->get()
            ->keyBy('id');

        if ($products->count() !== count($productIds)) {
            abort(422, 'One or more products are unavailable.');
        }

        $subtotal = 0;
        $itemCount = 0;

        foreach ($items as $item) {
            $productId = (int) ($item['id'] ?? 0);
            $quantity = max(1, (int) ($item['qty'] ?? 0));
            $product = $products->get($productId);

            if (! $product || $product->stock < $quantity) {
                abort(422, 'Insufficient stock for one or more products.');
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

        $invoiceNumber = 'INV-' . now()->format('YmdHis') . '-' . random_int(100, 999);

        DB::table('owner_sales')->insert([
            'owner_user_id' => $ownerId,
            'invoice_number' => $invoiceNumber,
            'customer_name' => $data['customer_name'] ?: 'Walk-in Customer',
            'items_count' => $itemCount,
            'total' => round($total, 2),
            'payment_method' => $data['payment_method'],
            'status' => 'Completed',
            'sold_at' => now(),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return $invoiceNumber;
    });

    return back()->with('payment_success', [
        'invoice' => $sale,
    ]);
});
