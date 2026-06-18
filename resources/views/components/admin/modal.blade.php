@props(['name', 'title' => 'Konfirmasi', 'message' => 'Apakah Anda yakin?', 'confirm' => 'Hapus', 'danger' => true, 'action' => '#'])

{{--
    Generic confirm modal driven by a window event.
    Trigger with:  @click="$dispatch('open-modal-{{ $name }}', { label: 'Item X' })"
--}}
<div
    x-data="{ open: false, label: '', action: @js($action) }"
    x-show="open"
    x-cloak
    @open-modal-{{ $name }}.window="open = true; label = $event.detail?.label ?? ''; action = $event.detail?.url ?? @js($action)"
    @keydown.escape.window="open = false"
    class="fixed inset-0 z-[70] flex items-center justify-center px-4"
>
    <div class="absolute inset-0 bg-navy-900/50 backdrop-blur-sm" @click="open = false" x-transition.opacity></div>
    <div class="relative w-full max-w-md overflow-hidden rounded-2xl border border-line bg-card shadow-lg"
         x-transition:enter="transition ease-out duration-150" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100">
        <div class="p-6">
            <div class="flex items-start gap-4">
                <span @class(['grid h-11 w-11 shrink-0 place-items-center rounded-full', 'bg-danger/10 text-danger' => $danger, 'bg-brass-100 text-brass-700' => ! $danger])>
                    <x-admin.icon :name="$danger ? 'trash' : 'bell'" class="h-5 w-5" />
                </span>
                <div class="min-w-0">
                    <h3 class="font-display text-lg font-semibold text-navy-900">{{ $title }}</h3>
                    <p class="mt-1 text-sm text-slate-500">{{ $message }} <span class="font-semibold text-navy-800" x-text="label"></span></p>
                </div>
            </div>
            {{ $slot }}
        </div>
        <div class="flex justify-end gap-2 border-t border-line bg-paper2/50 px-6 py-4">
            <x-admin.btn variant="ghost" x-on:click="open = false">Batal</x-admin.btn>
            <form :action="action" method="POST" class="inline">
                @csrf @method('DELETE')
                <x-admin.btn type="submit" :variant="$danger ? 'danger' : 'accent'">{{ $confirm }}</x-admin.btn>
            </form>
        </div>
    </div>
</div>
