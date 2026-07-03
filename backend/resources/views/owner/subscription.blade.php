@extends('layouts.dashboard')

@section('content')
<div>
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-900">Subscription</h1>
        <p class="text-sm text-gray-500 mt-1">
            Manage your plan and billing
        </p>
    </div>

    {{-- Current Plan --}}
    <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-6 mb-6">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <div class="flex items-center gap-2 mb-1">
                    <h3 class="text-lg font-bold text-gray-900">Pro Plan</h3>
                    <span class="px-2 py-0.5 bg-blue-100 text-blue-700 text-xs font-semibold rounded-full">
                        Active
                    </span>
                </div>
                <p class="text-sm text-gray-500">
                    LKR 5,000/month · Renews on April 15, 2026
                </p>
            </div>
            <div class="flex gap-2">
                <button class="px-4 py-2 text-sm font-medium text-gray-700 border border-gray-200 rounded-lg hover:bg-gray-50 transition-colors">
                    Change Plan
                </button>
                <button class="px-4 py-2 text-sm font-medium text-red-600 border border-red-200 rounded-lg hover:bg-red-50 transition-colors">
                    Cancel
                </button>
            </div>
        </div>
    </div>

    {{-- Usage Stats --}}
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-6">
        <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-5">
            <p class="text-sm text-gray-500 mb-2">Users</p>
            <div class="flex items-end justify-between">
                <p class="text-2xl font-bold text-gray-900">
                    5 <span class="text-sm font-normal text-gray-400">/ 5</span>
                </p>
            </div>
            <div class="mt-3 w-full bg-gray-100 rounded-full h-2">
                <div class="bg-blue-600 h-2 rounded-full" style="width: 100%;"></div>
            </div>
        </div>
        <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-5">
            <p class="text-sm text-gray-500 mb-2">Products</p>
            <div class="flex items-end justify-between">
                <p class="text-2xl font-bold text-gray-900">
                    342 <span class="text-sm font-normal text-gray-400">/ 1,000</span>
                </p>
            </div>
            <div class="mt-3 w-full bg-gray-100 rounded-full h-2">
                <div class="bg-emerald-500 h-2 rounded-full" style="width: 34.2%;"></div>
            </div>
        </div>
        <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-5">
            <p class="text-sm text-gray-500 mb-2">Monthly Transactions</p>
            <div class="flex items-end justify-between">
                <p class="text-2xl font-bold text-gray-900">1,247</p>
            </div>
            <p class="text-xs text-gray-400 mt-2">Unlimited on Pro plan</p>
        </div>
    </div>

    {{-- Upgrade Options --}}
    <div class="bg-gradient-to-r from-gray-900 to-slate-800 rounded-xl p-6 mb-6">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <div class="flex items-center gap-2 mb-1">
                    <svg class="w-5 h-5 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                    </svg>
                    <h3 class="text-lg font-bold text-white">
                        Upgrade to Enterprise
                    </h3>
                </div>
                <p class="text-sm text-slate-300">
                    Unlimited users, products, and priority support for LKR 10,000/mo
                </p>
            </div>
            <button class="px-6 py-2.5 bg-blue-600 text-white text-sm font-semibold rounded-lg hover:bg-blue-500 transition-colors whitespace-nowrap">
                Upgrade Now
            </button>
        </div>
    </div>

    {{-- Billing History --}}
    <div class="bg-white rounded-xl border border-gray-100 shadow-sm">
        <div class="p-5 border-b border-gray-100">
            <h3 class="font-semibold text-gray-900 flex items-center gap-2">
                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h1m4 0h1m-7-10h2a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v2a2 2 0 002 2zm12 6a2 2 0 002-2v-2a2 2 0 00-2-2h-2a2 2 0 00-2 2v2a2 2 0 002 2zm0 0a2 2 0 002 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2a2 2 0 012-2zm-4 4h4"></path>
                </svg>
                Billing History
            </h3>
        </div>
        <div class="divide-y divide-gray-50">
            <div class="flex items-center justify-between p-5">
                <div class="flex items-center gap-3">
                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                    <div>
                        <p class="text-sm font-medium text-gray-900">March 2026</p>
                        <p class="text-xs text-gray-500">Pro Plan - Monthly</p>
                    </div>
                </div>
                <div class="text-right">
                    <p class="text-sm font-semibold text-gray-900">LKR 5,000</p>
                    <span class="text-xs text-emerald-600 font-medium">Paid</span>
                </div>
            </div>
            <div class="flex items-center justify-between p-5">
                <div class="flex items-center gap-3">
                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                    <div>
                        <p class="text-sm font-medium text-gray-900">February 2026</p>
                        <p class="text-xs text-gray-500">Pro Plan - Monthly</p>
                    </div>
                </div>
                <div class="text-right">
                    <p class="text-sm font-semibold text-gray-900">LKR 5,000</p>
                    <span class="text-xs text-emerald-600 font-medium">Paid</span>
                </div>
            </div>
            <div class="flex items-center justify-between p-5">
                <div class="flex items-center gap-3">
                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                    <div>
                        <p class="text-sm font-medium text-gray-900">January 2026</p>
                        <p class="text-xs text-gray-500">Pro Plan - Monthly</p>
                    </div>
                </div>
                <div class="text-right">
                    <p class="text-sm font-semibold text-gray-900">LKR 5,000</p>
                    <span class="text-xs text-emerald-600 font-medium">Paid</span>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
