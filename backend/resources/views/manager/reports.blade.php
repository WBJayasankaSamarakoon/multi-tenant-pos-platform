@extends('layouts.dashboard')

@section('content')
<div>
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-6 gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Reports</h1>
            <p class="text-sm text-gray-500 mt-1">
                Sales performance and analytics
            </p>
        </div>
        <button class="flex items-center gap-2 px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-200 rounded-lg hover:bg-gray-50 transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
            </svg>
            Export Report
        </button>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-6">
        @component('partials.stats-card', [
            'label' => 'Weekly Revenue',
            'value' => 'LKR 343,580',
            'icon' => '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>',
            'trend' => ['value' => 8.3, 'isPositive' => true],
            'color' => 'emerald'
        ])
        @endcomponent

        @component('partials.stats-card', [
            'label' => 'Avg. Daily Sales',
            'value' => 'LKR 49,083',
            'icon' => '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path></svg>',
            'trend' => ['value' => 5.1, 'isPositive' => true],
            'color' => 'blue'
        ])
        @endcomponent

        @component('partials.stats-card', [
            'label' => 'Items Sold',
            'value' => '487',
            'icon' => '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>',
            'trend' => ['value' => 12.0, 'isPositive' => true],
            'color' => 'purple'
        ])
        @endcomponent
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-5">
            <h3 class="font-semibold text-gray-900 mb-4">
                Daily Sales Summary
            </h3>
            {{-- Simple bar chart representation --}}
            <div class="h-64 flex items-end justify-between gap-2 px-4">
                @foreach([42, 38, 52, 45, 62, 58, 45] as $height)
                    <div class="flex-1 flex flex-col items-center gap-2">
                        <div class="w-full bg-blue-500 rounded-t" style="height: {{ $height }}%;"></div>
                    </div>
                @endforeach
            </div>
            <div class="flex justify-between px-4 mt-2">
                @foreach(['Mar 8', 'Mar 9', 'Mar 10', 'Mar 11', 'Mar 12', 'Mar 13', 'Mar 14'] as $date)
                    <span class="text-xs text-gray-400">{{ $date }}</span>
                @endforeach
            </div>
        </div>

        <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-5">
            <h3 class="font-semibold text-gray-900 mb-4">
                Top Selling Products
            </h3>
            {{-- Simple pie chart representation using bars --}}
            <div class="space-y-3">
                @foreach([
                    ['name' => 'Basmati Rice 5kg', 'value' => 85200, 'color' => 'bg-blue-500'],
                    ['name' => 'Milk Powder 400g', 'value' => 62500, 'color' => 'bg-emerald-500'],
                    ['name' => 'Coconut Oil 750ml', 'value' => 44500, 'color' => 'bg-amber-500'],
                    ['name' => 'Tea 200g', 'value' => 32500, 'color' => 'bg-purple-500'],
                    ['name' => 'Sugar 1kg', 'value' => 28000, 'color' => 'bg-red-500']
                ] as $product)
                    <div>
                        <div class="flex justify-between text-sm mb-1">
                            <span class="text-gray-700">{{ $product['name'] }}</span>
                            <span class="font-medium text-gray-900">LKR {{ number_format($product['value']) }}</span>
                        </div>
                        <div class="w-full bg-gray-100 rounded-full h-2">
                            <div class="{{ $product['color'] }} h-2 rounded-full" style="width: {{ ($product['value'] / 85200) * 100 }}%;"></div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection
