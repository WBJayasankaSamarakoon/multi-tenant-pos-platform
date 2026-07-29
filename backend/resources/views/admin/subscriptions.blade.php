@extends('layouts.dashboard')

@section('content')
<div>
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-900">Subscriptions</h1>
        <p class="text-sm text-gray-500 mt-1">
            Manage platform subscriptions and billing
        </p>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
        @component('partials.stats-card', [
            'label' => 'Monthly Revenue',
            'value' => 'LKR 742K',
            'icon' => '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>',
            'trend' => ['value' => 22.1, 'isPositive' => true],
            'color' => 'emerald'
        ])
        @endcomponent

        @component('partials.stats-card', [
            'label' => 'Active Plans',
            'value' => '128',
            'icon' => '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h1m4 0h1m-7-10h2a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v2a2 2 0 002 2zm12 6a2 2 0 002-2v-2a2 2 0 00-2-2h-2a2 2 0 00-2 2v2a2 2 0 002 2zm0 0a2 2 0 002 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2a2 2 0 012-2zm-4 4h4"></path></svg>',
            'trend' => ['value' => 15.2, 'isPositive' => true],
            'color' => 'blue'
        ])
        @endcomponent

        @component('partials.stats-card', [
            'label' => 'Expiring Soon',
            'value' => '3',
            'icon' => '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>',
            'color' => 'amber'
        ])
        @endcomponent

        @component('partials.stats-card', [
            'label' => 'Avg. Revenue/Tenant',
            'value' => 'LKR 5,797',
            'icon' => '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path></svg>',
            'trend' => ['value' => 4.5, 'isPositive' => true],
            'color' => 'purple'
        ])
        @endcomponent
    </div>

    <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-5 mb-6">
        <h3 class="font-semibold text-gray-900 mb-4">Revenue by Plan</h3>
        {{-- Simple horizontal bar chart representation --}}
        <div class="space-y-3">
            @foreach([
                ['plan' => 'Basic', 'revenue' => 130000],
                ['plan' => 'Pro', 'revenue' => 325000],
                ['plan' => 'Enterprise', 'revenue' => 170000]
            ] as $item)
                <div>
                    <div class="flex justify-between text-sm mb-1">
                        <span class="text-gray-700">{{ $item['plan'] }}</span>
                        <span class="font-medium text-gray-900">LKR {{ number_format($item['revenue']) }}</span>
                    </div>
                    <div class="w-full bg-gray-100 rounded-full h-2">
                        <div class="bg-blue-500 h-2 rounded-full" style="width: {{ ($item['revenue'] / 325000) * 100 }}%;"></div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    @php
        $subscriptions = [
            ['company' => 'Perera Grocery', 'plan' => 'Pro', 'amount' => 5000, 'status' => 'Active', 'nextBilling' => '2026-04-15', 'startDate' => '2025-01-15'],
            ['company' => 'Silva Electronics', 'plan' => 'Enterprise', 'amount' => 10000, 'status' => 'Active', 'nextBilling' => '2026-04-20', 'startDate' => '2025-01-20'],
            ['company' => 'Fernando Textiles', 'plan' => 'Pro', 'amount' => 5000, 'status' => 'Active', 'nextBilling' => '2026-04-01', 'startDate' => '2025-02-01'],
            ['company' => 'Mendis Pharmacy', 'plan' => 'Basic', 'amount' => 2500, 'status' => 'Active', 'nextBilling' => '2026-04-15', 'startDate' => '2025-02-15'],
            ['company' => 'Bandara Hardware', 'plan' => 'Pro', 'amount' => 5000, 'status' => 'Active', 'nextBilling' => '2026-04-01', 'startDate' => '2025-03-01'],
            ['company' => 'Jayawardena Books', 'plan' => 'Basic', 'amount' => 2500, 'status' => 'Expired', 'nextBilling' => '-', 'startDate' => '2025-03-05'],
            ['company' => 'Ratnayake Foods', 'plan' => 'Enterprise', 'amount' => 10000, 'status' => 'Active', 'nextBilling' => '2026-04-10', 'startDate' => '2025-03-10'],
        ];
        $columns = [
            ['key' => 'company', 'label' => 'Company', 'sortable' => true],
            ['key' => 'plan', 'label' => 'Plan'],
            ['key' => 'amount', 'label' => 'Amount', 'sortable' => true],
            ['key' => 'status', 'label' => 'Status'],
            ['key' => 'nextBilling', 'label' => 'Next Billing', 'sortable' => true],
        ];
    @endphp
    @component('partials.data-table', [
        'columns' => $columns,
        'data' => $subscriptions,
        'searchPlaceholder' => 'Search by company...',
        'searchKey' => 'company',
        'pageSize' => 10
    ])
    @endcomponent
</div>
@endsection
