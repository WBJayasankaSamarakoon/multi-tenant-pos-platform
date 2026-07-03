@extends('layouts.dashboard')

@section('content')
<div>
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-6 gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Employees</h1>
            <p class="text-sm text-gray-500 mt-1">
                Manage your team members and their roles
            </p>
        </div>
        <button class="flex items-center gap-2 px-4 py-2.5 bg-blue-600 text-white text-sm font-semibold rounded-lg hover:bg-blue-700 transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
            </svg>
            Add Employee
        </button>
    </div>

    {{-- Employee Cards --}}
    @php
        $employees = [
            ['id' => 1, 'name' => 'Nimal Perera', 'role' => 'Business Owner', 'email' => 'nimal@pereragrocery.lk', 'phone' => '+94 77 123 4567', 'status' => 'Active', 'joined' => '2025-01-15'],
            ['id' => 2, 'name' => 'Saman Kumara', 'role' => 'Manager', 'email' => 'saman@pereragrocery.lk', 'phone' => '+94 77 234 5678', 'status' => 'Active', 'joined' => '2025-02-01'],
            ['id' => 3, 'name' => 'Kamala Dissanayake', 'role' => 'Cashier', 'email' => 'kamala@pereragrocery.lk', 'phone' => '+94 77 345 6789', 'status' => 'Active', 'joined' => '2025-02-15'],
            ['id' => 4, 'name' => 'Ruwan Jayawardena', 'role' => 'Cashier', 'email' => 'ruwan@pereragrocery.lk', 'phone' => '+94 77 456 7890', 'status' => 'Active', 'joined' => '2025-03-01'],
            ['id' => 5, 'name' => 'Dilini Fernando', 'role' => 'Cashier', 'email' => 'dilini@pereragrocery.lk', 'phone' => '+94 77 567 8901', 'status' => 'Inactive', 'joined' => '2025-03-10'],
        ];
        $roleColors = [
            'Business Owner' => 'bg-blue-100 text-blue-700',
            'Manager' => 'bg-amber-100 text-amber-700',
            'Cashier' => 'bg-emerald-100 text-emerald-700'
        ];
    @endphp
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
        @foreach($employees as $emp)
            <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-5">
                <div class="flex items-start justify-between mb-4">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-full bg-gray-100 flex items-center justify-center">
                            <span class="text-sm font-semibold text-gray-600">
                                {{ collect(explode(' ', $emp['name']))->map(fn($n) => substr($n, 0, 1))->implode('') }}
                            </span>
                        </div>
                        <div>
                            <p class="font-semibold text-gray-900">{{ $emp['name'] }}</p>
                            <span class="text-xs font-medium px-2 py-0.5 rounded-full {{ $roleColors[$emp['role']] ?? 'bg-gray-100 text-gray-600' }}">
                                {{ $emp['role'] }}
                            </span>
                        </div>
                    </div>
                    <span class="text-xs font-medium px-2 py-0.5 rounded-full {{ $emp['status'] === 'Active' ? 'bg-emerald-50 text-emerald-700' : 'bg-gray-100 text-gray-500' }}">
                        {{ $emp['status'] }}
                    </span>
                </div>
                <div class="space-y-2">
                    <div class="flex items-center gap-2 text-sm text-gray-500">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                        </svg>
                        {{ $emp['email'] }}
                    </div>
                    <div class="flex items-center gap-2 text-sm text-gray-500">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                        </svg>
                        {{ $emp['phone'] }}
                    </div>
                </div>
                <div class="mt-4 pt-3 border-t border-gray-50 flex justify-between items-center">
                    <span class="text-xs text-gray-400">Joined {{ $emp['joined'] }}</span>
                    <button class="text-xs text-blue-600 font-medium hover:text-blue-700">
                        Edit
                    </button>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection
