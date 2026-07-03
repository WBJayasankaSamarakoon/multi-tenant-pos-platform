@extends('layouts.dashboard')

@section('content')
<div>
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-6 gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Settings</h1>
            <p class="text-sm text-gray-500 mt-1">
                Configure your business preferences
            </p>
        </div>
        <button class="flex items-center gap-2 px-5 py-2.5 bg-blue-600 text-white text-sm font-semibold rounded-lg hover:bg-blue-700 transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"></path>
            </svg>
            Save Changes
        </button>
    </div>

    <div class="space-y-6">
        {{-- Company Profile --}}
        <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-6">
            <div class="flex items-center gap-3 mb-5">
                <div class="w-10 h-10 rounded-lg bg-blue-50 flex items-center justify-center">
                    <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                    </svg>
                </div>
                <div>
                    <h3 class="font-semibold text-gray-900">Company Profile</h3>
                    <p class="text-xs text-gray-500">Basic business information</p>
                </div>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Company Name</label>
                    <input type="text" value="Perera Grocery" class="w-full px-4 py-2.5 text-sm border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Business Email</label>
                    <input type="email" value="info@pereragrocery.lk" class="w-full px-4 py-2.5 text-sm border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Phone</label>
                    <input type="tel" value="+94 77 123 4567" class="w-full px-4 py-2.5 text-sm border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Address</label>
                    <input type="text" value="No. 42, Galle Road, Colombo 03" class="w-full px-4 py-2.5 text-sm border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500">
                </div>
            </div>
        </div>

        {{-- Tax & Currency --}}
        <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-6">
            <div class="flex items-center gap-3 mb-5">
                <div class="w-10 h-10 rounded-lg bg-emerald-50 flex items-center justify-center">
                    <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                    </svg>
                </div>
                <div>
                    <h3 class="font-semibold text-gray-900">Tax & Currency</h3>
                    <p class="text-xs text-gray-500">Configure financial settings</p>
                </div>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Currency</label>
                    <select class="w-full px-4 py-2.5 text-sm border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500">
                        <option value="LKR" selected>LKR - Sri Lankan Rupee</option>
                        <option value="USD">USD - US Dollar</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Tax Rate (%)</label>
                    <input type="number" value="15" class="w-full px-4 py-2.5 text-sm border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500">
                </div>
            </div>
        </div>

        {{-- Invoice Template --}}
        <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-6">
            <div class="flex items-center gap-3 mb-5">
                <div class="w-10 h-10 rounded-lg bg-purple-50 flex items-center justify-center">
                    <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                </div>
                <div>
                    <h3 class="font-semibold text-gray-900">Invoice Template</h3>
                    <p class="text-xs text-gray-500">Choose your invoice layout</p>
                </div>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                <label class="p-4 rounded-xl border-2 cursor-pointer transition-all border-blue-600 bg-blue-50/50">
                    <input type="radio" name="template" value="standard" checked class="sr-only">
                    <div class="h-20 bg-gray-100 rounded-lg mb-3 flex flex-col items-center justify-center gap-1">
                        <div class="w-12 h-1.5 bg-gray-300 rounded"></div>
                        <div class="w-16 h-1 bg-gray-200 rounded"></div>
                        <div class="w-10 h-1 bg-gray-200 rounded"></div>
                    </div>
                    <p class="text-sm font-medium text-gray-900">Standard</p>
                    <p class="text-xs text-gray-500">Clean, professional layout</p>
                </label>
                <label class="p-4 rounded-xl border-2 cursor-pointer transition-all border-gray-200 hover:border-gray-300">
                    <input type="radio" name="template" value="compact" class="sr-only">
                    <div class="h-20 bg-gray-100 rounded-lg mb-3 flex flex-col items-center justify-center gap-0.5">
                        <div class="w-14 h-1 bg-gray-300 rounded"></div>
                        <div class="w-16 h-1 bg-gray-200 rounded"></div>
                        <div class="w-12 h-1 bg-gray-200 rounded"></div>
                        <div class="w-10 h-1 bg-gray-200 rounded"></div>
                    </div>
                    <p class="text-sm font-medium text-gray-900">Compact</p>
                    <p class="text-xs text-gray-500">Space-efficient design</p>
                </label>
                <label class="p-4 rounded-xl border-2 cursor-pointer transition-all border-gray-200 hover:border-gray-300">
                    <input type="radio" name="template" value="detailed" class="sr-only">
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
</div>
@endsection
