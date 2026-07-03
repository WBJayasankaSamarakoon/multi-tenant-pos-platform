@extends('layouts.dashboard')

@section('content')
@php
    $cashierMenuItems = [
        [
            'path' => '/cashier/pos',
            'label' => 'POS',
            'icon' => '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>'
        ],
        [
            'path' => '/cashier/sales-history',
            'label' => 'Sales History',
            'icon' => '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>'
        ],
    ];
@endphp
@include('partials.sidebar', [
    'menuItems' => $cashierMenuItems,
    'userName' => 'Kamala Dissanayake',
    'userRole' => 'Cashier',
    'companyName' => 'Perera Grocery'
])

<div class="flex-1 min-h-screen">
    <main class="p-4 lg:p-6">
        @yield('content')
    </main>
</div>
@endsection
