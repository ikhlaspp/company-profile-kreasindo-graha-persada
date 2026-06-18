@props(['title', 'subtitle' => null, 'breadcrumb' => [], 'eyebrow' => null])

<div class="mb-6 flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
    <div class="min-w-0">
        @if ($eyebrow)
            <p class="mb-1 flex items-center gap-2 text-[11px] font-bold uppercase tracking-[0.2em] text-brass-700">
                <span class="h-3 w-[3px] rounded-full bg-brass-500"></span>{{ $eyebrow }}
            </p>
        @endif
        @if (! empty($breadcrumb))
            <nav class="mb-1.5 flex items-center gap-1.5 text-xs text-slate-500">
                @foreach ($breadcrumb as $label => $url)
                    @if (! $loop->first)<span class="text-slate-300">/</span>@endif
                    @if ($url && ! $loop->last)
                        <a href="{{ $url }}" class="font-medium transition-colors hover:text-navy-700">{{ $label }}</a>
                    @else
                        <span class="font-semibold text-slate-500">{{ $label }}</span>
                    @endif
                @endforeach
            </nav>
        @endif
        <h1 class="font-display text-[26px] font-semibold leading-tight tracking-tight text-navy-900">{{ $title }}</h1>
        @if ($subtitle)<p class="mt-1 text-sm text-slate-500">{{ $subtitle }}</p>@endif
    </div>
    @if (isset($actions) || ! $slot->isEmpty())
        <div class="flex shrink-0 items-center gap-2">{{ $actions ?? $slot }}</div>
    @endif
</div>
