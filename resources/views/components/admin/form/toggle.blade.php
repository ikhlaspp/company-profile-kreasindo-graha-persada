@props(['label' => null, 'name', 'checked' => false, 'hint' => null])

<label class="flex cursor-pointer items-start justify-between gap-4" x-data="{ on: @js((bool) old($name, $checked)) }">
    <span class="min-w-0">
        @if ($label)<span class="block text-[13px] font-semibold text-navy-800">{{ $label }}</span>@endif
        @if ($hint)<span class="mt-0.5 block text-xs text-slate-500">{{ $hint }}</span>@endif
    </span>
    <input type="hidden" name="{{ $name }}" :value="on ? 1 : 0">
    <button type="button" @click="on = !on" role="switch" :aria-checked="on"
            class="relative inline-flex h-6 w-11 shrink-0 items-center rounded-full transition-colors"
            :class="on ? 'bg-success' : 'bg-slate-300'">
        <span class="inline-block h-5 w-5 transform rounded-full bg-white shadow transition-transform" :class="on ? 'translate-x-[22px]' : 'translate-x-0.5'"></span>
    </button>
</label>
