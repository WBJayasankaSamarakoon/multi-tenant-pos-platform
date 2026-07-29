@extends('layouts.dashboard')

@section('title', 'Tenants - MultiBizPOS')

@section('content')
@php
    $menuItems = [
        ['label' => 'Dashboard', 'path' => '/admin', 'icon' => 'D', 'match' => 'admin'],
        ['label' => 'Tenants', 'path' => '/admin/tenants', 'icon' => 'T', 'match' => 'admin/tenants*'],
        ['label' => 'Subscriptions', 'path' => '/admin/subscriptions', 'icon' => '$', 'match' => 'admin/subscriptions*'],
        ['label' => 'System Logs', 'path' => '/admin/logs', 'icon' => 'L', 'match' => 'admin/logs*'],
    ];
    $tenants = [
        ['T001', 'Perera Grocery', 'Pro', 'Active', 5, 342, '2025-01-15', 'Colombo 03'],
        ['T002', 'Silva Electronics', 'Enterprise', 'Active', 12, 890, '2025-01-20', 'Kandy'],
        ['T003', 'Fernando Textiles', 'Pro', 'Active', 4, 256, '2025-02-01', 'Galle'],
        ['T004', 'Mendis Pharmacy', 'Basic', 'Active', 1, 89, '2025-02-15', 'Negombo'],
        ['T005', 'Bandara Hardware', 'Pro', 'Active', 3, 567, '2025-03-01', 'Matara'],
        ['T006', 'Jayawardena Books', 'Basic', 'Suspended', 1, 45, '2025-03-05', 'Colombo 07'],
        ['T007', 'Ratnayake Foods', 'Enterprise', 'Active', 8, 1200, '2025-03-10', 'Kurunegala'],
        ['T008', 'De Silva Bakery', 'Pro', 'Active', 3, 178, '2025-03-12', 'Colombo 05'],
    ];
@endphp
<div class="flex min-h-screen bg-gray-50">
    @include('partials.sidebar', [
        'menuItems' => $menuItems,
        'userName' => 'Admin User',
        'userRole' => 'Platform Admin',
    ])

    <main class="flex-1 min-w-0">
        <div class="p-4 sm:p-6 lg:p-8">
            <div class="mb-6">
                <h1 class="text-2xl font-bold text-gray-900">Tenants</h1>
                <p class="text-sm text-gray-500 mt-1">Manage all registered businesses</p>
            </div>

            <div class="bg-white rounded-xl border border-gray-100 shadow-sm overflow-hidden">
                <div class="p-4 border-b border-gray-100">
                    <div class="relative max-w-sm">
                        <input type="text" placeholder="Search companies..." class="w-full pl-4 pr-4 py-2 text-sm border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all">
                    </div>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead>
                            <tr class="border-b border-gray-100">
                                <th class="text-left text-xs font-semibold text-gray-500 uppercase tracking-wider px-4 py-3">Company</th>
                                <th class="text-left text-xs font-semibold text-gray-500 uppercase tracking-wider px-4 py-3">Plan</th>
                                <th class="text-left text-xs font-semibold text-gray-500 uppercase tracking-wider px-4 py-3">Status</th>
                                <th class="text-left text-xs font-semibold text-gray-500 uppercase tracking-wider px-4 py-3">Users</th>
                                <th class="text-left text-xs font-semibold text-gray-500 uppercase tracking-wider px-4 py-3">Products</th>
                                <th class="text-left text-xs font-semibold text-gray-500 uppercase tracking-wider px-4 py-3">Created</th>
                                <th class="text-right text-xs font-semibold text-gray-500 uppercase tracking-wider px-4 py-3">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50">
                            @foreach ($tenants as $tenant)
                                <tr class="hover:bg-gray-50/50">
                                    <td class="px-4 py-3 text-sm font-medium text-gray-900">{{ $tenant[1] }}<div class="text-xs text-gray-400">{{ $tenant[7] }}</div></td>
                                    <td class="px-4 py-3">
                                        <span class="text-xs font-medium px-2 py-0.5 rounded-full {{ $tenant[2] === 'Basic' ? 'bg-gray-100 text-gray-600' : ($tenant[2] === 'Pro' ? 'bg-blue-100 text-blue-700' : 'bg-purple-100 text-purple-700') }}">{{ $tenant[2] }}</span>
                                    </td>
                                    <td class="px-4 py-3">
                                        <span class="text-xs font-medium px-2 py-0.5 rounded-full {{ $tenant[3] === 'Active' ? 'bg-emerald-50 text-emerald-700' : 'bg-red-50 text-red-700' }}">{{ $tenant[3] }}</span>
                                    </td>
                                    <td class="px-4 py-3 text-sm text-gray-700">{{ $tenant[4] }}</td>
                                    <td class="px-4 py-3 text-sm text-gray-700">{{ $tenant[5] }}</td>
                                    <td class="px-4 py-3 text-sm text-gray-700">{{ $tenant[6] }}</td>
                                    <td class="px-4 py-3 text-right">
                                        <button data-modal-open="#tenant-details" class="p-1.5 rounded-md hover:bg-gray-100 text-gray-400 hover:text-blue-600">View</button>
                                        <button class="p-1.5 rounded-md hover:bg-red-50 text-gray-400 hover:text-red-600">Suspend</button>
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

<div id="tenant-details" data-modal class="hidden fixed inset-0 z-50">
    <div class="absolute inset-0 bg-black/50" data-modal-close="#tenant-details"></div>
    <div class="fixed top-0 right-0 h-full w-full max-w-md bg-white shadow-2xl z-50 overflow-y-auto">
        <div class="flex items-center justify-between p-5 border-b border-gray-100">
            <h3 class="text-lg font-semibold text-gray-900">Tenant Details</h3>
            <button data-modal-close="#tenant-details" class="p-1 rounded-md hover:bg-gray-100">X</button>
        </div>
        <div class="p-5 space-y-6">
            <div class="flex items-center gap-3">
                <div class="w-12 h-12 rounded-xl bg-blue-50 flex items-center justify-center">
                    <span class="text-blue-600 text-xs font-bold">CO</span>
                </div>
                <div>
                    <p class="font-bold text-gray-900">Perera Grocery</p>
                    <p class="text-sm text-gray-500">Colombo 03</p>
                </div>
            </div>
            <div class="grid grid-cols-2 gap-4">
                <div class="p-3 bg-gray-50 rounded-lg">
                    <p class="text-xs text-gray-500">Plan</p>
                    <p class="font-semibold text-gray-900">Pro</p>
                </div>
                <div class="p-3 bg-gray-50 rounded-lg">
                    <p class="text-xs text-gray-500">Status</p>
                    <p class="font-semibold text-gray-900">Active</p>
                </div>
                <div class="p-3 bg-gray-50 rounded-lg">
                    <p class="text-xs text-gray-500">Users</p>
                    <p class="font-semibold text-gray-900">5</p>
                </div>
                <div class="p-3 bg-gray-50 rounded-lg">
                    <p class="text-xs text-gray-500">Products</p>
                    <p class="font-semibold text-gray-900">342</p>
                </div>
                <div class="p-3 bg-gray-50 rounded-lg col-span-2">
                    <p class="text-xs text-gray-500">Created</p>
                    <p class="font-semibold text-gray-900">2025-01-15</p>
                </div>
            </div>
            <div class="flex gap-3">
                <button class="flex-1 py-2.5 bg-red-50 text-red-600 font-medium rounded-lg hover:bg-red-100 text-sm">Suspend Tenant</button>
                <button class="flex-1 py-2.5 bg-blue-600 text-white font-medium rounded-lg hover:bg-blue-700 text-sm">Contact</button>
            </div>
        </div>
    </div>
</div>
@endsection
