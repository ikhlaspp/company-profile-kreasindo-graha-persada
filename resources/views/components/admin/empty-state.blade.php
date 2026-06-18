@props(['icon' => 'folder', 'title' => 'Belum ada data', 'message' => 'Data akan tampil di sini setelah ditambahkan.'])

<div class="flex flex-col items-center justify-center px-6 py-16 text-center">
    <span class="grid h-14 w-14 place-items-center rounded-2xl bg-paper2 text-slate-500 ring-1 ring-line">
        <x-admin.icon :name="$icon" class="h-6 w-6" />
    </span>
    <h3 class="mt-4 font-display text-lg font-semibold text-navy-900">{{ $title }}</h3>
    <p class="mt-1 max-w-sm text-sm text-slate-500">{{ $message }}</p>
    @if (! $slot->isEmpty())<div class="mt-5">{{ $slot }}</div>@endif
</div>
