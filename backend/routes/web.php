<?php

use App\Models\User;
use App\Http\Controllers\OwnerController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

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
    $email = $request->input('email');

    return match (true) {
        str_starts_with($email, 'admin@') => redirect('/admin'),
        str_starts_with($email, 'manager@') => redirect('/manager'),
        str_starts_with($email, 'cashier@') => redirect('/cashier'),
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
    Route::get('/', fn () => view('pos.cashier.pos'));
    Route::get('/history', fn () => view('pos.cashier.history'));
});

Route::prefix('manager')->group(function () {
    Route::get('/', fn () => view('pos.manager.dashboard'));
    Route::get('/inventory', fn () => view('pos.manager.inventory'));
    Route::get('/reports', fn () => view('pos.manager.reports'));
    Route::get('/customers', fn () => view('pos.manager.customers'));
});

Route::prefix('admin')->group(function () {
    Route::get('/', fn () => view('pos.admin.dashboard'));
    Route::get('/tenants', fn () => view('pos.admin.tenants'));
    Route::get('/subscriptions', fn () => view('pos.admin.subscriptions'));
    Route::get('/logs', fn () => view('pos.admin.logs'));
});
