@extends('layouts.public')

@section('title', 'Register - MultiBizPOS')

@section('content')
<div class="w-full min-h-screen bg-gray-50 flex flex-col">
    <div class="py-6 px-4">
        <div class="max-w-lg mx-auto flex items-center justify-between">
            <a href="/" class="flex items-center gap-2">
                <div class="w-8 h-8 bg-blue-600 rounded-lg flex items-center justify-center"><svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg></div>
                <span class="text-sm font-bold text-gray-900">MultiBiz<span class="text-blue-600">POS</span></span>
            </a>
            <a href="/login" class="text-sm text-gray-500 hover:text-gray-700">Already have an account? <span class="text-blue-600 font-medium">Sign in</span></a>
        </div>
    </div>

    <div class="flex-1 flex items-start justify-center px-4 pb-12">
        <div class="w-full max-w-lg" data-stepper data-step-current="1">
            <div class="flex items-center justify-center mb-10">
                <div class="flex items-center gap-2"><div data-step-indicator="1" data-step-number="1" class="w-9 h-9 rounded-full flex items-center justify-center text-sm font-semibold transition-all bg-blue-600 text-white">1</div><span data-step-label="1" class="text-sm font-medium hidden sm:block text-gray-900">Company</span></div>
                <div data-step-connector="1" class="w-12 sm:w-20 h-0.5 mx-2 sm:mx-4 bg-gray-200"></div>
                <div class="flex items-center gap-2"><div data-step-indicator="2" data-step-number="2" class="w-9 h-9 rounded-full flex items-center justify-center text-sm font-semibold transition-all bg-gray-200 text-gray-400">2</div><span data-step-label="2" class="text-sm font-medium hidden sm:block text-gray-400">Account</span></div>
                <div data-step-connector="2" class="w-12 sm:w-20 h-0.5 mx-2 sm:mx-4 bg-gray-200"></div>
                <div class="flex items-center gap-2"><div data-step-indicator="3" data-step-number="3" class="w-9 h-9 rounded-full flex items-center justify-center text-sm font-semibold transition-all bg-gray-200 text-gray-400">3</div><span data-step-label="3" class="text-sm font-medium hidden sm:block text-gray-400">Plan</span></div>
            </div>

            <form action="{{ route('register') }}" method="post" class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 sm:p-8 surface-fade-up">
                @csrf
                @if ($errors->any())
                    <p class="text-sm text-red-600 mb-4">{{ $errors->first() }}</p>
                @endif

                <div data-step="1">
                    <h2 class="text-xl font-bold text-gray-900 mb-1">Company Details</h2>
                    <p class="text-sm text-gray-500 mb-6">Tell us about your business</p>
                    <div class="space-y-4">
                        <div><label for="company_name" class="block text-sm font-medium text-gray-700 mb-1.5">Company Name</label><input id="company_name" name="company_name" type="text" value="{{ old('company_name') }}" placeholder="e.g., Sunrise Market" class="w-full px-4 py-2.5 text-sm border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all"></div>
                        <div><label for="company_email" class="block text-sm font-medium text-gray-700 mb-1.5">Business Email</label><input id="company_email" name="company_email" type="email" value="{{ old('company_email') }}" placeholder="info@yourcompany.com" class="w-full px-4 py-2.5 text-sm border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all"></div>
                        <div><label for="company_phone" class="block text-sm font-medium text-gray-700 mb-1.5">Phone Number</label><input id="company_phone" name="company_phone" type="tel" value="{{ old('company_phone') }}" placeholder="+94 77 123 4567" class="w-full px-4 py-2.5 text-sm border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all"></div>
                    </div>
                    <button type="button" data-step-next class="mt-6 w-full flex items-center justify-center gap-2 py-3 bg-blue-600 text-white font-semibold rounded-xl hover:bg-blue-700 transition-colors">Continue <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg></button>
                </div>

                <div data-step="2" class="hidden">
                    <h2 class="text-xl font-bold text-gray-900 mb-1">Owner Account</h2>
                    <p class="text-sm text-gray-500 mb-6">Create your admin account</p>
                    <div class="space-y-4">
                        <div><label for="owner_name" class="block text-sm font-medium text-gray-700 mb-1.5">Full Name</label><input id="owner_name" name="owner_name" type="text" value="{{ old('owner_name') }}" required placeholder="Your Name" class="w-full px-4 py-2.5 text-sm border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all"></div>
                        <div><label for="owner_email" class="block text-sm font-medium text-gray-700 mb-1.5">Email Address</label><input id="owner_email" name="owner_email" type="email" value="{{ old('owner_email') }}" required placeholder="owner@yourcompany.com" class="w-full px-4 py-2.5 text-sm border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all"></div>
                        <div><label for="password" class="block text-sm font-medium text-gray-700 mb-1.5">Password</label><input id="password" name="password" type="password" required placeholder="Min. 8 characters" class="w-full px-4 py-2.5 text-sm border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all"></div>
                        <div><label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-1.5">Confirm Password</label><input id="password_confirmation" name="password_confirmation" type="password" required placeholder="Re-enter password" class="w-full px-4 py-2.5 text-sm border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all"></div>
                    </div>
                    <div class="mt-6 flex gap-3">
                        <button type="button" data-step-prev class="flex items-center justify-center gap-2 px-5 py-3 border border-gray-200 text-gray-700 font-medium rounded-xl hover:bg-gray-50 transition-colors"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg> Back</button>
                        <button type="button" data-step-next class="flex-1 flex items-center justify-center gap-2 py-3 bg-blue-600 text-white font-semibold rounded-xl hover:bg-blue-700 transition-colors">Continue <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg></button>
                    </div>
                </div>

                <div data-step="3" class="hidden">
                    <h2 class="text-xl font-bold text-gray-900 mb-1">Select Your Plan</h2>
                    <p class="text-sm text-gray-500 mb-6">You can change this anytime</p>
                    <div class="space-y-3" data-plan-picker>
                        <label data-plan-card class="flex items-start gap-4 p-4 rounded-xl border-2 cursor-pointer transition-all border-gray-200 hover:border-gray-300"><input type="radio" name="plan" value="basic" class="mt-1 accent-blue-600"><div class="flex-1"><div class="flex items-center justify-between"><p class="font-semibold text-gray-900">Basic</p><p class="font-bold text-gray-900">LKR 2,500 <span class="text-xs font-normal text-gray-400">/mo</span></p></div><p class="text-xs text-gray-500 mt-1">1 user &middot; 100 products &middot; Basic POS</p></div></label>
                        <label data-plan-card class="flex items-start gap-4 p-4 rounded-xl border-2 cursor-pointer transition-all border-blue-600 bg-blue-50/50"><input type="radio" name="plan" value="pro" class="mt-1 accent-blue-600" checked><div class="flex-1"><div class="flex items-center justify-between"><div class="flex items-center gap-2"><p class="font-semibold text-gray-900">Pro</p><span class="px-2 py-0.5 bg-blue-100 text-blue-700 text-xs font-semibold rounded-full">Recommended</span></div><p class="font-bold text-gray-900">LKR 5,000 <span class="text-xs font-normal text-gray-400">/mo</span></p></div><p class="text-xs text-gray-500 mt-1">5 users &middot; 1,000 products &middot; Full POS + Inventory + Reports</p></div></label>
                        <label data-plan-card class="flex items-start gap-4 p-4 rounded-xl border-2 cursor-pointer transition-all border-gray-200 hover:border-gray-300"><input type="radio" name="plan" value="enterprise" class="mt-1 accent-blue-600"><div class="flex-1"><div class="flex items-center justify-between"><p class="font-semibold text-gray-900">Enterprise</p><p class="font-bold text-gray-900">LKR 10,000 <span class="text-xs font-normal text-gray-400">/mo</span></p></div><p class="text-xs text-gray-500 mt-1">Unlimited users &middot; Unlimited products &middot; All features + Priority support</p></div></label>
                    </div>
                    <div class="mt-6 flex gap-3">
                        <button type="button" data-step-prev class="flex items-center justify-center gap-2 px-5 py-3 border border-gray-200 text-gray-700 font-medium rounded-xl hover:bg-gray-50 transition-colors"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg> Back</button>
                        <button type="submit" class="flex-1 flex items-center justify-center gap-2 py-3 bg-blue-600 text-white font-semibold rounded-xl hover:bg-blue-700 transition-colors">Create Account <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg></button>
                    </div>
                    <p class="mt-4 text-xs text-center text-gray-400">By creating an account, you agree to our Terms of Service and Privacy Policy.</p>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection


