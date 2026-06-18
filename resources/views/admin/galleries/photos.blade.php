@extends('admin.layouts.admin')

@section('content')
    <x-admin.page-header title="Kelola Foto" :subtitle="$gallery->title" :breadcrumb="['Galeri' => route('panel.galleries.index'), $gallery->title => null]">
        <x-admin.btn variant="ghost" size="sm" :href="route('panel.galleries.index')">Kembali</x-admin.btn>
    </x-admin.page-header>

    <form action="{{ route('panel.galleries.photos.store', $gallery->id) }}" method="POST" enctype="multipart/form-data" class="mb-6 rounded-xl border border-line bg-card p-6 shadow-sm">
        @csrf
        <x-admin.form.image-multi label="Unggah Foto Baru" hint="Pilih beberapa foto sekaligus." />
        <div class="mt-4 flex justify-end">
            <x-admin.btn variant="primary" type="submit"><x-admin.icon name="check" class="h-4 w-4" />Unggah Foto</x-admin.btn>
        </div>
    </form>

    @if ($photos->isNotEmpty())
        <form action="{{ route('panel.galleries.photos.update', $gallery->id) }}" method="POST">
            @csrf @method('PUT')
            <div class="grid grid-cols-2 gap-4 sm:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5">
                @foreach ($photos as $photo)
                    <div class="group overflow-hidden rounded-xl border border-line bg-card shadow-sm">
                        <div class="relative grid aspect-square place-items-center overflow-hidden bg-paper2">
                            <img src="{{ \Illuminate\Support\Facades\Storage::url($photo->file_path) }}" class="h-full w-full object-cover" alt="" loading="lazy">
                            <span class="absolute left-2 top-2 rounded bg-navy-900/70 px-1.5 py-0.5 text-[10px] font-bold text-white backdrop-blur">#{{ $photo->sort_order }}</span>
                            <button type="button" @click="$dispatch('open-modal-delete', { label: @js($photo->caption ?? 'Foto #'.$photo->sort_order), url: @js(route('panel.galleries.photos.destroy', [$gallery->id, $photo->id])) })" class="absolute right-2 top-2 grid h-7 w-7 place-items-center rounded-md bg-white/90 text-danger opacity-0 shadow transition-opacity group-hover:opacity-100"><x-admin.icon name="trash" class="h-4 w-4" /></button>
                        </div>
                        <div class="space-y-2 p-2.5">
                            <input type="text" name="captions[{{ $photo->id }}]" value="{{ $photo->caption }}" placeholder="Caption…" class="w-full rounded-md border border-line bg-paper2/40 px-2 py-1.5 text-xs text-navy-900 focus:border-brass-500 focus:ring-1 focus:ring-brass-500/20">
                            <label class="flex items-center gap-1.5 text-[11px] font-medium text-slate-500">
                                Urutan
                                <input type="number" name="sort_orders[{{ $photo->id }}]" value="{{ $photo->sort_order }}" min="0" class="w-16 rounded-md border border-line bg-paper2/40 px-2 py-1 text-xs text-navy-900 focus:border-brass-500 focus:ring-1 focus:ring-brass-500/20">
                            </label>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="mt-4 flex justify-end">
                <x-admin.btn variant="primary" type="submit"><x-admin.icon name="check" class="h-4 w-4" />Simpan Keterangan & Urutan</x-admin.btn>
            </div>
        </form>
    @else
        <p class="py-10 text-center text-sm text-slate-500">Belum ada foto di album ini.</p>
    @endif

    <x-admin.modal name="delete" title="Hapus Foto" message="Foto berikut akan dihapus dari album:" />
@endsection
