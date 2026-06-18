@props(['label' => null, 'name', 'type' => 'text', 'value' => '', 'placeholder' => '', 'required' => false, 'hint' => null, 'prefix' => null])

<div>
    @if ($label)
        <label for="{{ $name }}" class="mb-1.5 block text-[13px] font-semibold text-navy-800">
            {{ $label }} @if ($required)<span class="text-danger">*</span>@endif
        </label>
    @endif
    <div class="relative">
        @if ($prefix)<span class="pointer-events-none absolute left-3 top-1/2 -translate-y-1/2 text-sm text-slate-500">{{ $prefix }}</span>@endif
        <input
            type="{{ $type }}" name="{{ $name }}" id="{{ $name }}"
            value="{{ old($name, $value) }}" placeholder="{{ $placeholder }}" @if($required) required @endif
            {{ $attributes->merge(['class' => 'w-full rounded-lg border border-line bg-card py-2.5 text-sm text-navy-900 placeholder:text-slate-500 transition-colors focus:border-brass-500 focus:ring-2 focus:ring-brass-500/20 '.($prefix ? 'pl-7 pr-3' : 'px-3')]) }}
        />
    </div>
    @if ($hint)<p class="mt-1 text-xs text-slate-500">{{ $hint }}</p>@endif
    @error($name)<p class="mt-1 text-xs font-medium text-danger">{{ $message }}</p>@enderror
</div>
