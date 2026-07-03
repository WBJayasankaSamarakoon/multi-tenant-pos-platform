@extends('layouts.dashboard')

@section('title', 'Sales History - MultiBizPOS')

@section('content')
@php
    $menuItems = [
        ['label' => 'POS Terminal', 'path' => '/cashier', 'icon' => 'P', 'match' => 'cashier'],
        ['label' => 'Sales History', 'path' => '/cashier/history', 'icon' => 'H', 'match' => 'cashier/history*'],
    ];
    $sales = [
        ['INV-1024', '14:32', 'Kamal Jayasinghe', 5, 3450, 'Cash'],
        ['INV-1023', '14:15', 'Dilani Wickrama', 12, 12800, 'Card'],
        ['INV-1022', '13:48', 'Walk-in Customer', 2, 890, 'Cash'],
        ['INV-1021', '13:20', 'Priya Mendis', 8, 5670, 'Mobile'],
        ['INV-1020', '12:45', 'Walk-in Customer', 3, 2340, 'Cash'],
        ['INV-1019', '11:30', 'Anoma Perera', 6, 7890, 'Card'],
        ['INV-1018', '10:15', 'Walk-in Customer', 1, 450, 'Cash'],
        ['INV-1017', '09:45', 'Lakshmi Fernando', 15, 18500, 'Card'],
    ];
@endphp
<div class="flex min-h-screen bg-gray-50">
    @include('partials.sidebar', [
        'menuItems' => $menuItems,
        'userName' => 'Kamala Dissanayake',
        'userRole' => 'Cashier',
        'companyName' => 'Perera Grocery',
    ])

    <main class="flex-1 min-w-0">
        <div class="p-4 sm:p-6 lg:p-8">
            <div class="mb-6">
                <h1 class="text-2xl font-bold text-gray-900">Sales History</h1>
                <p class="text-sm text-gray-500 mt-1">Today's transactions</p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-6">
                <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-5">
                    <p class="text-sm text-gray-500">Total Sales</p>
                    <p class="text-2xl font-bold text-gray-900 mt-1">LKR 51,990</p>
                </div>
                <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-5">
                    <p class="text-sm text-gray-500">Transactions</p>
                    <p class="text-2xl font-bold text-gray-900 mt-1">8</p>
                </div>
                <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-5">
                    <p class="text-sm text-gray-500">Average Sale</p>
                    <p class="text-2xl font-bold text-gray-900 mt-1">LKR 6,499</p>
                </div>
            </div>

            <div class="bg-white rounded-xl border border-gray-100 shadow-sm overflow-hidden">
                <div class="p-4 border-b border-gray-100">
                    <div class="relative max-w-sm">
                        <input type="text" placeholder="Search by invoice number..." class="w-full pl-4 pr-4 py-2 text-sm border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all">
                    </div>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead>
                            <tr class="border-b border-gray-100">
                                <th class="text-left text-xs font-semibold text-gray-500 uppercase tracking-wider px-4 py-3">Invoice</th>
                                <th class="text-left text-xs font-semibold text-gray-500 uppercase tracking-wider px-4 py-3">Time</th>
                                <th class="text-left text-xs font-semibold text-gray-500 uppercase tracking-wider px-4 py-3">Customer</th>
                                <th class="text-left text-xs font-semibold text-gray-500 uppercase tracking-wider px-4 py-3">Items</th>
                                <th class="text-left text-xs font-semibold text-gray-500 uppercase tracking-wider px-4 py-3">Total</th>
                                <th class="text-left text-xs font-semibold text-gray-500 uppercase tracking-wider px-4 py-3">Payment</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50">
                            @foreach ($sales as $row)
                                <tr class="hover:bg-gray-50/50">
                                    <td class="px-4 py-3 text-sm font-medium text-blue-600">{{ $row[0] }}</td>
                                    <td class="px-4 py-3 text-sm text-gray-700">{{ $row[1] }}</td>
                                    <td class="px-4 py-3 text-sm text-gray-700">{{ $row[2] }}</td>
                                    <td class="px-4 py-3 text-sm text-gray-700">{{ $row[3] }}</td>
                                    <td class="px-4 py-3 text-sm font-semibold">LKR {{ number_format($row[4]) }}</td>
                                    <td class="px-4 py-3">
                                        <span class="text-xs font-medium px-2 py-0.5 rounded-full {{ $row[5] === 'Cash' ? 'bg-emerald-50 text-emerald-700' : ($row[5] === 'Card' ? 'bg-blue-50 text-blue-700' : 'bg-purple-50 text-purple-700') }}">{{ $row[5] }}</span>
                                    </td>
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
@endsection
