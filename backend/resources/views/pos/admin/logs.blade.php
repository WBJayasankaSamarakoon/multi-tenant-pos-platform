@extends('layouts.dashboard')

@section('title', 'System Logs - MultiBizPOS')

@section('content')
@php
    $menuItems = [
        ['label' => 'Dashboard', 'path' => '/admin', 'icon' => 'D', 'match' => 'admin'],
        ['label' => 'Tenants', 'path' => '/admin/tenants', 'icon' => 'T', 'match' => 'admin/tenants*'],
        ['label' => 'Subscriptions', 'path' => '/admin/subscriptions', 'icon' => '$', 'match' => 'admin/subscriptions*'],
        ['label' => 'System Logs', 'path' => '/admin/logs', 'icon' => 'L', 'match' => 'admin/logs*'],
    ];
    $logs = [
        ['2026-03-14 14:32:15', 'nimal@pereragrocery.lk', 'Sale Completed', 'INV-1024 - LKR 3,450', '192.168.1.45', 'Transaction'],
        ['2026-03-14 14:30:02', 'admin@multibizpos.lk', 'Tenant Activated', 'Ratnayake Foods - Enterprise', '10.0.0.1', 'Admin'],
        ['2026-03-14 14:28:45', 'kamala@pereragrocery.lk', 'Login', 'Successful login from Colombo', '192.168.1.46', 'Auth'],
        ['2026-03-14 14:25:10', 'saman@pereragrocery.lk', 'Product Added', 'New product: Organic Tea 100g', '192.168.1.47', 'Inventory'],
        ['2026-03-14 14:20:33', 'dilani@silvaelectronics.lk', 'Sale Completed', 'INV-2045 - LKR 45,800', '192.168.2.12', 'Transaction'],
        ['2026-03-14 14:15:00', 'system', 'Backup Completed', 'Daily database backup successful', '10.0.0.1', 'System'],
        ['2026-03-14 14:10:22', 'admin@multibizpos.lk', 'Subscription Updated', 'Mendis Pharmacy - Basic to Pro', '10.0.0.1', 'Admin'],
        ['2026-03-14 14:05:18', 'ruwan@pereragrocery.lk', 'Login Failed', 'Invalid password attempt', '192.168.1.50', 'Auth'],
        ['2026-03-14 14:00:00', 'system', 'Health Check', 'All services operational', '10.0.0.1', 'System'],
        ['2026-03-14 13:55:42', 'nimal@pereragrocery.lk', 'Settings Updated', 'Tax rate changed to 15%', '192.168.1.45', 'Settings'],
    ];
    $types = ['All', 'Transaction', 'Auth', 'Admin', 'Inventory', 'System', 'Settings'];
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
                <h1 class="text-2xl font-bold text-gray-900">System Logs</h1>
                <p class="text-sm text-gray-500 mt-1">Monitor platform activity and events</p>
            </div>

            <div class="flex items-center gap-2 mb-4 overflow-x-auto pb-2">
                <span class="text-xs text-gray-400">Filter</span>
                @foreach ($types as $type)
                    <button class="px-3 py-1.5 text-xs font-medium rounded-full whitespace-nowrap transition-all {{ $type === 'All' ? 'bg-blue-600 text-white' : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }}">{{ $type }}</button>
                @endforeach
            </div>

            <div class="bg-white rounded-xl border border-gray-100 shadow-sm overflow-hidden">
                <div class="p-4 border-b border-gray-100">
                    <div class="relative max-w-sm">
                        <input type="text" placeholder="Search logs..." class="w-full pl-4 pr-4 py-2 text-sm border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all">
                    </div>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead>
                            <tr class="border-b border-gray-100">
                                <th class="text-left text-xs font-semibold text-gray-500 uppercase tracking-wider px-4 py-3">Timestamp</th>
                                <th class="text-left text-xs font-semibold text-gray-500 uppercase tracking-wider px-4 py-3">User</th>
                                <th class="text-left text-xs font-semibold text-gray-500 uppercase tracking-wider px-4 py-3">Action</th>
                                <th class="text-left text-xs font-semibold text-gray-500 uppercase tracking-wider px-4 py-3">Details</th>
                                <th class="text-left text-xs font-semibold text-gray-500 uppercase tracking-wider px-4 py-3">Type</th>
                                <th class="text-left text-xs font-semibold text-gray-500 uppercase tracking-wider px-4 py-3">IP Address</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50">
                            @foreach ($logs as $log)
                                <tr class="hover:bg-gray-50/50">
                                    <td class="px-4 py-3 text-xs font-mono text-gray-500">{{ $log[0] }}</td>
                                    <td class="px-4 py-3 text-sm font-medium text-gray-900">{{ $log[1] }}</td>
                                    <td class="px-4 py-3 text-sm text-gray-700">{{ $log[2] }}</td>
                                    <td class="px-4 py-3 text-sm text-gray-500">{{ $log[3] }}</td>
                                    <td class="px-4 py-3">
                                        @php
                                            $typeColor = match($log[5]) {
                                                'Transaction' => 'bg-emerald-50 text-emerald-700',
                                                'Auth' => 'bg-blue-50 text-blue-700',
                                                'Admin' => 'bg-purple-50 text-purple-700',
                                                'Inventory' => 'bg-amber-50 text-amber-700',
                                                'System' => 'bg-gray-100 text-gray-600',
                                                'Settings' => 'bg-rose-50 text-rose-700',
                                                default => 'bg-gray-100 text-gray-600',
                                            };
                                        @endphp
                                        <span class="text-xs font-medium px-2 py-0.5 rounded-full {{ $typeColor }}">{{ $log[5] }}</span>
                                    </td>
                                    <td class="px-4 py-3 text-xs font-mono text-gray-400">{{ $log[4] }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="flex items-center justify-between px-4 py-3 border-t border-gray-100">
                    <p class="text-xs text-gray-500">Showing 1-10 of 10</p>
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
