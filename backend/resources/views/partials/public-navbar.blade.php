@php
    $isPricing = request()->is('pricing');
@endphp
<nav
    data-scroll-nav
    class="fixed top-0 left-0 right-0 z-50 transition-all duration-300 bg-transparent">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-16 lg:h-[72px]">
            <a href="/" class="flex items-center gap-2 group">
                <div class="w-9 h-9 bg-blue-600 rounded-lg flex items-center justify-center group-hover:bg-blue-700 transition-colors">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                    </svg>
                </div>
                <span class="text-lg font-bold text-gray-900 transition-colors">
                    MultiBiz<span class="text-blue-600">POS</span>
                </span>
            </a>

            <div class="hidden md:flex items-center gap-8">
                <a href="/#features" data-scroll-link class="text-sm font-medium transition-colors hover:text-blue-600 text-gray-700">
                    Features
                </a>
                <a href="/pricing" @unless($isPricing) data-scroll-link @endunless class="text-sm font-medium transition-colors hover:text-blue-600 {{ $isPricing ? 'text-blue-600' : 'text-gray-700' }}">
                    Pricing
                </a>
                <a href="/#about" data-scroll-link class="text-sm font-medium transition-colors hover:text-blue-600 text-gray-700">
                    About
                </a>
            </div>

            <div class="hidden md:flex items-center gap-3">
                <a href="/login" class="text-sm font-medium text-gray-700 hover:text-blue-600 transition-colors px-4 py-2">
                    Sign In
                </a>
                <a href="/register" class="text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 transition-colors px-5 py-2.5 rounded-lg shadow-sm">
                    Get Started Free
                </a>
            </div>

            <button
                type="button"
                data-mobile-menu-button
                data-mobile-menu-target="#public-mobile-menu"
                class="md:hidden p-2 rounded-lg hover:bg-gray-100 transition-colors"
                aria-expanded="false"
                aria-label="Toggle menu">
                <svg data-menu-icon class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                </svg>
                <svg data-close-icon class="w-5 h-5 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>
    </div>

    <div
        id="public-mobile-menu"
        data-mobile-menu
        class="md:hidden bg-white overflow-hidden transition-all duration-300 max-h-0 opacity-0 pointer-events-none">
        <div class="px-4 py-4 space-y-1">
            <a href="/#features" data-mobile-close class="block px-4 py-3 text-sm font-medium text-gray-700 hover:bg-gray-50 rounded-lg">
                Features
            </a>
            <a href="/pricing" data-mobile-close class="block px-4 py-3 text-sm font-medium text-gray-700 hover:bg-gray-50 rounded-lg">
                Pricing
            </a>
            <a href="/#about" data-mobile-close class="block px-4 py-3 text-sm font-medium text-gray-700 hover:bg-gray-50 rounded-lg">
                About
            </a>
            <div class="pt-3 border-t border-gray-100 space-y-2">
                <a href="/login" data-mobile-close class="block px-4 py-3 text-sm font-medium text-gray-700 hover:bg-gray-50 rounded-lg text-center">
                    Sign In
                </a>
                <a href="/register" data-mobile-close class="block px-4 py-3 text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 rounded-lg text-center">
                    Get Started Free
                </a>
            </div>
        </div>
    </div>
</nav>



