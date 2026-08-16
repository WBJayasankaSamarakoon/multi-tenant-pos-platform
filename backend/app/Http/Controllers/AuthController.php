<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class AuthController extends Controller
{
    public function showLogin(): View
    {
        return view('public.login');
    }

    public function login(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        if (! Auth::attempt($credentials, $request->boolean('remember'))) {
            return back()
                ->withErrors(['email' => 'Invalid email or password.'])
                ->onlyInput('email');
        }

        $request->session()->regenerate();

        return redirect()->intended($this->dashboardPath(Auth::user()?->role));
    }

    public function showRegister(): View
    {
        return view('public.register');
    }

    public function register(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'company_name' => ['nullable', 'string', 'max:255'],
            'company_email' => ['nullable', 'email', 'max:255'],
            'company_phone' => ['nullable', 'string', 'max:50'],
            'owner_name' => ['required', 'string', 'max:255'],
            'owner_email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'plan' => ['nullable', 'in:basic,pro,enterprise'],
        ]);

        $user = User::create([
            'name' => $data['owner_name'],
            'email' => $data['owner_email'],
            'password' => $data['password'],
            'role' => 'owner',
        ]);

        // Create company record
        DB::table('owner_companies')->updateOrInsert(
            ['owner_user_id' => $user->id],
            [
                'name' => $data['company_name'] ?: $data['owner_name'],
                'email' => $data['company_email'] ?? $data['owner_email'],
                'phone' => $data['company_phone'] ?? null,
                'currency' => 'LKR',
                'tax_rate' => 15,
                'invoice_template' => 'standard',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        );

        // Map plan tier to limits
        $planTier = strtolower($data['plan'] ?? 'pro');
        [$planName, $price, $userLimit, $productLimit] = match ($planTier) {
            'basic' => ['Basic', 2500, 1, 100],
            'enterprise' => ['Enterprise', 10000, 999, 99999],
            default => ['Pro', 5000, 5, 1000],
        };

        // Create tenant subscription record
        DB::table('owner_subscriptions')->updateOrInsert(
            ['owner_user_id' => $user->id],
            [
                'plan' => $planName,
                'status' => 'Active',
                'price' => $price,
                'renews_at' => now()->addMonth()->toDateString(),
                'user_limit' => $userLimit,
                'product_limit' => $productLimit,
                'transaction_limit' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ]
        );

        return redirect('/login')->with('status', 'Registration complete. Please sign in.');
    }

    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }

    private function dashboardPath(?string $role): string
    {
        return match ($role) {
            'cashier' => '/cashier',
            'manager' => '/manager',
            'admin' => '/admin',
            default => '/owner',
        };
    }
}
