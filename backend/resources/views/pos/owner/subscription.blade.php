@extends('layouts.dashboard')

@section('title', 'Subscription - MultiBizPOS')

@section('content')
@php
    $menuItems = [
        ['label' => 'Dashboard', 'path' => '/owner', 'icon' => 'D', 'match' => 'owner'],
        ['label' => 'Sales', 'path' => '/owner/sales', 'icon' => 'S', 'match' => 'owner/sales*'],
        ['label' => 'Inventory', 'path' => '/owner/inventory', 'icon' => 'I', 'match' => 'owner/inventory*'],
        ['label' => 'Employees', 'path' => '/owner/employees', 'icon' => 'E', 'match' => 'owner/employees*'],
        ['label' => 'Customers', 'path' => '/owner/customers', 'icon' => 'C', 'match' => 'owner/customers*'],
        ['label' => 'Settings', 'path' => '/owner/settings', 'icon' => 'S', 'match' => 'owner/settings*'],
        ['label' => 'Subscription', 'path' => '/owner/subscription', 'icon' => '$', 'match' => 'owner/subscription*'],
    ];
@endphp
<div class="flex min-h-screen bg-gray-50">
    @include('partials.sidebar', [
        'menuItems' => $menuItems,
        'userName' => auth()->user()?->name ?? 'Owner',
        'userRole' => 'Business Owner',
        'companyName' => $company->name ?? 'Business',
    ])

    <main class="flex-1 min-w-0">
        <div class="p-4 sm:p-6 lg:p-8">
            <div class="mb-6">
                <h1 class="text-2xl font-bold text-gray-900">Subscription</h1>
                <p class="text-sm text-gray-500 mt-1">Manage your plan and billing</p>
            </div>

            <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-6 mb-6">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                    <div>
                        <div class="flex items-center gap-2 mb-1">
                            <h3 class="text-lg font-bold text-gray-900">{{ $subscription->plan }}</h3>
                            <span class="px-2 py-0.5 bg-blue-100 text-blue-700 text-xs font-semibold rounded-full">{{ $subscription->status }}</span>
                        </div>
                        <p class="text-sm text-gray-500">LKR {{ number_format($subscription->price) }}/month · Renews on {{ $subscription->renews_at }}</p>
                    </div>
                    <div class="flex gap-2">
                        <button class="px-4 py-2 text-sm font-medium text-gray-700 border border-gray-200 rounded-lg hover:bg-gray-50 transition-colors">Change Plan</button>
                        <button class="px-4 py-2 text-sm font-medium text-red-600 border border-red-200 rounded-lg hover:bg-red-50 transition-colors">Cancel</button>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-6">
                <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-5">
                    <p class="text-sm text-gray-500 mb-2">Users</p>
                    <div class="flex items-end justify-between">
                        <p class="text-2xl font-bold text-gray-900">{{ $subscription->user_limit }} <span class="text-sm font-normal text-gray-400">/ {{ $subscription->user_limit }}</span></p>
                    </div>
                    <div class="mt-3 w-full bg-gray-100 rounded-full h-2">
                        <div class="bg-blue-600 h-2 rounded-full" style="width: 100%;"></div>
                    </div>
                </div>
                <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-5">
                    <p class="text-sm text-gray-500 mb-2">Products</p>
                    <div class="flex items-end justify-between">
                        <p class="text-2xl font-bold text-gray-900">{{ $subscription->product_limit }} <span class="text-sm font-normal text-gray-400">/ {{ $subscription->product_limit }}</span></p>
                    </div>
                    <div class="mt-3 w-full bg-gray-100 rounded-full h-2">
                        <div class="bg-emerald-500 h-2 rounded-full" style="width: 100%;"></div>
                    </div>
                </div>
                <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-5">
                    <p class="text-sm text-gray-500 mb-2">Monthly Transactions</p>
                    <div class="flex items-end justify-between">
                        <p class="text-2xl font-bold text-gray-900">{{ $subscription->transaction_limit }}</p>
                    </div>
                    <p class="text-xs text-gray-400 mt-2">Unlimited on {{ $subscription->plan }} plan</p>
                </div>
            </div>

            <div class="bg-gradient-to-r from-navy to-slate-800 rounded-xl p-6 mb-6">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                    <div>
                        <div class="flex items-center gap-2 mb-1">
                            <span class="text-blue-400 text-xs font-bold">UP</span>
                            <h3 class="text-lg font-bold text-white">Upgrade to Enterprise</h3>
                        </div>
                        <p class="text-sm text-slate-300">
                            Unlimited users, products, and priority support for LKR 10,000/mo
                        </p>
                    </div>
                    <button class="px-6 py-2.5 bg-blue-600 text-white text-sm font-semibold rounded-lg hover:bg-blue-500 transition-colors whitespace-nowrap">Upgrade Now</button>
                </div>
            </div>

            <div class="bg-white rounded-xl border border-gray-100 shadow-sm">
                <div class="p-5 border-b border-gray-100">
                    <h3 class="font-semibold text-gray-900">Billing History</h3>
                </div>
                <div class="divide-y divide-gray-50">
                    @foreach ($billingHistory as $bill)
                        <div class="flex items-center justify-between p-5">
                            <div>
                                <p class="text-sm font-medium text-gray-900">{{ $bill->period }}</p>
                                <p class="text-xs text-gray-500">{{ $subscription->plan }} - Monthly</p>
                            </div>
                            <div class="text-right">
                                <p class="text-sm font-semibold text-gray-900">LKR {{ number_format($bill->amount) }}</p>
                                <span class="text-xs text-emerald-600 font-medium">{{ $bill->status }}</span>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </main>
</div>
@endsection
