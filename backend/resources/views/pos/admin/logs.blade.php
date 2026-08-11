@extends('layouts.admin')

@section('title', 'System Logs - MultiBizPOS')

@section('content')
<div>
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
                                    <td class="px-4 py-3 text-xs font-mono text-gray-500">{{ $log['timestamp'] }}</td>
                                    <td class="px-4 py-3 text-sm font-medium text-gray-900">{{ $log['user'] }}</td>
                                    <td class="px-4 py-3 text-sm text-gray-700">{{ $log['action'] }}</td>
                                    <td class="px-4 py-3 text-sm text-gray-500">{{ $log['details'] }}</td>
                                    <td class="px-4 py-3">
                                        @php
                                            $typeColor = match($log['type']) {
                                                'Transaction' => 'bg-emerald-50 text-emerald-700',
                                                'Admin' => 'bg-purple-50 text-purple-700',
                                                'Inventory' => 'bg-amber-50 text-amber-700',
                                                default => 'bg-gray-100 text-gray-600',
                                            };
                                        @endphp
                                        <span class="text-xs font-medium px-2 py-0.5 rounded-full {{ $typeColor }}">{{ $log['type'] }}</span>
                                    </td>
                                    <td class="px-4 py-3 text-xs font-mono text-gray-400">{{ $log['ip'] }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="flex items-center justify-between px-4 py-3 border-t border-gray-100">
                    <p class="text-xs text-gray-500">Showing 1-{{ $logs->count() }} of {{ $logs->count() }}</p>
                    <div class="flex items-center gap-1">
                        <button class="p-1.5 rounded-md hover:bg-gray-100 disabled:opacity-30 disabled:cursor-not-allowed transition-colors" disabled>Prev</button>
                        <span class="text-xs font-medium text-gray-600 px-2">1 / 1</span>
                        <button class="p-1.5 rounded-md hover:bg-gray-100 disabled:opacity-30 disabled:cursor-not-allowed transition-colors" disabled>Next</button>
                    </div>
                </div>
            </div>
</div>
@endsection
