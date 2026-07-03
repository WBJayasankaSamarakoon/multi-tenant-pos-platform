@extends('layouts.public')

@section('title', 'Pricing - MultiBizPOS')

@section('content')
<div class="w-full min-h-screen bg-white">
    @include('partials.public-navbar')

    <section class="pt-28 pb-20 bg-gradient-to-b from-gray-50 to-white" data-billing="monthly">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h1 class="text-4xl lg:text-5xl font-bold text-gray-900">Pricing Plans</h1>
                <p class="mt-4 text-lg text-gray-500 max-w-2xl mx-auto">Choose the plan that fits your business. All plans include a 14-day free trial.</p>

                <div class="mt-8 inline-flex items-center gap-3 bg-gray-100 rounded-full p-1">
                    <button type="button" data-billing-toggle="monthly" data-billing-button class="px-5 py-2 rounded-full text-sm font-medium transition-all bg-white shadow-sm text-gray-900">Monthly</button>
                    <button type="button" data-billing-toggle="annual" data-billing-button class="px-5 py-2 rounded-full text-sm font-medium transition-all text-gray-500">Annual <span class="text-emerald-600 text-xs font-semibold">Save 20%</span></button>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 max-w-5xl mx-auto">
                <div class="plan-fade-up rounded-2xl border border-gray-200 bg-white p-8">
                    <div class="mb-6">
                        <p class="text-sm font-semibold text-gray-500 uppercase tracking-wider">Basic</p>
                        <div class="mt-4 flex items-baseline">
                            <span class="text-4xl font-bold text-gray-900"><span data-billing-monthly>LKR 2,500</span><span data-billing-annual class="hidden">LKR 2,000</span></span>
                            <span class="text-gray-400 ml-1">/mo</span>
                        </div>
                        <p data-billing-annual class="text-xs text-emerald-600 mt-1 hidden">LKR 24,000 billed annually</p>
                        <p class="mt-3 text-sm text-gray-500">Perfect for small shops just getting started with digital POS.</p>
                    </div>
                    <a href="/register" class="block w-full text-center py-3 rounded-xl border border-gray-200 text-sm font-semibold text-gray-700 hover:bg-gray-50 transition-colors">Start Free Trial</a>
                    <div class="mt-8">
                        <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-4">What's included</p>
                        <ul class="space-y-3">
                            @foreach (['1 user account', 'Basic POS billing', 'Up to 100 products', 'Invoice generation', 'Basic sales reports', 'Email support'] as $item)
                                <li class="flex items-start gap-2.5 text-sm text-gray-600"><svg class="w-4 h-4 text-emerald-500 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>{{ $item }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>

                <div class="plan-fade-up plan-delay-1 rounded-2xl border-2 border-blue-600 bg-white p-8 relative shadow-xl">
                    <span class="absolute -top-3.5 left-1/2 -translate-x-1/2 px-4 py-1 bg-blue-600 text-white text-xs font-bold rounded-full">Most Popular</span>
                    <div class="mb-6">
                        <p class="text-sm font-semibold text-blue-600 uppercase tracking-wider">Pro</p>
                        <div class="mt-4 flex items-baseline">
                            <span class="text-4xl font-bold text-gray-900"><span data-billing-monthly>LKR 5,000</span><span data-billing-annual class="hidden">LKR 4,000</span></span>
                            <span class="text-gray-400 ml-1">/mo</span>
                        </div>
                        <p data-billing-annual class="text-xs text-emerald-600 mt-1 hidden">LKR 48,000 billed annually</p>
                        <p class="mt-3 text-sm text-gray-500">For growing businesses that need full POS and inventory management.</p>
                    </div>
                    <a href="/register" class="block w-full text-center py-3 rounded-xl bg-blue-600 text-white text-sm font-semibold hover:bg-blue-700 transition-colors shadow-lg shadow-blue-600/25">Start Free Trial</a>
                    <div class="mt-8">
                        <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-4">Everything in Basic, plus</p>
                        <ul class="space-y-3">
                            @foreach (['Up to 5 users', 'Full POS with discounts', 'Up to 1,000 products', 'Inventory management', 'Advanced reports & analytics', 'Customer management', 'Custom tax & currency', 'Priority email support'] as $item)
                                <li class="flex items-start gap-2.5 text-sm text-gray-600"><svg class="w-4 h-4 text-emerald-500 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>{{ $item }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>

                <div class="plan-fade-up plan-delay-2 rounded-2xl border border-gray-200 bg-white p-8">
                    <div class="mb-6">
                        <p class="text-sm font-semibold text-gray-500 uppercase tracking-wider">Enterprise</p>
                        <div class="mt-4 flex items-baseline">
                            <span class="text-4xl font-bold text-gray-900"><span data-billing-monthly>LKR 10,000</span><span data-billing-annual class="hidden">LKR 8,000</span></span>
                            <span class="text-gray-400 ml-1">/mo</span>
                        </div>
                        <p data-billing-annual class="text-xs text-emerald-600 mt-1 hidden">LKR 96,000 billed annually</p>
                        <p class="mt-3 text-sm text-gray-500">For larger businesses needing unlimited access and priority support.</p>
                    </div>
                    <a href="/register" class="block w-full text-center py-3 rounded-xl border border-gray-200 text-sm font-semibold text-gray-700 hover:bg-gray-50 transition-colors">Contact Sales</a>
                    <div class="mt-8">
                        <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-4">Everything in Pro, plus</p>
                        <ul class="space-y-3">
                            @foreach (['Unlimited users', 'Unlimited products', 'All features unlocked', 'Custom invoice templates', 'Supplier management', 'Priority phone support', 'Dedicated account manager'] as $item)
                                <li class="flex items-start gap-2.5 text-sm text-gray-600"><svg class="w-4 h-4 text-emerald-500 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>{{ $item }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>

            <div class="mt-20 max-w-5xl mx-auto">
                <h3 class="text-2xl font-bold text-gray-900 text-center mb-8">Feature Comparison</h3>
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead>
                            <tr class="border-b border-gray-200">
                                <th class="text-left py-4 px-4 text-sm font-semibold text-gray-900">Feature</th>
                                <th class="text-center py-4 px-4 text-sm font-semibold text-gray-500">Basic</th>
                                <th class="text-center py-4 px-4 text-sm font-semibold text-blue-600">Pro</th>
                                <th class="text-center py-4 px-4 text-sm font-semibold text-gray-500">Enterprise</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            <tr><td class="py-3 px-4 text-sm text-gray-600">Users</td><td class="py-3 px-4 text-sm text-gray-900 text-center">1</td><td class="py-3 px-4 text-sm text-gray-900 text-center font-medium">5</td><td class="py-3 px-4 text-sm text-gray-900 text-center">Unlimited</td></tr>
                            <tr><td class="py-3 px-4 text-sm text-gray-600">Products</td><td class="py-3 px-4 text-sm text-gray-900 text-center">100</td><td class="py-3 px-4 text-sm text-gray-900 text-center font-medium">1,000</td><td class="py-3 px-4 text-sm text-gray-900 text-center">Unlimited</td></tr>
                            @foreach ([['POS Billing', [true, true, true]], ['Invoice Generation', [true, true, true]], ['Inventory Management', [false, true, true]], ['Advanced Reports', [false, true, true]], ['Customer Management', [false, true, true]], ['Custom Tax & Currency', [false, true, true]], ['Supplier Management', [false, false, true]], ['Custom Invoice Templates', [false, false, true]], ['Priority Support', [false, false, true]]] as $row)
                                <tr>
                                    <td class="py-3 px-4 text-sm text-gray-600">{{ $row[0] }}</td>
                                    @foreach ($row[1] as $value)
                                        <td class="py-3 px-4 text-center">
                                            @if ($value)
                                                <svg class="w-4 h-4 text-emerald-500 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                            @else
                                                <svg class="w-4 h-4 text-gray-300 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                            @endif
                                        </td>
                                    @endforeach
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="mt-20 max-w-3xl mx-auto text-center">
                <p class="text-sm text-gray-500">All plans include a 14-day free trial. No credit card required. Cancel anytime.</p>
                <p class="mt-2 text-sm text-gray-500">Need a custom plan? <a href="#" class="text-blue-600 font-medium hover:underline">Contact our sales team</a></p>
            </div>
        </div>
    </section>
</div>
@endsection
