<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
                ->withErrors(['email' => 'The provided credentials are incorrect.'])
                ->onlyInput('email');
        }

        $request->session()->regenerate();

        return redirect()->intended($this->dashboardPath(Auth::user()?->email));
    }

    public function showRegister(): View
    {
        return view('public.register');
    }

    public function register(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'companyName' => ['nullable', 'string', 'max:255'],
            'companyEmail' => ['nullable', 'email', 'max:255'],
            'companyPhone' => ['nullable', 'string', 'max:50'],
            'ownerName' => ['required', 'string', 'max:255'],
            'ownerEmail' => ['required', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'plan' => ['required', 'in:basic,pro,enterprise'],
        ]);

        $user = User::create([
            'name' => $data['ownerName'],
            'email' => $data['ownerEmail'],
            'password' => $data['password'],
            'email_verified_at' => now(),
        ]);

        Auth::login($user);

        return redirect()->to($this->dashboardPath($user->email));
    }

    private function dashboardPath(string $email): string
    {
        return match ($email) {
            'cashier@demo.lk' => '/cashier',
            'manager@demo.lk' => '/manager',
            'admin@demo.lk' => '/admin',
            default => '/owner',
        };
    }
}
