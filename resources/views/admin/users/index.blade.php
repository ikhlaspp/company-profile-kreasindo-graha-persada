@extends('admin.layouts.admin')
@section('title', 'Admin & Users')

@php $roleMap = ['superadmin'=>['warning','Superadmin'],'admin'=>['it','Admin'],'editor'=>['info','Editor']]; @endphp

@section('content')
    <x-admin.page-header eyebrow="Sistem" title="Admin & Users" subtitle="Manajemen akun pengelola." :breadcrumb="['Admin & Users' => null]">
        <x-admin.btn variant="accent" :href="route('panel.users.create')"><x-admin.icon name="plus" class="h-4 w-4" />Tambah Admin</x-admin.btn>
    </x-admin.page-header>

    <x-admin.data-table>
        <x-slot name="head">
            <th class="px-5 py-3 font-semibold">Nama</th>
            <th class="px-5 py-3 font-semibold">Email</th>
            <th class="px-5 py-3 font-semibold">Role</th>
            <th class="px-5 py-3 font-semibold">Status</th>
            <th class="px-5 py-3 text-right font-semibold">Aksi</th>
        </x-slot>
        @forelse ($items as $item)
            <tr class="transition-colors hover:bg-paper2/50">
                <td class="px-5 py-3.5">
                    <div class="flex items-center gap-3">
                        <span class="grid h-9 w-9 place-items-center rounded-full bg-navy-800 text-xs font-semibold text-white">{{ strtoupper(\Illuminate\Support\Str::substr($item->name,0,2)) }}</span>
                        <span class="font-semibold text-navy-900">{{ $item->name }}</span>
                    </div>
                </td>
                <td class="px-5 py-3.5 text-slate-500">{{ $item->email }}</td>
                <td class="px-5 py-3.5"><x-admin.badge :type="$roleMap[$item->role][0] ?? 'info'">{{ $roleMap[$item->role][1] ?? $item->role }}</x-admin.badge></td>
                <td class="px-5 py-3.5"><x-admin.badge :type="$item->is_active ? 'ok' : 'off'" dot>{{ $item->is_active ? 'Aktif' : 'Nonaktif' }}</x-admin.badge></td>
                <td class="px-5 py-3.5">
                    <div class="flex items-center justify-end gap-1">
                        <x-admin.btn variant="ghost" size="icon" :href="route('panel.users.edit', $item->id)"><x-admin.icon name="edit" class="h-4 w-4" /></x-admin.btn>
                        <button @click="$dispatch('open-modal-delete', { label: @js($item->name), url: @js(route('panel.users.destroy', $item->id)) })" class="rounded-lg p-2 text-danger transition-colors hover:bg-danger/10"><x-admin.icon name="trash" class="h-4 w-4" /></button>
                    </div>
                </td>
            </tr>
        @empty
            <tr><td colspan="5" class="px-5 py-10 text-center text-sm text-slate-500">Belum ada admin.</td></tr>
        @endforelse
    </x-admin.data-table>

    <div class="mt-6"><x-admin.pagination :paginator="$items" /></div>

    <x-admin.modal name="delete" title="Hapus Admin" message="Akun berikut akan dihapus:" />
@endsection
