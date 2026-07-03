@extends('layouts.dashboard')

@section('title', 'Sales - MultiBizPOS')

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
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-6 gap-4">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">Sales</h1>
                    <p class="text-sm text-gray-500 mt-1">Track and analyze your sales performance</p>
                </div>
                <div class="flex items-center gap-2">
                    <button class="flex items-center gap-2 px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-200 rounded-lg hover:bg-gray-50 transition-colors">Last 7 Days</button>
                    <button class="flex items-center gap-2 px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-200 rounded-lg hover:bg-gray-50 transition-colors">Export</button>
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-6">
                <div class="bg-white rounded-xl border border-gray-100 p-5 shadow-sm">
                    <p class="text-sm text-gray-500">Today's Sales</p>
                    <p class="text-2xl font-bold text-gray-900 mt-1">LKR 45,280</p>
                    <p class="text-xs text-emerald-600 mt-2">Up 12.5% vs last month</p>
                </div>
                <div class="bg-white rounded-xl border border-gray-100 p-5 shadow-sm">
                    <p class="text-sm text-gray-500">Total Invoices</p>
                    <p class="text-2xl font-bold text-gray-900 mt-1">24</p>
                    <p class="text-xs text-blue-600 mt-2">Up 5.2% vs last month</p>
                </div>
                <div class="bg-white rounded-xl border border-gray-100 p-5 shadow-sm">
                    <p class="text-sm text-gray-500">Avg. Transaction</p>
                    <p class="text-2xl font-bold text-gray-900 mt-1">LKR 1,887</p>
                    <p class="text-xs text-purple-600 mt-2">Up 3.1% vs last month</p>
                </div>
            </div>

            <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-5 mb-6" data-tab-group data-tab-initial="daily">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="font-semibold text-gray-900">Sales Trend</h3>
                    <div class="flex bg-gray-100 rounded-lg p-0.5">
                        <button
                            data-tab-target="daily"
                            data-active-classes="bg-white shadow-sm text-gray-900"
                            data-inactive-classes="text-gray-500"
                            class="px-3 py-1.5 text-xs font-medium rounded-md transition-all bg-white shadow-sm text-gray-900">
                            Daily
                        </button>
                        <button
                            data-tab-target="monthly"
                            data-active-classes="bg-white shadow-sm text-gray-900"
                            data-inactive-classes="text-gray-500"
                            class="px-3 py-1.5 text-xs font-medium rounded-md transition-all text-gray-500">
                            Monthly
                        </button>
                    </div>
                </div>
                <div class="h-64" data-tab-panel="daily">
                    <div class="flex items-end gap-3 h-full">
                        @foreach ([42500, 38200, 51800, 45300, 62100, 58400, 45280] as $value)
                            @php $height = max(20, round($value / 700)); @endphp
                            <div class="flex-1 bg-blue-500/80 rounded-t" style="height: {{ $height }}px"></div>
                        @endforeach
                    </div>
                </div>
                <div class="h-64 hidden" data-tab-panel="monthly">
                    <div class="flex items-end gap-3 h-full">
                        @foreach ([320000, 355000, 402000, 398000, 452000, 478000] as $value)
                            @php $height = max(20, round($value / 6000)); @endphp
                            <div class="flex-1 bg-blue-500/50 rounded-t" style="height: {{ $height }}px"></div>
                        @endforeach
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl border border-gray-100 shadow-sm overflow-hidden">
                <div class="p-4 border-b border-gray-100">
                    <div class="relative max-w-sm">
                        <input type="text" placeholder="Search by invoice or customer..." class="w-full pl-4 pr-4 py-2 text-sm border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all">
                    </div>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead>
                            <tr class="border-b border-gray-100">
                                <th class="text-left text-xs font-semibold text-gray-500 uppercase tracking-wider px-4 py-3">Invoice</th>
                                <th class="text-left text-xs font-semibold text-gray-500 uppercase tracking-wider px-4 py-3">Date</th>
                                <th class="text-left text-xs font-semibold text-gray-500 uppercase tracking-wider px-4 py-3">Customer</th>
                                <th class="text-left text-xs font-semibold text-gray-500 uppercase tracking-wider px-4 py-3">Items</th>
                                <th class="text-left text-xs font-semibold text-gray-500 uppercase tracking-wider px-4 py-3">Total</th>
                                <th class="text-left text-xs font-semibold text-gray-500 uppercase tracking-wider px-4 py-3">Payment</th>
                                <th class="text-left text-xs font-semibold text-gray-500 uppercase tracking-wider px-4 py-3">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50">
                            @foreach ([
                                ['INV-1024', '2026-03-14', 'Kamal Jayasinghe', 5, 3450, 'Cash', 'Completed'],
                                ['INV-1023', '2026-03-14', 'Dilani Wickrama', 12, 12800, 'Card', 'Completed'],
                                ['INV-1022', '2026-03-14', 'Sunil Bandara', 2, 890, 'Cash', 'Completed'],
                                ['INV-1021', '2026-03-14', 'Priya Mendis', 8, 5670, 'Mobile', 'Completed'],
                                ['INV-1020', '2026-03-13', 'Ranjith De Silva', 3, 2340, 'Cash', 'Completed'],
                                ['INV-1019', '2026-03-13', 'Anoma Perera', 6, 7890, 'Card', 'Completed'],
                                ['INV-1018', '2026-03-13', 'Chaminda Ratnayake', 1, 450, 'Cash', 'Refunded'],
                            ] as $row)
                                <tr class="hover:bg-gray-50/50">
                                    <td class="px-4 py-3 text-sm font-medium text-blue-600">{{ $row[0] }}</td>
                                    <td class="px-4 py-3 text-sm text-gray-700">{{ $row[1] }}</td>
                                    <td class="px-4 py-3 text-sm text-gray-700">{{ $row[2] }}</td>
                                    <td class="px-4 py-3 text-sm text-gray-700">{{ $row[3] }}</td>
                                    <td class="px-4 py-3 text-sm font-semibold">LKR {{ number_format($row[4]) }}</td>
                                    <td class="px-4 py-3">
                                        <span class="text-xs font-medium px-2 py-0.5 rounded-full {{ $row[5] === 'Cash' ? 'bg-emerald-50 text-emerald-700' : ($row[5] === 'Card' ? 'bg-blue-50 text-blue-700' : 'bg-purple-50 text-purple-700') }}">{{ $row[5] }}</span>
                                    </td>
                                    <td class="px-4 py-3">
                                        <span class="text-xs font-medium px-2 py-0.5 rounded-full {{ $row[6] === 'Completed' ? 'bg-emerald-50 text-emerald-700' : 'bg-red-50 text-red-700' }}">{{ $row[6] }}</span>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="flex items-center justify-between px-4 py-3 border-t border-gray-100">
                    <p class="text-xs text-gray-500">Showing 1-7 of 7</p>
                    <div class="flex items-center gap-1">
                        <button class="p-1.5 rounded-md hover:bg-gray-100 disabled:opacity-30 disabled:cursor-not-allowed transition-colors" disabled>Prev</button>
                        <span class="text-xs font-medium text-gray-600 px-2">1 / 1</span>
                        <button class="p-1.5 rounded-md hover:bg-gray-100 disabled:opacity-30 disabled:cursor-not-allowed transition-colors" disabled>Next</button>
                    </div>
                </div>
            </div>
        </div>
    </main>
</div>
@endsection
