@extends('layouts.dashboard')

@section('content')
<div>
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-900">System Logs</h1>
        <p class="text-sm text-gray-500 mt-1">
            Monitor platform activity and events
        </p>
    </div>

    <div class="flex items-center gap-2 mb-4 overflow-x-auto pb-2">
        <svg class="w-4 h-4 text-gray-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path>
        </svg>
        @foreach(['All', 'Transaction', 'Auth', 'Admin', 'Inventory', 'System', 'Settings'] as $type)
            <button class="px-3 py-1.5 text-xs font-medium rounded-full whitespace-nowrap transition-all {{ $type === 'All' ? 'bg-blue-600 text-white' : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }}">
                {{ $type }}
            </button>
        @endforeach
    </div>

    @php
        $logs = [
            ['id' => 1, 'timestamp' => '2026-03-14 14:32:15', 'user' => 'nimal@pereragrocery.lk', 'action' => 'Sale Completed', 'details' => 'INV-1024 - LKR 3,450', 'ip' => '192.168.1.45', 'type' => 'Transaction'],
            ['id' => 2, 'timestamp' => '2026-03-14 14:30:02', 'user' => 'admin@multibizpos.lk', 'action' => 'Tenant Activated', 'details' => 'Ratnayake Foods - Enterprise', 'ip' => '10.0.0.1', 'type' => 'Admin'],
            ['id' => 3, 'timestamp' => '2026-03-14 14:28:45', 'user' => 'kamala@pereragrocery.lk', 'action' => 'Login', 'details' => 'Successful login from Colombo', 'ip' => '192.168.1.46', 'type' => 'Auth'],
            ['id' => 4, 'timestamp' => '2026-03-14 14:25:10', 'user' => 'saman@pereragrocery.lk', 'action' => 'Product Added', 'details' => 'New product: Organic Tea 100g', 'ip' => '192.168.1.47', 'type' => 'Inventory'],
            ['id' => 5, 'timestamp' => '2026-03-14 14:20:33', 'user' => 'dilani@silvaelectronics.lk', 'action' => 'Sale Completed', 'details' => 'INV-2045 - LKR 45,800', 'ip' => '192.168.2.12', 'type' => 'Transaction'],
            ['id' => 6, 'timestamp' => '2026-03-14 14:15:00', 'user' => 'system', 'action' => 'Backup Completed', 'details' => 'Daily database backup successful', 'ip' => '10.0.0.1', 'type' => 'System'],
            ['id' => 7, 'timestamp' => '2026-03-14 14:10:22', 'user' => 'admin@multibizpos.lk', 'action' => 'Subscription Updated', 'details' => 'Mendis Pharmacy - Basic to Pro', 'ip' => '10.0.0.1', 'type' => 'Admin'],
            ['id' => 8, 'timestamp' => '2026-03-14 14:05:18', 'user' => 'ruwan@pereragrocery.lk', 'action' => 'Login Failed', 'details' => 'Invalid password attempt', 'ip' => '192.168.1.50', 'type' => 'Auth'],
            ['id' => 9, 'timestamp' => '2026-03-14 14:00:00', 'user' => 'system', 'action' => 'Health Check', 'details' => 'All services operational', 'ip' => '10.0.0.1', 'type' => 'System'],
            ['id' => 10, 'timestamp' => '2026-03-14 13:55:42', 'user' => 'nimal@pereragrocery.lk', 'action' => 'Settings Updated', 'details' => 'Tax rate changed to 15%', 'ip' => '192.168.1.45', 'type' => 'Settings'],
        ];
        $columns = [
            ['key' => 'timestamp', 'label' => 'Timestamp', 'sortable' => true],
            ['key' => 'user', 'label' => 'User', 'sortable' => true],
            ['key' => 'action', 'label' => 'Action', 'sortable' => true],
            ['key' => 'details', 'label' => 'Details'],
            ['key' => 'type', 'label' => 'Type'],
            ['key' => 'ip', 'label' => 'IP Address'],
        ];
    @endphp
    @component('partials.data-table', [
        'columns' => $columns,
        'data' => $logs,
        'searchPlaceholder' => 'Search logs...',
        'searchKey' => 'user',
        'pageSize' => 10
    ])
    @endcomponent
</div>
@endsection
