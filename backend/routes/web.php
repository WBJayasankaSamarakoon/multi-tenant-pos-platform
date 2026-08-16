<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CashierController;
use App\Http\Controllers\ManagerController;
use App\Http\Controllers\OwnerController;
use Illuminate\Support\Facades\Route;

/*
 Public & Authentication Routes
*/
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.submit');
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.submit');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

/*
 Business Owner Management Portal
*/
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

/*
 Store Manager Operations Portal
*/
Route::prefix('manager')->controller(ManagerController::class)->group(function () {
    Route::get('/', 'dashboard');
    Route::get('/inventory', 'inventory');
    Route::post('/inventory', 'storeProduct');
    Route::get('/reports', 'reports');
    Route::get('/customers', 'customers');
});

/*
 Cashier POS Billing Portal
*/
Route::prefix('cashier')->controller(CashierController::class)->group(function () {
    Route::get('/', 'pos');
    Route::get('/history', 'history');
    Route::post('/checkout', 'checkout')->name('cashier.checkout');
});

/*
 Super Administrator Console
*/
Route::prefix('admin')->group(function () {
    Route::redirect('/', '/admin/dashboard');
    Route::get('/dashboard', [AdminController::class, 'dashboard']);
    Route::get('/tenants', [AdminController::class, 'tenants']);
    Route::get('/subscriptions', [AdminController::class, 'subscriptions']);
    Route::get('/logs', [AdminController::class, 'logs']);
    Route::redirect('/system-logs', '/admin/logs');
});
