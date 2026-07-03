@extends('layouts.dashboard')

@section('title', 'Customers - MultiBizPOS')

@section('content')
@php
    $menuItems = [
        ['label' => 'Dashboard', 'path' => '/manager', 'icon' => 'D', 'match' => 'manager'],
        ['label' => 'Inventory', 'path' => '/manager/inventory', 'icon' => 'I', 'match' => 'manager/inventory*'],
        ['label' => 'Reports', 'path' => '/manager/reports', 'icon' => 'R', 'match' => 'manager/reports*'],
        ['label' => 'Customers', 'path' => '/manager/customers', 'icon' => 'C', 'match' => 'manager/customers*'],
    ];
    $customers = [
        ['Kamal Jayasinghe', 'kamal@gmail.com', '+94 77 111 2233', 45200, 28],
        ['Dilani Wickrama', 'dilani@yahoo.com', '+94 77 222 3344', 128500, 52],
        ['Sunil Bandara', 'sunil@gmail.com', '+94 77 333 4455', 18900, 12],
        ['Priya Mendis', 'priya@hotmail.com', '+94 77 444 5566', 67800, 35],
        ['Ranjith De Silva', 'ranjith@gmail.com', '+94 77 555 6677', 34500, 20],
        ['Anoma Perera', 'anoma@gmail.com', '+94 77 666 7788', 89200, 41],
    ];
@endphp
<div class="flex min-h-screen bg-gray-50">
    @include('partials.sidebar', [
        'menuItems' => $menuItems,
        'userName' => 'Saman Kumara',
        'userRole' => 'Manager',
        'companyName' => 'Perera Grocery',
    ])

    <main class="flex-1 min-w-0">
        <div class="p-4 sm:p-6 lg:p-8">
            <div class="mb-6">
                <h1 class="text-2xl font-bold text-gray-900">Customers</h1>
                <p class="text-sm text-gray-500 mt-1">View and manage customer information</p>
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
                                    <td class="px-4 py-3 text-sm font-medium text-gray-900">{{ $customer[0] }}</td>
                                    <td class="px-4 py-3 text-sm text-gray-700">{{ $customer[1] }}</td>
                                    <td class="px-4 py-3 text-sm text-gray-700">{{ $customer[2] }}</td>
                                    <td class="px-4 py-3 text-sm font-semibold text-emerald-600">LKR {{ number_format($customer[3]) }}</td>
                                    <td class="px-4 py-3 text-sm text-gray-700">{{ $customer[4] }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="flex items-center justify-between px-4 py-3 border-t border-gray-100">
                    <p class="text-xs text-gray-500">Showing 1-6 of 6</p>
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
@endsection
