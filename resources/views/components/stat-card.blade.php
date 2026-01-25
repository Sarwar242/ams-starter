@props([
    'title' => '',
    'value' => '',
    'trend' => null,
    'color' => 'indigo'
])

@php
    $colorClasses = [
        'indigo' => 'bg-indigo-100 text-indigo-600',
        'blue' => 'bg-blue-100 text-blue-600',
        'green' => 'bg-green-100 text-green-600',
        'yellow' => 'bg-yellow-100 text-yellow-600',
        'purple' => 'bg-purple-100 text-purple-600',
        'red' => 'bg-red-100 text-red-600',
    ];
@endphp

<div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 hover:shadow-md transition-shadow duration-200">
    <div class="flex items-center justify-between">
        <div class="flex-1">
            <p class="text-sm font-medium text-gray-600 mb-1">{{ $title }}</p>
            <p class="text-2xl font-bold text-gray-900">{{ $value }}</p>
            @if($trend)
                <p class="text-xs text-gray-500 mt-1">{{ $trend }}</p>
            @endif
        </div>
        @if(isset($icon))
            <div class="flex items-center justify-center w-12 h-12 rounded-lg {{ $colorClasses[$color] ?? $colorClasses['indigo'] }}">
                {{ $icon }}
            </div>
        @endif
    </div>
</div>

