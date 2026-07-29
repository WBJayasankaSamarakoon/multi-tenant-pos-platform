@extends('layouts.dashboard')

@section('content')
<div class="h-screen flex flex-col lg:flex-row overflow-hidden">
    {{-- Left: Product Grid --}}
    <div class="flex-1 flex flex-col min-h-0 p-4 lg:p-6">
        {{-- Search & Filters --}}
        <div class="flex-shrink-0 mb-4">
            <div class="relative mb-3">
                <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                </svg>
                <input type="text" placeholder="Search products by name or ID..." class="w-full pl-10 pr-4 py-3 text-sm bg-white border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all" autofocus>
            </div>
            <div class="flex gap-1.5 overflow-x-auto pb-1">
                @foreach(['All', 'Groceries', 'Cooking', 'Dairy', 'Beverages', 'Canned', 'Personal Care', 'Bakery', 'Snacks', 'Spices'] as $cat)
                    <button class="px-3 py-1.5 text-xs font-medium rounded-full whitespace-nowrap transition-all {{ $cat === 'All' ? 'bg-blue-600 text-white' : 'bg-white text-gray-600 border border-gray-200 hover:bg-gray-50' }}">
                        {{ $cat }}
                    </button>
                @endforeach
            </div>
        </div>

        {{-- Product Grid --}}
        <div class="flex-1 overflow-y-auto">
            <div class="pos-grid">
                @php
                    $products = [
                        ['id' => 'P001', 'name' => 'Basmati Rice 5kg', 'price' => 1850, 'stock' => 45, 'category' => 'Groceries'],
                        ['id' => 'P002', 'name' => 'Coconut Oil 750ml', 'price' => 890, 'stock' => 30, 'category' => 'Cooking'],
                        ['id' => 'P003', 'name' => 'Sugar 1kg', 'price' => 320, 'stock' => 60, 'category' => 'Groceries'],
                        ['id' => 'P004', 'name' => 'Dhal 500g', 'price' => 480, 'stock' => 25, 'category' => 'Groceries'],
                        ['id' => 'P005', 'name' => 'Milk Powder 400g', 'price' => 1250, 'stock' => 20, 'category' => 'Dairy'],
                        ['id' => 'P006', 'name' => 'Tea 200g', 'price' => 650, 'stock' => 42, 'category' => 'Beverages'],
                        ['id' => 'P007', 'name' => 'Wheat Flour 1kg', 'price' => 280, 'stock' => 35, 'category' => 'Groceries'],
                        ['id' => 'P008', 'name' => 'Canned Fish 425g', 'price' => 520, 'stock' => 18, 'category' => 'Canned'],
                        ['id' => 'P009', 'name' => 'Soap Bar', 'price' => 180, 'stock' => 60, 'category' => 'Personal Care'],
                        ['id' => 'P010', 'name' => 'Toothpaste 120g', 'price' => 350, 'stock' => 30, 'category' => 'Personal Care'],
                        ['id' => 'P011', 'name' => 'Bread Loaf', 'price' => 220, 'stock' => 15, 'category' => 'Bakery'],
                        ['id' => 'P012', 'name' => 'Eggs (10 pack)', 'price' => 580, 'stock' => 12, 'category' => 'Dairy'],
                    ];
                @endphp
                @foreach($products as $product)
                    <button class="relative bg-white rounded-xl border border-gray-200 p-3 text-left transition-all hover:shadow-md hover:border-blue-200">
                        <div class="w-full h-16 bg-gray-50 rounded-lg flex items-center justify-center mb-2">
                            <svg class="w-6 h-6 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                            </svg>
                        </div>
                        <p class="text-xs font-semibold text-gray-900 leading-tight line-clamp-2">{{ $product['name'] }}</p>
                        <p class="text-xs text-gray-400 mt-0.5">{{ $product['category'] }}</p>
                        <div class="flex items-center justify-between mt-2">
                            <p class="text-sm font-bold text-blue-600">LKR {{ number_format($product['price']) }}</p>
                            <span class="text-xs font-medium {{ $product['stock'] <= 5 ? 'text-red-500' : 'text-gray-400' }}">
                                {{ $product['stock'] }}
                            </span>
                        </div>
                    </button>
                @endforeach
            </div>
        </div>
    </div>

    {{-- Right: Cart / Bill --}}
    <div class="w-full lg:w-[400px] xl:w-[440px] bg-white border-t lg:border-t-0 lg:border-l border-gray-200 flex flex-col min-h-0 max-h-[50vh] lg:max-h-none lg:h-screen">
        {{-- Cart Header --}}
        <div class="flex-shrink-0 px-5 py-4 border-b border-gray-100">
            <div class="flex items-center justify-between">
                <h2 class="font-bold text-gray-900">Current Bill</h2>
                <span class="text-xs font-medium text-gray-400">0 items</span>
            </div>
            {{-- Customer Selector --}}
            <div class="mt-3 flex items-center gap-2">
                <svg class="w-4 h-4 text-gray-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                </svg>
                <select class="flex-1 text-sm border border-gray-200 rounded-lg px-3 py-1.5 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500">
                    <option value="walk-in">Walk-in Customer</option>
                    <option value="C001">Kamal Jayasinghe</option>
                    <option value="C002">Dilani Wickrama</option>
                    <option value="C003">Sunil Bandara</option>
                    <option value="C004">Priya Mendis</option>
                </select>
            </div>
        </div>

        {{-- Cart Items --}}
        <div class="flex-1 overflow-y-auto px-5 py-3">
            <div class="flex flex-col items-center justify-center h-full text-gray-300">
                <svg class="w-12 h-12 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                </svg>
                <p class="text-sm font-medium">Cart is empty</p>
                <p class="text-xs mt-1">Click products to add them</p>
            </div>
        </div>

        {{-- Bill Summary --}}
        <div class="flex-shrink-0 border-t border-gray-100 px-5 py-4 space-y-3">
            {{-- Discount --}}
            <div class="flex items-center gap-2">
                <label class="text-xs font-medium text-gray-500 whitespace-nowrap">Discount %</label>
                <input type="number" placeholder="0" min="0" max="100" class="flex-1 px-3 py-1.5 text-sm border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 text-right">
            </div>

            {{-- Totals --}}
            <div class="space-y-1.5 text-sm">
                <div class="flex justify-between text-gray-500">
                    <span>Subtotal</span>
                    <span>LKR 0.00</span>
                </div>
                <div class="flex justify-between text-gray-500">
                    <span>Tax (15%)</span>
                    <span>LKR 0.00</span>
                </div>
                <div class="flex justify-between text-lg font-bold text-gray-900 pt-2 border-t border-gray-200">
                    <span>Total</span>
                    <span>LKR 0.00</span>
                </div>
            </div>

            {{-- Payment Method --}}
            <div class="flex gap-2">
                <button class="flex-1 flex items-center justify-center gap-1.5 py-2.5 rounded-lg text-xs font-medium border transition-all bg-emerald-50 border-emerald-300 text-emerald-700">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path>
                    </svg>
                    Cash
                </button>
                <button class="flex-1 flex items-center justify-center gap-1.5 py-2.5 rounded-lg text-xs font-medium border transition-all bg-white border-gray-200 text-gray-500 hover:bg-gray-50">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h1m4 0h1m-7-10h2a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v2a2 2 0 002 2zm12 6a2 2 0 002-2v-2a2 2 0 00-2-2h-2a2 2 0 00-2 2v2a2 2 0 002 2zm0 0a2 2 0 002 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2a2 2 0 012-2zm-4 4h4"></path>
                    </svg>
                    Card
                </button>
                <button class="flex-1 flex items-center justify-center gap-1.5 py-2.5 rounded-lg text-xs font-medium border transition-all bg-white border-gray-200 text-gray-500 hover:bg-gray-50">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                    </svg>
                    Mobile
                </button>
            </div>

            {{-- Pay Button --}}
            <button class="w-full py-3.5 bg-emerald-600 text-white font-bold rounded-xl hover:bg-emerald-700 transition-colors shadow-lg shadow-emerald-600/25 text-base">
                Pay LKR 0.00
            </button>
        </div>
    </div>
</div>
@endsection
