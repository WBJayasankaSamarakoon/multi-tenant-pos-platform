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
                                            <button
                                                type="button"
                                                data-delete-modal-open
                                                data-delete-url="/owner/inventory/{{ $product->id }}"
                                                data-delete-title="Delete Product"
                                                data-delete-subtitle="Are you sure you want to delete this product from inventory?"
                                                data-delete-item="{{ $product->name }} (SKU: {{ $product->sku }})"
                                                class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-medium rounded-md bg-red-50 text-red-700 hover:bg-red-100 transition-colors">
                                                <svg class="w-3.5 h-3.5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                                    <path fill-rule="evenodd" d="M7 2.75A1.75 1.75 0 0 0 5.25 4.5V5h-.75a.75.75 0 0 0 0 1.5h.41l.54 9.066A2.25 2.25 0 0 0 7.7 17.75h4.6a2.25 2.25 0 0 0 2.25-2.184L15.09 6.5h.41a.75.75 0 0 0 0-1.5h-.75v-.5A1.75 1.75 0 0 0 13 2.75H7Zm1.25 2V5h3.5v-.25a.25.25 0 0 0-.25-.25h-3a.25.25 0 0 0-.25.25Zm-.72 1.75.48 8h4.48l.48-8H7.53Z" clip-rule="evenodd" />
                                                </svg>
                                                Delete
                                            </button>
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
    <div class="fixed inset-x-4 top-[10%] sm:inset-auto sm:left-1/2 sm:top-1/2 sm:-translate-x-1/2 sm:-translate-y-1/2 sm:w-full sm:max-w-md bg-white rounded-2xl shadow-2xl z-50">
        <div class="flex items-center justify-between p-5 border-b border-gray-100">
            <h3 class="text-lg font-semibold text-gray-900">Add Product</h3>
            <button data-modal-close="#add-product-modal" class="p-1 rounded-md hover:bg-gray-100">X</button>
        </div>
        <form method="POST" action="/owner/inventory">
            @csrf
            <div class="p-5 space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">SKU</label>
                    <input name="sku" type="text" placeholder="e.g., COF-001" class="w-full px-4 py-2.5 text-sm border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Product Name</label>
                    <input name="name" type="text" placeholder="Product name" class="w-full px-4 py-2.5 text-sm border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500">
                </div>
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">Category</label>
                        <select name="category" class="w-full px-4 py-2.5 text-sm border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500">
                            @foreach ($categories as $cat)
                                <option>{{ $cat }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">Price (LKR)</label>
                        <input name="price" type="number" step="0.01" placeholder="0.00" class="w-full px-4 py-2.5 text-sm border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500">
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">Stock Quantity</label>
                        <input name="stock" type="number" placeholder="0" class="w-full px-4 py-2.5 text-sm border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500">
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

<div id="edit-product-modal" data-modal class="hidden fixed inset-0 z-50">
    <div class="absolute inset-0 bg-black/50" data-modal-close="#edit-product-modal"></div>
    <div class="fixed inset-x-4 top-[10%] sm:inset-auto sm:left-1/2 sm:top-1/2 sm:-translate-x-1/2 sm:-translate-y-1/2 sm:w-full sm:max-w-md bg-white rounded-2xl shadow-2xl z-50">
        <div class="flex items-center justify-between p-5 border-b border-gray-100">
            <h3 class="text-lg font-semibold text-gray-900">Edit Product</h3>
            <button data-modal-close="#edit-product-modal" class="p-1 rounded-md hover:bg-gray-100">X</button>
        </div>
        <form method="POST" id="edit-product-form">
            @csrf
            @method('PUT')
            <div class="p-5 space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">SKU</label>
                    <input name="sku" id="edit-product-sku" type="text" class="w-full px-4 py-2.5 text-sm border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Product Name</label>
                    <input name="name" id="edit-product-name" type="text" class="w-full px-4 py-2.5 text-sm border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500">
                </div>
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">Category</label>
                        <select name="category" id="edit-product-category" class="w-full px-4 py-2.5 text-sm border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500">
                            @foreach ($categories as $cat)
                                <option>{{ $cat }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">Price (LKR)</label>
                        <input name="price" id="edit-product-price" type="number" step="0.01" class="w-full px-4 py-2.5 text-sm border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500">
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">Stock Quantity</label>
                        <input name="stock" id="edit-product-stock" type="number" class="w-full px-4 py-2.5 text-sm border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">Supplier</label>
                        <input name="supplier" id="edit-product-supplier" type="text" class="w-full px-4 py-2.5 text-sm border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500">
                    </div>
                </div>
            </div>
            <div class="flex gap-3 p-5 border-t border-gray-100">
                <button type="button" data-modal-close="#edit-product-modal" class="flex-1 py-2.5 border border-gray-200 text-gray-700 font-medium rounded-lg hover:bg-gray-50 text-sm">Cancel</button>
                <button type="submit" class="flex-1 py-2.5 bg-blue-600 text-white font-semibold rounded-lg hover:bg-blue-700 text-sm">Save Changes</button>
            </div>
        </form>
    </div>
</div>

<div id="delete-confirm-modal" data-modal class="hidden fixed inset-0 z-50">
    <div class="absolute inset-0 bg-black/60 backdrop-blur-sm" data-modal-close="#delete-confirm-modal"></div>
    <div class="fixed inset-x-4 top-[20%] sm:inset-auto sm:left-1/2 sm:top-1/2 sm:-translate-x-1/2 sm:-translate-y-1/2 sm:w-full sm:max-w-md bg-white rounded-2xl shadow-2xl z-50 overflow-hidden border border-gray-100">
        <div class="p-6 text-center">
            <div class="w-14 h-14 bg-red-100 text-red-600 rounded-full flex items-center justify-center mx-auto mb-4 ring-8 ring-red-50">
                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                </svg>
            </div>
            <h3 class="text-xl font-bold text-gray-900 mb-1" id="delete-modal-title">Delete Product</h3>
            <p class="text-sm text-gray-500 mb-3" id="delete-modal-subtitle">Are you sure you want to delete this product from inventory?</p>
            <div class="bg-gray-50 py-2.5 px-4 rounded-xl border border-gray-100 mb-3">
                <p class="text-sm font-semibold text-gray-900" id="delete-modal-item-name"></p>
            </div>
            <p class="text-xs text-red-500 font-medium">This action cannot be undone.</p>
        </div>
        <div class="flex gap-3 p-4 bg-gray-50 border-t border-gray-100">
            <button type="button" data-modal-close="#delete-confirm-modal" style="background-color: #f3f4f6 !important; color: #1f2937 !important; border: 1px solid #e5e7eb !important;" class="btn-cancel-modal flex-1 py-2.5 px-4 bg-gray-100 hover:bg-gray-200 text-gray-800 font-semibold rounded-xl transition-all text-sm shadow-sm cursor-pointer">
                Cancel
            </button>
            <form id="delete-modal-form" method="POST" class="flex-1">
                @csrf
                @method('DELETE')
                <button type="submit" style="background-color: #dc2626 !important; color: #ffffff !important;" class="btn-danger-confirm w-full py-2.5 px-4 bg-red-600 hover:bg-red-700 text-white font-semibold rounded-xl transition-all text-sm shadow-md shadow-red-200 cursor-pointer flex items-center justify-center gap-1.5 border-0">
                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                    </svg>
                    <span style="color: #ffffff !important;" class="text-white font-semibold">Delete</span>
                </button>
            </form>
        </div>
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

        const deleteTriggers = document.querySelectorAll('[data-delete-modal-open]');
        const deleteModal = document.getElementById('delete-confirm-modal');
        const deleteTitle = document.getElementById('delete-modal-title');
        const deleteSubtitle = document.getElementById('delete-modal-subtitle');
        const deleteItemName = document.getElementById('delete-modal-item-name');
        const deleteForm = document.getElementById('delete-modal-form');

        let currentProductId = null;
        let currentProductName = '';
        let currentProductSku = '';

        const openDeleteModal = (url, title, subtitle, itemName) => {
            if (!deleteModal || !deleteForm) return;
            deleteForm.action = url;
            if (deleteTitle) deleteTitle.textContent = title || 'Delete Product';
            if (deleteSubtitle) deleteSubtitle.textContent = subtitle || 'Are you sure you want to delete this product?';
            if (deleteItemName) deleteItemName.textContent = itemName || '';
            deleteModal.classList.remove('hidden');
        };

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
                currentProductId = button.dataset.productId;
                currentProductName = button.dataset.productName || '';
                currentProductSku = button.dataset.productSku || '';
                editForm.action = `/owner/inventory/${currentProductId}`;
                editSku.value = currentProductSku;
                editName.value = currentProductName;
                editCategory.value = button.dataset.productCategory || 'Groceries';
                editPrice.value = button.dataset.productPrice || '';
                editStock.value = button.dataset.productStock || '';
                editSupplier.value = button.dataset.productSupplier || '';
            });
        });

        deleteTriggers.forEach((btn) => {
            btn.addEventListener('click', () => {
                openDeleteModal(
                    btn.dataset.deleteUrl,
                    btn.dataset.deleteTitle,
                    btn.dataset.deleteSubtitle,
                    btn.dataset.deleteItem
                );
            });
        });
    })();
</script>
@endsection
