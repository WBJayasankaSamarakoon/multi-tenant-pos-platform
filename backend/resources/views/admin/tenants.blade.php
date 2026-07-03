@extends('layouts.dashboard')

@section('content')
<div>
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-900">Tenants</h1>
        <p class="text-sm text-gray-500 mt-1">
            Manage all registered businesses
        </p>
    </div>

    @php
        $tenants = [
            ['id' => 'T001', 'name' => 'Perera Grocery', 'plan' => 'Pro', 'status' => 'Active', 'users' => 5, 'products' => 342, 'created' => '2025-01-15', 'location' => 'Colombo 03'],
            ['id' => 'T002', 'name' => 'Silva Electronics', 'plan' => 'Enterprise', 'status' => 'Active', 'users' => 12, 'products' => 890, 'created' => '2025-01-20', 'location' => 'Kandy'],
            ['id' => 'T003', 'name' => 'Fernando Textiles', 'plan' => 'Pro', 'status' => 'Active', 'users' => 4, 'products' => 256, 'created' => '2025-02-01', 'location' => 'Galle'],
            ['id' => 'T004', 'name' => 'Mendis Pharmacy', 'plan' => 'Basic', 'status' => 'Active', 'users' => 1, 'products' => 89, 'created' => '2025-02-15', 'location' => 'Negombo'],
            ['id' => 'T005', 'name' => 'Bandara Hardware', 'plan' => 'Pro', 'status' => 'Active', 'users' => 3, 'products' => 567, 'created' => '2025-03-01', 'location' => 'Matara'],
            ['id' => 'T006', 'name' => 'Jayawardena Books', 'plan' => 'Basic', 'status' => 'Suspended', 'users' => 1, 'products' => 45, 'created' => '2025-03-05', 'location' => 'Colombo 07'],
            ['id' => 'T007', 'name' => 'Ratnayake Foods', 'plan' => 'Enterprise', 'status' => 'Active', 'users' => 8, 'products' => 1200, 'created' => '2025-03-10', 'location' => 'Kurunegala'],
            ['id' => 'T008', 'name' => 'De Silva Bakery', 'plan' => 'Pro', 'status' => 'Active', 'users' => 3, 'products' => 178, 'created' => '2025-03-12', 'location' => 'Colombo 05'],
        ];
        $columns = [
            ['key' => 'name', 'label' => 'Company', 'sortable' => true],
            ['key' => 'plan', 'label' => 'Plan'],
            ['key' => 'status', 'label' => 'Status'],
            ['key' => 'users', 'label' => 'Users', 'sortable' => true],
            ['key' => 'products', 'label' => 'Products', 'sortable' => true],
            ['key' => 'created', 'label' => 'Created', 'sortable' => true],
        ];
    @endphp
    @component('partials.data-table', [
        'columns' => $columns,
        'data' => $tenants,
        'searchPlaceholder' => 'Search companies...',
        'searchKey' => 'name',
        'pageSize' => 10
    ])
    @endcomponent
</div>
@endsection
