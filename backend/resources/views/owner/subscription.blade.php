@extends('layouts.dashboard')

@section('content')
<div>
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-900">Subscription</h1>
        <p class="text-sm text-gray-500 mt-1">
            Manage your plan and billing
        </p>
    </div>

    <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-6 mb-6">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <div class="flex items-center gap-2 mb-1">
                    <h3 class="text-lg font-bold text-gray-900">{{ $subscription->plan ?? 'Pro Plan' }}</h3>
                    <span class="px-2 py-0.5 bg-blue-100 text-blue-700 text-xs font-semibold rounded-full">
                        {{ $subscription->status ?? 'Active' }}
                    </span>
                </div>
                <p class="text-sm text-gray-500">
                    LKR {{ number_format($subscription->price ?? 0, 0) }}/month · Renews on {{ \Illuminate\Support\Carbon::parse($subscription->renews_at ?? now())->toFormattedDateString() }}
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

    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-6">
        <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-5">
            <p class="text-sm text-gray-500 mb-2">Users</p>
            <div class="flex items-end justify-between">
                <p class="text-2xl font-bold text-gray-900">
                    {{ $subscription->user_limit ?? 0 }} <span class="text-sm font-normal text-gray-400">/ {{ $subscription->user_limit ?? 0 }}</span>
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
                    {{ $subscription->product_limit ?? 0 }} <span class="text-sm font-normal text-gray-400">/ {{ $subscription->product_limit ?? 0 }}</span>
                </p>
            </div>
            <div class="mt-3 w-full bg-gray-100 rounded-full h-2">
                <div class="bg-emerald-500 h-2 rounded-full" style="width: 100%;"></div>
            </div>
        </div>
        <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-5">
            <p class="text-sm text-gray-500 mb-2">Monthly Transactions</p>
            <div class="flex items-end justify-between">
                <p class="text-2xl font-bold text-gray-900">{{ $subscription->transaction_limit ?? 'Unlimited' }}</p>
            </div>
            <p class="text-xs text-gray-400 mt-2">Unlimited on {{ $subscription->plan ?? 'current' }} plan</p>
        </div>
    </div>

    <div class="bg-gradient-to-r from-gray-900 to-slate-800 rounded-xl p-6 mb-6">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <div class="flex items-center gap-2 mb-1">
                    <svg class="w-5 h-5 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                    </svg>
                    <h3 class="text-lg font-bold text-white">Upgrade to Enterprise</h3>
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
            @forelse($billingHistory ?? [] as $payment)
                <div class="flex items-center justify-between p-5">
                    <div class="flex items-center gap-3">
                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                        <div>
                            <p class="text-sm font-medium text-gray-900">{{ \Illuminate\Support\Carbon::parse($payment->period)->format('F Y') }}</p>
                            <p class="text-xs text-gray-500">{{ $subscription->plan ?? 'Plan' }} - Monthly</p>
                        </div>
                    </div>
                    <div class="text-right">
                        <p class="text-sm font-semibold text-gray-900">LKR {{ number_format($payment->amount, 0) }}</p>
                        <span class="text-xs text-emerald-600 font-medium">{{ $payment->status }}</span>
                    </div>
                </div>
            @empty
                <div class="p-5 text-sm text-gray-500">No payment history yet.</div>
            @endforelse
        </div>
    </div>
</div>
@endsection
