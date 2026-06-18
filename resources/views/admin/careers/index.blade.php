@extends('admin.layouts.admin')
@section('title', 'Karir')

@php $typeLabel = ['full_time'=>'Full-time','part_time'=>'Part-time','contract'=>'Kontrak','internship'=>'Magang']; @endphp

@section('content')
    <x-admin.page-header eyebrow="Publikasi" title="Kelola Karir" subtitle="Lowongan pekerjaan." :breadcrumb="['Karir' => null]">
        <x-admin.btn variant="accent" :href="route('panel.careers.create')"><x-admin.icon name="plus" class="h-4 w-4" />Tambah Lowongan</x-admin.btn>
    </x-admin.page-header>

    <x-admin.data-table>
        <x-slot name="head">
            <th class="px-5 py-3 font-semibold">Posisi</th>
            <th class="px-5 py-3 font-semibold">Divisi</th>
            <th class="px-5 py-3 font-semibold">Tipe</th>
            <th class="px-5 py-3 font-semibold">Lokasi</th>
            <th class="px-5 py-3 font-semibold">Deadline</th>
            <th class="px-5 py-3 font-semibold">Status</th>
            <th class="px-5 py-3 text-right font-semibold">Aksi</th>
        </x-slot>
        @forelse ($items as $item)
            <tr class="transition-colors hover:bg-paper2/50">
                <td class="px-5 py-3.5 font-semibold text-navy-900">{{ $item->title }}</td>
                <td class="px-5 py-3.5"><x-admin.badge :type="$item->division" dot>{{ strtoupper($item->division) }}</x-admin.badge></td>
                <td class="px-5 py-3.5 text-slate-500">{{ $typeLabel[$item->employment_type] ?? $item->employment_type }}</td>
                <td class="px-5 py-3.5 text-slate-500">{{ $item->location }}</td>
                <td class="px-5 py-3.5 text-xs text-slate-500">{{ optional($item->deadline)->format('d M Y') ?? '—' }}</td>
                <td class="px-5 py-3.5"><x-admin.badge :type="$item->is_active ? 'ok' : 'off'" dot>{{ $item->is_active ? 'Dibuka' : 'Ditutup' }}</x-admin.badge></td>
                <td class="px-5 py-3.5">
                    <div class="flex items-center justify-end gap-1">
                        <x-admin.btn variant="ghost" size="icon" :href="route('panel.careers.edit', $item->id)"><x-admin.icon name="edit" class="h-4 w-4" /></x-admin.btn>
                        <button @click="$dispatch('open-modal-delete', { label: @js($item->title), url: @js(route('panel.careers.destroy', $item->id)) })" class="rounded-lg p-2 text-danger transition-colors hover:bg-danger/10"><x-admin.icon name="trash" class="h-4 w-4" /></button>
                    </div>
                </td>
            </tr>
        @empty
            <tr><td colspan="7" class="px-5 py-10 text-center text-sm text-slate-500">Belum ada lowongan.</td></tr>
        @endforelse
    </x-admin.data-table>

    <div class="mt-6"><x-admin.pagination :paginator="$items" /></div>

    <x-admin.modal name="delete" title="Hapus Lowongan" message="Lowongan berikut akan dihapus:" />
@endsection
