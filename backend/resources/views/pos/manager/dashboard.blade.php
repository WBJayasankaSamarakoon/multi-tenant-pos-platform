@extends('layouts.dashboard')

@section('title', 'Manager Dashboard - MultiBizPOS')

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
        'userName' => 'Saman Kumara',
        'userRole' => 'Manager',
        'companyName' => 'Perera Grocery',
    ])

    <main class="flex-1 min-w-0">
        <div class="p-4 sm:p-6 lg:p-8">
            <div class="mb-6">
                <h1 class="text-2xl font-bold text-gray-900">Manager Dashboard</h1>
                <p class="text-sm text-gray-500 mt-1">Overview of store operations</p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
                <div class="bg-white rounded-xl border border-gray-100 p-5 shadow-sm">
                    <p class="text-sm font-medium text-gray-500">Today's Sales</p>
                    <p class="text-2xl font-bold text-gray-900 mt-1">LKR 45,280</p>
                    <p class="text-xs text-emerald-600 mt-2">Up 12.5% vs last month</p>
                </div>
                <div class="bg-white rounded-xl border border-gray-100 p-5 shadow-sm">
                    <p class="text-sm font-medium text-gray-500">Total Products</p>
                    <p class="text-2xl font-bold text-gray-900 mt-1">342</p>
                </div>
                <div class="bg-white rounded-xl border border-gray-100 p-5 shadow-sm">
                    <p class="text-sm font-medium text-gray-500">Low Stock Items</p>
                    <p class="text-2xl font-bold text-gray-900 mt-1">4</p>
                </div>
                <div class="bg-white rounded-xl border border-gray-100 p-5 shadow-sm">
                    <p class="text-sm font-medium text-gray-500">Today's Orders</p>
                    <p class="text-2xl font-bold text-gray-900 mt-1">24</p>
                    <p class="text-xs text-purple-600 mt-2">Up 5.2% vs last month</p>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <div class="lg:col-span-2 bg-white rounded-xl border border-gray-100 shadow-sm p-5">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="font-semibold text-gray-900">Weekly Sales</h3>
                        <a href="/manager/reports" class="text-xs text-blue-600 font-medium flex items-center gap-1">View Reports <span>&gt;</span></a>
                    </div>
                    <div class="h-56 flex items-end gap-3">
                        @foreach ([32500, 28400, 45200, 38900, 52100, 61800, 41300] as $value)
                            @php $height = max(20, round($value / 700)); @endphp
                            <div class="flex-1 bg-blue-500/80 rounded-t" style="height: {{ $height }}px"></div>
                        @endforeach
                    </div>
                </div>

                <div class="space-y-6">
                    <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-5">
                        <h3 class="font-semibold text-gray-900 mb-3">Low Stock</h3>
                        <div class="space-y-2">
                            @foreach ([['Dhal 500g', 2], ['Basmati Rice 5kg', 3], ['Coconut Oil 750ml', 5], ['Sugar 1kg', 8]] as $item)
                                <div class="flex justify-between items-center p-2 rounded-lg bg-amber-50/50">
                                    <span class="text-sm text-gray-700">{{ $item[0] }}</span>
                                    <span class="text-sm font-bold text-amber-600">{{ $item[1] }}</span>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-5">
                        <h3 class="font-semibold text-gray-900 mb-3">Recent Sales</h3>
                        <div class="space-y-2">
                            @foreach ([['Kamal Jayasinghe', 'LKR 3,450', '2 min ago'], ['Dilani Wickrama', 'LKR 12,800', '15 min ago'], ['Sunil Bandara', 'LKR 890', '32 min ago']] as $sale)
                                <div class="flex justify-between items-center">
                                    <div>
                                        <p class="text-sm font-medium text-gray-900">{{ $sale[0] }}</p>
                                        <p class="text-xs text-gray-400">{{ $sale[2] }}</p>
                                    </div>
                                    <span class="text-sm font-semibold text-gray-900">{{ $sale[1] }}</span>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
</div>
@endsection
