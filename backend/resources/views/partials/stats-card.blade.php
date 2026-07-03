@props([
    'label' => '',
    'value' => '',
    'icon' => '',
    'trend' => null,
    'color' => 'blue'
])

@php
    $colorMap = [
        'blue' => ['bg' => 'bg-blue-50', 'icon' => 'bg-blue-100 text-blue-600', 'trend' => 'text-blue-600'],
        'emerald' => ['bg' => 'bg-emerald-50', 'icon' => 'bg-emerald-100 text-emerald-600', 'trend' => 'text-emerald-600'],
        'amber' => ['bg' => 'bg-amber-50', 'icon' => 'bg-amber-100 text-amber-600', 'trend' => 'text-amber-600'],
        'red' => ['bg' => 'bg-red-50', 'icon' => 'bg-red-100 text-red-600', 'trend' => 'text-red-600'],
        'purple' => ['bg' => 'bg-purple-50', 'icon' => 'bg-purple-100 text-purple-600', 'trend' => 'text-purple-600'],
    ];
    $safeColor = is_string($color) ? $color : 'blue';
    $colors = $colorMap[$safeColor] ?? $colorMap['blue'];
@endphp

<div class="{{ $colors['bg'] }} rounded-xl border border-gray-100 p-5 shadow-sm">
    <div class="flex items-start justify-between">
        <div class="flex-1">
            <p class="text-sm font-medium text-gray-500">{{ $label }}</p>
            <p class="text-2xl font-bold text-gray-900 mt-1">{{ $value }}</p>
            @if($trend)
                <div class="flex items-center gap-1 mt-2">
                    @if($trend['isPositive'])
                        <svg class="w-3.5 h-3.5 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                        </svg>
                    @else
                        <svg class="w-3.5 h-3.5 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 17h8m0 0V9m0 8l-8-8-4 4-6-6"></path>
                        </svg>
                    @endif
                    <span class="text-xs font-medium {{ $trend['isPositive'] ? 'text-emerald-600' : 'text-red-600' }}">
                        {{ $trend['isPositive'] ? '+' : '' }}{{ $trend['value'] }}%
                    </span>
                    <span class="text-xs text-gray-400">vs last month</span>
                </div>
            @endif
        </div>
        <div class="w-10 h-10 rounded-lg flex items-center justify-center {{ $colors['icon'] }}">
            {!! $icon !!}
        </div>
    </div>
</div>
