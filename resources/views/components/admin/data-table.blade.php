@props(['title' => null])

<div {{ $attributes->merge(['class' => 'overflow-hidden rounded-xl border border-line bg-card shadow-sm']) }}>
    @isset($toolbar)
        <div class="border-b border-line p-3">{{ $toolbar }}</div>
    @endisset
    <div class="overflow-x-auto">
        <table class="w-full border-collapse text-left text-sm">
            <thead>
                <tr class="border-b border-line bg-paper2/60 text-[11px] uppercase tracking-wider text-slate-500">
                    {{ $head }}
                </tr>
            </thead>
            <tbody class="divide-y divide-line/70">
                {{ $slot }}
            </tbody>
        </table>
    </div>
    @isset($footer)
        <div class="border-t border-line px-4 py-3">{{ $footer }}</div>
    @endisset
</div>
