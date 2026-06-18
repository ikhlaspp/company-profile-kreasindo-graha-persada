@props(['label' => null, 'name', 'options' => [], 'selected' => '', 'placeholder' => 'Pilih…', 'required' => false, 'hint' => null])

<div>
    @if ($label)
        <label for="{{ $name }}" class="mb-1.5 block text-[13px] font-semibold text-navy-800">
            {{ $label }} @if ($required)<span class="text-danger">*</span>@endif
        </label>
    @endif
    <div class="relative">
        <select name="{{ $name }}" id="{{ $name }}" @if($required) required @endif
            {{ $attributes->merge(['class' => 'w-full appearance-none rounded-lg border border-line bg-card py-2.5 pl-3 pr-9 text-sm text-navy-900 transition-colors focus:border-brass-500 focus:ring-2 focus:ring-brass-500/20']) }}>
            @if ($placeholder)<option value="">{{ $placeholder }}</option>@endif
            @foreach ($options as $val => $text)
                <option value="{{ $val }}" @selected(old($name, $selected) == $val)>{{ $text }}</option>
            @endforeach
            {{ $slot }}
        </select>
        <x-admin.icon name="chevron" class="pointer-events-none absolute right-3 top-1/2 h-4 w-4 -translate-y-1/2 text-slate-500" />
    </div>
    @if ($hint)<p class="mt-1 text-xs text-slate-500">{{ $hint }}</p>@endif
    @error($name)<p class="mt-1 text-xs font-medium text-danger">{{ $message }}</p>@enderror
</div>
