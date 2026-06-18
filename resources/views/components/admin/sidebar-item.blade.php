@props(['href' => '#', 'icon' => 'circle', 'active' => false])

<a href="{{ $href }}"
   @if ($active) aria-current="page" @endif
   :title="mini ? @js(trim($slot)) : null"
   :class="mini ? 'lg:justify-center lg:px-2' : ''"
   @class([
       'group relative flex items-center gap-3 rounded-lg px-3 py-2 text-[13px] font-medium transition-colors',
       'bg-navy-700/60 text-white' => $active,
       'text-slate-400 hover:bg-navy-800/70 hover:text-slate-100' => ! $active,
   ])>
    <span @class(['absolute left-0 top-1.5 bottom-1.5 w-[3px] rounded-r-full bg-brass-500 transition-opacity', 'opacity-100' => $active, 'opacity-0' => ! $active])></span>
    <x-admin.icon :name="$icon" class="h-[18px] w-[18px] shrink-0 {{ $active ? 'text-brass-300' : 'text-slate-500 group-hover:text-slate-300' }}" />
    <span class="truncate" x-show="!mini" x-cloak>{{ $slot }}</span>
</a>
