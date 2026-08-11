@extends('layouts.dashboard')

@section('title', 'Inventory - MultiBizPOS')

@section('content')
@php
    $menuItems = [
        ['label' => 'Dashboard', 'path' => '/manager', 'icon' => 'D', 'match' => 'manager'],
        ['label' => 'Inventory', 'path' => '/manager/inventory', 'icon' => 'I', 'match' => 'manager/inventory*'],
        ['label' => 'Reports', 'path' => '/manager/reports', 'icon' => 'R', 'match' => 'manager/reports*'],
        ['label' => 'Customers', 'path' => '/manager/customers', 'icon' => 'C', 'match' => 'manager/customers*'],
    ];
    $suppliers = collect($suppliers ?? [])->map(fn ($supplier) => (object) ['name' => $supplier])->values();
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
                    <h1 class="text-2xl font-bold text-gray-900">Inventory</h1>
                    <p class="text-sm text-gray-500 mt-1">Manage products and suppliers</p>
                </div>
                <button data-modal-open="#add-product-modal" class="flex items-center gap-2 px-4 py-2.5 bg-blue-600 text-white text-sm font-semibold rounded-lg hover:bg-blue-700 transition-colors">
                    + Add Product
                </button>
            </div>

            @if (session('status'))
                <div class="mb-6 rounded-lg border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-700">
                    {{ session('status') }}
                </div>
            @endif

            <div class="bg-white rounded-xl border border-gray-100 shadow-sm overflow-hidden" data-tab-group data-tab-initial="products">
                <div class="flex gap-1 bg-gray-100 rounded-lg p-0.5 w-fit m-4">
                    <button data-tab-target="products" data-active-classes="bg-white shadow-sm text-gray-900" data-inactive-classes="text-gray-500" class="px-4 py-2 text-sm font-medium rounded-md transition-all bg-white shadow-sm text-gray-900">Products</button>
                    <button data-tab-target="suppliers" data-active-classes="bg-white shadow-sm text-gray-900" data-inactive-classes="text-gray-500" class="px-4 py-2 text-sm font-medium rounded-md transition-all text-gray-500">Suppliers</button>
                </div>

                <div class="border-t border-gray-100" data-tab-panel="products">
                    <div class="p-4 border-b border-gray-100">
                        <div class="relative max-w-sm">
                            <input type="text" placeholder="Search products..." class="w-full pl-4 pr-4 py-2 text-sm border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all">
                        </div>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead>
                                <tr class="border-b border-gray-100">
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
                                        <td class="px-4 py-3 text-sm text-gray-900 font-medium">{{ $product->name }}</td>
                                        <td class="px-4 py-3"><span class="text-xs font-medium px-2 py-0.5 rounded-full bg-gray-100 text-gray-600">{{ $product->category }}</span></td>
                                        <td class="px-4 py-3 text-sm font-medium">LKR {{ number_format($product->price) }}</td>
                                        <td class="px-4 py-3 text-sm font-semibold {{ $product->stock <= 10 ? 'text-red-600' : 'text-gray-900' }}">{{ $product->stock }}</td>
                                        <td class="px-4 py-3 text-sm text-gray-700">{{ $product->supplier ?? '-' }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="border-t border-gray-100 hidden" data-tab-panel="suppliers">
                    <div class="p-4 border-b border-gray-100">
                        <div class="relative max-w-sm">
                            <input type="text" placeholder="Search suppliers..." class="w-full pl-4 pr-4 py-2 text-sm border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all">
                        </div>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead>
                                <tr class="border-b border-gray-100">
                                    <th class="text-left text-xs font-semibold text-gray-500 uppercase tracking-wider px-4 py-3">Supplier</th>
                                    <th class="text-left text-xs font-semibold text-gray-500 uppercase tracking-wider px-4 py-3">Phone</th>
                                    <th class="text-left text-xs font-semibold text-gray-500 uppercase tracking-wider px-4 py-3">Email</th>
                                    <th class="text-left text-xs font-semibold text-gray-500 uppercase tracking-wider px-4 py-3">Products</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-50">
                                @foreach ($suppliers as $supplier)
                                    @php
                                        $supplierName = is_object($supplier) ? ($supplier->supplier ?? $supplier->name ?? '') : $supplier;
                                    @endphp
                                    <tr class="hover:bg-gray-50/50">
                                        <td class="px-4 py-3 text-sm text-gray-900 font-medium">{{ $supplierName }}</td>
                                        <td class="px-4 py-3 text-sm text-gray-700">-</td>
                                        <td class="px-4 py-3 text-sm text-gray-700">-</td>
                                        <td class="px-4 py-3 text-sm text-gray-700">{{ collect($products)->where('supplier', $supplierName)->count() }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </main>
</div>

<div id="add-product-modal" data-modal class="hidden fixed inset-0 z-50">
    <div class="absolute inset-0 bg-black/50" data-modal-close="#add-product-modal"></div>
    <div class="fixed inset-x-4 top-[10%] sm:inset-auto sm:left-1/2 sm:top-1/2 sm:-translate-x-1/2 sm:-translate-y-1/2 sm:w-full sm:max-w-lg bg-white rounded-2xl shadow-2xl z-50">
        <div class="flex items-center justify-between p-5 border-b border-gray-100">
            <h3 class="text-lg font-semibold text-gray-900">Add Product</h3>
            <button data-modal-close="#add-product-modal" class="p-1 rounded-md hover:bg-gray-100">X</button>
        </div>
        <form method="POST" action="/manager/inventory">
            @csrf
            <div class="p-5 space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">SKU</label>
                    <input name="sku" type="text" placeholder="Optional SKU" class="w-full px-4 py-2.5 text-sm border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Product Name</label>
                    <input name="name" type="text" placeholder="Product name" required class="w-full px-4 py-2.5 text-sm border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500">
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">Price (LKR)</label>
                        <input name="price" type="number" min="0" step="0.01" placeholder="0" required class="w-full px-4 py-2.5 text-sm border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">Stock</label>
                        <input name="stock" type="number" min="0" placeholder="0" required class="w-full px-4 py-2.5 text-sm border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500">
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">Category</label>
                        <select name="category" required class="w-full px-4 py-2.5 text-sm border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500">
                            <option value="Groceries">Groceries</option>
                            <option value="Cooking">Cooking</option>
                            <option value="Dairy">Dairy</option>
                            <option value="Beverages">Beverages</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">Supplier</label>
                        <input name="supplier" type="text" placeholder="Supplier name" class="w-full px-4 py-2.5 text-sm border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500">
                    </div>
                </div>
            </div>
            <div class="flex gap-3 p-5 border-t border-gray-100">
                <button type="button" data-modal-close="#add-product-modal" class="flex-1 py-2.5 border border-gray-200 text-gray-700 font-medium rounded-lg hover:bg-gray-50 text-sm">Cancel</button>
                <button type="submit" class="flex-1 py-2.5 bg-blue-600 text-white font-semibold rounded-lg hover:bg-blue-700 text-sm">Add Product</button>
            </div>
        </form>
    </div>
</div>
@endsection
