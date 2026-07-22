{{-- Error validasi — sengaja TANPA Alpine/x-cloak agar tetap tampil
     walau JavaScript gagal dimuat. --}}
@if ($errors->any())
    <div class="mb-6 rounded-xl border border-danger/30 bg-danger/5 px-4 py-3 text-sm text-danger">
        <p class="mb-1 font-semibold">Gagal menyimpan. Mohon periksa isian berikut:</p>
        <ul class="list-inside list-disc space-y-0.5">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

@if (session('success') || session('error'))
    @php $isError = (bool) session('error'); @endphp
    <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 4500)" x-cloak
         x-transition:leave="transition ease-in duration-200" x-transition:leave-end="opacity-0 -translate-y-1"
         @class([
            'mb-6 flex items-start gap-3 rounded-xl border px-4 py-3 text-sm',
            'border-danger/20 bg-danger/5 text-danger' => $isError,
            'border-success/20 bg-success/5 text-success' => ! $isError,
         ])>
        <x-admin.icon :name="$isError ? 'trash' : 'check'" class="mt-0.5 h-4 w-4 shrink-0" />
        <p class="flex-1 font-medium">{{ session('success') ?? session('error') }}</p>
        <button @click="show = false" aria-label="Tutup" class="text-current/60 hover:text-current"><x-admin.icon name="x" class="h-4 w-4" /></button>
    </div>
@endif
