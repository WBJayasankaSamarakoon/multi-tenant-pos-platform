@extends('layouts.dashboard')

@section('title', 'Owner Dashboard - MultiBizPOS')

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
        'userName' => 'Nimal Perera',
        'userRole' => 'Business Owner',
        'companyName' => 'Perera Grocery',
    ])

    <main class="flex-1 min-w-0">
        <div class="p-4 sm:p-6 lg:p-8">
            <div class="mb-6">
                <h1 class="text-2xl font-bold text-gray-900">Dashboard</h1>
                <p class="text-sm text-gray-500 mt-1">Welcome back, Nimal. Here's your business overview.</p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
                <div class="bg-white rounded-xl border border-gray-100 p-5 shadow-sm">
                    <p class="text-sm font-medium text-gray-500">Today's Sales</p>
                    <p class="text-2xl font-bold text-gray-900 mt-1">LKR 45,280</p>
                    <p class="text-xs text-emerald-600 mt-2">Up 12.5% vs last month</p>
                </div>
                <div class="bg-white rounded-xl border border-gray-100 p-5 shadow-sm">
                    <p class="text-sm font-medium text-gray-500">Monthly Revenue</p>
                    <p class="text-2xl font-bold text-gray-900 mt-1">LKR 1.24M</p>
                    <p class="text-xs text-blue-600 mt-2">Up 8.3% vs last month</p>
                </div>
                <div class="bg-white rounded-xl border border-gray-100 p-5 shadow-sm">
                    <p class="text-sm font-medium text-gray-500">Total Products</p>
                    <p class="text-2xl font-bold text-gray-900 mt-1">342</p>
                    <p class="text-xs text-purple-600 mt-2">Up 2.1% vs last month</p>
                </div>
                <div class="bg-white rounded-xl border border-gray-100 p-5 shadow-sm">
                    <p class="text-sm font-medium text-gray-500">Active Employees</p>
                    <p class="text-2xl font-bold text-gray-900 mt-1">8</p>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <div class="lg:col-span-2 bg-white rounded-xl border border-gray-100 shadow-sm p-5">
                    <div class="flex items-center justify-between mb-6">
                        <div>
                            <h3 class="font-semibold text-gray-900">Sales This Week</h3>
                            <p class="text-xs text-gray-500 mt-0.5">Daily revenue for the last 7 days</p>
                        </div>
                        <a href="/owner/sales" class="text-xs text-blue-600 font-medium hover:text-blue-700 flex items-center gap-1">
                            View All <span>&gt;</span>
                        </a>
                    </div>
                    <div class="h-64 flex items-end gap-3">
                        @foreach ([32500, 28400, 45200, 38900, 52100, 61800, 41300] as $value)
                            @php $height = max(20, round($value / 700)); @endphp
                            <div class="flex-1 bg-blue-500/80 rounded-t" style="height: {{ $height }}px"></div>
                        @endforeach
                    </div>
                </div>

                <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-5">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="font-semibold text-gray-900">Low Stock Alerts</h3>
                        <span class="text-xs font-medium text-amber-600 bg-amber-50 px-2 py-0.5 rounded-full">4 items</span>
                    </div>
                    <div class="space-y-3">
                        @foreach ([
                            ['Basmati Rice 5kg', 3, 10],
                            ['Coconut Oil 750ml', 5, 15],
                            ['Sugar 1kg', 8, 20],
                            ['Dhal 500g', 2, 10],
                        ] as $item)
                            <div class="flex items-center justify-between p-3 rounded-lg bg-amber-50/50 border border-amber-100/50">
                                <div>
                                    <p class="text-sm font-medium text-gray-900">{{ $item[0] }}</p>
                                    <p class="text-xs text-gray-500">Threshold: {{ $item[2] }}</p>
                                </div>
                                <span class="text-sm font-bold text-amber-600">{{ $item[1] }} left</span>
                            </div>
                        @endforeach
                    </div>
                    <a href="/owner/inventory" class="mt-4 block text-center text-xs text-blue-600 font-medium hover:text-blue-700">
                        Manage Inventory
                    </a>
                </div>
            </div>

            <div class="mt-6 bg-white rounded-xl border border-gray-100 shadow-sm">
                <div class="flex items-center justify-between p-5 border-b border-gray-100">
                    <h3 class="font-semibold text-gray-900">Recent Transactions</h3>
                    <a href="/owner/sales" class="text-xs text-blue-600 font-medium hover:text-blue-700 flex items-center gap-1">
                        View All <span>&gt;</span>
                    </a>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead>
                            <tr class="border-b border-gray-50">
                                <th class="text-left text-xs font-semibold text-gray-500 uppercase px-5 py-3">Invoice</th>
                                <th class="text-left text-xs font-semibold text-gray-500 uppercase px-5 py-3">Customer</th>
                                <th class="text-left text-xs font-semibold text-gray-500 uppercase px-5 py-3">Amount</th>
                                <th class="text-left text-xs font-semibold text-gray-500 uppercase px-5 py-3">Method</th>
                                <th class="text-left text-xs font-semibold text-gray-500 uppercase px-5 py-3">Time</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50">
                            @foreach ([
                                ['INV-1024', 'Kamal Jayasinghe', 'LKR 3,450', 'Cash', '2 min ago'],
                                ['INV-1023', 'Dilani Wickrama', 'LKR 12,800', 'Card', '15 min ago'],
                                ['INV-1022', 'Sunil Bandara', 'LKR 890', 'Cash', '32 min ago'],
                                ['INV-1021', 'Priya Mendis', 'LKR 5,670', 'Mobile', '1 hr ago'],
                                ['INV-1020', 'Ranjith De Silva', 'LKR 2,340', 'Cash', '1.5 hr ago'],
                            ] as $tx)
                                <tr class="hover:bg-gray-50/50">
                                    <td class="px-5 py-3 text-sm font-medium text-blue-600">{{ $tx[0] }}</td>
                                    <td class="px-5 py-3 text-sm text-gray-700">{{ $tx[1] }}</td>
                                    <td class="px-5 py-3 text-sm font-semibold text-gray-900">{{ $tx[2] }}</td>
                                    <td class="px-5 py-3">
                                        <span class="text-xs font-medium px-2 py-0.5 rounded-full {{ $tx[3] === 'Cash' ? 'bg-emerald-50 text-emerald-700' : ($tx[3] === 'Card' ? 'bg-blue-50 text-blue-700' : 'bg-purple-50 text-purple-700') }}">{{ $tx[3] }}</span>
                                    </td>
                                    <td class="px-5 py-3 text-sm text-gray-400">{{ $tx[4] }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="mt-6 grid grid-cols-2 sm:grid-cols-4 gap-3">
                <a href="/cashier" class="flex flex-col items-center gap-2 p-4 bg-white rounded-xl border border-gray-100 shadow-sm hover:border-blue-200 hover:shadow-md transition-all">
                    <div class="w-10 h-10 rounded-lg bg-blue-50 flex items-center justify-center">
                        <span class="text-blue-600 text-xs font-bold">$</span>
                    </div>
                    <span class="text-xs font-medium text-gray-700">New Sale</span>
                </a>
                <a href="/owner/inventory" class="flex flex-col items-center gap-2 p-4 bg-white rounded-xl border border-gray-100 shadow-sm hover:border-emerald-200 hover:shadow-md transition-all">
                    <div class="w-10 h-10 rounded-lg bg-emerald-50 flex items-center justify-center">
                        <span class="text-emerald-600 text-xs font-bold">I</span>
                    </div>
                    <span class="text-xs font-medium text-gray-700">Add Product</span>
                </a>
                <a href="/owner/employees" class="flex flex-col items-center gap-2 p-4 bg-white rounded-xl border border-gray-100 shadow-sm hover:border-amber-200 hover:shadow-md transition-all">
                    <div class="w-10 h-10 rounded-lg bg-amber-50 flex items-center justify-center">
                        <span class="text-amber-600 text-xs font-bold">E</span>
                    </div>
                    <span class="text-xs font-medium text-gray-700">Add Employee</span>
                </a>
                <a href="/owner/sales" class="flex flex-col items-center gap-2 p-4 bg-white rounded-xl border border-gray-100 shadow-sm hover:border-purple-200 hover:shadow-md transition-all">
                    <div class="w-10 h-10 rounded-lg bg-purple-50 flex items-center justify-center">
                        <span class="text-purple-600 text-xs font-bold">R</span>
                    </div>
                    <span class="text-xs font-medium text-gray-700">View Reports</span>
                </a>
            </div>
        </div>
    </main>
</div>
@endsection
