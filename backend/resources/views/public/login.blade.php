@extends('layouts.public')

@section('title', 'Login - MultiBizPOS')

@section('content')
<div class="w-full min-h-screen bg-gray-50 flex">
    <div class="flex-1 flex flex-col justify-center px-4 sm:px-8 py-12">
        <div class="w-full max-w-md mx-auto surface-fade-up" data-demo-container>
            <a href="/" class="flex items-center gap-2 mb-10">
                <div class="w-9 h-9 bg-blue-600 rounded-lg flex items-center justify-center">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                </div>
                <span class="text-lg font-bold text-gray-900">MultiBiz<span class="text-blue-600">POS</span></span>
            </a>

            <h1 class="text-2xl font-bold text-gray-900">Welcome back</h1>
            <p class="text-sm text-gray-500 mt-1">Sign in to your account to continue</p>

            <form class="mt-8 space-y-4" action="{{ route('login.submit') }}" method="post">
                @csrf
                @if ($errors->any())
                    <p class="text-sm text-red-600">{{ $errors->first() }}</p>
                @endif
                @if (session('status'))
                    <p class="text-sm text-emerald-600">{{ session('status') }}</p>
                @endif

                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-1.5">Email Address</label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" placeholder="you@company.lk" class="w-full px-4 py-2.5 text-sm border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all" required>
                </div>

                <div>
                    <div class="flex items-center justify-between mb-1.5">
                        <label for="password" class="text-sm font-medium text-gray-700">Password</label>
                        <a href="#" class="text-xs text-blue-600 hover:text-blue-700 font-medium">Forgot password?</a>
                    </div>
                    <div class="relative">
                        <input id="password" type="password" name="password" placeholder="Enter your password" class="w-full px-4 py-2.5 pr-10 text-sm border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all" required>
                        <button type="button" data-password-toggle="#password" class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600" aria-label="Toggle password visibility">
                            <svg data-password-icon="show" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                            <svg data-password-icon="hide" class="w-4 h-4 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.477 0-8.268-2.943-9.542-7a9.956 9.956 0 012.042-3.368m2.158-1.964A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.542 7a9.97 9.97 0 01-4.132 5.411M15 12a3 3 0 00-4.243-2.743M9.88 9.88A3 3 0 0014.12 14.12M3 3l18 18"></path></svg>
                        </button>
                    </div>
                </div>

                <div class="flex items-center gap-2">
                    <input id="remember" name="remember" type="checkbox" class="w-4 h-4 rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                    <label for="remember" class="text-sm text-gray-600">Remember me</label>
                </div>

                <button type="submit" class="w-full py-3 bg-blue-600 text-white font-semibold rounded-xl hover:bg-blue-700 transition-colors shadow-lg shadow-blue-600/25">Sign In</button>
            </form>

            <p class="mt-6 text-center text-sm text-gray-500">Don't have an account? <a href="/register" class="text-blue-600 font-medium hover:text-blue-700">Register your business</a></p>
        </div>
    </div>

    <div class="hidden lg:flex flex-1 bg-navy items-center justify-center p-12 relative overflow-hidden">
        <div class="absolute inset-0 bg-gradient-to-br from-blue-600/20 to-emerald-600/10"></div>
        <div class="absolute top-20 right-20 w-64 h-64 bg-blue-500/10 rounded-full blur-3xl"></div>
        <div class="absolute bottom-20 left-20 w-48 h-48 bg-emerald-500/10 rounded-full blur-3xl"></div>
        <div class="relative text-center max-w-md">
            <div class="w-20 h-20 bg-blue-600 rounded-2xl flex items-center justify-center mx-auto mb-8 shadow-2xl shadow-blue-600/30"><svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg></div>
            <h2 class="text-3xl font-bold text-white mb-4">MultiBiz POS</h2>
            <p class="text-slate-300 leading-relaxed">The complete cloud-based POS platform for Sri Lankan businesses. Manage sales, inventory, and employees from anywhere.</p>
            <div class="mt-8 grid grid-cols-3 gap-4">
                <div class="bg-white/5 backdrop-blur-sm rounded-xl p-4 border border-white/10"><p class="text-2xl font-bold text-white">500+</p><p class="text-xs text-slate-400 mt-1">Businesses</p></div>
                <div class="bg-white/5 backdrop-blur-sm rounded-xl p-4 border border-white/10"><p class="text-2xl font-bold text-white">50K+</p><p class="text-xs text-slate-400 mt-1">Transactions</p></div>
                <div class="bg-white/5 backdrop-blur-sm rounded-xl p-4 border border-white/10"><p class="text-2xl font-bold text-white">99.9%</p><p class="text-xs text-slate-400 mt-1">Uptime</p></div>
            </div>
        </div>
    </div>
</div>
@endsection
