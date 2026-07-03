@extends('layouts.dashboard')

@section('content')
<div>
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-900">Customers</h1>
        <p class="text-sm text-gray-500 mt-1">
            View and manage customer information
        </p>
    </div>

    @php
        $customers = [
            ['id' => 'C001', 'name' => 'Kamal Jayasinghe', 'email' => 'kamal@gmail.com', 'phone' => '+94 77 111 2233', 'totalPurchases' => 45200, 'visits' => 28],
            ['id' => 'C002', 'name' => 'Dilani Wickrama', 'email' => 'dilani@yahoo.com', 'phone' => '+94 77 222 3344', 'totalPurchases' => 128500, 'visits' => 52],
            ['id' => 'C003', 'name' => 'Sunil Bandara', 'email' => 'sunil@gmail.com', 'phone' => '+94 77 333 4455', 'totalPurchases' => 18900, 'visits' => 12],
            ['id' => 'C004', 'name' => 'Priya Mendis', 'email' => 'priya@hotmail.com', 'phone' => '+94 77 444 5566', 'totalPurchases' => 67800, 'visits' => 35],
            ['id' => 'C005', 'name' => 'Ranjith De Silva', 'email' => 'ranjith@gmail.com', 'phone' => '+94 77 555 6677', 'totalPurchases' => 34500, 'visits' => 20],
            ['id' => 'C006', 'name' => 'Anoma Perera', 'email' => 'anoma@gmail.com', 'phone' => '+94 77 666 7788', 'totalPurchases' => 89200, 'visits' => 41],
        ];
        $columns = [
            ['key' => 'name', 'label' => 'Name', 'sortable' => true],
            ['key' => 'email', 'label' => 'Email'],
            ['key' => 'phone', 'label' => 'Phone'],
            ['key' => 'totalPurchases', 'label' => 'Total Purchases', 'sortable' => true],
            ['key' => 'visits', 'label' => 'Visits', 'sortable' => true],
        ];
    @endphp
    @component('partials.data-table', [
        'columns' => $columns,
        'data' => $customers,
        'searchPlaceholder' => 'Search customers...',
        'searchKey' => 'name',
        'pageSize' => 10
    ])
    @endcomponent
</div>
@endsection
