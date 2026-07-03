@extends('layouts.dashboard')

@section('title', 'POS Terminal - MultiBizPOS')

@section('content')
@php
    $menuItems = [
        ['label' => 'POS Terminal', 'path' => '/cashier', 'icon' => 'P', 'match' => 'cashier'],
        ['label' => 'Sales History', 'path' => '/cashier/history', 'icon' => 'H', 'match' => 'cashier/history*'],
    ];
    $products = [
        ['P001', 'Basmati Rice 5kg', 1850, 45, 'Groceries'],
        ['P002', 'Coconut Oil 750ml', 890, 30, 'Cooking'],
        ['P003', 'Sugar 1kg', 320, 60, 'Groceries'],
        ['P004', 'Dhal 500g', 480, 25, 'Groceries'],
        ['P005', 'Milk Powder 400g', 1250, 20, 'Dairy'],
        ['P006', 'Tea 200g', 650, 42, 'Beverages'],
        ['P007', 'Wheat Flour 1kg', 280, 35, 'Groceries'],
        ['P008', 'Canned Fish 425g', 520, 18, 'Canned'],
        ['P009', 'Soap Bar', 180, 60, 'Personal Care'],
        ['P010', 'Toothpaste 120g', 350, 30, 'Personal Care'],
    ];
    $categories = ['All', 'Groceries', 'Cooking', 'Dairy', 'Beverages', 'Canned', 'Personal Care', 'Bakery', 'Snacks', 'Spices'];
@endphp
<div class="flex min-h-screen bg-gray-50">
    @include('partials.sidebar', [
        'menuItems' => $menuItems,
        'userName' => 'Kamala Dissanayake',
        'userRole' => 'Cashier',
        'companyName' => 'Perera Grocery',
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
                            <button class="px-3 py-1.5 text-xs font-medium rounded-full whitespace-nowrap transition-all {{ $cat === 'All' ? 'bg-blue-600 text-white' : 'bg-white text-gray-600 border border-gray-200 hover:bg-gray-50' }}">{{ $cat }}</button>
                        @endforeach
                    </div>
                </div>

                <div class="flex-1 overflow-y-auto">
                    <div class="pos-grid">
                        @foreach ($products as $product)
                            <button class="relative bg-white rounded-xl border p-3 text-left transition-all hover:shadow-md border-gray-200 hover:border-blue-200">
                                <div class="w-full h-16 bg-gray-50 rounded-lg flex items-center justify-center mb-2">
                                    <span class="text-xs text-gray-400">IMG</span>
                                </div>
                                <p class="text-xs font-semibold text-gray-900 leading-tight line-clamp-2">{{ $product[1] }}</p>
                                <p class="text-xs text-gray-400 mt-0.5">{{ $product[4] }}</p>
                                <div class="flex items-center justify-between mt-2">
                                    <p class="text-sm font-bold text-blue-600">LKR {{ number_format($product[2]) }}</p>
                                    <span class="text-xs font-medium {{ $product[3] <= 5 ? 'text-red-500' : 'text-gray-400' }}">{{ $product[3] }}</span>
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
                        <span class="text-xs font-medium text-gray-400">2 items</span>
                    </div>
                    <div class="mt-3 flex items-center gap-2">
                        <span class="text-xs text-gray-400">Customer</span>
                        <select class="flex-1 text-sm border border-gray-200 rounded-lg px-3 py-1.5 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500">
                            <option>Walk-in Customer</option>
                            <option>Kamal Jayasinghe</option>
                            <option>Dilani Wickrama</option>
                        </select>
                    </div>
                </div>

                <div class="flex-1 overflow-y-auto px-5 py-3">
                    <div class="space-y-2">
                        <div class="flex items-center gap-3 p-3 rounded-lg bg-gray-50 border border-gray-100">
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-medium text-gray-900 truncate">Basmati Rice 5kg</p>
                                <p class="text-xs text-gray-400">LKR 1,850 each</p>
                            </div>
                            <div class="flex items-center gap-1.5">
                                <button class="w-7 h-7 rounded-md bg-white border border-gray-200 flex items-center justify-center hover:bg-gray-100 transition-colors">-</button>
                                <span class="w-8 text-center text-sm font-semibold">1</span>
                                <button class="w-7 h-7 rounded-md bg-white border border-gray-200 flex items-center justify-center hover:bg-gray-100 transition-colors">+</button>
                            </div>
                            <p class="text-sm font-bold text-gray-900 w-20 text-right">1,850</p>
                            <button class="p-1 rounded-md hover:bg-red-50 text-gray-300 hover:text-red-500 transition-colors">X</button>
                        </div>
                        <div class="flex items-center gap-3 p-3 rounded-lg bg-gray-50 border border-gray-100">
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-medium text-gray-900 truncate">Coconut Oil 750ml</p>
                                <p class="text-xs text-gray-400">LKR 890 each</p>
                            </div>
                            <div class="flex items-center gap-1.5">
                                <button class="w-7 h-7 rounded-md bg-white border border-gray-200 flex items-center justify-center hover:bg-gray-100 transition-colors">-</button>
                                <span class="w-8 text-center text-sm font-semibold">2</span>
                                <button class="w-7 h-7 rounded-md bg-white border border-gray-200 flex items-center justify-center hover:bg-gray-100 transition-colors">+</button>
                            </div>
                            <p class="text-sm font-bold text-gray-900 w-20 text-right">1,780</p>
                            <button class="p-1 rounded-md hover:bg-red-50 text-gray-300 hover:text-red-500 transition-colors">X</button>
                        </div>
                    </div>
                </div>

                <div class="flex-shrink-0 border-t border-gray-100 px-5 py-4 space-y-3">
                    <div class="flex items-center gap-2">
                        <label class="text-xs font-medium text-gray-500 whitespace-nowrap">Discount %</label>
                        <input type="number" placeholder="0" min="0" max="100" class="flex-1 px-3 py-1.5 text-sm border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 text-right">
                    </div>

                    <div class="space-y-1.5 text-sm">
                        <div class="flex justify-between text-gray-500"><span>Subtotal</span><span>LKR 3,630</span></div>
                        <div class="flex justify-between text-gray-500"><span>Tax (15%)</span><span>LKR 545</span></div>
                        <div class="flex justify-between text-lg font-bold text-gray-900 pt-2 border-t border-gray-200"><span>Total</span><span>LKR 4,175</span></div>
                    </div>

                    <div class="flex gap-2">
                        <button class="flex-1 flex items-center justify-center gap-1.5 py-2.5 rounded-lg text-xs font-medium border transition-all bg-emerald-50 border-emerald-300 text-emerald-700">Cash</button>
                        <button class="flex-1 flex items-center justify-center gap-1.5 py-2.5 rounded-lg text-xs font-medium border transition-all bg-white border-gray-200 text-gray-500 hover:bg-gray-50">Card</button>
                        <button class="flex-1 flex items-center justify-center gap-1.5 py-2.5 rounded-lg text-xs font-medium border transition-all bg-white border-gray-200 text-gray-500 hover:bg-gray-50">Mobile</button>
                    </div>

                    <button data-modal-open="#payment-success" class="w-full py-3.5 bg-emerald-600 text-white font-bold rounded-xl hover:bg-emerald-700 transition-colors shadow-lg shadow-emerald-600/25 text-base">
                        Pay LKR 4,175
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
        <p class="text-lg font-bold text-emerald-600 mt-3">LKR 4,175</p>
        <button data-modal-close="#payment-success" class="mt-6 w-full py-2.5 bg-blue-600 text-white font-medium rounded-lg hover:bg-blue-700 text-sm">Close</button>
    </div>
</div>
@endsection
