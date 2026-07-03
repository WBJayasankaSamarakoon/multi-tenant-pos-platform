@extends('layouts.dashboard')

@section('content')
<div>
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-900">Dashboard</h1>
        <p class="text-sm text-gray-500 mt-1">
            Welcome back, Nimal. Here's your business overview.
        </p>
    </div>

    {{-- KPI Cards --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
        @component('partials.stats-card', [
            'label' => "Today's Sales",
            'value' => 'LKR 45,280',
            'icon' => '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>',
            'trend' => ['value' => 12.5, 'isPositive' => true],
            'color' => 'emerald'
        ])
        @endcomponent

        @component('partials.stats-card', [
            'label' => 'Monthly Revenue',
            'value' => 'LKR 1.24M',
            'icon' => '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path></svg>',
            'trend' => ['value' => 8.3, 'isPositive' => true],
            'color' => 'blue'
        ])
        @endcomponent

        @component('partials.stats-card', [
            'label' => 'Total Products',
            'value' => '342',
            'icon' => '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>',
            'trend' => ['value' => 2.1, 'isPositive' => true],
            'color' => 'purple'
        ])
        @endcomponent

        @component('partials.stats-card', [
            'label' => 'Active Employees',
            'value' => '8',
            'icon' => '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>',
            'color' => 'amber'
        ])
        @endcomponent
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        {{-- Sales Chart --}}
        <div class="lg:col-span-2 bg-white rounded-xl border border-gray-100 shadow-sm p-5">
            <div class="flex items-center justify-between mb-6">
                <div>
                    <h3 class="font-semibold text-gray-900">Sales This Week</h3>
                    <p class="text-xs text-gray-500 mt-0.5">
                        Daily revenue for the last 7 days
                    </p>
                </div>
                <a href="/owner/sales" class="text-xs text-blue-600 font-medium hover:text-blue-700 flex items-center gap-1">
                    View All
                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </a>
            </div>
            {{-- Simple bar chart representation --}}
            <div class="h-64 flex items-end justify-between gap-2 px-4">
                @foreach([32, 28, 45, 39, 52, 62, 41] as $height)
                    <div class="flex-1 flex flex-col items-center gap-2">
                        <div class="w-full bg-blue-500 rounded-t" style="height: {{ $height }}%;"></div>
                        <span class="text-xs text-gray-400">{{ $loop->iteration % 2 == 0 ? '' : '' }}</span>
                    </div>
                @endforeach
            </div>
            <div class="flex justify-between px-4 mt-2">
                @foreach(['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'] as $day)
                    <span class="text-xs text-gray-400">{{ $day }}</span>
                @endforeach
            </div>
        </div>

        {{-- Low Stock Alerts --}}
        <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-5">
            <div class="flex items-center justify-between mb-4">
                <h3 class="font-semibold text-gray-900 flex items-center gap-2">
                    <svg class="w-4 h-4 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                    </svg>
                    Low Stock Alerts
                </h3>
                <span class="text-xs font-medium text-amber-600 bg-amber-50 px-2 py-0.5 rounded-full">
                    4 items
                </span>
            </div>
            <div class="space-y-3">
                @foreach([
                    ['name' => 'Basmati Rice 5kg', 'stock' => 3, 'threshold' => 10],
                    ['name' => 'Coconut Oil 750ml', 'stock' => 5, 'threshold' => 15],
                    ['name' => 'Sugar 1kg', 'stock' => 8, 'threshold' => 20],
                    ['name' => 'Dhal 500g', 'stock' => 2, 'threshold' => 10]
                ] as $item)
                    <div class="flex items-center justify-between p-3 rounded-lg bg-amber-50/50 border border-amber-100/50">
                        <div>
                            <p class="text-sm font-medium text-gray-900">{{ $item['name'] }}</p>
                            <p class="text-xs text-gray-500">Threshold: {{ $item['threshold'] }}</p>
                        </div>
                        <span class="text-sm font-bold text-amber-600">{{ $item['stock'] }} left</span>
                    </div>
                @endforeach
            </div>
            <a href="/owner/inventory" class="mt-4 block text-center text-xs text-blue-600 font-medium hover:text-blue-700">
                Manage Inventory →
            </a>
        </div>
    </div>

    {{-- Recent Transactions --}}
    <div class="mt-6 bg-white rounded-xl border border-gray-100 shadow-sm">
        <div class="flex items-center justify-between p-5 border-b border-gray-100">
            <h3 class="font-semibold text-gray-900">Recent Transactions</h3>
            <a href="/owner/sales" class="text-xs text-blue-600 font-medium hover:text-blue-700 flex items-center gap-1">
                View All
                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                </svg>
            </a>
        </div>

        {{-- Desktop Table --}}
        <div class="hidden md:block overflow-x-auto">
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
                    @foreach([
                        ['id' => 'INV-1024', 'customer' => 'Kamal Jayasinghe', 'amount' => 'LKR 3,450', 'time' => '2 min ago', 'method' => 'Cash'],
                        ['id' => 'INV-1023', 'customer' => 'Dilani Wickrama', 'amount' => 'LKR 12,800', 'time' => '15 min ago', 'method' => 'Card'],
                        ['id' => 'INV-1022', 'customer' => 'Sunil Bandara', 'amount' => 'LKR 890', 'time' => '32 min ago', 'method' => 'Cash'],
                        ['id' => 'INV-1021', 'customer' => 'Priya Mendis', 'amount' => 'LKR 5,670', 'time' => '1 hr ago', 'method' => 'Mobile'],
                        ['id' => 'INV-1020', 'customer' => 'Ranjith De Silva', 'amount' => 'LKR 2,340', 'time' => '1.5 hr ago', 'method' => 'Cash']
                    ] as $tx)
                        <tr class="hover:bg-gray-50/50">
                            <td class="px-5 py-3 text-sm font-medium text-blue-600">{{ $tx['id'] }}</td>
                            <td class="px-5 py-3 text-sm text-gray-700">{{ $tx['customer'] }}</td>
                            <td class="px-5 py-3 text-sm font-semibold text-gray-900">{{ $tx['amount'] }}</td>
                            <td class="px-5 py-3">
                                <span class="text-xs font-medium px-2 py-0.5 rounded-full {{ $tx['method'] === 'Cash' ? 'bg-emerald-50 text-emerald-700' : ($tx['method'] === 'Card' ? 'bg-blue-50 text-blue-700' : 'bg-purple-50 text-purple-700') }}">
                                    {{ $tx['method'] }}
                                </span>
                            </td>
                            <td class="px-5 py-3 text-sm text-gray-400">{{ $tx['time'] }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{-- Mobile Cards --}}
        <div class="md:hidden divide-y divide-gray-100">
            @foreach([
                ['id' => 'INV-1024', 'customer' => 'Kamal Jayasinghe', 'amount' => 'LKR 3,450', 'time' => '2 min ago'],
                ['id' => 'INV-1023', 'customer' => 'Dilani Wickrama', 'amount' => 'LKR 12,800', 'time' => '15 min ago'],
                ['id' => 'INV-1022', 'customer' => 'Sunil Bandara', 'amount' => 'LKR 890', 'time' => '32 min ago']
            ] as $tx)
                <div class="p-4 space-y-2">
                    <div class="flex justify-between">
                        <span class="text-sm font-medium text-blue-600">{{ $tx['id'] }}</span>
                        <span class="text-sm font-semibold text-gray-900">{{ $tx['amount'] }}</span>
                    </div>
                    <div class="flex justify-between text-xs text-gray-500">
                        <span>{{ $tx['customer'] }}</span>
                        <span>{{ $tx['time'] }}</span>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    {{-- Quick Actions --}}
    <div class="mt-6 grid grid-cols-2 sm:grid-cols-4 gap-3">
        <a href="/cashier" class="flex flex-col items-center gap-2 p-4 bg-white rounded-xl border border-gray-100 shadow-sm hover:border-blue-200 hover:shadow-md transition-all">
            <div class="w-10 h-10 rounded-lg bg-blue-50 flex items-center justify-center">
                <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
            <span class="text-xs font-medium text-gray-700">New Sale</span>
        </a>
        <a href="/owner/inventory" class="flex flex-col items-center gap-2 p-4 bg-white rounded-xl border border-gray-100 shadow-sm hover:border-emerald-200 hover:shadow-md transition-all">
            <div class="w-10 h-10 rounded-lg bg-emerald-50 flex items-center justify-center">
                <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                </svg>
            </div>
            <span class="text-xs font-medium text-gray-700">Add Product</span>
        </a>
        <a href="/owner/employees" class="flex flex-col items-center gap-2 p-4 bg-white rounded-xl border border-gray-100 shadow-sm hover:border-amber-200 hover:shadow-md transition-all">
            <div class="w-10 h-10 rounded-lg bg-amber-50 flex items-center justify-center">
                <svg class="w-5 h-5 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                </svg>
            </div>
            <span class="text-xs font-medium text-gray-700">Add Employee</span>
        </a>
        <a href="/owner/sales" class="flex flex-col items-center gap-2 p-4 bg-white rounded-xl border border-gray-100 shadow-sm hover:border-purple-200 hover:shadow-md transition-all">
            <div class="w-10 h-10 rounded-lg bg-purple-50 flex items-center justify-center">
                <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                </svg>
            </div>
            <span class="text-xs font-medium text-gray-700">View Reports</span>
        </a>
    </div>
</div>
@endsection
