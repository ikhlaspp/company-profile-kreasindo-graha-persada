@extends('admin.layouts.admin')

@php $item ??= null; $editing = $item !== null; @endphp

@section('content')
    <x-admin.page-header :title="$editing ? 'Ubah Admin' : 'Tambah Admin'" :breadcrumb="['Admin & Users' => route('panel.users.index'), ($editing ? 'Ubah' : 'Tambah') => null]" />

    <form action="{{ $editing ? route('panel.users.update', $item->id) : route('panel.users.store') }}" method="POST" enctype="multipart/form-data" class="mx-auto max-w-2xl space-y-6">
        @csrf
        @if ($editing) @method('PUT') @endif
        <div class="space-y-5 rounded-xl border border-line bg-card p-6 shadow-sm">
            <x-admin.form.input label="Nama Lengkap" name="name" :value="$item?->name" required />
            <x-admin.form.input label="Email" name="email" type="email" :value="$item?->email" required />
            <x-admin.form.input
                :label="$editing ? 'Kata Sandi Baru' : 'Kata Sandi'"
                name="password" type="password" :required="! $editing"
                :hint="$editing ? 'Kosongkan bila tak ingin mengubah.' : 'Minimal 8 karakter.'" />
            <div class="grid grid-cols-1 gap-5 sm:grid-cols-2">
                <x-admin.form.select label="Role" name="role" required :selected="$item?->role" :options="['superadmin'=>'Superadmin','admin'=>'Admin','editor'=>'Editor']" />
                <x-admin.form.file label="Avatar" name="avatar" :preview="$editing && $item->avatar ? \Illuminate\Support\Facades\Storage::url($item->avatar) : null" />
            </div>
            <x-admin.form.toggle label="Aktif" name="is_active" :checked="$item?->is_active ?? true" hint="Akun dapat masuk ke panel." />
        </div>
        <div class="flex items-center justify-end gap-2">
            <x-admin.btn variant="ghost" :href="route('panel.users.index')">Batal</x-admin.btn>
            <x-admin.btn variant="primary" type="submit"><x-admin.icon name="check" class="h-4 w-4" />{{ $editing ? 'Simpan Perubahan' : 'Simpan Admin' }}</x-admin.btn>
        </div>
    </form>
@endsection
