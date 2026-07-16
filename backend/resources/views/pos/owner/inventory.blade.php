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
@endphp
<div class="flex min-h-screen bg-gray-50">
    @include('partials.sidebar', [
        'menuItems' => $menuItems,
        'userName' => auth()->user()?->name ?? 'Owner',
        'userRole' => 'Business Owner',
        'companyName' => $company->name ?? 'Business',
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

            <div class="flex gap-2 mb-4 overflow-x-auto pb-2" data-category-tabs>
                @foreach ($categories as $cat)
                    <button type="button" data-category-tab="{{ $cat }}" class="px-3 py-1.5 text-xs font-medium rounded-full whitespace-nowrap transition-all {{ $cat === 'All' ? 'bg-blue-600 text-white' : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }}">
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
                                <th class="text-left text-xs font-semibold text-gray-500 uppercase tracking-wider px-4 py-3">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50" data-product-list>
                            @foreach ($products as $product)
                                <tr class="hover:bg-gray-50/50" data-product-row data-product-category="{{ $product->category }}">
                                    <td class="px-4 py-3 text-xs text-gray-400 font-mono">{{ $product->sku ?? $product->id }}</td>
                                    <td class="px-4 py-3 text-sm text-gray-900 font-medium">{{ $product->name }}</td>
                                    <td class="px-4 py-3"><span class="text-xs font-medium px-2 py-0.5 rounded-full bg-gray-100 text-gray-600">{{ $product->category }}</span></td>
                                    <td class="px-4 py-3 text-sm font-medium">LKR {{ number_format($product->price) }}</td>
                                    <td class="px-4 py-3 text-sm font-semibold {{ $product->stock <= 10 ? 'text-red-600' : 'text-gray-900' }}">{{ $product->stock }}</td>
                                    <td class="px-4 py-3 text-sm text-gray-700">{{ $product->supplier ?? '-' }}</td>
                                    <td class="px-4 py-3">
                                        <div class="flex items-center gap-2">
                                            <button
                                                type="button"
                                                data-modal-open="#edit-product-modal"
                                                data-product-id="{{ $product->id }}"
                                                data-product-sku="{{ $product->sku }}"
                                                data-product-name="{{ $product->name }}"
                                                data-product-category="{{ $product->category }}"
                                                data-product-price="{{ $product->price }}"
                                                data-product-stock="{{ $product->stock }}"
                                                data-product-supplier="{{ $product->supplier }}"
                                                class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-medium rounded-md bg-blue-50 text-blue-700 hover:bg-blue-100">
                                                <svg class="w-3.5 h-3.5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                                    <path d="M13.586 3a2 2 0 0 1 2.828 0l.586.586a2 2 0 0 1 0 2.828l-8.95 8.95a2 2 0 0 1-.878.518l-3.42 1.025a.75.75 0 0 1-.93-.93l1.025-3.42a2 2 0 0 1 .518-.878l8.95-8.95Z" />
                                                </svg>
                                                Edit
                                            </button>
                                            <form method="POST" action="/owner/inventory/{{ $product->id }}" onsubmit="return confirm('Delete this product?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-medium rounded-md bg-red-50 text-red-700 hover:bg-red-100">
                                                    <svg class="w-3.5 h-3.5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                                        <path fill-rule="evenodd" d="M7 2.75A1.75 1.75 0 0 0 5.25 4.5V5h-.75a.75.75 0 0 0 0 1.5h.41l.54 9.066A2.25 2.25 0 0 0 7.7 17.75h4.6a2.25 2.25 0 0 0 2.25-2.184L15.09 6.5h.41a.75.75 0 0 0 0-1.5h-.75v-.5A1.75 1.75 0 0 0 13 2.75H7Zm1.25 2V5h3.5v-.25a.25.25 0 0 0-.25-.25h-3a.25.25 0 0 0-.25.25Zm-.72 1.75.48 8h4.48l.48-8H7.53Z" clip-rule="evenodd" />
                                                    </svg>
                                                    Delete
                                                </button>
                                            </form>
                                        </div>
                                    </td>
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
        <form method="POST" action="/owner/inventory">
            @csrf
            <div class="p-5 space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Product Name</label>
                    <input name="name" type="text" placeholder="e.g., Basmati Rice 5kg" class="w-full px-4 py-2.5 text-sm border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500">
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">Category</label>
                        <select name="category" class="w-full px-4 py-2.5 text-sm border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500">
                            <option>Groceries</option>
                            <option>Cooking</option>
                            <option>Dairy</option>
                            <option>Beverages</option>
                            <option>Canned</option>
                            <option>Personal Care</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">Barcode</label>
                        <input name="sku" type="text" placeholder="8901234567890" class="w-full px-4 py-2.5 text-sm border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500">
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">Price (LKR)</label>
                        <input name="price" type="number" step="0.01" placeholder="0.00" class="w-full px-4 py-2.5 text-sm border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">Stock Quantity</label>
                        <input name="stock" type="number" placeholder="0" class="w-full px-4 py-2.5 text-sm border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500">
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Supplier</label>
                    <select name="supplier" class="w-full px-4 py-2.5 text-sm border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500">
                        <option value="">Select supplier</option>
                        <option>Lanka Rice Mills</option>
                        <option>Ceylon Oils Ltd</option>
                        <option>Import Foods Ltd</option>
                        <option>Highland Dairy</option>
                    </select>
                </div>
            </div>
            <div class="flex gap-3 p-5 border-t border-gray-100">
                <button type="button" data-modal-close="#add-product-modal" class="flex-1 py-2.5 border border-gray-200 text-gray-700 font-medium rounded-lg hover:bg-gray-50 text-sm">Cancel</button>
                <button type="submit" class="flex-1 py-2.5 bg-blue-600 text-white font-semibold rounded-lg hover:bg-blue-700 text-sm">Add Product</button>
            </div>
        </form>
    </div>
</div>

<div id="edit-product-modal" data-modal class="hidden fixed inset-0 z-50">
    <div class="absolute inset-0 bg-black/50" data-modal-close="#edit-product-modal"></div>
    <div class="fixed inset-x-4 top-[10%] sm:inset-auto sm:left-1/2 sm:top-1/2 sm:-translate-x-1/2 sm:-translate-y-1/2 sm:w-full sm:max-w-lg bg-white rounded-2xl shadow-2xl z-50 max-h-[80vh] overflow-y-auto">
        <div class="flex items-center justify-between p-5 border-b border-gray-100">
            <h3 class="text-lg font-semibold text-gray-900">Edit Product</h3>
            <button data-modal-close="#edit-product-modal" class="p-1 rounded-md hover:bg-gray-100">X</button>
        </div>
        <form method="POST" id="edit-product-form">
            @csrf
            @method('PUT')
            <div class="p-5 space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Product Name</label>
                    <input name="name" id="edit-product-name" type="text" class="w-full px-4 py-2.5 text-sm border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500">
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">Category</label>
                        <select name="category" id="edit-product-category" class="w-full px-4 py-2.5 text-sm border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500">
                            <option>Groceries</option>
                            <option>Cooking</option>
                            <option>Dairy</option>
                            <option>Beverages</option>
                            <option>Canned</option>
                            <option>Personal Care</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">Barcode</label>
                        <input name="sku" id="edit-product-sku" type="text" class="w-full px-4 py-2.5 text-sm border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500">
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">Price (LKR)</label>
                        <input name="price" id="edit-product-price" type="number" step="0.01" class="w-full px-4 py-2.5 text-sm border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">Stock Quantity</label>
                        <input name="stock" id="edit-product-stock" type="number" class="w-full px-4 py-2.5 text-sm border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500">
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Supplier</label>
                    <input name="supplier" id="edit-product-supplier" type="text" class="w-full px-4 py-2.5 text-sm border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500">
                </div>
            </div>
            <div class="flex gap-3 p-5 border-t border-gray-100">
                <button type="button" data-modal-close="#edit-product-modal" class="flex-1 py-2.5 border border-gray-200 text-gray-700 font-medium rounded-lg hover:bg-gray-50 text-sm">Cancel</button>
                <button type="submit" class="flex-1 py-2.5 bg-blue-600 text-white font-semibold rounded-lg hover:bg-blue-700 text-sm">Save Changes</button>
            </div>
        </form>
    </div>
</div>

<script>
    (() => {
        const tabs = document.querySelectorAll('[data-category-tab]');
        const rows = document.querySelectorAll('[data-product-row]');
        const editButtons = document.querySelectorAll('[data-modal-open="#edit-product-modal"]');
        const editForm = document.getElementById('edit-product-form');
        const editSku = document.getElementById('edit-product-sku');
        const editName = document.getElementById('edit-product-name');
        const editCategory = document.getElementById('edit-product-category');
        const editPrice = document.getElementById('edit-product-price');
        const editStock = document.getElementById('edit-product-stock');
        const editSupplier = document.getElementById('edit-product-supplier');
        const editModal = document.getElementById('edit-product-modal');

        if (tabs.length && rows.length) {
            const setActive = (category) => {
                tabs.forEach((tab) => {
                    const active = tab.dataset.categoryTab === category;
                    tab.className = active
                        ? 'px-3 py-1.5 text-xs font-medium rounded-full whitespace-nowrap transition-all bg-blue-600 text-white'
                        : 'px-3 py-1.5 text-xs font-medium rounded-full whitespace-nowrap transition-all bg-gray-100 text-gray-600 hover:bg-gray-200';
                });

                rows.forEach((row) => {
                    const rowCategory = row.dataset.productCategory;
                    const show = category === 'All' || rowCategory === category;
                    row.style.display = show ? '' : 'none';
                });
            };

            tabs.forEach((tab) => {
                tab.addEventListener('click', () => setActive(tab.dataset.categoryTab));
            });

            setActive('All');
        }

        editButtons.forEach((button) => {
            button.addEventListener('click', () => {
                const productId = button.dataset.productId;
                editForm.action = `/owner/inventory/${productId}`;
                editSku.value = button.dataset.productSku || '';
                editName.value = button.dataset.productName || '';
                editCategory.value = button.dataset.productCategory || 'Groceries';
                editPrice.value = button.dataset.productPrice || '';
                editStock.value = button.dataset.productStock || '';
                editSupplier.value = button.dataset.productSupplier || '';
            });
        });
    })();
</script>
@endsection
