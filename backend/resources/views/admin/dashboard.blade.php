@extends('layouts.dashboard')

@section('content')
<div>
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-900">Platform Dashboard</h1>
        <p class="text-sm text-gray-500 mt-1">
            System-wide overview and monitoring
        </p>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
        @component('partials.stats-card', [
            'label' => 'Total Tenants',
            'value' => '134',
            'icon' => '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>',
            'trend' => ['value' => 19.6, 'isPositive' => true],
            'color' => 'blue'
        ])
        @endcomponent

        @component('partials.stats-card', [
            'label' => 'Active Subscriptions',
            'value' => '128',
            'icon' => '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h1m4 0h1m-7-10h2a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v2a2 2 0 002 2zm12 6a2 2 0 002-2v-2a2 2 0 00-2-2h-2a2 2 0 00-2 2v2a2 2 0 002 2zm0 0a2 2 0 002 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2a2 2 0 012-2zm-4 4h4"></path></svg>',
            'trend' => ['value' => 15.2, 'isPositive' => true],
            'color' => 'emerald'
        ])
        @endcomponent

        @component('partials.stats-card', [
            'label' => 'Monthly Revenue',
            'value' => 'LKR 742K',
            'icon' => '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>',
            'trend' => ['value' => 22.1, 'isPositive' => true],
            'color' => 'purple'
        ])
        @endcomponent

        @component('partials.stats-card', [
            'label' => 'System Health',
            'value' => '99.9%',
            'icon' => '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>',
            'color' => 'emerald'
        ])
        @endcomponent
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">
        <div class="lg:col-span-2 bg-white rounded-xl border border-gray-100 shadow-sm p-5">
            <div class="flex items-center justify-between mb-4">
                <h3 class="font-semibold text-gray-900">Tenant Growth</h3>
                <a href="/admin/tenants" class="text-xs text-blue-600 font-medium flex items-center gap-1">
                    View All
                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </a>
            </div>
            {{-- Simple bar chart representation --}}
            <div class="h-64 flex items-end justify-between gap-2 px-4">
                @foreach([42, 58, 71, 89, 112, 134] as $tenants)
                    <div class="flex-1 flex flex-col items-center gap-2">
                        <div class="w-full bg-blue-500 rounded-t" style="height: {{ ($tenants / 134) * 100 }}%;"></div>
                    </div>
                @endforeach
            </div>
            <div class="flex justify-between px-4 mt-2">
                @foreach(['Oct', 'Nov', 'Dec', 'Jan', 'Feb', 'Mar'] as $month)
                    <span class="text-xs text-gray-400">{{ $month }}</span>
                @endforeach
            </div>
        </div>

        <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-5">
            <h3 class="font-semibold text-gray-900 mb-4">
                Plan Distribution
            </h3>
            {{-- Simple pie chart representation using bars --}}
            <div class="space-y-3">
                @foreach([
                    ['name' => 'Basic', 'value' => 52, 'color' => 'bg-gray-400'],
                    ['name' => 'Pro', 'value' => 65, 'color' => 'bg-blue-500'],
                    ['name' => 'Enterprise', 'value' => 17, 'color' => 'bg-purple-500']
                ] as $plan)
                    <div>
                        <div class="flex justify-between text-sm mb-1">
                            <span class="text-gray-700">{{ $plan['name'] }}</span>
                            <span class="font-medium text-gray-900">{{ $plan['value'] }}</span>
                        </div>
                        <div class="w-full bg-gray-100 rounded-full h-2">
                            <div class="{{ $plan['color'] }} h-2 rounded-full" style="width: {{ ($plan['value'] / 65) * 100 }}%;"></div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    {{-- Recent Registrations --}}
    <div class="bg-white rounded-xl border border-gray-100 shadow-sm">
        <div class="flex items-center justify-between p-5 border-b border-gray-100">
            <h3 class="font-semibold text-gray-900">Recent Registrations</h3>
            <a href="/admin/tenants" class="text-xs text-blue-600 font-medium flex items-center gap-1">
                View All
                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                </svg>
            </a>
        </div>
        <div class="divide-y divide-gray-50">
            @foreach([
                ['name' => 'Jayawardena Hardware', 'plan' => 'Pro', 'date' => '2026-03-14', 'location' => 'Colombo'],
                ['name' => 'Mendis Pharmacy', 'plan' => 'Basic', 'date' => '2026-03-13', 'location' => 'Kandy'],
                ['name' => 'Fernando Textiles', 'plan' => 'Enterprise', 'date' => '2026-03-12', 'location' => 'Galle'],
                ['name' => 'Silva Bakery', 'plan' => 'Pro', 'date' => '2026-03-11', 'location' => 'Negombo'],
                ['name' => 'Bandara Electronics', 'plan' => 'Basic', 'date' => '2026-03-10', 'location' => 'Matara']
            ] as $reg)
                <div class="flex items-center justify-between p-4 hover:bg-gray-50/50">
                    <div class="flex items-center gap-3">
                        <div class="w-9 h-9 rounded-lg bg-blue-50 flex items-center justify-center">
                            <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-900">{{ $reg['name'] }}</p>
                            <p class="text-xs text-gray-400">{{ $reg['location'] }} · {{ $reg['date'] }}</p>
                        </div>
                    </div>
                    <span class="text-xs font-medium px-2 py-0.5 rounded-full {{ $reg['plan'] === 'Basic' ? 'bg-gray-100 text-gray-600' : ($reg['plan'] === 'Pro' ? 'bg-blue-100 text-blue-700' : 'bg-purple-100 text-purple-700') }}">
                        {{ $reg['plan'] }}
                    </span>
                </div>
            @endforeach
        </div>
    </div>
</div>
@endsection
