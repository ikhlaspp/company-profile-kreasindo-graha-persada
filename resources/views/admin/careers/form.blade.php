@extends('admin.layouts.admin')

@php $item ??= null; $editing = $item !== null; @endphp

@section('content')
    <x-admin.page-header :title="$editing ? 'Ubah Lowongan' : 'Tambah Lowongan'" :breadcrumb="['Karir' => route('panel.careers.index'), ($editing ? 'Ubah' : 'Tambah') => null]" />

    <form action="{{ $editing ? route('panel.careers.update', $item->id) : route('panel.careers.store') }}" method="POST" class="mx-auto max-w-3xl space-y-6">
        @csrf
        @if ($editing) @method('PUT') @endif
        <div class="space-y-5 rounded-xl border border-line bg-card p-6 shadow-sm">
            <x-admin.form.input label="Judul Posisi" name="title" :value="$item?->title" required placeholder="mis. Backend Developer" />
            <x-admin.form.input label="Slug" name="slug" prefix="/" :value="$item?->slug" hint="Otomatis dari judul bila dikosongkan." />
            <div class="grid grid-cols-1 gap-5 sm:grid-cols-3">
                <x-admin.form.select label="Divisi" name="division" required :selected="$item?->division" :options="['it'=>'IT','interior'=>'Interior','me'=>'M/E','umum'=>'Umum']" />
                <x-admin.form.select label="Tipe" name="employment_type" required :selected="$item?->employment_type" :options="['full_time'=>'Full-time','part_time'=>'Part-time','contract'=>'Kontrak','internship'=>'Magang']" />
                <x-admin.form.input label="Lokasi" name="location" :value="$item?->location" placeholder="Depok" />
            </div>
            <x-admin.form.input label="Batas Lamaran" name="deadline" type="date" :value="$item?->deadline?->format('Y-m-d')" />
            <x-admin.form.textarea label="Deskripsi Pekerjaan" name="description" rows="5" :value="$item?->description" />
            <x-admin.form.textarea label="Persyaratan" name="requirements" rows="5" :value="$item?->requirements" hint="Satu syarat per baris." />
            <x-admin.form.toggle label="Dibuka" name="is_active" :checked="$item?->is_active ?? true" hint="Tampilkan lowongan di situs publik." />
        </div>
        <div class="flex items-center justify-end gap-2">
            <x-admin.btn variant="ghost" :href="route('panel.careers.index')">Batal</x-admin.btn>
            <x-admin.btn variant="primary" type="submit"><x-admin.icon name="check" class="h-4 w-4" />{{ $editing ? 'Simpan Perubahan' : 'Simpan Lowongan' }}</x-admin.btn>
        </div>
    </form>
@endsection
