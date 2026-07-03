@extends('layouts.dashboard')

@section('title', 'Subscriptions - MultiBizPOS')

@section('content')
@php
    $menuItems = [
        ['label' => 'Dashboard', 'path' => '/admin', 'icon' => 'D', 'match' => 'admin'],
        ['label' => 'Tenants', 'path' => '/admin/tenants', 'icon' => 'T', 'match' => 'admin/tenants*'],
        ['label' => 'Subscriptions', 'path' => '/admin/subscriptions', 'icon' => '$', 'match' => 'admin/subscriptions*'],
        ['label' => 'System Logs', 'path' => '/admin/logs', 'icon' => 'L', 'match' => 'admin/logs*'],
    ];
    $subscriptions = [
        ['Perera Grocery', 'Pro', 5000, 'Active', '2026-04-15'],
        ['Silva Electronics', 'Enterprise', 10000, 'Active', '2026-04-20'],
        ['Fernando Textiles', 'Pro', 5000, 'Active', '2026-04-01'],
        ['Mendis Pharmacy', 'Basic', 2500, 'Active', '2026-04-15'],
        ['Bandara Hardware', 'Pro', 5000, 'Active', '2026-04-01'],
        ['Jayawardena Books', 'Basic', 2500, 'Expired', '-'],
        ['Ratnayake Foods', 'Enterprise', 10000, 'Active', '2026-04-10'],
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
                <h1 class="text-2xl font-bold text-gray-900">Subscriptions</h1>
                <p class="text-sm text-gray-500 mt-1">Manage platform subscriptions and billing</p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
                <div class="bg-white rounded-xl border border-gray-100 p-5 shadow-sm">
                    <p class="text-sm text-gray-500">Monthly Revenue</p>
                    <p class="text-2xl font-bold text-gray-900 mt-1">LKR 742K</p>
                    <p class="text-xs text-emerald-600 mt-2">Up 22.1% vs last month</p>
                </div>
                <div class="bg-white rounded-xl border border-gray-100 p-5 shadow-sm">
                    <p class="text-sm text-gray-500">Active Plans</p>
                    <p class="text-2xl font-bold text-gray-900 mt-1">128</p>
                    <p class="text-xs text-blue-600 mt-2">Up 15.2% vs last month</p>
                </div>
                <div class="bg-white rounded-xl border border-gray-100 p-5 shadow-sm">
                    <p class="text-sm text-gray-500">Expiring Soon</p>
                    <p class="text-2xl font-bold text-gray-900 mt-1">3</p>
                </div>
                <div class="bg-white rounded-xl border border-gray-100 p-5 shadow-sm">
                    <p class="text-sm text-gray-500">Avg. Revenue/Tenant</p>
                    <p class="text-2xl font-bold text-gray-900 mt-1">LKR 5,797</p>
                    <p class="text-xs text-purple-600 mt-2">Up 4.5% vs last month</p>
                </div>
            </div>

            <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-5 mb-6">
                <h3 class="font-semibold text-gray-900 mb-4">Revenue by Plan</h3>
                <div class="space-y-3">
                    @foreach ([['Basic', 130000], ['Pro', 325000], ['Enterprise', 170000]] as $plan)
                        <div>
                            <div class="flex items-center justify-between text-sm">
                                <span class="text-gray-700">{{ $plan[0] }}</span>
                                <span class="font-semibold">LKR {{ number_format($plan[1]) }}</span>
                            </div>
                            <div class="mt-2 w-full bg-gray-100 rounded-full h-2">
                                <div class="bg-blue-600 h-2 rounded-full" style="width: {{ min(100, round($plan[1] / 4000)) }}%"></div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="bg-white rounded-xl border border-gray-100 shadow-sm overflow-hidden">
                <div class="p-4 border-b border-gray-100">
                    <div class="relative max-w-sm">
                        <input type="text" placeholder="Search by company..." class="w-full pl-4 pr-4 py-2 text-sm border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all">
                    </div>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead>
                            <tr class="border-b border-gray-100">
                                <th class="text-left text-xs font-semibold text-gray-500 uppercase tracking-wider px-4 py-3">Company</th>
                                <th class="text-left text-xs font-semibold text-gray-500 uppercase tracking-wider px-4 py-3">Plan</th>
                                <th class="text-left text-xs font-semibold text-gray-500 uppercase tracking-wider px-4 py-3">Amount</th>
                                <th class="text-left text-xs font-semibold text-gray-500 uppercase tracking-wider px-4 py-3">Status</th>
                                <th class="text-left text-xs font-semibold text-gray-500 uppercase tracking-wider px-4 py-3">Next Billing</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50">
                            @foreach ($subscriptions as $sub)
                                <tr class="hover:bg-gray-50/50">
                                    <td class="px-4 py-3 text-sm font-medium text-gray-900">{{ $sub[0] }}</td>
                                    <td class="px-4 py-3">
                                        <span class="text-xs font-medium px-2 py-0.5 rounded-full {{ $sub[1] === 'Basic' ? 'bg-gray-100 text-gray-600' : ($sub[1] === 'Pro' ? 'bg-blue-100 text-blue-700' : 'bg-purple-100 text-purple-700') }}">{{ $sub[1] }}</span>
                                    </td>
                                    <td class="px-4 py-3 text-sm font-semibold">LKR {{ number_format($sub[2]) }}</td>
                                    <td class="px-4 py-3">
                                        <span class="text-xs font-medium px-2 py-0.5 rounded-full {{ $sub[3] === 'Active' ? 'bg-emerald-50 text-emerald-700' : 'bg-red-50 text-red-700' }}">{{ $sub[3] }}</span>
                                    </td>
                                    <td class="px-4 py-3 text-sm text-gray-700">{{ $sub[4] }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </main>
</div>
@endsection
