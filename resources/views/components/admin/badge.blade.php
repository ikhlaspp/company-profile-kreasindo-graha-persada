@props(['type' => 'default', 'dot' => false])

@php
    $styles = [
        'default'  => 'bg-paper2 text-slate-600 ring-line',
        'ok'       => 'bg-success/10 text-success ring-success/20',
        'off'      => 'bg-slate-400/10 text-slate-500 ring-slate-400/20',
        'draft'    => 'bg-warning/10 text-warning ring-warning/20',
        'publish'  => 'bg-success/10 text-success ring-success/20',
        'archived' => 'bg-slate-400/10 text-slate-500 ring-slate-400/20',
        'warning'  => 'bg-brass-100 text-brass-700 ring-brass-300',
        'info'     => 'bg-info/10 text-info ring-info/20',
        'it'       => 'bg-navy-100 text-navy-700 ring-navy-600/20',
        'interior' => 'bg-brass-100 text-brass-700 ring-brass-300',
        'me'       => 'bg-info/10 text-info ring-info/20',
        'faq'      => 'bg-success/10 text-success ring-success/20',
        'gemini'   => 'bg-info/10 text-info ring-info/20',
        'grok'     => 'bg-purple-500/10 text-purple-600 ring-purple-500/20',
        'fallback' => 'bg-slate-400/10 text-slate-500 ring-slate-400/20',
    ];
    $dotColors = [
        'ok' => 'bg-success', 'publish' => 'bg-success', 'faq' => 'bg-success',
        'off' => 'bg-slate-400', 'archived' => 'bg-slate-400', 'fallback' => 'bg-slate-400',
        'draft' => 'bg-warning', 'warning' => 'bg-brass-500',
        'info' => 'bg-info', 'gemini' => 'bg-info', 'me' => 'bg-info', 'grok' => 'bg-purple-500',
        'it' => 'bg-navy-600', 'interior' => 'bg-brass-500', 'default' => 'bg-slate-400',
    ];
    $cls = $styles[$type] ?? $styles['default'];
@endphp

<span {{ $attributes->merge(['class' => "inline-flex items-center gap-1.5 rounded-full px-2.5 py-0.5 text-[11px] font-semibold ring-1 ring-inset $cls"]) }}>
    @if ($dot)<span class="h-1.5 w-1.5 rounded-full {{ $dotColors[$type] ?? 'bg-slate-400' }}"></span>@endif
    {{ $slot }}
</span>
