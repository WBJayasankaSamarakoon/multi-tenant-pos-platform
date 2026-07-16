<?php

use App\Models\User;
use App\Http\Controllers\OwnerController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

Route::view('/', 'welcome')->name('home');
Route::view('/pricing', 'public.pricing')->name('pricing');
Route::get('/features', fn () => redirect('/#features'));
Route::get('/about', fn () => redirect('/#about'));

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

    User::create([
        'name' => $data['owner_name'],
        'email' => $data['owner_email'],
        'password' => Hash::make($data['password']),
        'role' => 'owner',
    ]);

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
        return view('pos.cashier.pos', [
            'company' => DB::table('owner_companies')->first(),
            'products' => DB::table('owner_products')->orderBy('name')->get(),
            'customers' => DB::table('owner_customers')->orderBy('name')->get(),
        ]);
    });
    Route::get('/history', function () {
        $sales = DB::table('owner_sales')->orderByDesc('sold_at')->get();

        return view('pos.cashier.history', [
            'company' => DB::table('owner_companies')->first(),
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
        $owner = DB::table('owner_companies')->first();
        $ownerId = $owner?->owner_user_id;
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
    Route::get('/inventory', function () {
        $owner = DB::table('owner_companies')->first();
        $ownerId = $owner?->owner_user_id;
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
        $owner = DB::table('owner_companies')->first();
        $ownerId = $owner?->owner_user_id;
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
        $owner = DB::table('owner_companies')->first();
        $ownerId = $owner?->owner_user_id;

        return view('pos.manager.customers', [
            'company' => $owner,
            'customers' => DB::table('owner_customers')->where('owner_user_id', $ownerId)->orderBy('name')->get(),
        ]);
    });
});

Route::prefix('admin')->group(function () {
    Route::get('/', fn () => view('pos.admin.dashboard'));
    Route::get('/tenants', fn () => view('pos.admin.tenants'));
    Route::get('/subscriptions', fn () => view('pos.admin.subscriptions'));
    Route::get('/logs', fn () => view('pos.admin.logs'));
});
