@extends('admin.layouts.admin')
@section('title', 'Dokumen')

@section('content')
    <x-admin.page-header eyebrow="Publikasi" title="Kelola Dokumen" subtitle="Dokumen legal & profil (PDF)." :breadcrumb="['Dokumen' => null]">
        <x-admin.btn variant="outline" :href="route('panel.document-categories.index')"><x-admin.icon name="folder" class="h-4 w-4" />Kategori</x-admin.btn>
        <x-admin.btn variant="accent" :href="route('panel.documents.create')"><x-admin.icon name="plus" class="h-4 w-4" />Tambah Dokumen</x-admin.btn>
    </x-admin.page-header>

    <x-admin.data-table>
        <x-slot name="toolbar">
            <form method="GET">
                <x-admin.table-toolbar placeholder="Cari dokumen…" />
            </form>
        </x-slot>
        <x-slot name="head">
            <th class="px-5 py-3 font-semibold">Dokumen</th>
            <th class="px-5 py-3 font-semibold">Kategori</th>
            <th class="px-5 py-3 font-semibold">Tahun</th>
            <th class="px-5 py-3 font-semibold">Unduhan</th>
            <th class="px-5 py-3 font-semibold">Status</th>
            <th class="px-5 py-3 text-right font-semibold">Aksi</th>
        </x-slot>
        @forelse ($items as $item)
            <tr class="transition-colors hover:bg-paper2/50">
                <td class="px-5 py-3.5">
                    <div class="flex items-center gap-3">
                        <span class="grid h-9 w-9 place-items-center rounded-lg bg-danger/10 text-danger"><x-admin.icon name="file-text" class="h-4 w-4" /></span>
                        <span class="font-semibold text-navy-900">{{ $item->title }}</span>
                    </div>
                </td>
                <td class="px-5 py-3.5"><x-admin.badge>{{ $item->category?->name ?? '—' }}</x-admin.badge></td>
                <td class="px-5 py-3.5 text-slate-500">{{ $item->year }}</td>
                <td class="px-5 py-3.5 text-slate-500">{{ number_format($item->download_count, 0, ',', '.') }}×</td>
                <td class="px-5 py-3.5"><x-admin.badge :type="$item->is_active ? 'ok' : 'off'" dot>{{ $item->is_active ? 'Aktif' : 'Nonaktif' }}</x-admin.badge></td>
                <td class="px-5 py-3.5">
                    <div class="flex items-center justify-end gap-1">
                        <x-admin.btn variant="ghost" size="icon" :href="route('panel.documents.edit', $item->id)"><x-admin.icon name="edit" class="h-4 w-4" /></x-admin.btn>
                        <button @click="$dispatch('open-modal-delete', { label: @js($item->title), url: @js(route('panel.documents.destroy', $item->id)) })" class="rounded-lg p-2 text-danger transition-colors hover:bg-danger/10"><x-admin.icon name="trash" class="h-4 w-4" /></button>
                    </div>
                </td>
            </tr>
        @empty
            <tr><td colspan="6" class="px-5 py-10 text-center text-sm text-slate-500">Belum ada dokumen.</td></tr>
        @endforelse
        <x-slot name="footer"><x-admin.pagination :paginator="$items" /></x-slot>
    </x-admin.data-table>

    <x-admin.modal name="delete" title="Hapus Dokumen" message="Dokumen berikut akan dihapus:" />
@endsection
