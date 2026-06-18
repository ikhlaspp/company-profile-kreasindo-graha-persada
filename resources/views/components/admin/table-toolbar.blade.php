@props(['placeholder' => 'Cari…', 'name' => 'q'])

<div class="flex flex-col gap-3 sm:flex-row sm:items-center">
    <div class="relative flex-1">
        <x-admin.icon name="search" class="pointer-events-none absolute left-3 top-1/2 h-4 w-4 -translate-y-1/2 text-slate-500" />
        <input type="text" name="{{ $name }}" value="{{ request($name) }}" placeholder="{{ $placeholder }}"
               class="w-full rounded-lg border border-line bg-paper2/50 py-2 pl-9 pr-3 text-sm text-navy-900 placeholder:text-slate-500 transition-colors focus:border-brass-500 focus:bg-card focus:ring-2 focus:ring-brass-500/20" />
    </div>
    @isset($filters)
        <div class="flex flex-wrap items-center gap-2">{{ $filters }}</div>
    @endisset
    @isset($action)
        <div class="shrink-0">{{ $action }}</div>
    @endisset
</div>
