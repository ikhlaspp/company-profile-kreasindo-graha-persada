@extends('admin.layouts.admin')

@php $item ??= null; $editing = $item !== null; @endphp

@section('content')
    <x-admin.page-header :title="$editing ? 'Ubah Dokumen' : 'Tambah Dokumen'" :breadcrumb="['Dokumen' => route('panel.documents.index'), ($editing ? 'Ubah' : 'Tambah') => null]" />

    <form action="{{ $editing ? route('panel.documents.update', $item->id) : route('panel.documents.store') }}" method="POST" enctype="multipart/form-data" class="mx-auto max-w-2xl space-y-6">
        @csrf
        @if ($editing) @method('PUT') @endif
        <div class="space-y-5 rounded-xl border border-line bg-card p-6 shadow-sm">
            <x-admin.form.input label="Judul Dokumen" name="title" :value="$item?->title" required />
            <div class="grid grid-cols-1 gap-5 sm:grid-cols-2">
                <x-admin.form.select label="Kategori" name="category_id" required :selected="$item?->document_category_id" :options="$categories" />
                <x-admin.form.input label="Tahun" name="year" type="number" :value="$item?->year" placeholder="2026" />
            </div>
            <x-admin.form.input label="Urutan" name="sort_order" type="number" :value="$item?->sort_order ?? 0" />
            @if ($editing)
                <div class="rounded-lg bg-paper2/60 px-4 py-3 text-sm text-slate-500">Telah diunduh <span class="font-semibold text-navy-800">{{ number_format($item->download_count, 0, ',', '.') }}×</span></div>
            @endif
            <x-admin.form.file
                :label="$editing ? 'Ganti Berkas PDF' : 'Berkas PDF'"
                name="file" accept="application/pdf"
                :hint="$editing ? 'Kosongkan bila tak ingin mengganti.' : 'Hanya file PDF, maks. 10MB.'" />
            <x-admin.form.toggle label="Aktif" name="is_active" :checked="$item?->is_active ?? true" hint="Dokumen dapat diunduh publik." />
        </div>
        <div class="flex items-center justify-end gap-2">
            <x-admin.btn variant="ghost" :href="route('panel.documents.index')">Batal</x-admin.btn>
            <x-admin.btn variant="primary" type="submit"><x-admin.icon name="check" class="h-4 w-4" />{{ $editing ? 'Simpan Perubahan' : 'Simpan Dokumen' }}</x-admin.btn>
        </div>
    </form>
@endsection
