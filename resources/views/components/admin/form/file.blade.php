@props(['label' => null, 'name', 'accept' => 'image/*', 'hint' => null, 'preview' => null])

<div x-data="{ name: '', url: @js($preview) }">
    @if ($label)<label class="mb-1.5 block text-[13px] font-semibold text-navy-800">{{ $label }}</label>@endif
    <label class="flex cursor-pointer items-center gap-4 rounded-xl border border-dashed border-slate-300 bg-paper2/40 p-4 transition-colors hover:border-brass-500 hover:bg-brass-100/30">
        <span class="grid h-16 w-16 shrink-0 place-items-center overflow-hidden rounded-lg bg-card ring-1 ring-line">
            <template x-if="url"><img :src="url" class="h-full w-full object-cover" alt=""></template>
            <template x-if="!url"><x-admin.icon name="upload" class="h-6 w-6 text-slate-500" /></template>
        </span>
        <span class="min-w-0 flex-1">
            <span class="block text-sm font-semibold text-navy-800">Klik untuk mengunggah</span>
            <span class="mt-0.5 block truncate text-xs text-slate-500" x-text="name || @js($hint ?? 'PNG, JPG, atau PDF — maks. 5MB')"></span>
        </span>
        <input type="file" name="{{ $name }}" accept="{{ $accept }}" class="hidden"
               @change="name = $event.target.files[0]?.name ?? ''; if ($event.target.files[0]?.type.startsWith('image')) url = URL.createObjectURL($event.target.files[0])">
    </label>
    @error($name)<p class="mt-1 text-xs font-medium text-danger">{{ $message }}</p>@enderror
</div>
