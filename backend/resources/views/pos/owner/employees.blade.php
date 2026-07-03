@extends('layouts.dashboard')

@section('title', 'Employees - MultiBizPOS')

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
    $employees = [
        ['Nimal Perera', 'Business Owner', 'nimal@pereragrocery.lk', '+94 77 123 4567', 'Active', '2025-01-15'],
        ['Saman Kumara', 'Manager', 'saman@pereragrocery.lk', '+94 77 234 5678', 'Active', '2025-02-01'],
        ['Kamala Dissanayake', 'Cashier', 'kamala@pereragrocery.lk', '+94 77 345 6789', 'Active', '2025-02-15'],
        ['Ruwan Jayawardena', 'Cashier', 'ruwan@pereragrocery.lk', '+94 77 456 7890', 'Active', '2025-03-01'],
        ['Dilini Fernando', 'Cashier', 'dilini@pereragrocery.lk', '+94 77 567 8901', 'Inactive', '2025-03-10'],
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
                    <h1 class="text-2xl font-bold text-gray-900">Employees</h1>
                    <p class="text-sm text-gray-500 mt-1">Manage your team members and their roles</p>
                </div>
                <button data-modal-open="#add-employee-modal" class="flex items-center gap-2 px-4 py-2.5 bg-blue-600 text-white text-sm font-semibold rounded-lg hover:bg-blue-700 transition-colors">
                    + Add Employee
                </button>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                @foreach ($employees as $emp)
                    @php
                        $initials = collect(explode(' ', $emp[0]))->map(fn ($n) => substr($n, 0, 1))->implode('');
                        $roleColors = [
                            'Business Owner' => 'bg-blue-100 text-blue-700',
                            'Manager' => 'bg-amber-100 text-amber-700',
                            'Cashier' => 'bg-emerald-100 text-emerald-700',
                        ];
                    @endphp
                    <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-5">
                        <div class="flex items-start justify-between mb-4">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-full bg-gray-100 flex items-center justify-center">
                                    <span class="text-sm font-semibold text-gray-600">{{ $initials }}</span>
                                </div>
                                <div>
                                    <p class="font-semibold text-gray-900">{{ $emp[0] }}</p>
                                    <span class="text-xs font-medium px-2 py-0.5 rounded-full {{ $roleColors[$emp[1]] ?? 'bg-gray-100 text-gray-600' }}">{{ $emp[1] }}</span>
                                </div>
                            </div>
                            <span class="text-xs font-medium px-2 py-0.5 rounded-full {{ $emp[4] === 'Active' ? 'bg-emerald-50 text-emerald-700' : 'bg-gray-100 text-gray-500' }}">{{ $emp[4] }}</span>
                        </div>
                        <div class="space-y-2">
                            <div class="flex items-center gap-2 text-sm text-gray-500">
                                <span class="text-xs">@</span>
                                {{ $emp[2] }}
                            </div>
                            <div class="flex items-center gap-2 text-sm text-gray-500">
                                <span class="text-xs">T</span>
                                {{ $emp[3] }}
                            </div>
                        </div>
                        <div class="mt-4 pt-3 border-t border-gray-50 flex justify-between items-center">
                            <span class="text-xs text-gray-400">Joined {{ $emp[5] }}</span>
                            <button class="text-xs text-blue-600 font-medium hover:text-blue-700">Edit</button>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </main>
</div>

<div id="add-employee-modal" data-modal class="hidden fixed inset-0 z-50">
    <div class="absolute inset-0 bg-black/50" data-modal-close="#add-employee-modal"></div>
    <div class="fixed inset-x-4 top-[10%] sm:inset-auto sm:left-1/2 sm:top-1/2 sm:-translate-x-1/2 sm:-translate-y-1/2 sm:w-full sm:max-w-md bg-white rounded-2xl shadow-2xl z-50">
        <div class="flex items-center justify-between p-5 border-b border-gray-100">
            <h3 class="text-lg font-semibold text-gray-900">Add Employee</h3>
            <button data-modal-close="#add-employee-modal" class="p-1 rounded-md hover:bg-gray-100">X</button>
        </div>
        <div class="p-5 space-y-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5">Full Name</label>
                <input type="text" placeholder="e.g., Saman Kumara" class="w-full px-4 py-2.5 text-sm border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5">Email</label>
                <input type="email" placeholder="saman@company.lk" class="w-full px-4 py-2.5 text-sm border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5">Role</label>
                <select class="w-full px-4 py-2.5 text-sm border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500">
                    <option>Cashier</option>
                    <option>Manager</option>
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5">Temporary Password</label>
                <input type="password" placeholder="Min. 8 characters" class="w-full px-4 py-2.5 text-sm border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500">
            </div>
        </div>
        <div class="flex gap-3 p-5 border-t border-gray-100">
            <button data-modal-close="#add-employee-modal" class="flex-1 py-2.5 border border-gray-200 text-gray-700 font-medium rounded-lg hover:bg-gray-50 text-sm">Cancel</button>
            <button data-modal-close="#add-employee-modal" class="flex-1 py-2.5 bg-blue-600 text-white font-semibold rounded-lg hover:bg-blue-700 text-sm">Add Employee</button>
        </div>
    </div>
</div>
@endsection
