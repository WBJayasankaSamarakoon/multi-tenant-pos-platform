@extends('layouts.dashboard')

@section('content')
<div>
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-6 gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Inventory</h1>
            <p class="text-sm text-gray-500 mt-1">
                Manage products and suppliers
            </p>
        </div>
        <button class="flex items-center gap-2 px-4 py-2.5 bg-blue-600 text-white text-sm font-semibold rounded-lg hover:bg-blue-700 transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
            </svg>
            Add Product
        </button>
    </div>

    <div class="flex gap-1 bg-gray-100 rounded-lg p-0.5 w-fit mb-6">
        <button class="px-4 py-2 text-sm font-medium rounded-md transition-all bg-white shadow-sm text-gray-900">
            Products
        </button>
        <button class="px-4 py-2 text-sm font-medium rounded-md transition-all text-gray-500">
            Suppliers
        </button>
    </div>

    @php
        $products = [
            ['id' => 'P001', 'name' => 'Basmati Rice 5kg', 'category' => 'Groceries', 'price' => 1850, 'stock' => 3, 'barcode' => '8901234567890', 'supplier' => 'Lanka Rice Mills'],
            ['id' => 'P002', 'name' => 'Coconut Oil 750ml', 'category' => 'Cooking', 'price' => 890, 'stock' => 5, 'barcode' => '8901234567891', 'supplier' => 'Ceylon Oils Ltd'],
            ['id' => 'P003', 'name' => 'Sugar 1kg', 'category' => 'Groceries', 'price' => 320, 'stock' => 8, 'barcode' => '8901234567892', 'supplier' => 'Lanka Sugar Co'],
            ['id' => 'P004', 'name' => 'Dhal 500g', 'category' => 'Groceries', 'price' => 480, 'stock' => 2, 'barcode' => '8901234567893', 'supplier' => 'Import Foods Ltd'],
            ['id' => 'P005', 'name' => 'Milk Powder 400g', 'category' => 'Dairy', 'price' => 1250, 'stock' => 25, 'barcode' => '8901234567894', 'supplier' => 'Highland Dairy'],
            ['id' => 'P006', 'name' => 'Tea 200g', 'category' => 'Beverages', 'price' => 650, 'stock' => 42, 'barcode' => '8901234567895', 'supplier' => 'Dilmah Tea'],
            ['id' => 'P007', 'name' => 'Wheat Flour 1kg', 'category' => 'Groceries', 'price' => 280, 'stock' => 35, 'barcode' => '8901234567896', 'supplier' => 'Prima Mills'],
            ['id' => 'P008', 'name' => 'Canned Fish 425g', 'category' => 'Canned', 'price' => 520, 'stock' => 18, 'barcode' => '8901234567897', 'supplier' => 'Ocean Foods'],
        ];
        $columns = [
            ['key' => 'name', 'label' => 'Product', 'sortable' => true],
            ['key' => 'category', 'label' => 'Category'],
            ['key' => 'price', 'label' => 'Price', 'sortable' => true],
            ['key' => 'stock', 'label' => 'Stock', 'sortable' => true],
            ['key' => 'supplier', 'label' => 'Supplier'],
        ];
    @endphp
    @component('partials.data-table', [
        'columns' => $columns,
        'data' => $products,
        'searchPlaceholder' => 'Search products...',
        'searchKey' => 'name',
        'pageSize' => 8
    ])
    @endcomponent
</div>
@endsection
