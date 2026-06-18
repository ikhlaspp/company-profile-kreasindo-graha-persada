@props(['variant' => 'primary', 'href' => null, 'type' => 'button', 'size' => 'md'])

@php
    $base = 'inline-flex items-center justify-center gap-2 rounded-lg font-semibold whitespace-nowrap transition-all focus:outline-none focus-visible:ring-2 focus-visible:ring-brass-500/40 disabled:opacity-50';
    $sizes = [
        'sm' => 'px-2.5 py-1.5 text-xs',
        'md' => 'px-3.5 py-2 text-[13px]',
        'lg' => 'px-5 py-2.5 text-sm',
        'icon' => 'p-2',
    ];
    $variants = [
        'primary' => 'bg-navy-800 text-white shadow-sm hover:bg-navy-700',
        'accent'  => 'bg-brass-500 text-navy-900 shadow-sm hover:bg-brass-700 hover:text-white',
        'ghost'   => 'text-slate-600 hover:bg-paper2 hover:text-navy-900',
        'outline' => 'border border-line bg-card text-navy-800 hover:border-slate-300 hover:bg-paper2',
        'danger'  => 'bg-danger text-white shadow-sm hover:bg-danger/90',
    ];
    $classes = $base.' '.($sizes[$size] ?? $sizes['md']).' '.($variants[$variant] ?? $variants['primary']);
@endphp

@if ($href)
    <a href="{{ $href }}" {{ $attributes->merge(['class' => $classes]) }}>{{ $slot }}</a>
@else
    <button type="{{ $type }}" {{ $attributes->merge(['class' => $classes]) }}>{{ $slot }}</button>
@endif
