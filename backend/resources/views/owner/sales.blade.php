@extends('layouts.dashboard')

@section('content')
<div>
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-6 gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Sales</h1>
            <p class="text-sm text-gray-500 mt-1">
                Track and analyze your sales performance
            </p>
        </div>
        <div class="flex items-center gap-2">
            <button class="flex items-center gap-2 px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-200 rounded-lg hover:bg-gray-50 transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                </svg>
                Last 7 Days
            </button>
            <button class="flex items-center gap-2 px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-200 rounded-lg hover:bg-gray-50 transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                </svg>
                Export
            </button>
        </div>
    </div>

    {{-- KPIs --}}
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-6">
        @component('partials.stats-card', [
            'label' => "Today's Sales",
            'value' => 'LKR 45,280',
            'icon' => '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>',
            'trend' => ['value' => 12.5, 'isPositive' => true],
            'color' => 'emerald'
        ])
        @endcomponent

        @component('partials.stats-card', [
            'label' => 'Total Invoices',
            'value' => '24',
            'icon' => '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>',
            'trend' => ['value' => 5.2, 'isPositive' => true],
            'color' => 'blue'
        ])
        @endcomponent

        @component('partials.stats-card', [
            'label' => 'Avg. Transaction',
            'value' => 'LKR 1,887',
            'icon' => '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path></svg>',
            'trend' => ['value' => 3.1, 'isPositive' => true],
            'color' => 'purple'
        ])
        @endcomponent
    </div>

    {{-- Chart --}}
    <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-5 mb-6">
        <div class="flex items-center justify-between mb-4">
            <h3 class="font-semibold text-gray-900">Sales Trend</h3>
            <div class="flex bg-gray-100 rounded-lg p-0.5">
                <button class="px-3 py-1.5 text-xs font-medium rounded-md transition-all bg-white shadow-sm text-gray-900">
                    Daily
                </button>
                <button class="px-3 py-1.5 text-xs font-medium rounded-md transition-all text-gray-500">
                    Monthly
                </button>
            </div>
        </div>
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

    {{-- Sales Table --}}
    @php
        $salesRecords = [
            ['id' => 'INV-1024', 'date' => '2026-03-14', 'customer' => 'Kamal Jayasinghe', 'items' => 5, 'total' => 3450, 'method' => 'Cash', 'status' => 'Completed'],
            ['id' => 'INV-1023', 'date' => '2026-03-14', 'customer' => 'Dilani Wickrama', 'items' => 12, 'total' => 12800, 'method' => 'Card', 'status' => 'Completed'],
            ['id' => 'INV-1022', 'date' => '2026-03-14', 'customer' => 'Sunil Bandara', 'items' => 2, 'total' => 890, 'method' => 'Cash', 'status' => 'Completed'],
            ['id' => 'INV-1021', 'date' => '2026-03-14', 'customer' => 'Priya Mendis', 'items' => 8, 'total' => 5670, 'method' => 'Mobile', 'status' => 'Completed'],
            ['id' => 'INV-1020', 'date' => '2026-03-13', 'customer' => 'Ranjith De Silva', 'items' => 3, 'total' => 2340, 'method' => 'Cash', 'status' => 'Completed'],
            ['id' => 'INV-1019', 'date' => '2026-03-13', 'customer' => 'Anoma Perera', 'items' => 6, 'total' => 7890, 'method' => 'Card', 'status' => 'Completed'],
            ['id' => 'INV-1018', 'date' => '2026-03-13', 'customer' => 'Chaminda Ratnayake', 'items' => 1, 'total' => 450, 'method' => 'Cash', 'status' => 'Refunded'],
            ['id' => 'INV-1017', 'date' => '2026-03-12', 'customer' => 'Lakshmi Fernando', 'items' => 15, 'total' => 18500, 'method' => 'Card', 'status' => 'Completed'],
        ];
        $columns = [
            ['key' => 'id', 'label' => 'Invoice', 'sortable' => true],
            ['key' => 'date', 'label' => 'Date', 'sortable' => true],
            ['key' => 'customer', 'label' => 'Customer', 'sortable' => true],
            ['key' => 'items', 'label' => 'Items', 'sortable' => true],
            ['key' => 'total', 'label' => 'Total', 'sortable' => true],
            ['key' => 'method', 'label' => 'Payment'],
            ['key' => 'status', 'label' => 'Status'],
        ];
    @endphp
    @component('partials.data-table', [
        'columns' => $columns,
        'data' => $salesRecords,
        'searchPlaceholder' => 'Search by invoice or customer...',
        'searchKey' => 'customer',
        'pageSize' => 8
    ])
    @endcomponent
</div>
@endsection
