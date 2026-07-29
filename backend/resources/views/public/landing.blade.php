@extends('layouts.public')

@section('title', 'MultiBizPOS')

@section('content')
<div class="w-full min-h-screen bg-white">
    @include('partials.public-navbar')

    <section class="relative pt-24 pb-16 lg:pt-32 lg:pb-24 overflow-hidden">
        <div class="absolute inset-0 bg-gradient-to-br from-blue-50 via-white to-emerald-50/30"></div>
        <div class="absolute top-20 right-0 w-96 h-96 bg-blue-100/40 rounded-full blur-3xl"></div>
        <div class="absolute bottom-0 left-0 w-80 h-80 bg-emerald-100/30 rounded-full blur-3xl"></div>

        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="max-w-3xl mx-auto text-center">
                <span class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-blue-50 border border-blue-100 text-blue-700 text-xs font-semibold mb-6">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                    </svg>
                    Built for Sri Lankan Businesses
                </span>

                <h1 class="text-4xl sm:text-5xl lg:text-6xl font-extrabold text-gray-900 leading-tight tracking-tight">
                    One Platform.
                    <span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-600 to-emerald-500">
                        Every Business.
                    </span>
                </h1>

                <p class="mt-6 text-lg text-gray-600 leading-relaxed max-w-2xl mx-auto">
                    MultiBiz POS is a cloud-based point of sale platform designed for small and medium businesses in Sri
                    Lanka. Manage sales, inventory, and employees all from one place.
                </p>

                <div class="mt-8 flex flex-col sm:flex-row items-center justify-center gap-3">
                    <a href="/register" class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-7 py-3.5 bg-blue-600 text-white font-semibold rounded-xl hover:bg-blue-700 transition-colors shadow-lg shadow-blue-600/25">
                        Start Free Trial
                        <span class="text-sm">&gt;</span>
                    </a>
                    <a href="/login" class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-7 py-3.5 bg-white text-gray-700 font-semibold rounded-xl border border-gray-200 hover:border-gray-300 hover:bg-gray-50 transition-colors">
                        View Demo
                    </a>
                </div>

                <div class="mt-8 flex items-center justify-center gap-6 text-sm text-gray-500">
                    <span class="flex items-center gap-1.5">
                        <span class="w-2.5 h-2.5 rounded-full bg-emerald-500"></span>
                        14-day free trial
                    </span>
                    <span class="flex items-center gap-1.5">
                        <span class="w-2.5 h-2.5 rounded-full bg-emerald-500"></span>
                        No credit card required
                    </span>
                    <span class="hidden sm:flex items-center gap-1.5">
                        <span class="w-2.5 h-2.5 rounded-full bg-emerald-500"></span>
                        LKR pricing
                    </span>
                </div>
            </div>

            <div class="mt-16 max-w-5xl mx-auto">
                <div class="relative rounded-2xl overflow-hidden shadow-2xl shadow-gray-900/10 border border-gray-200/50">
                    <div class="bg-gray-900 px-4 py-2.5 flex items-center gap-2">
                        <div class="flex gap-1.5">
                            <div class="w-3 h-3 rounded-full bg-red-400"></div>
                            <div class="w-3 h-3 rounded-full bg-amber-400"></div>
                            <div class="w-3 h-3 rounded-full bg-emerald-400"></div>
                        </div>
                        <div class="flex-1 text-center">
                            <span class="text-xs text-gray-400">app.multibizpos.lk</span>
                        </div>
                    </div>
                    <div class="bg-gradient-to-br from-slate-50 to-blue-50 p-8 lg:p-12">
                        <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
                            <div class="bg-white rounded-xl p-4 shadow-sm border border-gray-100">
                                <p class="text-xs text-gray-500">Today's Sales</p>
                                <p class="text-xl font-bold text-gray-900 mt-1">LKR 45,280</p>
                                <p class="text-xs text-emerald-600 mt-1">Up 12.5%</p>
                            </div>
                            <div class="bg-white rounded-xl p-4 shadow-sm border border-gray-100">
                                <p class="text-xs text-gray-500">Monthly Revenue</p>
                                <p class="text-xl font-bold text-gray-900 mt-1">LKR 1.2M</p>
                                <p class="text-xs text-emerald-600 mt-1">Up 8.3%</p>
                            </div>
                            <div class="bg-white rounded-xl p-4 shadow-sm border border-gray-100">
                                <p class="text-xs text-gray-500">Products</p>
                                <p class="text-xl font-bold text-gray-900 mt-1">342</p>
                                <p class="text-xs text-blue-600 mt-1">5 low stock</p>
                            </div>
                            <div class="bg-white rounded-xl p-4 shadow-sm border border-gray-100">
                                <p class="text-xs text-gray-500">Employees</p>
                                <p class="text-xl font-bold text-gray-900 mt-1">8</p>
                                <p class="text-xs text-gray-400 mt-1">3 online</p>
                            </div>
                        </div>
                        <div class="mt-4 grid grid-cols-1 lg:grid-cols-3 gap-4">
                            <div class="lg:col-span-2 bg-white rounded-xl p-4 shadow-sm border border-gray-100 h-40 flex items-center justify-center">
                                <div class="flex items-end gap-2 h-24">
                                    @foreach ([40, 65, 45, 80, 55, 90, 70] as $h)
                                        <div class="w-8 bg-blue-500/80 rounded-t" style="height: {{ $h }}%"></div>
                                    @endforeach
                                </div>
                            </div>
                            <div class="bg-white rounded-xl p-4 shadow-sm border border-gray-100">
                                <p class="text-xs font-medium text-gray-500 mb-3">Recent Sales</p>
                                <div class="space-y-2.5">
                                    <div class="flex justify-between text-xs">
                                        <span class="text-gray-600">INV-001</span>
                                        <span class="font-medium text-gray-900">LKR 2,450</span>
                                    </div>
                                    <div class="flex justify-between text-xs">
                                        <span class="text-gray-600">INV-002</span>
                                        <span class="font-medium text-gray-900">LKR 8,900</span>
                                    </div>
                                    <div class="flex justify-between text-xs">
                                        <span class="text-gray-600">INV-003</span>
                                        <span class="font-medium text-gray-900">LKR 1,200</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="features" class="py-20 lg:py-28 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <span class="text-sm font-semibold text-blue-600 uppercase tracking-wider">Features</span>
                <h2 class="mt-3 text-3xl lg:text-4xl font-bold text-gray-900">
                    Everything your business needs
                </h2>
                <p class="mt-4 text-lg text-gray-500 max-w-2xl mx-auto">
                    From sales processing to inventory management, MultiBiz POS covers all aspects of your business
                    operations.
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <div class="p-6 rounded-2xl border border-gray-100 bg-white hover:shadow-lg hover:border-blue-100 transition-all group">
                    <div class="w-12 h-12 rounded-xl bg-blue-50 flex items-center justify-center mb-4 group-hover:bg-blue-100 transition-colors">
                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">POS Billing System</h3>
                    <p class="text-sm text-gray-500 leading-relaxed">
                        Fast and intuitive point of sale with invoice generation, tax calculations, discounts, and multiple
                        payment methods.
                    </p>
                </div>

                <div class="p-6 rounded-2xl border border-gray-100 bg-white hover:shadow-lg hover:border-emerald-100 transition-all group">
                    <div class="w-12 h-12 rounded-xl bg-emerald-50 flex items-center justify-center mb-4 group-hover:bg-emerald-100 transition-colors">
                        <svg class="w-6 h-6 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Inventory Management</h3>
                    <p class="text-sm text-gray-500 leading-relaxed">
                        Track products, categories, stock levels, and suppliers. Get low-stock alerts and real-time inventory
                        updates.
                    </p>
                </div>

                <div class="p-6 rounded-2xl border border-gray-100 bg-white hover:shadow-lg hover:border-purple-100 transition-all group">
                    <div class="w-12 h-12 rounded-xl bg-purple-50 flex items-center justify-center mb-4 group-hover:bg-purple-100 transition-colors">
                        <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Reports & Analytics</h3>
                    <p class="text-sm text-gray-500 leading-relaxed">
                        Interactive dashboards with daily sales, monthly summaries, top products, and profit calculations.
                    </p>
                </div>

                <div class="p-6 rounded-2xl border border-gray-100 bg-white hover:shadow-lg hover:border-amber-100 transition-all group">
                    <div class="w-12 h-12 rounded-xl bg-amber-50 flex items-center justify-center mb-4 group-hover:bg-amber-100 transition-colors">
                        <svg class="w-6 h-6 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Multi-Tenant Platform</h3>
                    <p class="text-sm text-gray-500 leading-relaxed">
                        Multiple businesses operate independently with complete data isolation and secure access control.
                    </p>
                </div>

                <div class="p-6 rounded-2xl border border-gray-100 bg-white hover:shadow-lg hover:border-rose-100 transition-all group">
                    <div class="w-12 h-12 rounded-xl bg-rose-50 flex items-center justify-center mb-4 group-hover:bg-rose-100 transition-colors">
                        <svg class="w-6 h-6 text-rose-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h1m4 0h1m-7-10h2a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v2a2 2 0 002 2zm12 6a2 2 0 002-2v-2a2 2 0 00-2-2h-2a2 2 0 00-2 2v2a2 2 0 002 2zm0 0a2 2 0 002 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2a2 2 0 012-2zm-4 4h4"></path>
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Subscription Plans</h3>
                    <p class="text-sm text-gray-500 leading-relaxed">
                        Flexible pricing plans Basic, Pro, and Enterprise designed for businesses of every size.
                    </p>
                </div>

                <div class="p-6 rounded-2xl border border-gray-100 bg-white hover:shadow-lg hover:border-teal-100 transition-all group">
                    <div class="w-12 h-12 rounded-xl bg-teal-50 flex items-center justify-center mb-4 group-hover:bg-teal-100 transition-colors">
                        <svg class="w-6 h-6 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Customization</h3>
                    <p class="text-sm text-gray-500 leading-relaxed">
                        Configure currencies, tax rates, invoice templates, and role-based permissions for your business.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <section id="about" class="py-20 lg:py-28 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid lg:grid-cols-2 gap-16 items-center">
                <div>
                    <span class="text-sm font-semibold text-blue-600 uppercase tracking-wider">Why MultiBiz POS</span>
                    <h2 class="mt-3 text-3xl lg:text-4xl font-bold text-gray-900">
                        Built specifically for Sri Lankan SMBs
                    </h2>
                    <p class="mt-4 text-gray-500 leading-relaxed">
                        Unlike expensive enterprise solutions, MultiBiz POS is designed from the ground up for the unique
                        needs of small and medium businesses in Sri Lanka.
                    </p>

                    <div class="mt-8 space-y-5">
                        <div class="flex gap-4">
                            <div class="w-10 h-10 rounded-lg bg-blue-100 flex items-center justify-center flex-shrink-0">
                                <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 15a4 4 0 004 4h9a5 5 0 10-.1-9.999 5.002 5.002 0 10-9.78 2.096A4.001 4.001 0 003 15z"></path>
                                </svg>
                            </div>
                            <div>
                                <h4 class="font-semibold text-gray-900">Cloud-Based, No Installation</h4>
                                <p class="text-sm text-gray-500 mt-1">
                                    Access from any device with a browser. No downloads, no setup, no IT team required.
                                </p>
                            </div>
                        </div>
                        <div class="flex gap-4">
                            <div class="w-10 h-10 rounded-lg bg-emerald-100 flex items-center justify-center flex-shrink-0">
                                <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                                </svg>
                            </div>
                            <div>
                                <h4 class="font-semibold text-gray-900">Secure Data Isolation</h4>
                                <p class="text-sm text-gray-500 mt-1">
                                    Each business's data is completely isolated. Your data is yours always.
                                </p>
                            </div>
                        </div>
                        <div class="flex gap-4">
                            <div class="w-10 h-10 rounded-lg bg-amber-100 flex items-center justify-center flex-shrink-0">
                                <svg class="w-5 h-5 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                                </svg>
                            </div>
                            <div>
                                <h4 class="font-semibold text-gray-900">Works on Any Device</h4>
                                <p class="text-sm text-gray-500 mt-1">
                                    Responsive design works on desktops, tablets, and mobile phones.
                                </p>
                            </div>
                        </div>
                        <div class="flex gap-4">
                            <div class="w-10 h-10 rounded-lg bg-purple-100 flex items-center justify-center flex-shrink-0">
                                <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <div>
                                <h4 class="font-semibold text-gray-900">LKR Pricing & Local Support</h4>
                                <p class="text-sm text-gray-500 mt-1">
                                    Affordable plans in Sri Lankan Rupees with local currency and tax support.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="relative">
                    <div class="bg-white rounded-2xl shadow-xl border border-gray-100 p-6">
                        <div class="flex items-center gap-3 mb-6">
                            <div class="w-10 h-10 rounded-full bg-blue-600 flex items-center justify-center">
                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                                </svg>
                            </div>
                            <div>
                                <p class="font-semibold text-gray-900">Role-Based Access</p>
                                <p class="text-xs text-gray-500">4 distinct user roles</p>
                            </div>
                        </div>
                        <div class="space-y-3">
                            <div class="flex items-center gap-3 p-3 rounded-lg bg-blue-50 border border-blue-100">
                                <div class="w-8 h-8 rounded-md bg-blue-600 flex items-center justify-center text-white text-xs font-bold">BO</div>
                                <div>
                                    <p class="text-sm font-medium text-gray-900">Business Owner</p>
                                    <p class="text-xs text-gray-500">Full access to all features</p>
                                </div>
                            </div>
                            <div class="flex items-center gap-3 p-3 rounded-lg bg-gray-50 border border-gray-100">
                                <div class="w-8 h-8 rounded-md bg-emerald-600 flex items-center justify-center text-white text-xs font-bold">CA</div>
                                <div>
                                    <p class="text-sm font-medium text-gray-900">Cashier</p>
                                    <p class="text-xs text-gray-500">POS billing & sales transactions</p>
                                </div>
                            </div>
                            <div class="flex items-center gap-3 p-3 rounded-lg bg-gray-50 border border-gray-100">
                                <div class="w-8 h-8 rounded-md bg-amber-600 flex items-center justify-center text-white text-xs font-bold">MG</div>
                                <div>
                                    <p class="text-sm font-medium text-gray-900">Manager</p>
                                    <p class="text-xs text-gray-500">Inventory, reports & customers</p>
                                </div>
                            </div>
                            <div class="flex items-center gap-3 p-3 rounded-lg bg-gray-50 border border-gray-100">
                                <div class="w-8 h-8 rounded-md bg-purple-600 flex items-center justify-center text-white text-xs font-bold">PA</div>
                                <div>
                                    <p class="text-sm font-medium text-gray-900">Platform Admin</p>
                                    <p class="text-xs text-gray-500">System-wide monitoring</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="py-20 lg:py-28 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <span class="text-sm font-semibold text-blue-600 uppercase tracking-wider">Pricing</span>
            <h2 class="mt-3 text-3xl lg:text-4xl font-bold text-gray-900">Simple, affordable plans</h2>
            <p class="mt-4 text-lg text-gray-500 max-w-2xl mx-auto">
                Start with our free trial and upgrade as your business grows. All prices in Sri Lankan Rupees.
            </p>

            <div class="mt-12 grid grid-cols-1 md:grid-cols-3 gap-6 max-w-4xl mx-auto">
                <div class="p-6 rounded-2xl border border-gray-200 bg-white text-left">
                    <p class="text-sm font-semibold text-gray-500">Basic</p>
                    <p class="mt-2 text-3xl font-bold text-gray-900">
                        LKR 2,500
                        <span class="text-base font-normal text-gray-400">/mo</span>
                    </p>
                    <p class="mt-2 text-sm text-gray-500">For small shops getting started</p>
                    <ul class="mt-6 space-y-3">
                        <li class="flex items-center gap-2 text-sm text-gray-600">
                            <svg class="w-4 h-4 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            1 user
                        </li>
                        <li class="flex items-center gap-2 text-sm text-gray-600">
                            <svg class="w-4 h-4 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            Basic POS
                        </li>
                        <li class="flex items-center gap-2 text-sm text-gray-600">
                            <svg class="w-4 h-4 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            100 products
                        </li>
                    </ul>
                    <a href="/register" class="mt-6 block text-center py-2.5 rounded-lg border border-gray-200 text-sm font-medium text-gray-700 hover:bg-gray-50 transition-colors">
                        Get Started
                    </a>
                </div>

                <div class="p-6 rounded-2xl border-2 border-blue-600 bg-white text-left relative shadow-lg">
                    <span class="absolute -top-3 left-1/2 -translate-x-1/2 px-3 py-0.5 bg-blue-600 text-white text-xs font-semibold rounded-full">
                        Popular
                    </span>
                    <p class="text-sm font-semibold text-blue-600">Pro</p>
                    <p class="mt-2 text-3xl font-bold text-gray-900">
                        LKR 5,000
                        <span class="text-base font-normal text-gray-400">/mo</span>
                    </p>
                    <p class="mt-2 text-sm text-gray-500">For growing businesses</p>
                    <ul class="mt-6 space-y-3">
                        <li class="flex items-center gap-2 text-sm text-gray-600">
                            <svg class="w-4 h-4 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            5 users
                        </li>
                        <li class="flex items-center gap-2 text-sm text-gray-600">
                            <svg class="w-4 h-4 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            Full POS + Inventory
                        </li>
                        <li class="flex items-center gap-2 text-sm text-gray-600">
                            <svg class="w-4 h-4 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            1,000 products
                        </li>
                        <li class="flex items-center gap-2 text-sm text-gray-600">
                            <svg class="w-4 h-4 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            Reports & Analytics
                        </li>
                    </ul>
                    <a href="/register" class="mt-6 block text-center py-2.5 rounded-lg bg-blue-600 text-white text-sm font-medium hover:bg-blue-700 transition-colors">
                        Start Free Trial
                    </a>
                </div>

                <div class="p-6 rounded-2xl border border-gray-200 bg-white text-left">
                    <p class="text-sm font-semibold text-gray-500">Enterprise</p>
                    <p class="mt-2 text-3xl font-bold text-gray-900">
                        LKR 10,000
                        <span class="text-base font-normal text-gray-400">/mo</span>
                    </p>
                    <p class="mt-2 text-sm text-gray-500">For larger operations</p>
                    <ul class="mt-6 space-y-3">
                        <li class="flex items-center gap-2 text-sm text-gray-600">
                            <svg class="w-4 h-4 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            Unlimited users
                        </li>
                        <li class="flex items-center gap-2 text-sm text-gray-600">
                            <svg class="w-4 h-4 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            All features
                        </li>
                        <li class="flex items-center gap-2 text-sm text-gray-600">
                            <svg class="w-4 h-4 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            Unlimited products
                        </li>
                        <li class="flex items-center gap-2 text-sm text-gray-600">
                            <svg class="w-4 h-4 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            Priority support
                        </li>
                    </ul>
                    <a href="/register" class="mt-6 block text-center py-2.5 rounded-lg border border-gray-200 text-sm font-medium text-gray-700 hover:bg-gray-50 transition-colors">
                        Contact Sales
                    </a>
                </div>
            </div>

            <a href="/pricing" class="inline-flex items-center gap-1 mt-8 text-sm font-medium text-blue-600 hover:text-blue-700 transition-colors">
                View full comparison <span class="text-sm">&gt;</span>
            </a>
        </div>
    </section>

    <section class="py-20 lg:py-28 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <span class="text-sm font-semibold text-blue-600 uppercase tracking-wider">Testimonials</span>
                <h2 class="mt-3 text-3xl lg:text-4xl font-bold text-gray-900">
                    Trusted by businesses across Sri Lanka
                </h2>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm">
                    <div class="flex gap-1 mb-4">
                        <svg class="w-4 h-4 text-amber-400" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"></path>
                        </svg>
                        <svg class="w-4 h-4 text-amber-400" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"></path>
                        </svg>
                        <svg class="w-4 h-4 text-amber-400" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"></path>
                        </svg>
                        <svg class="w-4 h-4 text-amber-400" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"></path>
                        </svg>
                        <svg class="w-4 h-4 text-amber-400" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"></path>
                        </svg>
                    </div>
                    <p class="text-sm text-gray-600 leading-relaxed">
                        "MultiBiz POS transformed how we manage our grocery store. The inventory alerts alone have saved us
                        from stockouts multiple times."
                    </p>
                    <div class="mt-4 flex items-center gap-3">
                        <div class="w-10 h-10 rounded-full bg-blue-100 flex items-center justify-center">
                            <span class="text-sm font-semibold text-blue-600">NP</span>
                        </div>
                        <div>
                            <p class="text-sm font-semibold text-gray-900">Nimal Perera</p>
                            <p class="text-xs text-gray-500">Perera Grocery, Colombo</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm">
                    <div class="flex gap-1 mb-4">
                        <svg class="w-4 h-4 text-amber-400" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"></path>
                        </svg>
                        <svg class="w-4 h-4 text-amber-400" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"></path>
                        </svg>
                        <svg class="w-4 h-4 text-amber-400" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"></path>
                        </svg>
                        <svg class="w-4 h-4 text-amber-400" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"></path>
                        </svg>
                        <svg class="w-4 h-4 text-amber-400" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"></path>
                        </svg>
                    </div>
                    <p class="text-sm text-gray-600 leading-relaxed">
                        "The POS system is incredibly fast and easy for my cashiers to use. We process sales 3x faster than
                        our old system."
                    </p>
                    <div class="mt-4 flex items-center gap-3">
                        <div class="w-10 h-10 rounded-full bg-emerald-100 flex items-center justify-center">
                            <span class="text-sm font-semibold text-emerald-600">KS</span>
                        </div>
                        <div>
                            <p class="text-sm font-semibold text-gray-900">Kumari Silva</p>
                            <p class="text-xs text-gray-500">Silva Electronics, Kandy</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm">
                    <div class="flex gap-1 mb-4">
                        <svg class="w-4 h-4 text-amber-400" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"></path>
                        </svg>
                        <svg class="w-4 h-4 text-amber-400" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"></path>
                        </svg>
                        <svg class="w-4 h-4 text-amber-400" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"></path>
                        </svg>
                        <svg class="w-4 h-4 text-amber-400" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"></path>
                        </svg>
                        <svg class="w-4 h-4 text-amber-400" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"></path>
                        </svg>
                    </div>
                    <p class="text-sm text-gray-600 leading-relaxed">
                        "Affordable pricing in LKR was a game changer. Finally a POS system that understands Sri Lankan
                        business needs."
                    </p>
                    <div class="mt-4 flex items-center gap-3">
                        <div class="w-10 h-10 rounded-full bg-amber-100 flex items-center justify-center">
                            <span class="text-sm font-semibold text-amber-600">RF</span>
                        </div>
                        <div>
                            <p class="text-sm font-semibold text-gray-900">Ruwan Fernando</p>
                            <p class="text-xs text-gray-500">Fernando Textiles, Galle</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="py-20 lg:py-28 bg-navy">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h2 class="text-3xl lg:text-4xl font-bold text-white">Ready to modernize your business?</h2>
            <p class="mt-4 text-lg text-slate-300 max-w-2xl mx-auto">
                Join hundreds of Sri Lankan businesses already using MultiBiz POS. Start your free 14-day trial today.
            </p>
            <div class="mt-8 flex flex-col sm:flex-row items-center justify-center gap-3">
                <a href="/register" class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-8 py-3.5 bg-blue-600 text-white font-semibold rounded-xl hover:bg-blue-500 transition-colors">
                    Start Free Trial
                    <span class="text-sm">&gt;</span>
                </a>
                <a href="/login" class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-8 py-3.5 bg-slate-700 text-white font-semibold rounded-xl hover:bg-slate-600 transition-colors">
                    View Live Demo
                </a>
            </div>
        </div>
    </section>

    <footer class="bg-gray-900 text-gray-400 py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-8">
                <div class="col-span-2 md:col-span-1">
                    <div class="flex items-center gap-2 mb-4">
                        <div class="w-8 h-8 bg-blue-600 rounded-lg flex items-center justify-center">
                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                            </svg>
                        </div>
                        <span class="text-sm font-bold text-white">
                            MultiBiz<span class="text-blue-400">POS</span>
                        </span>
                    </div>
                    <p class="text-sm leading-relaxed">
                        Cloud-based POS platform for Sri Lankan SMBs. Simple, affordable, powerful.
                    </p>
                </div>
                <div>
                    <h4 class="text-sm font-semibold text-white mb-4">Product</h4>
                    <ul class="space-y-2 text-sm">
                        <li><a href="/#features" class="hover:text-white transition-colors">Features</a></li>
                        <li><a href="/pricing" class="hover:text-white transition-colors">Pricing</a></li>
                        <li><a href="#" class="hover:text-white transition-colors">Documentation</a></li>
                        <li><a href="#" class="hover:text-white transition-colors">API</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="text-sm font-semibold text-white mb-4">Company</h4>
                    <ul class="space-y-2 text-sm">
                        <li><a href="#" class="hover:text-white transition-colors">About</a></li>
                        <li><a href="#" class="hover:text-white transition-colors">Blog</a></li>
                        <li><a href="#" class="hover:text-white transition-colors">Careers</a></li>
                        <li><a href="#" class="hover:text-white transition-colors">Contact</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="text-sm font-semibold text-white mb-4">Legal</h4>
                    <ul class="space-y-2 text-sm">
                        <li><a href="#" class="hover:text-white transition-colors">Privacy Policy</a></li>
                        <li><a href="#" class="hover:text-white transition-colors">Terms of Service</a></li>
                        <li><a href="#" class="hover:text-white transition-colors">Data Protection</a></li>
                    </ul>
                </div>
            </div>
            <div class="mt-10 pt-6 border-t border-gray-800 text-center text-xs">
                <p>(c) 2026 MultiBiz POS. All rights reserved. Made in Sri Lanka.</p>
            </div>
        </div>
    </footer>
</div>
@endsection
