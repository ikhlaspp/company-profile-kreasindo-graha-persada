@props(['paginator'])

@php
    // Replicates Illuminate\Pagination\LengthAwarePaginator::elements() (protected),
    // so we can render Laravel's first/slider/last window with custom styling.
    $elements = [];
    if ($paginator->hasPages()) {
        $window = \Illuminate\Pagination\UrlWindow::make($paginator);
        $elements = array_filter([
            $window['first'],
            is_array($window['slider']) ? '...' : null,
            $window['slider'],
            is_array($window['last']) ? '...' : null,
            $window['last'],
        ]);
    }

    $current = $paginator->currentPage();
    $btnBase = 'grid h-8 place-items-center rounded-lg border border-line bg-card transition-colors';
@endphp

<div class="flex flex-col items-center justify-between gap-3 sm:flex-row">
    <p class="text-xs text-slate-500">Menampilkan <span class="font-semibold text-slate-600">{{ $paginator->firstItem() ?? 0 }}–{{ $paginator->lastItem() ?? 0 }}</span> dari <span class="font-semibold text-slate-600">{{ number_format($paginator->total(), 0, ',', '.') }}</span> data</p>

    @if ($paginator->hasPages())
        <div class="flex items-center gap-1">
            {{-- Previous --}}
            @if ($paginator->onFirstPage())
                <span aria-disabled="true" class="{{ $btnBase }} w-8 text-slate-300 opacity-40">
                    <x-admin.icon name="chevron" class="h-4 w-4 rotate-90" />
                </span>
            @else
                <a href="{{ $paginator->previousPageUrl() }}" rel="prev" aria-label="Halaman sebelumnya" class="{{ $btnBase }} w-8 text-slate-500 hover:bg-paper2">
                    <x-admin.icon name="chevron" class="h-4 w-4 rotate-90" />
                </a>
            @endif

            {{-- Page numbers (with ellipsis) --}}
            @foreach ($elements as $element)
                @if (is_string($element))
                    <span class="grid h-8 min-w-8 place-items-center px-1 text-[13px] text-slate-500">…</span>
                @endif
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $current)
                            <span aria-current="page" class="grid h-8 min-w-8 place-items-center rounded-lg bg-navy-800 px-2 text-[13px] font-semibold text-white">{{ $page }}</span>
                        @else
                            <a href="{{ $url }}" class="{{ $btnBase }} min-w-8 px-2 text-[13px] font-semibold text-slate-500 hover:bg-paper2">{{ $page }}</a>
                        @endif
                    @endforeach
                @endif
            @endforeach

            {{-- Next --}}
            @if ($paginator->hasMorePages())
                <a href="{{ $paginator->nextPageUrl() }}" rel="next" aria-label="Halaman berikutnya" class="{{ $btnBase }} w-8 text-slate-500 hover:bg-paper2">
                    <x-admin.icon name="chevron" class="h-4 w-4 -rotate-90" />
                </a>
            @else
                <span aria-disabled="true" class="{{ $btnBase }} w-8 text-slate-300 opacity-40">
                    <x-admin.icon name="chevron" class="h-4 w-4 -rotate-90" />
                </span>
            @endif
        </div>
    @endif
</div>
