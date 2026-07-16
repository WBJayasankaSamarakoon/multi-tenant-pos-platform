@extends('layouts.dashboard')

@section('title', 'Reports - MultiBizPOS')

@section('content')
@php
    $menuItems = [
        ['label' => 'Dashboard', 'path' => '/manager', 'icon' => 'D', 'match' => 'manager'],
        ['label' => 'Inventory', 'path' => '/manager/inventory', 'icon' => 'I', 'match' => 'manager/inventory*'],
        ['label' => 'Reports', 'path' => '/manager/reports', 'icon' => 'R', 'match' => 'manager/reports*'],
        ['label' => 'Customers', 'path' => '/manager/customers', 'icon' => 'C', 'match' => 'manager/customers*'],
    ];
@endphp
<div class="flex min-h-screen bg-gray-50">
    @include('partials.sidebar', [
        'menuItems' => $menuItems,
        'userName' => auth()->user()?->name ?? 'Manager',
        'userRole' => 'Manager',
        'companyName' => $company->name ?? 'Business',
    ])

    <main class="flex-1 min-w-0">
        <div class="p-4 sm:p-6 lg:p-8">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-6 gap-4">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">Reports</h1>
                    <p class="text-sm text-gray-500 mt-1">Sales performance and analytics</p>
                </div>
                <button class="flex items-center gap-2 px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-200 rounded-lg hover:bg-gray-50 transition-colors">
                    Export Report
                </button>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-6">
                <div class="bg-white rounded-xl border border-gray-100 p-5 shadow-sm">
                    <p class="text-sm text-gray-500">Weekly Revenue</p>
                    <p class="text-2xl font-bold text-gray-900 mt-1">LKR {{ number_format($weeklyRevenue) }}</p>
                    <p class="text-xs text-emerald-600 mt-2">Up 8.3% vs last week</p>
                </div>
                <div class="bg-white rounded-xl border border-gray-100 p-5 shadow-sm">
                    <p class="text-sm text-gray-500">Avg. Daily Sales</p>
                    <p class="text-2xl font-bold text-gray-900 mt-1">LKR {{ number_format($avgDailySales) }}</p>
                    <p class="text-xs text-blue-600 mt-2">Up 5.1% vs last week</p>
                </div>
                <div class="bg-white rounded-xl border border-gray-100 p-5 shadow-sm">
                    <p class="text-sm text-gray-500">Items Sold</p>
                    <p class="text-2xl font-bold text-gray-900 mt-1">{{ $itemsSold }}</p>
                    <p class="text-xs text-purple-600 mt-2">Up 12.0% vs last week</p>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-5">
                    <h3 class="font-semibold text-gray-900 mb-4">Daily Sales Summary</h3>
                    <div class="h-64 flex items-end gap-3">
                        @foreach ($salesSeries as $value)
                            @php $height = max(20, round($value / 700)); @endphp
                            <div class="flex-1 bg-blue-500/80 rounded-t" style="height: {{ $height }}px"></div>
                        @endforeach
                    </div>
                </div>

                <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-5">
                    <h3 class="font-semibold text-gray-900 mb-4">Top Selling Products</h3>
                    <div class="space-y-4">
                        @foreach ($topProducts as $item)
                            <div>
                                <div class="flex items-center justify-between text-sm">
                                    <span class="text-gray-700">{{ $item->name }}</span>
                                    <span class="font-semibold">LKR {{ number_format($item->price) }}</span>
                                </div>
                                <div class="mt-2 w-full bg-gray-100 rounded-full h-2">
                                    <div class="bg-blue-500 h-2 rounded-full" style="width: {{ min(100, round($item->price / 1000)) }}%"></div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </main>
</div>
@endsection
