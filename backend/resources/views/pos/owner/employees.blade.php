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
    $employees = collect($employees ?? []);
@endphp
<div class="flex min-h-screen bg-gray-50">
    @include('partials.sidebar', [
        'menuItems' => $menuItems,
        'userName' => auth()->user()?->name ?? 'Owner',
        'userRole' => 'Business Owner',
        'companyName' => $company->name ?? 'Business',
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
                @forelse ($employees as $emp)
                    @php
                        $initials = collect(explode(' ', $emp->name))->map(fn ($n) => substr($n, 0, 1))->implode('');
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
                                    <p class="font-semibold text-gray-900">{{ $emp->name }}</p>
                                    <span class="text-xs font-medium px-2 py-0.5 rounded-full {{ $roleColors[$emp->role] ?? 'bg-gray-100 text-gray-600' }}">{{ $emp->role }}</span>
                                </div>
                            </div>
                            <span class="text-xs font-medium px-2 py-0.5 rounded-full {{ $emp->status === 'Active' ? 'bg-emerald-50 text-emerald-700' : 'bg-gray-100 text-gray-500' }}">{{ $emp->status }}</span>
                        </div>
                        <div class="space-y-2">
                            <div class="flex items-center gap-2 text-sm text-gray-500">
                                {{ $emp->email }}
                            </div>
                            <div class="flex items-center gap-2 text-sm text-gray-500">
                                {{ $emp->phone }}
                            </div>
                        </div>
                        <div class="mt-4 pt-3 border-t border-gray-50 flex justify-between items-center">
                            <span class="text-xs text-gray-400">Joined {{ $emp->joined_at }}</span>
                            <div class="flex items-center gap-2">
                                <button
                                    type="button"
                                    data-modal-open="#edit-employee-modal"
                                    data-employee-id="{{ $emp->id ?? '' }}"
                                    data-employee-name="{{ $emp->name }}"
                                    data-employee-email="{{ $emp->email }}"
                                    data-employee-role="{{ $emp->role }}"
                                    data-employee-status="{{ $emp->status }}"
                                    data-employee-phone="{{ $emp->phone }}"
                                    data-employee-joined-at="{{ $emp->joined_at }}"
                                    class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-medium rounded-md bg-blue-50 text-blue-700 hover:bg-blue-100 transition-colors">
                                    <svg class="w-3.5 h-3.5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                        <path d="M13.586 3a2 2 0 0 1 2.828 0l.586.586a2 2 0 0 1 0 2.828l-8.95 8.95a2 2 0 0 1-.878.518l-3.42 1.025a.75.75 0 0 1-.93-.93l1.025-3.42a2 2 0 0 1 .518-.878l8.95-8.95Z" />
                                    </svg>
                                    Edit
                                </button>
                                <button
                                    type="button"
                                    data-delete-modal-open
                                    data-delete-url="/owner/employees/{{ $emp->id }}"
                                    data-delete-title="Delete Employee"
                                    data-delete-subtitle="Are you sure you want to delete this team member?"
                                    data-delete-item="{{ $emp->name }} ({{ $emp->role }})"
                                    class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-medium rounded-md bg-red-50 text-red-700 hover:bg-red-100 transition-colors">
                                    <svg class="w-3.5 h-3.5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                        <path fill-rule="evenodd" d="M7 2.75A1.75 1.75 0 0 0 5.25 4.5V5h-.75a.75.75 0 0 0 0 1.5h.41l.54 9.066A2.25 2.25 0 0 0 7.7 17.75h4.6a2.25 2.25 0 0 0 2.25-2.184L15.09 6.5h.41a.75.75 0 0 0 0-1.5h-.75v-.5A1.75 1.75 0 0 0 13 2.75H7Zm1.25 2V5h3.5v-.25a.25.25 0 0 0-.25-.25h-3a.25.25 0 0 0-.25.25Zm-.72 1.75.48 8h4.48l.48-8H7.53Z" clip-rule="evenodd" />
                                    </svg>
                                    Delete
                                </button>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full bg-white rounded-xl border border-gray-100 shadow-sm p-8 text-center text-gray-500">
                        No employees have been added yet.
                    </div>
                @endforelse
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
        <form method="POST" action="/owner/employees">
            @csrf
            <div class="p-5 space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Full Name</label>
                    <input name="name" type="text" placeholder="e.g., Team Member" class="w-full px-4 py-2.5 text-sm border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Email</label>
                    <input name="email" type="email" placeholder="saman@company.lk" class="w-full px-4 py-2.5 text-sm border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Login Password</label>
                    <input name="password" type="password" placeholder="Set employee login password" class="w-full px-4 py-2.5 text-sm border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Role</label>
                    <select name="role" class="w-full px-4 py-2.5 text-sm border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500">
                        <option>Cashier</option>
                        <option>Manager</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Status</label>
                    <select name="status" class="w-full px-4 py-2.5 text-sm border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500">
                        <option>Active</option>
                        <option>Inactive</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Joined At</label>
                    <input name="joined_at" type="date" class="w-full px-4 py-2.5 text-sm border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500">
                </div>
            </div>
            <div class="flex gap-3 p-5 border-t border-gray-100">
                <button type="button" data-modal-close="#add-employee-modal" class="flex-1 py-2.5 border border-gray-200 text-gray-700 font-medium rounded-lg hover:bg-gray-50 text-sm">Cancel</button>
                <button type="submit" class="flex-1 py-2.5 bg-blue-600 text-white font-semibold rounded-lg hover:bg-blue-700 text-sm">Add Employee</button>
            </div>
        </form>
    </div>
</div>

<div id="edit-employee-modal" data-modal class="hidden fixed inset-0 z-50">
    <div class="absolute inset-0 bg-black/50" data-modal-close="#edit-employee-modal"></div>
    <div class="fixed inset-x-4 top-[10%] sm:inset-auto sm:left-1/2 sm:top-1/2 sm:-translate-x-1/2 sm:-translate-y-1/2 sm:w-full sm:max-w-md bg-white rounded-2xl shadow-2xl z-50">
        <div class="flex items-center justify-between p-5 border-b border-gray-100">
            <h3 class="text-lg font-semibold text-gray-900">Edit Employee</h3>
            <button data-modal-close="#edit-employee-modal" class="p-1 rounded-md hover:bg-gray-100">X</button>
        </div>
        <form method="POST" id="edit-employee-form">
            @csrf
            @method('PUT')
            <div class="p-5 space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Full Name</label>
                    <input name="name" id="edit-employee-name" type="text" class="w-full px-4 py-2.5 text-sm border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Email</label>
                    <input name="email" id="edit-employee-email" type="email" class="w-full px-4 py-2.5 text-sm border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Login Password</label>
                    <input name="password" type="password" placeholder="Leave blank to keep current password" class="w-full px-4 py-2.5 text-sm border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Role</label>
                    <select name="role" id="edit-employee-role" class="w-full px-4 py-2.5 text-sm border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500">
                        <option>Cashier</option>
                        <option>Manager</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Status</label>
                    <select name="status" id="edit-employee-status" class="w-full px-4 py-2.5 text-sm border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500">
                        <option>Active</option>
                        <option>Inactive</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Joined At</label>
                    <input name="joined_at" id="edit-employee-joined-at" type="date" class="w-full px-4 py-2.5 text-sm border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500">
                </div>
            </div>
            <div class="flex gap-3 p-5 border-t border-gray-100">
                <button type="button" data-modal-close="#edit-employee-modal" class="flex-1 py-2.5 border border-gray-200 text-gray-700 font-medium rounded-lg hover:bg-gray-50 text-sm">Cancel</button>
                <button type="submit" class="flex-1 py-2.5 bg-blue-600 text-white font-semibold rounded-lg hover:bg-blue-700 text-sm">Save Changes</button>
            </div>
        </form>
    </div>
</div>

<div id="delete-confirm-modal" data-modal class="hidden fixed inset-0 z-50">
    <div class="absolute inset-0 bg-black/60 backdrop-blur-sm" data-modal-close="#delete-confirm-modal"></div>
    <div class="fixed inset-x-4 top-[20%] sm:inset-auto sm:left-1/2 sm:top-1/2 sm:-translate-x-1/2 sm:-translate-y-1/2 sm:w-full sm:max-w-md bg-white rounded-2xl shadow-2xl z-50 overflow-hidden border border-gray-100">
        <div class="p-6 text-center">
            <div class="w-14 h-14 bg-red-100 text-red-600 rounded-full flex items-center justify-center mx-auto mb-4 ring-8 ring-red-50">
                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                </svg>
            </div>
            <h3 class="text-xl font-bold text-gray-900 mb-1" id="delete-modal-title">Delete Employee</h3>
            <p class="text-sm text-gray-500 mb-3" id="delete-modal-subtitle">Are you sure you want to delete this team member?</p>
            <div class="bg-gray-50 py-2.5 px-4 rounded-xl border border-gray-100 mb-3">
                <p class="text-sm font-semibold text-gray-900" id="delete-modal-item-name"></p>
            </div>
            <p class="text-xs text-red-500 font-medium">This action cannot be undone.</p>
        </div>
        <div class="flex gap-3 p-4 bg-gray-50 border-t border-gray-100">
            <button type="button" data-modal-close="#delete-confirm-modal" style="background-color: #f3f4f6 !important; color: #1f2937 !important; border: 1px solid #e5e7eb !important;" class="btn-cancel-modal flex-1 py-2.5 px-4 bg-gray-100 hover:bg-gray-200 text-gray-800 font-semibold rounded-xl transition-all text-sm shadow-sm cursor-pointer">
                Cancel
            </button>
            <form id="delete-modal-form" method="POST" class="flex-1">
                @csrf
                @method('DELETE')
                <button type="submit" style="background-color: #dc2626 !important; color: #ffffff !important;" class="btn-danger-confirm w-full py-2.5 px-4 bg-red-600 hover:bg-red-700 text-white font-semibold rounded-xl transition-all text-sm shadow-md shadow-red-200 cursor-pointer flex items-center justify-center gap-1.5 border-0">
                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                    </svg>
                    <span style="color: #ffffff !important;" class="text-white font-semibold">Delete</span>
                </button>
            </form>
        </div>
    </div>
</div>

<script>
    (() => {
        const editButtons = document.querySelectorAll('[data-modal-open="#edit-employee-modal"]');
        const editForm = document.getElementById('edit-employee-form');
        const editName = document.getElementById('edit-employee-name');
        const editEmail = document.getElementById('edit-employee-email');
        const editRole = document.getElementById('edit-employee-role');
        const editStatus = document.getElementById('edit-employee-status');
        const editJoinedAt = document.getElementById('edit-employee-joined-at');

        const deleteTriggers = document.querySelectorAll('[data-delete-modal-open]');
        const deleteModal = document.getElementById('delete-confirm-modal');
        const deleteTitle = document.getElementById('delete-modal-title');
        const deleteSubtitle = document.getElementById('delete-modal-subtitle');
        const deleteItemName = document.getElementById('delete-modal-item-name');
        const deleteForm = document.getElementById('delete-modal-form');

        let currentEmployeeId = null;
        let currentEmployeeName = '';

        const openDeleteModal = (url, title, subtitle, itemName) => {
            if (!deleteModal || !deleteForm) return;
            deleteForm.action = url;
            if (deleteTitle) deleteTitle.textContent = title || 'Delete Employee';
            if (deleteSubtitle) deleteSubtitle.textContent = subtitle || 'Are you sure you want to delete this team member?';
            if (deleteItemName) deleteItemName.textContent = itemName || '';
            deleteModal.classList.remove('hidden');
        };

        editButtons.forEach((button) => {
            button.addEventListener('click', () => {
                currentEmployeeId = button.dataset.employeeId;
                currentEmployeeName = button.dataset.employeeName || 'this employee';
                editForm.action = `/owner/employees/${currentEmployeeId}`;
                editName.value = button.dataset.employeeName || '';
                editEmail.value = button.dataset.employeeEmail || '';
                editRole.value = button.dataset.employeeRole || 'Cashier';
                editStatus.value = button.dataset.employeeStatus || 'Active';
                editJoinedAt.value = button.dataset.employeeJoinedAt || '';
            });
        });

        deleteTriggers.forEach((btn) => {
            btn.addEventListener('click', () => {
                openDeleteModal(
                    btn.dataset.deleteUrl,
                    btn.dataset.deleteTitle,
                    btn.dataset.deleteSubtitle,
                    btn.dataset.deleteItem
                );
            });
        });
    })();
</script>
@endsection
