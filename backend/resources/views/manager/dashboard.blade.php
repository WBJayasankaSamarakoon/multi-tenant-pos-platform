@extends('layouts.dashboard')

@section('content')
<div>
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-900">Manager Dashboard</h1>
        <p class="text-sm text-gray-500 mt-1">
            Overview of store operations
        </p>
    </div>

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
            'label' => 'Total Products',
            'value' => '342',
            'icon' => '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>',
            'color' => 'blue'
        ])
        @endcomponent

        @component('partials.stats-card', [
            'label' => 'Low Stock Items',
            'value' => '4',
            'icon' => '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>',
            'color' => 'amber'
        ])
        @endcomponent

        @component('partials.stats-card', [
            'label' => "Today's Orders",
            'value' => '24',
            'icon' => '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>',
            'trend' => ['value' => 5.2, 'isPositive' => true],
            'color' => 'purple'
        ])
        @endcomponent
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="lg:col-span-2 bg-white rounded-xl border border-gray-100 shadow-sm p-5">
            <div class="flex items-center justify-between mb-4">
                <h3 class="font-semibold text-gray-900">Weekly Sales</h3>
                <a href="/manager/reports" class="text-xs text-blue-600 font-medium flex items-center gap-1">
                    View Reports
                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </a>
            </div>
            {{-- Simple bar chart representation --}}
            <div class="h-56 flex items-end justify-between gap-2 px-4">
                @foreach([32, 28, 45, 39, 52, 62, 41] as $height)
                    <div class="flex-1 flex flex-col items-center gap-2">
                        <div class="w-full bg-blue-500 rounded-t" style="height: {{ $height }}%;"></div>
                    </div>
                @endforeach
            </div>
            <div class="flex justify-between px-4 mt-2">
                @foreach(['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'] as $day)
                    <span class="text-xs text-gray-400">{{ $day }}</span>
                @endforeach
            </div>
        </div>

        <div class="space-y-6">
            <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-5">
                <h3 class="font-semibold text-gray-900 flex items-center gap-2 mb-3">
                    <svg class="w-4 h-4 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                    </svg>
                    Low Stock
                </h3>
                <div class="space-y-2">
                    @foreach([
                        ['name' => 'Dhal 500g', 'stock' => 2],
                        ['name' => 'Basmati Rice 5kg', 'stock' => 3],
                        ['name' => 'Coconut Oil 750ml', 'stock' => 5],
                        ['name' => 'Sugar 1kg', 'stock' => 8]
                    ] as $item)
                        <div class="flex justify-between items-center p-2 rounded-lg bg-amber-50/50">
                            <span class="text-sm text-gray-700">{{ $item['name'] }}</span>
                            <span class="text-sm font-bold text-amber-600">{{ $item['stock'] }}</span>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-5">
                <h3 class="font-semibold text-gray-900 mb-3">Recent Sales</h3>
                <div class="space-y-2">
                    @foreach([
                        ['id' => 'INV-1024', 'customer' => 'Kamal Jayasinghe', 'amount' => 'LKR 3,450', 'time' => '2 min ago'],
                        ['id' => 'INV-1023', 'customer' => 'Dilani Wickrama', 'amount' => 'LKR 12,800', 'time' => '15 min ago'],
                        ['id' => 'INV-1022', 'customer' => 'Sunil Bandara', 'amount' => 'LKR 890', 'time' => '32 min ago']
                    ] as $sale)
                        <div class="flex justify-between items-center">
                            <div>
                                <p class="text-sm font-medium text-gray-900">{{ $sale['customer'] }}</p>
                                <p class="text-xs text-gray-400">{{ $sale['time'] }}</p>
                            </div>
                            <span class="text-sm font-semibold text-gray-900">{{ $sale['amount'] }}</span>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
