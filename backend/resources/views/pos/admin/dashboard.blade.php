@extends('layouts.dashboard')

@section('title', 'Admin Dashboard - MultiBizPOS')

@section('content')
@php
    $menuItems = [
        ['label' => 'Dashboard', 'path' => '/admin', 'icon' => 'D', 'match' => 'admin'],
        ['label' => 'Tenants', 'path' => '/admin/tenants', 'icon' => 'T', 'match' => 'admin/tenants*'],
        ['label' => 'Subscriptions', 'path' => '/admin/subscriptions', 'icon' => '$', 'match' => 'admin/subscriptions*'],
        ['label' => 'System Logs', 'path' => '/admin/logs', 'icon' => 'L', 'match' => 'admin/logs*'],
    ];
@endphp
<div class="flex min-h-screen bg-gray-50">
    @include('partials.sidebar', [
        'menuItems' => $menuItems,
        'userName' => 'Admin User',
        'userRole' => 'Platform Admin',
    ])

    <main class="flex-1 min-w-0">
        <div class="p-4 sm:p-6 lg:p-8">
            <div class="mb-6">
                <h1 class="text-2xl font-bold text-gray-900">Platform Dashboard</h1>
                <p class="text-sm text-gray-500 mt-1">System-wide overview and monitoring</p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
                <div class="bg-white rounded-xl border border-gray-100 p-5 shadow-sm">
                    <p class="text-sm font-medium text-gray-500">Total Tenants</p>
                    <p class="text-2xl font-bold text-gray-900 mt-1">134</p>
                    <p class="text-xs text-blue-600 mt-2">Up 19.6% vs last month</p>
                </div>
                <div class="bg-white rounded-xl border border-gray-100 p-5 shadow-sm">
                    <p class="text-sm font-medium text-gray-500">Active Subscriptions</p>
                    <p class="text-2xl font-bold text-gray-900 mt-1">128</p>
                    <p class="text-xs text-emerald-600 mt-2">Up 15.2% vs last month</p>
                </div>
                <div class="bg-white rounded-xl border border-gray-100 p-5 shadow-sm">
                    <p class="text-sm font-medium text-gray-500">Monthly Revenue</p>
                    <p class="text-2xl font-bold text-gray-900 mt-1">LKR 742K</p>
                    <p class="text-xs text-purple-600 mt-2">Up 22.1% vs last month</p>
                </div>
                <div class="bg-white rounded-xl border border-gray-100 p-5 shadow-sm">
                    <p class="text-sm font-medium text-gray-500">System Health</p>
                    <p class="text-2xl font-bold text-gray-900 mt-1">99.9%</p>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">
                <div class="lg:col-span-2 bg-white rounded-xl border border-gray-100 shadow-sm p-5">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="font-semibold text-gray-900">Tenant Growth</h3>
                        <a href="/admin/tenants" class="text-xs text-blue-600 font-medium flex items-center gap-1">View All <span>&gt;</span></a>
                    </div>
                    <div class="h-64 flex items-end gap-3">
                        @foreach ([42, 58, 71, 89, 112, 134] as $value)
                            @php $height = max(20, $value * 2); @endphp
                            <div class="flex-1 bg-blue-500/80 rounded-t" style="height: {{ $height }}px"></div>
                        @endforeach
                    </div>
                </div>

                <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-5">
                    <h3 class="font-semibold text-gray-900 mb-4">Plan Distribution</h3>
                    <div class="space-y-3">
                        @foreach ([['Basic', 52, 'bg-gray-400'], ['Pro', 65, 'bg-blue-600'], ['Enterprise', 17, 'bg-purple-600']] as $plan)
                            <div>
                                <div class="flex items-center justify-between text-sm">
                                    <span class="text-gray-700">{{ $plan[0] }}</span>
                                    <span class="font-semibold">{{ $plan[1] }}</span>
                                </div>
                                <div class="mt-2 w-full bg-gray-100 rounded-full h-2">
                                    <div class="{{ $plan[2] }} h-2 rounded-full" style="width: {{ $plan[1] }}%"></div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl border border-gray-100 shadow-sm">
                <div class="flex items-center justify-between p-5 border-b border-gray-100">
                    <h3 class="font-semibold text-gray-900">Recent Registrations</h3>
                    <a href="/admin/tenants" class="text-xs text-blue-600 font-medium flex items-center gap-1">View All <span>&gt;</span></a>
                </div>
                <div class="divide-y divide-gray-50">
                    @foreach ([
                        ['Jayawardena Hardware', 'Pro', '2026-03-14', 'Colombo'],
                        ['Mendis Pharmacy', 'Basic', '2026-03-13', 'Kandy'],
                        ['Fernando Textiles', 'Enterprise', '2026-03-12', 'Galle'],
                        ['Silva Bakery', 'Pro', '2026-03-11', 'Negombo'],
                        ['Bandara Electronics', 'Basic', '2026-03-10', 'Matara'],
                    ] as $reg)
                        <div class="flex items-center justify-between p-4 hover:bg-gray-50/50">
                            <div>
                                <p class="text-sm font-medium text-gray-900">{{ $reg[0] }}</p>
                                <p class="text-xs text-gray-400">{{ $reg[3] }} · {{ $reg[2] }}</p>
                            </div>
                            <span class="text-xs font-medium px-2 py-0.5 rounded-full {{ $reg[1] === 'Basic' ? 'bg-gray-100 text-gray-600' : ($reg[1] === 'Pro' ? 'bg-blue-100 text-blue-700' : 'bg-purple-100 text-purple-700') }}">{{ $reg[1] }}</span>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </main>
</div>
@endsection
