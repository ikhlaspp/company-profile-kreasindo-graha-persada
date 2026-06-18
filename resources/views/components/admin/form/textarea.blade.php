@props(['label' => null, 'name', 'value' => '', 'placeholder' => '', 'rows' => 4, 'required' => false, 'hint' => null])

<div>
    @if ($label)
        <label for="{{ $name }}" class="mb-1.5 block text-[13px] font-semibold text-navy-800">
            {{ $label }} @if ($required)<span class="text-danger">*</span>@endif
        </label>
    @endif
    <textarea name="{{ $name }}" id="{{ $name }}" rows="{{ $rows }}" placeholder="{{ $placeholder }}" @if($required) required @endif
        {{ $attributes->merge(['class' => 'w-full rounded-lg border border-line bg-card px-3 py-2.5 text-sm text-navy-900 placeholder:text-slate-500 transition-colors focus:border-brass-500 focus:ring-2 focus:ring-brass-500/20']) }}>{{ old($name, $value) }}</textarea>
    @if ($hint)<p class="mt-1 text-xs text-slate-500">{{ $hint }}</p>@endif
    @error($name)<p class="mt-1 text-xs font-medium text-danger">{{ $message }}</p>@enderror
</div>
