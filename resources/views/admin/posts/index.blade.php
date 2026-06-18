@extends('admin.layouts.admin')
@section('title', 'Berita')

@php $statusMap = ['published'=>['publish','Terbit'],'draft'=>['draft','Draft'],'archived'=>['archived','Arsip']]; @endphp

@section('content')
    <x-admin.page-header eyebrow="Publikasi" title="Kelola Berita" subtitle="Artikel & publikasi." :breadcrumb="['Berita' => null]">
        <x-admin.btn variant="outline" :href="route('panel.post-categories.index')"><x-admin.icon name="folder" class="h-4 w-4" />Kategori</x-admin.btn>
        <x-admin.btn variant="outline" :href="route('panel.tags.index')"><x-admin.icon name="tag" class="h-4 w-4" />Tag</x-admin.btn>
        <x-admin.btn variant="accent" :href="route('panel.posts.create')"><x-admin.icon name="plus" class="h-4 w-4" />Tulis Berita</x-admin.btn>
    </x-admin.page-header>

    <x-admin.data-table>
        <x-slot name="toolbar">
            <form method="GET">
                <x-admin.table-toolbar placeholder="Cari judul berita…">
                    <x-slot name="filters">
                        <select name="status" onchange="this.form.submit()" class="appearance-none rounded-lg border border-line bg-card py-2 pl-3 pr-8 text-sm text-slate-600 focus:border-brass-500 focus:ring-2 focus:ring-brass-500/20">
                            <option value="">Semua Status</option>
                            <option value="published" @selected(request('status')==='published')>Terbit</option>
                            <option value="draft" @selected(request('status')==='draft')>Draft</option>
                            <option value="archived" @selected(request('status')==='archived')>Arsip</option>
                        </select>
                    </x-slot>
                </x-admin.table-toolbar>
            </form>
        </x-slot>
        <x-slot name="head">
            <th class="px-5 py-3 font-semibold">Judul</th>
            <th class="px-5 py-3 font-semibold">Kategori</th>
            <th class="px-5 py-3 font-semibold">Penulis</th>
            <th class="px-5 py-3 font-semibold">Terbit</th>
            <th class="px-5 py-3 font-semibold">Status</th>
            <th class="px-5 py-3 text-right font-semibold">Aksi</th>
        </x-slot>
        @forelse ($items as $item)
            <tr class="transition-colors hover:bg-paper2/50">
                <td class="px-5 py-3.5"><span class="font-semibold text-navy-900">{{ $item->title }}</span></td>
                <td class="px-5 py-3.5"><x-admin.badge>{{ $item->category?->name ?? '—' }}</x-admin.badge></td>
                <td class="px-5 py-3.5 text-slate-500">{{ $item->author?->name ?? '—' }}</td>
                <td class="px-5 py-3.5 text-xs text-slate-500">{{ optional($item->published_at)->format('d M Y') ?? '—' }}</td>
                <td class="px-5 py-3.5"><x-admin.badge :type="$statusMap[$item->status][0]" dot>{{ $statusMap[$item->status][1] }}</x-admin.badge></td>
                <td class="px-5 py-3.5">
                    <div class="flex items-center justify-end gap-1">
                        <x-admin.btn variant="ghost" size="icon" :href="route('panel.posts.edit', $item->id)"><x-admin.icon name="edit" class="h-4 w-4" /></x-admin.btn>
                        <button @click="$dispatch('open-modal-delete', { label: @js($item->title), url: @js(route('panel.posts.destroy', $item->id)) })" class="rounded-lg p-2 text-danger transition-colors hover:bg-danger/10"><x-admin.icon name="trash" class="h-4 w-4" /></button>
                    </div>
                </td>
            </tr>
        @empty
            <tr><td colspan="6" class="px-5 py-10 text-center text-sm text-slate-500">Belum ada berita.</td></tr>
        @endforelse
        <x-slot name="footer"><x-admin.pagination :paginator="$items" /></x-slot>
    </x-admin.data-table>

    <x-admin.modal name="delete" title="Hapus Berita" message="Artikel berikut akan dihapus:" />
@endsection
