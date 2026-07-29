@extends('layouts.dashboard')

@section('title', 'Settings - MultiBizPOS')

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
            <form method="POST" action="/owner/settings" class="space-y-6">
                @csrf
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-6 gap-4">
                    <div>
                        <h1 class="text-2xl font-bold text-gray-900">Settings</h1>
                        <p class="text-sm text-gray-500 mt-1">Configure your business preferences</p>
                    </div>
                    <button type="submit" class="flex items-center gap-2 px-5 py-2.5 text-sm font-semibold rounded-lg transition-all bg-blue-600 text-white hover:bg-blue-700">
                        Save Changes
                    </button>
                </div>

                <div class="space-y-6">
                <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-6">
                    <div class="flex items-center gap-3 mb-5">
                        <div class="w-10 h-10 rounded-lg bg-blue-50 flex items-center justify-center">
                            <span class="text-blue-600 text-xs font-bold">CO</span>
                        </div>
                        <div>
                            <h3 class="font-semibold text-gray-900">Company Profile</h3>
                            <p class="text-xs text-gray-500">Basic business information</p>
                        </div>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1.5">Company Name</label>
                            <input name="name" type="text" value="{{ $company->name }}" class="w-full px-4 py-2.5 text-sm border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1.5">Business Email</label>
                            <input name="email" type="email" value="{{ $company->email }}" class="w-full px-4 py-2.5 text-sm border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1.5">Phone</label>
                            <input name="phone" type="tel" value="{{ $company->phone }}" class="w-full px-4 py-2.5 text-sm border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1.5">Address</label>
                            <input name="address" type="text" value="{{ $company->address }}" class="w-full px-4 py-2.5 text-sm border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500">
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-6">
                    <div class="flex items-center gap-3 mb-5">
                        <div class="w-10 h-10 rounded-lg bg-emerald-50 flex items-center justify-center">
                            <span class="text-emerald-600 text-xs font-bold">TX</span>
                        </div>
                        <div>
                            <h3 class="font-semibold text-gray-900">Tax & Currency</h3>
                            <p class="text-xs text-gray-500">Configure financial settings</p>
                        </div>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1.5">Currency</label>
                            <select name="currency" class="w-full px-4 py-2.5 text-sm border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500">
                                <option value="LKR" @selected(($company->currency ?? 'LKR') === 'LKR')>LKR - Sri Lankan Rupee</option>
                                <option value="USD" @selected(($company->currency ?? 'LKR') === 'USD')>USD - US Dollar</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1.5">Tax Rate (%)</label>
                            <input name="tax_rate" type="number" value="{{ $company->tax_rate }}" class="w-full px-4 py-2.5 text-sm border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500">
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-6">
                    <div class="flex items-center gap-3 mb-5">
                        <div class="w-10 h-10 rounded-lg bg-purple-50 flex items-center justify-center">
                            <span class="text-purple-600 text-xs font-bold">IV</span>
                        </div>
                        <div>
                            <h3 class="font-semibold text-gray-900">Invoice Template</h3>
                            <p class="text-xs text-gray-500">Choose your invoice layout</p>
                        </div>
                    </div>
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                        <label class="p-4 rounded-xl border-2 cursor-pointer transition-all {{ ($company->invoice_template ?? 'standard') === 'standard' ? 'border-blue-600 bg-blue-50/50' : 'border-gray-200 hover:border-gray-300' }}">
                            <input type="radio" name="invoice_template" value="standard" class="sr-only" @checked(($company->invoice_template ?? 'standard') === 'standard')>
                            <div class="h-20 bg-gray-100 rounded-lg mb-3 flex flex-col items-center justify-center gap-1">
                                <div class="w-12 h-1.5 bg-gray-300 rounded"></div>
                                <div class="w-16 h-1 bg-gray-200 rounded"></div>
                                <div class="w-10 h-1 bg-gray-200 rounded"></div>
                            </div>
                            <p class="text-sm font-medium text-gray-900">Standard</p>
                            <p class="text-xs text-gray-500">Clean, professional layout</p>
                        </label>
                        <label class="p-4 rounded-xl border-2 cursor-pointer transition-all {{ ($company->invoice_template ?? 'standard') === 'compact' ? 'border-blue-600 bg-blue-50/50' : 'border-gray-200 hover:border-gray-300' }}">
                            <input type="radio" name="invoice_template" value="compact" class="sr-only" @checked(($company->invoice_template ?? 'standard') === 'compact')>
                            <div class="h-20 bg-gray-100 rounded-lg mb-3 flex flex-col items-center justify-center gap-0.5">
                                <div class="w-14 h-1 bg-gray-300 rounded"></div>
                                <div class="w-16 h-1 bg-gray-200 rounded"></div>
                                <div class="w-12 h-1 bg-gray-200 rounded"></div>
                                <div class="w-10 h-1 bg-gray-200 rounded"></div>
                            </div>
                            <p class="text-sm font-medium text-gray-900">Compact</p>
                            <p class="text-xs text-gray-500">Space-efficient design</p>
                        </label>
                        <label class="p-4 rounded-xl border-2 cursor-pointer transition-all {{ ($company->invoice_template ?? 'standard') === 'detailed' ? 'border-blue-600 bg-blue-50/50' : 'border-gray-200 hover:border-gray-300' }}">
                            <input type="radio" name="invoice_template" value="detailed" class="sr-only" @checked(($company->invoice_template ?? 'standard') === 'detailed')>
                            <div class="h-20 bg-gray-100 rounded-lg mb-3 flex flex-col items-center justify-center gap-1">
                                <div class="w-8 h-4 bg-gray-300 rounded"></div>
                                <div class="w-16 h-1 bg-gray-200 rounded"></div>
                                <div class="w-14 h-1 bg-gray-200 rounded"></div>
                            </div>
                            <p class="text-sm font-medium text-gray-900">Detailed</p>
                            <p class="text-xs text-gray-500">With logo and branding</p>
                        </label>
                    </div>
                </div>
                </div>
            </form>
        </div>
    </main>
</div>
@endsection
