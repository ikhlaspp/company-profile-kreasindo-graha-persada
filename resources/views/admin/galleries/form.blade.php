@extends('admin.layouts.admin')

@php $item ??= null; $editing = $item !== null; @endphp

@section('content')
    <x-admin.page-header :title="$editing ? 'Ubah Album' : 'Tambah Album'" :breadcrumb="['Galeri' => route('panel.galleries.index'), ($editing ? 'Ubah' : 'Tambah') => null]">
        @if ($editing)
            <x-admin.btn variant="outline" size="sm" :href="route('panel.galleries.photos', $item->id)"><x-admin.icon name="image" class="h-4 w-4" />Kelola Foto</x-admin.btn>
        @endif
    </x-admin.page-header>

    <form action="{{ $editing ? route('panel.galleries.update', $item->id) : route('panel.galleries.store') }}" method="POST" enctype="multipart/form-data" class="mx-auto max-w-2xl space-y-6">
        @csrf
        @if ($editing) @method('PUT') @endif
        <div class="space-y-5 rounded-xl border border-line bg-card p-6 shadow-sm">
            <x-admin.form.input label="Judul Album" name="title" :value="$item?->title" required />
            <x-admin.form.input label="Slug" name="slug" prefix="/" :value="$item?->slug" hint="Otomatis dari judul bila dikosongkan." />
            <x-admin.form.select label="Divisi" name="division" required :selected="$item?->division" :options="['it'=>'IT','interior'=>'Interior','sipil'=>'Sipil','event'=>'Event']" />
            <x-admin.form.textarea label="Deskripsi" name="description" rows="3" :value="$item?->description" />
            <x-admin.form.file label="Cover Album" name="cover_image" :preview="$editing && $item->cover_image ? \Illuminate\Support\Facades\Storage::url($item->cover_image) : null" />
            <x-admin.form.toggle label="Aktif" name="is_active" :checked="$item?->is_active ?? true" />
        </div>
        <div class="flex items-center justify-end gap-2">
            <x-admin.btn variant="ghost" :href="route('panel.galleries.index')">Batal</x-admin.btn>
            <x-admin.btn variant="primary" type="submit"><x-admin.icon name="check" class="h-4 w-4" />{{ $editing ? 'Simpan Perubahan' : 'Simpan & Tambah Foto' }}</x-admin.btn>
        </div>
    </form>
@endsection
