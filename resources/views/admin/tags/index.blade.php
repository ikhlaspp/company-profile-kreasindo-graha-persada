@extends('admin.layouts.admin')

@section('content')
    <div x-data="{ adding: false }">
        <x-admin.page-header title="Tag Berita" :breadcrumb="['Berita' => route('panel.posts.index'), 'Tag' => null]">
            <x-admin.btn variant="accent" x-on:click="adding = true"><x-admin.icon name="plus" class="h-4 w-4" />Tambah Tag</x-admin.btn>
        </x-admin.page-header>

        <div x-show="adding" x-cloak x-transition class="mb-6 rounded-xl border border-line bg-card p-4 shadow-sm">
            <form action="{{ route('panel.tags.store') }}" method="POST" class="flex flex-col gap-3 sm:flex-row sm:items-end">
                @csrf
                <div class="flex-1"><x-admin.form.input label="Nama Tag" name="name" required /></div>
                <x-admin.btn variant="primary" type="submit">Simpan</x-admin.btn>
                <x-admin.btn variant="ghost" x-on:click="adding=false">Batal</x-admin.btn>
            </form>
        </div>

        <div class="rounded-xl border border-line bg-card p-5 shadow-sm">
            <div class="flex flex-wrap gap-2">
                @forelse ($items as $item)
                    <span class="group inline-flex items-center gap-2 rounded-lg border border-line bg-paper2/50 py-1.5 pl-3 pr-2 text-sm">
                        <span class="font-semibold text-navy-800">{{ $item->name }}</span>
                        <span class="text-xs text-slate-500">{{ $item->posts_count }}</span>
                        <button @click="$dispatch('open-modal-delete', { label: @js($item->name), url: @js(route('panel.tags.destroy', $item->id)) })" class="grid h-5 w-5 place-items-center rounded text-slate-500 transition-colors hover:bg-danger/10 hover:text-danger">✕</button>
                    </span>
                @empty
                    <p class="py-6 text-center text-sm text-slate-500">Belum ada tag.</p>
                @endforelse
            </div>
        </div>

        <x-admin.modal name="delete" title="Hapus Tag" message="Tag berikut akan dihapus:" />
    </div>
@endsection
