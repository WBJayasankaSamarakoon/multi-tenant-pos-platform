@extends('layouts.dashboard')

@section('title', 'POS Terminal - MultiBizPOS')

@section('content')
@php
    $menuItems = [
        ['label' => 'POS Terminal', 'path' => '/cashier', 'icon' => 'P', 'match' => 'cashier'],
        ['label' => 'Sales History', 'path' => '/cashier/history', 'icon' => 'H', 'match' => 'cashier/history*'],
    ];
    $categories = collect($products)->pluck('category')->filter()->unique()->values()->all();
    array_unshift($categories, 'All');
    $currentCustomerNames = collect($customers)->pluck('name')->filter()->all();
@endphp
<div class="flex min-h-screen bg-gray-50">
    @include('partials.sidebar', [
        'menuItems' => $menuItems,
        'userName' => auth()->user()?->name ?? 'Cashier',
        'userRole' => 'Cashier',
        'companyName' => $company->name ?? 'Business',
    ])

    <main class="flex-1 min-w-0">
        <div class="h-screen flex flex-col lg:flex-row overflow-hidden">
            <div class="flex-1 flex flex-col min-h-0 p-4 lg:p-6">
                <div class="flex-shrink-0 mb-4">
                    <div class="relative mb-3">
                        <input type="text" placeholder="Search products by name or ID..." class="w-full pl-4 pr-4 py-3 text-sm bg-white border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all">
                    </div>
                    <div class="flex gap-1.5 overflow-x-auto pb-1">
                        @foreach ($categories as $cat)
                            <button type="button" data-category-tab="{{ $cat }}" class="px-3 py-1.5 text-xs font-medium rounded-full whitespace-nowrap transition-all {{ $cat === 'All' ? 'bg-blue-600 text-white' : 'bg-white text-gray-600 border border-gray-200 hover:bg-gray-50' }}">{{ $cat }}</button>
                        @endforeach
                    </div>
                </div>

                <div class="flex-1 overflow-y-auto">
                    <div class="pos-grid">
                        @foreach ($products as $product)
                            <button
                                type="button"
                                data-product-card
                                data-product-id="{{ $product->id }}"
                                data-product-name="{{ $product->name }}"
                                data-product-price="{{ $product->price }}"
                                data-product-category="{{ $product->category }}"
                                data-product-stock="{{ $product->stock }}"
                                class="relative bg-white rounded-xl border p-3 text-left transition-all hover:shadow-md border-gray-200 hover:border-blue-200">
                                <div class="w-full h-16 bg-gray-50 rounded-lg flex items-center justify-center mb-2">
                                    <span class="text-xs text-gray-400">IMG</span>
                                </div>
                                <p class="text-xs font-semibold text-gray-900 leading-tight line-clamp-2">{{ $product->name }}</p>
                                <p class="text-xs text-gray-400 mt-0.5">{{ $product->category }}</p>
                                <div class="flex items-center justify-between mt-2">
                                    <p class="text-sm font-bold text-blue-600">LKR {{ number_format($product->price) }}</p>
                                    <span class="text-xs font-medium {{ $product->stock <= 5 ? 'text-red-500' : 'text-gray-400' }}">{{ $product->stock }}</span>
                                </div>
                            </button>
                        @endforeach
                    </div>
                </div>
            </div>

            <div class="w-full lg:w-[400px] xl:w-[440px] bg-white border-t lg:border-t-0 lg:border-l border-gray-200 flex flex-col min-h-0 max-h-[50vh] lg:max-h-none lg:h-screen">
                <div class="flex-shrink-0 px-5 py-4 border-b border-gray-100">
                    <div class="flex items-center justify-between">
                        <h2 class="font-bold text-gray-900">Current Bill</h2>
                        <span class="text-xs font-medium text-gray-400" data-cart-count>0 items</span>
                    </div>
                    <div class="mt-3 flex items-center gap-2">
                        <span class="text-xs text-gray-400">Customer</span>
                        <select class="flex-1 text-sm border border-gray-200 rounded-lg px-3 py-1.5 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500" data-customer-select>
                            <option>Walk-in Customer</option>
                            @foreach ($currentCustomerNames as $customerName)
                                <option>{{ $customerName }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="flex-1 overflow-y-auto px-5 py-3">
                    <div class="h-full flex items-center justify-center" data-cart-empty-state>
                        <p class="text-sm text-gray-400">No items added yet</p>
                    </div>
                    <div class="space-y-2 hidden" data-cart-items></div>
                </div>

                <div class="flex-shrink-0 border-t border-gray-100 px-5 py-4 space-y-3">
                    <div class="flex items-center gap-2">
                        <label class="text-xs font-medium text-gray-500 whitespace-nowrap">Discount %</label>
                        <input type="number" placeholder="0" min="0" max="100" class="flex-1 px-3 py-1.5 text-sm border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 text-right" data-discount-input value="0">
                    </div>

                    <div class="space-y-1.5 text-sm">
                        <div class="flex justify-between text-gray-500"><span>Subtotal</span><span data-subtotal>LKR 0</span></div>
                        <div class="flex justify-between text-gray-500"><span>Tax (15%)</span><span data-tax>LKR 0</span></div>
                        <div class="flex justify-between text-lg font-bold text-gray-900 pt-2 border-t border-gray-200"><span>Total</span><span data-total>LKR 0</span></div>
                    </div>

                    <div class="flex gap-2" data-payment-methods>
                        <button type="button" data-payment-method="Cash" class="flex-1 flex items-center justify-center gap-1.5 py-2.5 rounded-lg text-xs font-medium border transition-all bg-emerald-50 border-emerald-300 text-emerald-700">Cash</button>
                        <button type="button" data-payment-method="Card" class="flex-1 flex items-center justify-center gap-1.5 py-2.5 rounded-lg text-xs font-medium border transition-all bg-white border-gray-200 text-gray-500 hover:bg-gray-50">Card</button>
                        <button type="button" data-payment-method="Mobile" class="flex-1 flex items-center justify-center gap-1.5 py-2.5 rounded-lg text-xs font-medium border transition-all bg-white border-gray-200 text-gray-500 hover:bg-gray-50">Mobile</button>
                    </div>

                    <button data-modal-open="#payment-success" class="w-full py-3.5 bg-emerald-600 text-white font-bold rounded-xl hover:bg-emerald-700 transition-colors shadow-lg shadow-emerald-600/25 text-base">
                        Pay <span data-pay-label>LKR 0</span>
                    </button>
                </div>
            </div>
        </div>
    </main>
</div>

<div id="payment-success" data-modal class="hidden fixed inset-0 bg-black/50 z-50 flex items-center justify-center">
    <div class="bg-white rounded-2xl p-8 text-center shadow-2xl max-w-sm mx-4">
        <div class="w-16 h-16 bg-emerald-100 rounded-full flex items-center justify-center mx-auto mb-4">
            <span class="text-emerald-600 text-lg font-bold">OK</span>
        </div>
        <h3 class="text-xl font-bold text-gray-900 mb-1">Payment Successful!</h3>
        <p class="text-sm text-gray-500">Invoice has been generated and printed.</p>
        <p class="text-lg font-bold text-emerald-600 mt-3" data-payment-total>LKR 0</p>
        <button data-modal-close="#payment-success" class="mt-6 w-full py-2.5 bg-blue-600 text-white font-medium rounded-lg hover:bg-blue-700 text-sm">Close</button>
    </div>
</div>

<script>
    (() => {
        const cards = Array.from(document.querySelectorAll('[data-product-card]'));
        const cartItems = document.querySelector('[data-cart-items]');
        const cartEmptyState = document.querySelector('[data-cart-empty-state]');
        const cartCount = document.querySelector('[data-cart-count]');
        const discountInput = document.querySelector('[data-discount-input]');
        const subtotalEl = document.querySelector('[data-subtotal]');
        const taxEl = document.querySelector('[data-tax]');
        const totalEl = document.querySelector('[data-total]');
        const payLabel = document.querySelector('[data-pay-label]');
        const paymentTotal = document.querySelector('[data-payment-total]');
        const paymentButtons = Array.from(document.querySelectorAll('[data-payment-method]'));
        const cart = new Map();
        let paymentMethod = 'Cash';

        const money = (value) => `LKR ${Math.round(value).toLocaleString('en-US')}`;

        const render = () => {
            const items = Array.from(cart.values());
            const itemCount = items.reduce((sum, item) => sum + item.qty, 0);
            const subtotal = items.reduce((sum, item) => sum + (item.qty * item.price), 0);
            const discountRate = Math.min(100, Math.max(0, Number.parseFloat(discountInput.value || '0') || 0));
            const discountedSubtotal = subtotal * (1 - discountRate / 100);
            const tax = discountedSubtotal * 0.15;
            const total = discountedSubtotal + tax;

            cartCount.textContent = `${itemCount} items`;
            subtotalEl.textContent = money(discountedSubtotal);
            taxEl.textContent = money(tax);
            totalEl.textContent = money(total);
            payLabel.textContent = money(total);
            paymentTotal.textContent = money(total);

            cartEmptyState.classList.toggle('hidden', items.length > 0);
            cartItems.classList.toggle('hidden', items.length === 0);
            cartItems.innerHTML = '';

            items.forEach((item) => {
                const row = document.createElement('div');
                row.className = 'flex items-center gap-3 p-3 rounded-lg bg-gray-50 border border-gray-100';
                row.innerHTML = `
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-medium text-gray-900 truncate">${item.name}</p>
                        <p class="text-xs text-gray-400">LKR ${Math.round(item.price).toLocaleString('en-US')} each</p>
                    </div>
                    <div class="flex items-center gap-1.5">
                        <button type="button" data-qty-minus="${item.id}" class="w-7 h-7 rounded-md bg-white border border-gray-200 flex items-center justify-center hover:bg-gray-100 transition-colors">-</button>
                        <span class="w-8 text-center text-sm font-semibold">${item.qty}</span>
                        <button type="button" data-qty-plus="${item.id}" class="w-7 h-7 rounded-md bg-white border border-gray-200 flex items-center justify-center hover:bg-gray-100 transition-colors">+</button>
                    </div>
                    <p class="text-sm font-bold text-gray-900 w-20 text-right">${Math.round(item.qty * item.price).toLocaleString('en-US')}</p>
                    <button type="button" data-remove-item="${item.id}" class="p-1 rounded-md hover:bg-red-50 text-gray-300 hover:text-red-500 transition-colors">X</button>
                `;
                cartItems.appendChild(row);
            });
        };

        const setPaymentMethod = (method) => {
            paymentMethod = method;
            paymentButtons.forEach((button) => {
                const active = button.dataset.paymentMethod === method;
                button.className = active
                    ? 'flex-1 flex items-center justify-center gap-1.5 py-2.5 rounded-lg text-xs font-medium border transition-all bg-emerald-50 border-emerald-300 text-emerald-700'
                    : 'flex-1 flex items-center justify-center gap-1.5 py-2.5 rounded-lg text-xs font-medium border transition-all bg-white border-gray-200 text-gray-500 hover:bg-gray-50';
            });
        };

        cards.forEach((card) => {
            card.addEventListener('click', () => {
                const id = card.dataset.productId;
                const existing = cart.get(id);
                const stock = Number.parseInt(card.dataset.productStock || '0', 10);

                if (existing) {
                    existing.qty = Math.min(existing.qty + 1, stock);
                    cart.set(id, existing);
                } else {
                    cart.set(id, {
                        id,
                        name: card.dataset.productName || '',
                        price: Number.parseFloat(card.dataset.productPrice || '0'),
                        stock,
                        qty: 1,
                    });
                }

                render();
            });
        });

        discountInput.addEventListener('input', render);

        cartItems.addEventListener('click', (event) => {
            const minusId = event.target.getAttribute('data-qty-minus');
            const plusId = event.target.getAttribute('data-qty-plus');
            const removeId = event.target.getAttribute('data-remove-item');

            if (minusId && cart.has(minusId)) {
                const item = cart.get(minusId);
                item.qty -= 1;
                if (item.qty <= 0) {
                    cart.delete(minusId);
                } else {
                    cart.set(minusId, item);
                }
                render();
            }

            if (plusId && cart.has(plusId)) {
                const item = cart.get(plusId);
                item.qty = Math.min(item.qty + 1, item.stock);
                cart.set(plusId, item);
                render();
            }

            if (removeId) {
                cart.delete(removeId);
                render();
            }
        });

        paymentButtons.forEach((button) => {
            button.addEventListener('click', () => setPaymentMethod(button.dataset.paymentMethod || 'Cash'));
        });

        setPaymentMethod('Cash');
        render();
    })();
</script>
@endsection
