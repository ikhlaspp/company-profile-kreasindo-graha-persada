@extends('admin.layouts.admin')

@section('content')
    <div x-data="{ adding: false }">
        <x-admin.page-header title="Kategori Dokumen" :breadcrumb="['Dokumen' => route('panel.documents.index'), 'Kategori' => null]">
            <x-admin.btn variant="accent" x-on:click="adding = true"><x-admin.icon name="plus" class="h-4 w-4" />Tambah Kategori</x-admin.btn>
        </x-admin.page-header>

        <div class="grid grid-cols-1 gap-6 lg:grid-cols-3">
            <div class="lg:col-span-2">
                <x-admin.data-table>
                    <x-slot name="head">
                        <th class="px-5 py-3 font-semibold">Nama</th>
                        <th class="px-5 py-3 font-semibold">Slug</th>
                        <th class="px-5 py-3 font-semibold">Dokumen</th>
                        <th class="px-5 py-3 font-semibold">Tampil di Tentang</th>
                        <th class="px-5 py-3 text-right font-semibold">Aksi</th>
                    </x-slot>
                    @forelse ($items as $item)
                        <tr class="transition-colors hover:bg-paper2/50">
                            <td class="px-5 py-3.5 font-semibold text-navy-900">{{ $item->name }}</td>
                            <td class="px-5 py-3.5 text-slate-500">/{{ $item->slug }}</td>
                            <td class="px-5 py-3.5"><x-admin.badge>{{ $item->documents_count }} dokumen</x-admin.badge></td>
                            <td class="px-5 py-3.5">
                                <form action="{{ route('panel.document-categories.update', $item->id) }}" method="POST">
                                    @csrf @method('PUT')
                                    <input type="hidden" name="name" value="{{ $item->name }}">
                                    <input type="hidden" name="slug" value="{{ $item->slug }}">
                                    <input type="hidden" name="is_legal" value="0">
                                    <label class="inline-flex cursor-pointer items-center gap-2" title="Tampilkan dokumen kategori ini di bagian Legalitas halaman Tentang">
                                        <input type="checkbox" name="is_legal" value="1" @checked($item->is_legal) onchange="this.form.submit()" class="h-4 w-4 rounded border-line text-brass-600 focus:ring-brass-500">
                                        <span class="text-xs text-slate-500">{{ $item->is_legal ? 'Ya' : 'Tidak' }}</span>
                                    </label>
                                </form>
                            </td>
                            <td class="px-5 py-3.5">
                                <div class="flex items-center justify-end gap-1">
                                    <button @click="$dispatch('open-modal-delete', { label: @js($item->name), url: @js(route('panel.document-categories.destroy', $item->id)) })" class="rounded-lg p-2 text-danger transition-colors hover:bg-danger/10"><x-admin.icon name="trash" class="h-4 w-4" /></button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="5" class="px-5 py-10 text-center text-sm text-slate-500">Belum ada kategori.</td></tr>
                    @endforelse
                </x-admin.data-table>
            </div>
            <div x-show="adding" x-cloak x-transition class="self-start rounded-xl border border-line bg-card p-6 shadow-sm">
                <div class="mb-4 flex items-center justify-between">
                    <h2 class="font-display text-base font-semibold text-navy-900">Kategori Baru</h2>
                    <button @click="adding=false" class="text-slate-500 hover:text-navy-900">✕</button>
                </div>
                <form action="{{ route('panel.document-categories.store') }}" method="POST" class="space-y-4">
                    @csrf
                    <x-admin.form.input label="Nama" name="name" required />
                    <x-admin.form.input label="Slug" name="slug" prefix="/" />
                    <input type="hidden" name="is_legal" value="0">
                    <label class="flex cursor-pointer items-center gap-2">
                        <input type="checkbox" name="is_legal" value="1" class="h-4 w-4 rounded border-line text-brass-600 focus:ring-brass-500">
                        <span class="text-sm text-slate-600">Tampilkan di halaman Tentang (Legalitas)</span>
                    </label>
                    <x-admin.btn variant="primary" type="submit" class="w-full">Simpan</x-admin.btn>
                </form>
            </div>
        </div>

        <x-admin.modal name="delete" title="Hapus Kategori" message="Kategori berikut akan dihapus:" />
    </div>
@endsection
