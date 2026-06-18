@extends('admin.layouts.admin')
@section('title', 'Portofolio')

@section('content')
    <x-admin.page-header eyebrow="Konten Profil" title="Kelola Portofolio" subtitle="Proyek IT, Interior & Sipil." :breadcrumb="['Portofolio' => null]">
        <x-admin.btn variant="accent" :href="route('panel.projects.create')"><x-admin.icon name="plus" class="h-4 w-4" />Tambah Proyek</x-admin.btn>
    </x-admin.page-header>

    <x-admin.data-table>
        <x-slot name="toolbar">
            <form method="GET">
                <x-admin.table-toolbar placeholder="Cari proyek…">
                    <x-slot name="filters">
                        <select name="division" onchange="this.form.submit()" class="appearance-none rounded-lg border border-line bg-card py-2 pl-3 pr-8 text-sm text-slate-600 focus:border-brass-500 focus:ring-2 focus:ring-brass-500/20">
                            <option value="">Semua Divisi</option>
                            <option value="it" @selected(request('division')==='it')>IT</option>
                            <option value="interior" @selected(request('division')==='interior')>Interior</option>
                            <option value="sipil" @selected(request('division')==='sipil')>Sipil</option>
                        </select>
                        <select name="year" onchange="this.form.submit()" class="appearance-none rounded-lg border border-line bg-card py-2 pl-3 pr-8 text-sm text-slate-600 focus:border-brass-500 focus:ring-2 focus:ring-brass-500/20">
                            <option value="">Semua Tahun</option>
                            @foreach ($years as $year)
                                <option value="{{ $year }}" @selected((string) request('year') === (string) $year)>{{ $year }}</option>
                            @endforeach
                        </select>
                        <select name="featured" onchange="this.form.submit()" class="appearance-none rounded-lg border border-line bg-card py-2 pl-3 pr-8 text-sm text-slate-600 focus:border-brass-500 focus:ring-2 focus:ring-brass-500/20">
                            <option value="">Semua Proyek</option>
                            <option value="1" @selected(request('featured')==='1')>Unggulan</option>
                            <option value="0" @selected(request('featured')==='0')>Non-unggulan</option>
                        </select>
                    </x-slot>
                </x-admin.table-toolbar>
            </form>
        </x-slot>
        <x-slot name="head">
            <th class="px-5 py-3 font-semibold">Proyek &amp; Klien</th>
            <th class="px-5 py-3 font-semibold">Divisi</th>
            <th class="px-5 py-3 font-semibold">Tahun</th>
            <th class="px-5 py-3 font-semibold">Status</th>
            <th class="px-5 py-3 text-right font-semibold">Aksi</th>
        </x-slot>
        @forelse ($items as $item)
            <tr class="transition-colors hover:bg-paper2/50">
                <td class="px-5 py-3.5">
                    <div class="flex items-center gap-2">
                        <span class="font-semibold text-navy-900">{{ $item->title }}</span>
                        @if ($item->is_featured)<x-admin.badge type="warning">Unggulan</x-admin.badge>@endif
                    </div>
                    <span class="text-xs text-slate-500">{{ $item->client?->name ?? '—' }}</span>
                </td>
                <td class="px-5 py-3.5"><x-admin.badge :type="$item->division" dot>{{ strtoupper($item->division) }}</x-admin.badge></td>
                <td class="px-5 py-3.5 text-slate-500">{{ $item->year }}</td>
                <td class="px-5 py-3.5"><x-admin.badge :type="$item->is_active ? 'ok' : 'off'" dot>{{ $item->is_active ? 'Aktif' : 'Nonaktif' }}</x-admin.badge></td>
                <td class="px-5 py-3.5">
                    <div class="flex items-center justify-end gap-1">
                        <x-admin.btn variant="ghost" size="icon" :href="route('panel.projects.edit', $item->id)"><x-admin.icon name="edit" class="h-4 w-4" /></x-admin.btn>
                        <button @click="$dispatch('open-modal-delete', { label: @js($item->title), url: @js(route('panel.projects.destroy', $item->id)) })" class="rounded-lg p-2 text-danger transition-colors hover:bg-danger/10"><x-admin.icon name="trash" class="h-4 w-4" /></button>
                    </div>
                </td>
            </tr>
        @empty
            <tr><td colspan="5" class="px-5 py-10 text-center text-sm text-slate-500">Belum ada proyek.</td></tr>
        @endforelse
        <x-slot name="footer"><x-admin.pagination :paginator="$items" /></x-slot>
    </x-admin.data-table>

    <x-admin.modal name="delete" title="Hapus Proyek" message="Proyek berikut akan dihapus permanen:" />
@endsection
