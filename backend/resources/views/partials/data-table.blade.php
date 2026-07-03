@props([
    'columns' => [],
    'data' => [],
    'searchPlaceholder' => 'Search...',
    'searchKey' => null,
    'pageSize' => 10,
    'emptyMessage' => 'No data found',
])

@php
    $search = request()->get('search', '');
    $page = request()->get('page', 0);
    $sortKey = request()->get('sort', null);
    $sortDir = request()->get('dir', 'asc');

    // Filter data
    $filtered = collect($data);
    if ($search && $searchKey) {
        $filtered = $filtered->filter(function($item) use ($search, $searchKey) {
            $value = is_array($item) ? ($item[$searchKey] ?? '') : '';
            return str_contains(strtolower($value), strtolower($search));
        });
    }

    // Sort data
    if ($sortKey) {
        $filtered = $filtered->sortBy(function($item) use ($sortKey, $sortDir) {
            $val = $item[$sortKey] ?? '';
            if (is_numeric($val)) {
                return $sortDir === 'asc' ? $val : -$val;
            }
            return $sortDir === 'asc' ? strtolower($val) : -strtolower($val);
        });
    }

    $totalPages = ceil($filtered->count() / $pageSize);
    $paged = $filtered->slice($page * $pageSize, $pageSize)->values();
@endphp

<div class="bg-white rounded-xl border border-gray-100 shadow-sm overflow-hidden">
    {{-- Search --}}
    @if($searchKey)
        <div class="p-4 border-b border-gray-100">
            <div class="relative max-w-sm">
                <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                </svg>
                <input
                    type="text"
                    name="search"
                    value="{{ $search }}"
                    placeholder="{{ $searchPlaceholder }}"
                    class="w-full pl-10 pr-4 py-2 text-sm border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all"
                >
            </div>
        </div>
    @endif

    {{-- Desktop Table --}}
    <div class="hidden md:block overflow-x-auto">
        <table class="w-full">
            <thead>
                <tr class="border-b border-gray-100">
                    @foreach($columns as $col)
                        <th class="text-left text-xs font-semibold text-gray-500 uppercase tracking-wider px-4 py-3 {{ $col['class'] ?? '' }}">
                            @if($col['sortable'] ?? false)
                                <a href="?sort={{ $col['key'] }}&dir={{ $sortKey === $col['key'] && $sortDir === 'asc' ? 'desc' : 'asc' }}&search={{ $search }}"
                                   class="flex items-center gap-1 hover:text-gray-700 transition-colors">
                                    {{ $col['label'] }}
                                    @if($sortKey === $col['key'])
                                        @if($sortDir === 'asc')
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"></path>
                                            </svg>
                                        @else
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                            </svg>
                                        @endif
                                    @else
                                        <svg class="w-3 h-3 opacity-40" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16V4m0 0L3 8m4-4l4 4m6 0v12m0 0l4-4m-4 4l-4-4"></path>
                                        </svg>
                                    @endif
                                </a>
                            @else
                                {{ $col['label'] }}
                            @endif
                        </th>
                    @endforeach
                    @if(isset($columns[0]['actions']))
                        <th class="text-right text-xs font-semibold text-gray-500 uppercase tracking-wider px-4 py-3">Actions</th>
                    @endif
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @if($paged->count() === 0)
                    <tr>
                        <td colspan="{{ count($columns) + (isset($columns[0]['actions']) ? 1 : 0) }}" class="text-center py-12 text-sm text-gray-400">
                            {{ $emptyMessage }}
                        </td>
                    </tr>
                @else
                    @foreach($paged as $item)
                        <tr class="hover:bg-gray-50/50 transition-colors">
                            @foreach($columns as $col)
                                <td class="px-4 py-3 text-sm text-gray-700 {{ $col['class'] ?? '' }}">
                                    {{ isset($col['render']) ? $col['render']($item) : ($item[$col['key']] ?? '') }}
                                </td>
                            @endforeach
                            @if(isset($columns[0]['actions']))
                                <td class="px-4 py-3 text-right">
                                    {{ $columns[0]['actions']($item) ?? '' }}
                                </td>
                            @endif
                        </tr>
                    @endforeach
                @endif
            </tbody>
        </table>
    </div>

    {{-- Mobile Card View --}}
    <div class="md:hidden divide-y divide-gray-100">
        @if($paged->count() === 0)
            <div class="text-center py-12 text-sm text-gray-400">
                {{ $emptyMessage }}
            </div>
        @else
            @foreach($paged as $item)
                <div class="p-4 space-y-2">
                    @foreach($columns as $col)
                        <div class="flex justify-between items-start">
                            <span class="text-xs font-medium text-gray-500 uppercase">
                                {{ $col['mobileLabel'] ?? $col['label'] }}
                            </span>
                            <span class="text-sm text-gray-900 text-right ml-4">
                                {{ isset($col['render']) ? $col['render']($item) : ($item[$col['key']] ?? '') }}
                            </span>
                        </div>
                    @endforeach
                    @if(isset($columns[0]['actions']))
                        <div class="flex justify-end pt-2 border-t border-gray-50">
                            {{ $columns[0]['actions']($item) ?? '' }}
                        </div>
                    @endif
                </div>
            @endforeach
        @endif
    </div>

    {{-- Pagination --}}
    @if($totalPages > 1)
        <div class="flex items-center justify-between px-4 py-3 border-t border-gray-100">
            <p class="text-xs text-gray-500">
                Showing {{ $page * $pageSize + 1 }}–{{ min(($page + 1) * $pageSize, $filtered->count()) }} of {{ $filtered->count() }}
            </p>
            <div class="flex items-center gap-1">
                <a href="?page={{ max(0, $page - 1) }}&sort={{ $sortKey }}&dir={{ $sortDir }}&search={{ $search }}"
                   class="p-1.5 rounded-md hover:bg-gray-100 disabled:opacity-30 disabled:cursor-not-allowed transition-colors {{ $page === 0 ? 'opacity-30 cursor-not-allowed' : '' }}">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                    </svg>
                </a>
                <span class="text-xs font-medium text-gray-600 px-2">{{ $page + 1 }} / {{ $totalPages }}</span>
                <a href="?page={{ min($totalPages - 1, $page + 1) }}&sort={{ $sortKey }}&dir={{ $sortDir }}&search={{ $search }}"
                   class="p-1.5 rounded-md hover:bg-gray-100 disabled:opacity-30 disabled:cursor-not-allowed transition-colors {{ $page >= $totalPages - 1 ? 'opacity-30 cursor-not-allowed' : '' }}">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </a>
            </div>
        </div>
    @endif
</div>
