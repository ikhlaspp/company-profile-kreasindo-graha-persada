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
                                @if ($img->is_cover)<span class="absolute bottom-1 left-1 rounded bg-brass-500 px-1.5 py-0.5 text-[9px] font-bold uppercase text-navy-900">Cover</span>@endif
                            </div>
                        @endforeach
                    </div>
                    <p class="text-xs text-slate-500">Unggah foto baru di bawah untuk menambah ke galeri.</p>
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
@endsection
