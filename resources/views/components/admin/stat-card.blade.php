@props(['label', 'value', 'icon' => 'spark', 'trend' => null, 'caption' => null])

@php
    $trendVal = is_numeric($trend) ? (float) $trend : null;
    $up = $trendVal !== null && $trendVal >= 0;
@endphp

<div {{ $attributes->merge(['class' => 'group rounded-xl border border-line bg-card p-5 shadow-sm transition-shadow hover:shadow-md']) }}>
    <div class="flex items-center justify-between">
        <span class="text-[11px] font-semibold uppercase tracking-wider text-slate-500">{{ $label }}</span>
        <span class="grid h-8 w-8 place-items-center rounded-lg bg-paper2 text-slate-500 transition-colors group-hover:bg-brass-100 group-hover:text-brass-700">
            <x-admin.icon :name="$icon" class="h-4 w-4" />
        </span>
    </div>
    <div class="mt-3 flex items-end gap-2">
        <span class="tabular font-display text-3xl font-semibold leading-none tracking-tight text-navy-900">{{ $value }}</span>
        @if ($trendVal !== null)
            <span class="mb-0.5 inline-flex items-center gap-0.5 rounded-full px-1.5 py-0.5 text-[11px] font-semibold {{ $up ? 'bg-success/10 text-success' : 'bg-danger/10 text-danger' }}">
                <x-admin.icon :name="$up ? 'trend-up' : 'trend-down'" class="h-3 w-3" />{{ ($up ? '+' : '').$trendVal }}%
            </span>
        @endif
    </div>
    @if ($caption)<p class="mt-1.5 text-xs text-slate-500">{{ $caption }}</p>@endif
</div>
