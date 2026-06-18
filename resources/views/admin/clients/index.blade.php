@extends('admin.layouts.admin')
@section('title', 'Klien')

@php $catLabel = ['militer'=>'Militer','pemerintah'=>'Pemerintah','bumn'=>'BUMN','swasta'=>'Swasta']; @endphp

@section('content')
    <x-admin.page-header eyebrow="Konten Profil" title="Kelola Klien" subtitle="Logo & kategori klien." :breadcrumb="['Klien' => null]">
        <x-admin.btn variant="accent" :href="route('panel.clients.create')"><x-admin.icon name="plus" class="h-4 w-4" />Tambah Klien</x-admin.btn>
    </x-admin.page-header>

    <x-admin.data-table>
        <x-slot name="toolbar">
            <form method="GET">
                <x-admin.table-toolbar placeholder="Cari klien…">
                    <x-slot name="filters">
                        <select name="category" onchange="this.form.submit()" class="appearance-none rounded-lg border border-line bg-card py-2 pl-3 pr-8 text-sm text-slate-600 focus:border-brass-500 focus:ring-2 focus:ring-brass-500/20">
                            <option value="">Semua Kategori</option>
                            @foreach ($catLabel as $val => $label)
                                <option value="{{ $val }}" @selected(request('category')===$val)>{{ $label }}</option>
                            @endforeach
                        </select>
                    </x-slot>
                </x-admin.table-toolbar>
            </form>
        </x-slot>
        <x-slot name="head">
            <th class="px-5 py-3 font-semibold">Klien</th>
            <th class="px-5 py-3 font-semibold">Kategori</th>
            <th class="px-5 py-3 font-semibold">Website</th>
            <th class="px-5 py-3 font-semibold">Status</th>
            <th class="px-5 py-3 text-right font-semibold">Aksi</th>
        </x-slot>
        @forelse ($items as $item)
            <tr class="transition-colors hover:bg-paper2/50">
                <td class="px-5 py-3.5">
                    <div class="flex items-center gap-3">
                        <span class="grid h-9 w-9 place-items-center rounded-lg bg-paper2 text-xs font-bold text-slate-500 ring-1 ring-line">{{ strtoupper(\Illuminate\Support\Str::substr($item->name,0,2)) }}</span>
                        <span class="font-semibold text-navy-900">{{ $item->name }}</span>
                    </div>
                </td>
                <td class="px-5 py-3.5"><x-admin.badge type="info">{{ $catLabel[$item->category] ?? $item->category }}</x-admin.badge></td>
                <td class="px-5 py-3.5 text-slate-500">{{ $item->website }}</td>
                <td class="px-5 py-3.5"><x-admin.badge :type="$item->is_active ? 'ok' : 'off'" dot>{{ $item->is_active ? 'Aktif' : 'Nonaktif' }}</x-admin.badge></td>
                <td class="px-5 py-3.5">
                    <div class="flex items-center justify-end gap-1">
                        <x-admin.btn variant="ghost" size="icon" :href="route('panel.clients.edit', $item->id)"><x-admin.icon name="edit" class="h-4 w-4" /></x-admin.btn>
                        <button @click="$dispatch('open-modal-delete', { label: @js($item->name), url: @js(route('panel.clients.destroy', $item->id)) })" class="rounded-lg p-2 text-danger transition-colors hover:bg-danger/10"><x-admin.icon name="trash" class="h-4 w-4" /></button>
                    </div>
                </td>
            </tr>
        @empty
            <tr><td colspan="5" class="px-5 py-10 text-center text-sm text-slate-500">Belum ada klien.</td></tr>
        @endforelse
        <x-slot name="footer"><x-admin.pagination :paginator="$items" /></x-slot>
    </x-admin.data-table>

    <x-admin.modal name="delete" title="Hapus Klien" message="Klien berikut akan dihapus:" />
@endsection
