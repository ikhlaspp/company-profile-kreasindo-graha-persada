@extends('admin.layouts.admin')

@php $item ??= null; $editing = $item !== null; @endphp

@section('content')
    <x-admin.page-header :title="$editing ? 'Ubah Klien' : 'Tambah Klien'" :breadcrumb="['Klien' => route('panel.clients.index'), ($editing ? 'Ubah' : 'Tambah') => null]" />

    <form action="{{ $editing ? route('panel.clients.update', $item->id) : route('panel.clients.store') }}" method="POST" enctype="multipart/form-data" class="mx-auto max-w-2xl space-y-6">
        @csrf
        @if ($editing) @method('PUT') @endif
        <div class="space-y-5 rounded-xl border border-line bg-card p-6 shadow-sm">
            <x-admin.form.input label="Nama Klien" name="name" :value="$item?->name" required placeholder="mis. TNI Angkatan Laut" />
            <x-admin.form.input label="Slug" name="slug" prefix="/" :value="$item?->slug" hint="Otomatis dari nama bila dikosongkan." />
            <div class="grid grid-cols-1 gap-5 sm:grid-cols-2">
                <x-admin.form.select label="Kategori" name="category" required :selected="$item?->category" :options="['militer'=>'Militer','pemerintah'=>'Pemerintah','bumn'=>'BUMN','swasta'=>'Swasta']" />
                <x-admin.form.input label="Urutan" name="sort_order" type="number" :value="$item?->sort_order ?? 0" />
            </div>
            <x-admin.form.input label="Website" name="website" prefix="@" :value="$item?->website" placeholder="example.co.id" />
            <x-admin.form.file label="Logo" name="logo" :preview="$editing && $item->logo ? \Illuminate\Support\Facades\Storage::url($item->logo) : null" />
            <x-admin.form.toggle label="Aktif" name="is_active" :checked="$item?->is_active ?? true" hint="Tampilkan logo di halaman Klien." />
        </div>
        <div class="flex items-center justify-end gap-2">
            <x-admin.btn variant="ghost" :href="route('panel.clients.index')">Batal</x-admin.btn>
            <x-admin.btn variant="primary" type="submit"><x-admin.icon name="check" class="h-4 w-4" />{{ $editing ? 'Simpan Perubahan' : 'Simpan Klien' }}</x-admin.btn>
        </div>
    </form>
@endsection
