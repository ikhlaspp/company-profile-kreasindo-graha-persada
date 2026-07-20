@extends('admin.layouts.admin')

@php $item ??= null; $editing = $item !== null; @endphp

@section('content')
    <x-admin.page-header :title="$editing ? 'Ubah Proyek' : 'Tambah Proyek'" :breadcrumb="['Portofolio' => route('panel.projects.index'), ($editing ? 'Ubah' : 'Tambah') => null]" />

    <form action="{{ $editing ? route('panel.projects.update', $item->id) : route('panel.projects.store') }}" method="POST" enctype="multipart/form-data" class="grid grid-cols-1 gap-6 lg:grid-cols-3">
        @csrf
        @if ($editing) @method('PUT') @endif
        <div class="space-y-6 lg:col-span-2">
            <div class="space-y-5 rounded-xl border border-line bg-card p-6 shadow-sm">
                <h2 class="font-display text-base font-semibold text-navy-900">Detail Proyek</h2>
                <x-admin.form.input label="Judul Proyek" name="title" :value="$item?->title" required placeholder="mis. Sistem Informasi Seskoal" />
                <x-admin.form.input label="Slug" name="slug" prefix="/" :value="$item?->slug" hint="Otomatis dari judul bila dikosongkan." />
                <div class="grid grid-cols-1 gap-5 sm:grid-cols-2">
                    <x-admin.form.select label="Klien" name="client_id" :selected="$item?->client_id" :options="$clients" />
                    <x-admin.form.select label="Layanan (opsional)" name="service_id" :selected="$item?->service_id" :options="$services" />
                    <x-admin.form.select label="Divisi" name="division" required :selected="$item?->division" :options="$divisions" />
                    <x-admin.form.input label="Lokasi" name="location" :value="$item?->location" placeholder="Jakarta" />
                </div>
                <x-admin.form.textarea label="Deskripsi" name="description" rows="5" :value="$item?->description" />
            </div>

            <div class="space-y-5 rounded-xl border border-line bg-card p-6 shadow-sm">
                <h2 class="font-display text-base font-semibold text-navy-900">Galeri Foto</h2>
                @if ($editing && $item->images->isNotEmpty())
                    <div class="grid grid-cols-3 gap-3 sm:grid-cols-4 lg:grid-cols-5">
                        @foreach ($item->images as $img)
                            <div class="relative aspect-square overflow-hidden rounded-lg ring-1 ring-line">
                                <img src="{{ \Illuminate\Support\Facades\Storage::url($img->file_path) }}" class="h-full w-full object-cover" alt="" loading="lazy">
                                @if ($img->is_cover)
                                    <span class="absolute bottom-1 left-1 rounded bg-brass-500 px-1.5 py-0.5 text-[9px] font-bold uppercase text-navy-900">Cover</span>
                                @else
                                    <button type="button" title="Jadikan cover"
                                        onclick="var f=document.getElementById('kgp-cover-form'); f.action='{{ route('panel.projects.photos.cover', [$item->id, $img->id]) }}'; f.submit();"
                                        class="absolute bottom-1 left-1 grid h-6 w-6 place-items-center rounded-full bg-navy-900/80 text-brass-300 shadow-sm transition-colors hover:bg-navy-900"><x-admin.icon name="spark" class="h-3.5 w-3.5" /></button>
                                @endif
                                <button type="button"
                                    @click="$dispatch('open-modal-delete', { label: 'foto ini', url: @js(route('panel.projects.photos.destroy', [$item->id, $img->id])) })"
                                    class="absolute right-1 top-1 grid h-6 w-6 place-items-center rounded-full bg-danger/90 text-white shadow-sm transition-colors hover:bg-danger"
                                    title="Hapus foto">
                                    <x-admin.icon name="x" class="h-3.5 w-3.5" />
                                </button>
                            </div>
                        @endforeach
                    </div>
                    <p class="text-xs text-slate-500">Klik <span class="font-semibold">✕</span> untuk menghapus, atau ikon <span class="font-semibold">bintang</span> untuk menjadikan foto sebagai cover. Unggah foto baru di bawah untuk menambah.</p>
                @endif
                <x-admin.form.image-multi />
            </div>
        </div>

        <div class="space-y-6">
            <div class="space-y-5 rounded-xl border border-line bg-card p-6 shadow-sm">
                <h2 class="font-display text-base font-semibold text-navy-900">Atribut</h2>
                <x-admin.form.input label="Nilai Kontrak" name="contract_value" type="number" prefix="Rp" :value="$item?->contract_value" placeholder="0" />
                <div class="grid grid-cols-2 gap-4">
                    <x-admin.form.input label="Tahun" name="year" type="number" :value="$item?->year" placeholder="2024" />
                    <x-admin.form.input label="Selesai" name="completed_at" type="date" :value="$item?->completed_at?->format('Y-m-d')" />
                </div>
            </div>
            <div class="space-y-4 rounded-xl border border-line bg-card p-6 shadow-sm">
                <h2 class="font-display text-base font-semibold text-navy-900">Publikasi</h2>
                <x-admin.form.toggle label="Unggulan" name="is_featured" :checked="$item?->is_featured ?? false" hint="Tampilkan di beranda." />
                <div class="border-t border-line"></div>
                <x-admin.form.toggle label="Aktif" name="is_active" :checked="$item?->is_active ?? true" />
            </div>
        </div>

        <div class="flex items-center justify-end gap-2 lg:col-span-3">
            <x-admin.btn variant="ghost" :href="route('panel.projects.index')">Batal</x-admin.btn>
            <x-admin.btn variant="primary" type="submit"><x-admin.icon name="check" class="h-4 w-4" />{{ $editing ? 'Simpan Perubahan' : 'Simpan Proyek' }}</x-admin.btn>
        </div>
    </form>

    {{-- Form tersembunyi untuk aksi "Jadikan Cover" (di luar form utama). --}}
    <form id="kgp-cover-form" method="POST" class="hidden">@csrf @method('PATCH')</form>

    <x-admin.modal name="delete" title="Hapus Foto" message="Foto berikut akan dihapus permanen:" />
@endsection
