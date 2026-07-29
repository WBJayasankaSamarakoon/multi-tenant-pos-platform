@php
    $menuItems = $menuItems ?? [];
    $userName = $userName ?? 'User';
    $userRole = $userRole ?? 'User';
    $companyName = $companyName ?? null;
@endphp

<div class="lg:hidden fixed top-0 left-0 right-0 z-40 bg-navy h-14 flex items-center justify-between px-4 shadow-lg">
    <a href="/" class="flex items-center gap-2">
        <div class="w-7 h-7 bg-blue-600 rounded-lg flex items-center justify-center">
            <svg class="w-3.5 h-3.5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
            </svg>
        </div>
        <span class="text-sm font-bold text-white">
            MultiBiz<span class="text-blue-400">POS</span>
        </span>
    </a>
    <button
        data-toggle-target="#sidebar-overlay,#sidebar-mobile"
        class="p-2 rounded-lg hover:bg-slate-700/50 text-white"
        aria-label="Open menu">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
        </svg>
    </button>
</div>

<aside
    id="sidebar"
    data-collapsed="false"
    class="hidden lg:flex flex-col fixed top-0 left-0 h-full bg-navy z-30 transition-all duration-300 w-64">
    <div class="flex items-center justify-between px-4 h-16 border-b border-slate-700/50">
        <a href="/" class="flex items-center gap-2.5">
            <div class="w-8 h-8 bg-blue-600 rounded-lg flex items-center justify-center flex-shrink-0">
                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                </svg>
            </div>
            <span data-sidebar-label class="text-sm font-bold text-white whitespace-nowrap">
                MultiBiz<span class="text-blue-400">POS</span>
            </span>
        </a>
        <button
            data-sidebar-toggle="#sidebar"
            class="hidden lg:flex p-1.5 rounded-md hover:bg-slate-700/50 text-slate-400 hover:text-white transition-colors"
            aria-label="Toggle sidebar">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
            </svg>
        </button>
    </div>

    @if ($companyName)
        <div data-sidebar-company class="px-4 py-3 border-b border-slate-700/50">
            <p class="text-xs text-slate-400 uppercase tracking-wider">Company</p>
            <p class="text-sm font-medium text-slate-200 truncate mt-0.5">{{ $companyName }}</p>
        </div>
    @endif

    <nav class="flex-1 px-3 py-4 space-y-1 overflow-y-auto">
        @foreach ($menuItems as $item)
            @php
                $path = ltrim($item['path'], '/');
                $match = $item['match'] ?? ($path === '' ? '/' : $path . '*');
                $isActive = request()->is($match) || request()->path() === trim($path, '/');
            @endphp
            <a
                href="{{ $item['path'] }}"
                class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-all {{ $isActive ? 'bg-blue-600 text-white shadow-lg shadow-blue-600/25' : 'text-slate-300 hover:bg-slate-700/50 hover:text-white' }}">
                <span class="flex-shrink-0">{!! $item['icon'] ?? '' !!}</span>
                <span data-sidebar-label>{{ $item['label'] }}</span>
            </a>
        @endforeach
    </nav>

    <div class="px-3 py-4 border-t border-slate-700/50">
        <div class="flex items-center gap-3 px-3 py-2">
            <div class="w-8 h-8 rounded-full bg-blue-600/20 flex items-center justify-center flex-shrink-0">
                <span class="text-xs font-semibold text-blue-400">
                    {{ collect(explode(' ', $userName))->map(fn ($n) => substr($n, 0, 1))->implode('') }}
                </span>
            </div>
            <div data-sidebar-label class="flex-1 min-w-0">
                <p class="text-sm font-medium text-white truncate">{{ $userName }}</p>
                <p class="text-xs text-slate-400 capitalize">{{ $userRole }}</p>
            </div>
        </div>
        <a
            href="/login"
            class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium text-slate-400 hover:bg-red-500/10 hover:text-red-400 transition-all mt-1">
            <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
            </svg>
            <span data-sidebar-label>Logout</span>
        </a>
    </div>
</aside>

<div data-sidebar-spacer class="hidden lg:block flex-shrink-0 w-64"></div>
<div class="lg:hidden h-14"></div>

<div id="sidebar-overlay" class="hidden lg:hidden fixed inset-0 bg-black/60 z-40" data-modal data-modal-close="#sidebar-overlay,#sidebar-mobile"></div>

<aside id="sidebar-mobile" class="hidden lg:hidden fixed top-0 left-0 h-full w-[280px] bg-navy z-50" data-modal>
    <div class="flex items-center justify-between px-4 h-16 border-b border-slate-700/50">
        <a href="/" class="flex items-center gap-2.5">
            <div class="w-8 h-8 bg-blue-600 rounded-lg flex items-center justify-center flex-shrink-0">
                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                </svg>
            </div>
            <span class="text-sm font-bold text-white whitespace-nowrap">
                MultiBiz<span class="text-blue-400">POS</span>
            </span>
        </a>
        <button
            data-modal-close="#sidebar-overlay,#sidebar-mobile"
            class="p-1.5 rounded-md hover:bg-slate-700/50 text-slate-400"
            aria-label="Close menu">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
            </svg>
        </button>
    </div>

    @if ($companyName)
        <div class="px-4 py-3 border-b border-slate-700/50">
            <p class="text-xs text-slate-400 uppercase tracking-wider">Company</p>
            <p class="text-sm font-medium text-slate-200 truncate mt-0.5">{{ $companyName }}</p>
        </div>
    @endif

    <nav class="flex-1 px-3 py-4 space-y-1 overflow-y-auto">
        @foreach ($menuItems as $item)
            @php
                $path = ltrim($item['path'], '/');
                $match = $item['match'] ?? ($path === '' ? '/' : $path . '*');
                $isActive = request()->is($match) || request()->path() === trim($path, '/');
            @endphp
            <a
                href="{{ $item['path'] }}"
                class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-all {{ $isActive ? 'bg-blue-600 text-white shadow-lg shadow-blue-600/25' : 'text-slate-300 hover:bg-slate-700/50 hover:text-white' }}">
                <span class="flex-shrink-0">{!! $item['icon'] ?? '' !!}</span>
                <span>{{ $item['label'] }}</span>
            </a>
        @endforeach
    </nav>

    <div class="px-3 py-4 border-t border-slate-700/50">
        <div class="flex items-center gap-3 px-3 py-2">
            <div class="w-8 h-8 rounded-full bg-blue-600/20 flex items-center justify-center flex-shrink-0">
                <span class="text-xs font-semibold text-blue-400">
                    {{ collect(explode(' ', $userName))->map(fn ($n) => substr($n, 0, 1))->implode('') }}
                </span>
            </div>
            <div class="flex-1 min-w-0">
                <p class="text-sm font-medium text-white truncate">{{ $userName }}</p>
                <p class="text-xs text-slate-400 capitalize">{{ $userRole }}</p>
            </div>
        </div>
        <a
            href="/login"
            class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium text-slate-400 hover:bg-red-500/10 hover:text-red-400 transition-all mt-1">
            <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
            </svg>
            <span>Logout</span>
        </a>
    </div>
</aside>
