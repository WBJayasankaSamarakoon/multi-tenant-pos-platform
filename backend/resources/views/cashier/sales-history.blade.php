@extends('layouts.dashboard')

@section('content')
<div class="p-4 sm:p-6 lg:p-8">
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-900">Sales History</h1>
        <p class="text-sm text-gray-500 mt-1">Today's transactions</p>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-6">
        <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-5">
            <p class="text-sm text-gray-500">Total Sales</p>
            <p class="text-2xl font-bold text-gray-900 mt-1">LKR 51,990</p>
        </div>
        <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-5">
            <p class="text-sm text-gray-500">Transactions</p>
            <p class="text-2xl font-bold text-gray-900 mt-1">8</p>
        </div>
        <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-5">
            <p class="text-sm text-gray-500">Average Sale</p>
            <p class="text-2xl font-bold text-gray-900 mt-1">LKR 6,499</p>
        </div>
    </div>

    @php
        $todaysSales = [
            ['id' => 'INV-1024', 'time' => '14:32', 'customer' => 'Kamal Jayasinghe', 'items' => 5, 'total' => 3450, 'method' => 'Cash'],
            ['id' => 'INV-1023', 'time' => '14:15', 'customer' => 'Dilani Wickrama', 'items' => 12, 'total' => 12800, 'method' => 'Card'],
            ['id' => 'INV-1022', 'time' => '13:48', 'customer' => 'Walk-in Customer', 'items' => 2, 'total' => 890, 'method' => 'Cash'],
            ['id' => 'INV-1021', 'time' => '13:20', 'customer' => 'Priya Mendis', 'items' => 8, 'total' => 5670, 'method' => 'Mobile'],
            ['id' => 'INV-1020', 'time' => '12:45', 'customer' => 'Walk-in Customer', 'items' => 3, 'total' => 2340, 'method' => 'Cash'],
            ['id' => 'INV-1019', 'time' => '11:30', 'customer' => 'Anoma Perera', 'items' => 6, 'total' => 7890, 'method' => 'Card'],
            ['id' => 'INV-1018', 'time' => '10:15', 'customer' => 'Walk-in Customer', 'items' => 1, 'total' => 450, 'method' => 'Cash'],
            ['id' => 'INV-1017', 'time' => '09:45', 'customer' => 'Lakshmi Fernando', 'items' => 15, 'total' => 18500, 'method' => 'Card'],
        ];
        $columns = [
            ['key' => 'id', 'label' => 'Invoice'],
            ['key' => 'time', 'label' => 'Time'],
            ['key' => 'customer', 'label' => 'Customer', 'sortable' => true],
            ['key' => 'items', 'label' => 'Items'],
            ['key' => 'total', 'label' => 'Total', 'sortable' => true],
            ['key' => 'method', 'label' => 'Payment'],
        ];
    @endphp
    @component('partials.data-table', [
        'columns' => $columns,
        'data' => $todaysSales,
        'searchPlaceholder' => 'Search by invoice number...',
        'searchKey' => 'id',
        'pageSize' => 10
    ])
    @endcomponent
</div>
@endsection
