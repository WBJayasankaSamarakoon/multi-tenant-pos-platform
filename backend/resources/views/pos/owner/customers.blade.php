@extends('layouts.dashboard')

@section('title', 'Customers - MultiBizPOS')

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
    $customers = [
        ['C001', 'Kamal Jayasinghe', 'kamal@gmail.com', '+94 77 111 2233', 45200, 28],
        ['C002', 'Dilani Wickrama', 'dilani@yahoo.com', '+94 77 222 3344', 128500, 52],
        ['C003', 'Sunil Bandara', 'sunil@gmail.com', '+94 77 333 4455', 18900, 12],
        ['C004', 'Priya Mendis', 'priya@hotmail.com', '+94 77 444 5566', 67800, 35],
        ['C005', 'Ranjith De Silva', 'ranjith@gmail.com', '+94 77 555 6677', 34500, 20],
        ['C006', 'Anoma Perera', 'anoma@gmail.com', '+94 77 666 7788', 89200, 41],
        ['C007', 'Chaminda Ratnayake', 'chaminda@yahoo.com', '+94 77 777 8899', 12300, 8],
        ['C008', 'Lakshmi Fernando', 'lakshmi@gmail.com', '+94 77 888 9900', 156000, 65],
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
                    <h1 class="text-2xl font-bold text-gray-900">Customers</h1>
                    <p class="text-sm text-gray-500 mt-1">Manage your customer database</p>
                </div>
                <button data-modal-open="#add-customer-modal" class="flex items-center gap-2 px-4 py-2.5 bg-blue-600 text-white text-sm font-semibold rounded-lg hover:bg-blue-700 transition-colors">
                    + Add Customer
                </button>
            </div>

            <div class="bg-white rounded-xl border border-gray-100 shadow-sm overflow-hidden">
                <div class="p-4 border-b border-gray-100">
                    <div class="relative max-w-sm">
                        <input type="text" placeholder="Search customers..." class="w-full pl-4 pr-4 py-2 text-sm border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all">
                    </div>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead>
                            <tr class="border-b border-gray-100">
                                <th class="text-left text-xs font-semibold text-gray-500 uppercase tracking-wider px-4 py-3">ID</th>
                                <th class="text-left text-xs font-semibold text-gray-500 uppercase tracking-wider px-4 py-3">Name</th>
                                <th class="text-left text-xs font-semibold text-gray-500 uppercase tracking-wider px-4 py-3">Email</th>
                                <th class="text-left text-xs font-semibold text-gray-500 uppercase tracking-wider px-4 py-3">Phone</th>
                                <th class="text-left text-xs font-semibold text-gray-500 uppercase tracking-wider px-4 py-3">Total Purchases</th>
                                <th class="text-left text-xs font-semibold text-gray-500 uppercase tracking-wider px-4 py-3">Visits</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50">
                            @foreach ($customers as $customer)
                                <tr class="hover:bg-gray-50/50">
                                    <td class="px-4 py-3 text-xs text-gray-400 font-mono">{{ $customer[0] }}</td>
                                    <td class="px-4 py-3 text-sm font-medium text-gray-900">{{ $customer[1] }}</td>
                                    <td class="px-4 py-3 text-sm text-gray-700">{{ $customer[2] }}</td>
                                    <td class="px-4 py-3 text-sm text-gray-700">{{ $customer[3] }}</td>
                                    <td class="px-4 py-3 text-sm font-semibold text-emerald-600">LKR {{ number_format($customer[4]) }}</td>
                                    <td class="px-4 py-3 text-sm text-gray-700">{{ $customer[5] }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="flex items-center justify-between px-4 py-3 border-t border-gray-100">
                    <p class="text-xs text-gray-500">Showing 1-8 of 8</p>
                    <div class="flex items-center gap-1">
                        <button class="p-1.5 rounded-md hover:bg-gray-100 disabled:opacity-30 disabled:cursor-not-allowed transition-colors" disabled>Prev</button>
                        <span class="text-xs font-medium text-gray-600 px-2">1 / 1</span>
                        <button class="p-1.5 rounded-md hover:bg-gray-100 disabled:opacity-30 disabled:cursor-not-allowed transition-colors" disabled>Next</button>
                    </div>
                </div>
            </div>
        </div>
    </main>
</div>

<div id="add-customer-modal" data-modal class="hidden fixed inset-0 z-50">
    <div class="absolute inset-0 bg-black/50" data-modal-close="#add-customer-modal"></div>
    <div class="fixed inset-x-4 top-[10%] sm:inset-auto sm:left-1/2 sm:top-1/2 sm:-translate-x-1/2 sm:-translate-y-1/2 sm:w-full sm:max-w-md bg-white rounded-2xl shadow-2xl z-50">
        <div class="flex items-center justify-between p-5 border-b border-gray-100">
            <h3 class="text-lg font-semibold text-gray-900">Add Customer</h3>
            <button data-modal-close="#add-customer-modal" class="p-1 rounded-md hover:bg-gray-100">X</button>
        </div>
        <div class="p-5 space-y-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5">Full Name</label>
                <input type="text" placeholder="Customer name" class="w-full px-4 py-2.5 text-sm border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5">Email</label>
                <input type="email" placeholder="customer@email.com" class="w-full px-4 py-2.5 text-sm border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5">Phone</label>
                <input type="tel" placeholder="+94 77 XXX XXXX" class="w-full px-4 py-2.5 text-sm border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500">
            </div>
        </div>
        <div class="flex gap-3 p-5 border-t border-gray-100">
            <button data-modal-close="#add-customer-modal" class="flex-1 py-2.5 border border-gray-200 text-gray-700 font-medium rounded-lg hover:bg-gray-50 text-sm">Cancel</button>
            <button data-modal-close="#add-customer-modal" class="flex-1 py-2.5 bg-blue-600 text-white font-semibold rounded-lg hover:bg-blue-700 text-sm">Add Customer</button>
        </div>
    </div>
</div>
@endsection
