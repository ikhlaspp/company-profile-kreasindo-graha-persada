@props([
    'as' => 'button',
    'variant' => 'accent',
    'size' => 'md',
    'href' => null,
])

@php
    $base = 'inline-flex items-center justify-center gap-2 font-sans font-semibold rounded-sm transition-colors focus:outline-none focus-visible:ring-2 focus-visible:ring-brass-500 focus-visible:ring-offset-2 focus-visible:ring-offset-transparent disabled:opacity-60 disabled:cursor-default cursor-pointer';

    $variants = [
        'accent'  => 'bg-brass-500 text-navy-900 hover:bg-brass-300',
        'primary' => 'bg-navy-800 text-white hover:bg-navy-700',
        'light'   => 'bg-white text-navy-900 border border-line hover:bg-paper2',
        'outline' => 'bg-transparent text-brass-300 border border-brass-500 hover:bg-brass-500 hover:text-navy-900',
        'ghost'   => 'bg-transparent text-navy-800 hover:bg-paper2',
        'danger'  => 'bg-danger text-white hover:opacity-90',
    ];

    $sizes = [
        'sm'   => 'text-xs px-3 py-1.5',
        'md'   => 'text-sm px-4 py-2.5',
        'lg'   => 'text-base px-6 py-3',
        'icon' => 'p-2',
    ];

    $classes = trim($base.' '.($variants[$variant] ?? $variants['accent']).' '.($sizes[$size] ?? $sizes['md']));
@endphp

@if ($as === 'a')
    <a href="{{ $href }}" {{ $attributes->merge(['class' => $classes]) }}>
        {{ $slot }}
    </a>
@else
    <button {{ $attributes->merge(['type' => 'button', 'class' => $classes]) }}>
        {{ $slot }}
    </button>
@endif
