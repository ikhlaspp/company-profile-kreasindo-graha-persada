@extends('admin.layouts.admin')

@php $item ??= null; $editing = $item !== null; @endphp

@section('content')
    <x-admin.page-header :title="$editing ? 'Ubah Layanan' : 'Tambah Layanan'" :breadcrumb="['Layanan' => route('panel.services.index'), ($editing ? 'Ubah' : 'Tambah') => null]" />

    <form action="{{ $editing ? route('panel.services.update', $item->id) : route('panel.services.store') }}" method="POST" enctype="multipart/form-data" class="grid grid-cols-1 gap-6 lg:grid-cols-3">
        @csrf
        @if ($editing) @method('PUT') @endif
        <div class="space-y-6 lg:col-span-2">
            <div class="space-y-5 rounded-xl border border-line bg-card p-6 shadow-sm">
                <h2 class="font-display text-base font-semibold text-navy-900">Informasi Layanan</h2>
                <div class="grid grid-cols-1 gap-5 sm:grid-cols-2">
                    <x-admin.form.select label="Divisi" name="division" required :selected="$item?->division" :options="['it'=>'IT & Security','interior'=>'Interior Design','me'=>'Mekanikal/Elektrikal']" />
                    <x-admin.form.input label="Urutan Tampil" name="sort_order" type="number" :value="$item?->sort_order ?? 0" />
                </div>
                <x-admin.form.input label="Judul" name="title" :value="$item?->title" placeholder="mis. Pengembangan Perangkat Lunak" required />
                <x-admin.form.input label="Slug" name="slug" prefix="/" :value="$item?->slug" placeholder="pengembangan-perangkat-lunak" hint="Otomatis dari judul bila dikosongkan." />
                <x-admin.form.textarea label="Excerpt" name="excerpt" rows="2" :value="$item?->excerpt" placeholder="Ringkasan singkat satu kalimat." />
                <x-admin.form.textarea label="Deskripsi" name="description" rows="6" :value="$item?->description" placeholder="Penjelasan lengkap layanan…" />
            </div>
        </div>

        <div class="space-y-6">
            <div class="space-y-5 rounded-xl border border-line bg-card p-6 shadow-sm">
                <h2 class="font-display text-base font-semibold text-navy-900">Publikasi</h2>
                <x-admin.form.toggle label="Aktif" name="is_active" :checked="$item?->is_active ?? true" hint="Tampilkan layanan di situs publik." />
            </div>
            <div class="space-y-5 rounded-xl border border-line bg-card p-6 shadow-sm">
                <h2 class="font-display text-base font-semibold text-navy-900">Media</h2>
                <x-admin.form.input label="Ikon" name="icon" :value="$item?->icon" placeholder="nama ikon / kelas" />
                <x-admin.form.file label="Gambar Cover" name="cover_image" :preview="$editing && $item->cover_image ? \Illuminate\Support\Facades\Storage::url($item->cover_image) : null" />
            </div>
        </div>

        <div class="flex items-center justify-end gap-2 lg:col-span-3">
            <x-admin.btn variant="ghost" :href="route('panel.services.index')">Batal</x-admin.btn>
            <x-admin.btn variant="primary" type="submit"><x-admin.icon name="check" class="h-4 w-4" />{{ $editing ? 'Simpan Perubahan' : 'Simpan Layanan' }}</x-admin.btn>
        </div>
    </form>
@endsection
