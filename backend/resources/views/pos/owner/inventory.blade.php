@extends('layouts.dashboard')

@section('title', 'Inventory - MultiBizPOS')

@section('content')
@php
    $menuItems = [
        ['label' => 'Dashboard', 'path' => '/owner', 'icon' => 'D', 'match' => 'owner'],
        ['label' => 'Sales', 'path' => '/owner/sales', 'icon' => 'S', 'match' => 'owner/sales*'],
        ['label' => 'Inventory', 'path' => '/owner/inventory', 'icon' => 'I', 'match' => 'owner/inventory*'],
        ['label' => 'Employees', 'path' => '/owner/employees', 'icon' => 'E', 'match' => 'owner/employees*'],
        ['label' => 'Customers', 'path' => '/owner/customers', 'icon' => 'C', 'match' => 'owner/customers*'],
        ['label' => 'Settings', 'path' => '/owner/settings', 'icon' => 'S', 'match' => 'owner/settings*'],
        ['label' => 'Subscription', 'path' => '/owner/subscription', 'icon' => '$', 'match' => 'owner/subscription*'],
    ];
    $categories = ['All', 'Groceries', 'Cooking', 'Dairy', 'Beverages', 'Canned', 'Personal Care'];
    $products = [
        ['P001', 'Basmati Rice 5kg', 'Groceries', 1850, 3, 'Lanka Rice Mills'],
        ['P002', 'Coconut Oil 750ml', 'Cooking', 890, 5, 'Ceylon Oils Ltd'],
        ['P003', 'Sugar 1kg', 'Groceries', 320, 8, 'Lanka Sugar Co'],
        ['P004', 'Dhal 500g', 'Groceries', 480, 2, 'Import Foods Ltd'],
        ['P005', 'Milk Powder 400g', 'Dairy', 1250, 25, 'Highland Dairy'],
        ['P006', 'Tea 200g', 'Beverages', 650, 42, 'Dilmah Tea'],
        ['P007', 'Wheat Flour 1kg', 'Groceries', 280, 35, 'Prima Mills'],
        ['P008', 'Canned Fish 425g', 'Canned', 520, 18, 'Ocean Foods'],
        ['P009', 'Soap Bar', 'Personal Care', 180, 60, 'Unilever SL'],
        ['P010', 'Toothpaste 120g', 'Personal Care', 350, 30, 'Signal Lanka'],
    ];
@endphp
<div class="flex min-h-screen bg-gray-50">
    @include('partials.sidebar', [
        'menuItems' => $menuItems,
        'userName' => 'Nimal Perera',
        'userRole' => 'Business Owner',
        'companyName' => 'Perera Grocery',
    ])

    <main class="flex-1 min-w-0">
        <div class="p-4 sm:p-6 lg:p-8">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-6 gap-4">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">Inventory</h1>
                    <p class="text-sm text-gray-500 mt-1">Manage your products and stock levels</p>
                </div>
                <button data-modal-open="#add-product-modal" class="flex items-center gap-2 px-4 py-2.5 bg-blue-600 text-white text-sm font-semibold rounded-lg hover:bg-blue-700 transition-colors">
                    + Add Product
                </button>
            </div>

            <div class="flex gap-2 mb-4 overflow-x-auto pb-2">
                @foreach ($categories as $cat)
                    <button class="px-3 py-1.5 text-xs font-medium rounded-full whitespace-nowrap transition-all {{ $cat === 'All' ? 'bg-blue-600 text-white' : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }}">
                        {{ $cat }}
                    </button>
                @endforeach
            </div>

            <div class="bg-white rounded-xl border border-gray-100 shadow-sm overflow-hidden">
                <div class="p-4 border-b border-gray-100">
                    <div class="relative max-w-sm">
                        <input type="text" placeholder="Search products..." class="w-full pl-4 pr-4 py-2 text-sm border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all">
                    </div>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead>
                            <tr class="border-b border-gray-100">
                                <th class="text-left text-xs font-semibold text-gray-500 uppercase tracking-wider px-4 py-3">ID</th>
                                <th class="text-left text-xs font-semibold text-gray-500 uppercase tracking-wider px-4 py-3">Product</th>
                                <th class="text-left text-xs font-semibold text-gray-500 uppercase tracking-wider px-4 py-3">Category</th>
                                <th class="text-left text-xs font-semibold text-gray-500 uppercase tracking-wider px-4 py-3">Price</th>
                                <th class="text-left text-xs font-semibold text-gray-500 uppercase tracking-wider px-4 py-3">Stock</th>
                                <th class="text-left text-xs font-semibold text-gray-500 uppercase tracking-wider px-4 py-3">Supplier</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50">
                            @foreach ($products as $product)
                                <tr class="hover:bg-gray-50/50">
                                    <td class="px-4 py-3 text-xs text-gray-400 font-mono">{{ $product[0] }}</td>
                                    <td class="px-4 py-3 text-sm text-gray-900 font-medium">{{ $product[1] }}</td>
                                    <td class="px-4 py-3"><span class="text-xs font-medium px-2 py-0.5 rounded-full bg-gray-100 text-gray-600">{{ $product[2] }}</span></td>
                                    <td class="px-4 py-3 text-sm font-medium">LKR {{ number_format($product[3]) }}</td>
                                    <td class="px-4 py-3 text-sm font-semibold {{ $product[4] <= 10 ? 'text-red-600' : 'text-gray-900' }}">{{ $product[4] }}</td>
                                    <td class="px-4 py-3 text-sm text-gray-700">{{ $product[5] }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </main>
</div>

<div id="add-product-modal" data-modal class="hidden fixed inset-0 z-50">
    <div class="absolute inset-0 bg-black/50" data-modal-close="#add-product-modal"></div>
    <div class="fixed inset-x-4 top-[10%] sm:inset-auto sm:left-1/2 sm:top-1/2 sm:-translate-x-1/2 sm:-translate-y-1/2 sm:w-full sm:max-w-lg bg-white rounded-2xl shadow-2xl z-50 max-h-[80vh] overflow-y-auto">
        <div class="flex items-center justify-between p-5 border-b border-gray-100">
            <h3 class="text-lg font-semibold text-gray-900">Add New Product</h3>
            <button data-modal-close="#add-product-modal" class="p-1 rounded-md hover:bg-gray-100">X</button>
        </div>
        <div class="p-5 space-y-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5">Product Name</label>
                <input type="text" placeholder="e.g., Basmati Rice 5kg" class="w-full px-4 py-2.5 text-sm border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500">
            </div>
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Category</label>
                    <select class="w-full px-4 py-2.5 text-sm border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500">
                        <option>Groceries</option>
                        <option>Cooking</option>
                        <option>Dairy</option>
                        <option>Beverages</option>
                        <option>Personal Care</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Barcode</label>
                    <input type="text" placeholder="8901234567890" class="w-full px-4 py-2.5 text-sm border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500">
                </div>
            </div>
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Price (LKR)</label>
                    <input type="number" placeholder="0.00" class="w-full px-4 py-2.5 text-sm border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Stock Quantity</label>
                    <input type="number" placeholder="0" class="w-full px-4 py-2.5 text-sm border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500">
                </div>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5">Supplier</label>
                <select class="w-full px-4 py-2.5 text-sm border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500">
                    <option>Lanka Rice Mills</option>
                    <option>Ceylon Oils Ltd</option>
                    <option>Import Foods Ltd</option>
                    <option>Highland Dairy</option>
                </select>
            </div>
        </div>
        <div class="flex gap-3 p-5 border-t border-gray-100">
            <button data-modal-close="#add-product-modal" class="flex-1 py-2.5 border border-gray-200 text-gray-700 font-medium rounded-lg hover:bg-gray-50 text-sm">Cancel</button>
            <button data-modal-close="#add-product-modal" class="flex-1 py-2.5 bg-blue-600 text-white font-semibold rounded-lg hover:bg-blue-700 text-sm">Add Product</button>
        </div>
    </div>
</div>
@endsection
