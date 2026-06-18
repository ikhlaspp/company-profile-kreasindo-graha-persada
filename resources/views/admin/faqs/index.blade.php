@extends('admin.layouts.admin')
@section('title', 'FAQ Chatbot')

@section('content')
    <x-admin.page-header eyebrow="Chatbot" title="FAQ Chatbot" subtitle="Basis pengetahuan untuk chatbot." :breadcrumb="['FAQ Chatbot' => null]">
        <x-admin.btn variant="accent" :href="route('panel.faqs.create')"><x-admin.icon name="plus" class="h-4 w-4" />Tambah FAQ</x-admin.btn>
    </x-admin.page-header>

    <x-admin.data-table>
        <x-slot name="toolbar">
            <form method="GET">
                <x-admin.table-toolbar placeholder="Cari pertanyaan…" />
            </form>
        </x-slot>
        <x-slot name="head">
            <th class="px-5 py-3 font-semibold">Pertanyaan</th>
            <th class="px-5 py-3 font-semibold">Popularitas</th>
            <th class="px-5 py-3 font-semibold">Status</th>
            <th class="px-5 py-3 text-right font-semibold">Aksi</th>
        </x-slot>
        @forelse ($items as $item)
            <tr class="transition-colors hover:bg-paper2/50">
                <td class="px-5 py-3.5 font-semibold text-navy-900">{{ $item->question }}</td>
                <td class="px-5 py-3.5"><span class="inline-flex items-center gap-1.5 text-sm text-slate-500"><x-admin.icon name="spark" class="h-4 w-4 text-brass-500" />{{ number_format($item->hit_count, 0, ',', '.') }} hit</span></td>
                <td class="px-5 py-3.5"><x-admin.badge :type="$item->is_active ? 'ok' : 'off'" dot>{{ $item->is_active ? 'Aktif' : 'Nonaktif' }}</x-admin.badge></td>
                <td class="px-5 py-3.5">
                    <div class="flex items-center justify-end gap-1">
                        <x-admin.btn variant="ghost" size="icon" :href="route('panel.faqs.edit', $item->id)"><x-admin.icon name="edit" class="h-4 w-4" /></x-admin.btn>
                        <button @click="$dispatch('open-modal-delete', { label: @js($item->question), url: @js(route('panel.faqs.destroy', $item->id)) })" class="rounded-lg p-2 text-danger transition-colors hover:bg-danger/10"><x-admin.icon name="trash" class="h-4 w-4" /></button>
                    </div>
                </td>
            </tr>
        @empty
            <tr><td colspan="4" class="px-5 py-10 text-center text-sm text-slate-500">Belum ada FAQ.</td></tr>
        @endforelse
        <x-slot name="footer"><x-admin.pagination :paginator="$items" /></x-slot>
    </x-admin.data-table>

    <x-admin.modal name="delete" title="Hapus FAQ" message="FAQ berikut akan dihapus:" />
@endsection
