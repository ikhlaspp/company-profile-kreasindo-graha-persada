@extends('admin.layouts.admin')
@section('title', 'Pesan Masuk')

@section('content')
    <x-admin.page-header eyebrow="Komunikasi" title="Pesan Masuk"
        subtitle="Pesan dari formulir kontak pengunjung."
        :breadcrumb="['Pesan Masuk' => null]" />

    <x-admin.data-table>
        <x-slot name="toolbar">
            <form method="GET">
                <x-admin.table-toolbar placeholder="Cari nama, email, atau isi pesan…">
                    <x-slot name="filters">
                        <select name="status" onchange="this.form.submit()"
                            class="rounded-lg border border-line bg-paper2/50 py-2 pl-3 pr-8 text-sm text-navy-900 focus:border-brass-500 focus:ring-2 focus:ring-brass-500/20">
                            <option value="">Semua status</option>
                            <option value="unread" @selected(request('status') === 'unread')>Belum dibaca ({{ $unreadCount }})</option>
                        </select>
                    </x-slot>
                </x-admin.table-toolbar>
            </form>
        </x-slot>
        <x-slot name="head">
            <th class="px-5 py-3 font-semibold">Pengirim</th>
            <th class="px-5 py-3 font-semibold">Kontak</th>
            <th class="px-5 py-3 font-semibold">Pesan</th>
            <th class="px-5 py-3 font-semibold">Tanggal</th>
            <th class="px-5 py-3 font-semibold">Status</th>
            <th class="px-5 py-3 text-right font-semibold">Aksi</th>
        </x-slot>
        @forelse ($items as $item)
            <tr class="cursor-pointer transition-colors hover:bg-paper2/50 {{ $item->is_read ? '' : 'bg-brass-50/40' }}"
                onclick="window.location='{{ route('panel.messages.show', $item->id) }}'">
                <td class="px-5 py-3.5">
                    <p class="font-semibold text-navy-900">{{ $item->name }}</p>
                    @if ($item->company)<p class="text-xs text-slate-500">{{ $item->company }}</p>@endif
                </td>
                <td class="px-5 py-3.5 text-xs text-slate-500">
                    <p>{{ $item->email }}</p>
                    <p>{{ $item->phone }}</p>
                </td>
                <td class="px-5 py-3.5 max-w-xs text-slate-600">{{ \Illuminate\Support\Str::limit($item->message, 70) }}</td>
                <td class="px-5 py-3.5 text-xs text-slate-500">{{ $item->created_at?->format('d M Y, H:i') ?? '—' }}</td>
                <td class="px-5 py-3.5">
                    @if ($item->is_read)
                        <span class="inline-flex items-center rounded-full bg-paper2 px-2 py-0.5 text-xs font-medium text-slate-500">Dibaca</span>
                    @else
                        <span class="inline-flex items-center gap-1 rounded-full bg-brass-100 px-2 py-0.5 text-xs font-semibold text-brass-700"><span class="h-1.5 w-1.5 rounded-full bg-brass-500"></span>Baru</span>
                    @endif
                </td>
                <td class="px-5 py-3.5 text-right" onclick="event.stopPropagation()">
                    <div class="flex items-center justify-end gap-1">
                        <x-admin.btn variant="ghost" size="icon" :href="route('panel.messages.show', $item->id)"><x-admin.icon name="eye" class="h-4 w-4" /></x-admin.btn>
                        <button type="button" @click="$dispatch('open-modal-delete', { label: @js($item->name), url: @js(route('panel.messages.destroy', $item->id)) })" class="rounded-lg p-2 text-danger transition-colors hover:bg-danger/10"><x-admin.icon name="trash" class="h-4 w-4" /></button>
                    </div>
                </td>
            </tr>
        @empty
            <tr><td colspan="6" class="px-5 py-10 text-center text-sm text-slate-500">Belum ada pesan masuk.</td></tr>
        @endforelse
        <x-slot name="footer"><x-admin.pagination :paginator="$items" /></x-slot>
    </x-admin.data-table>

    <x-admin.modal name="delete" title="Hapus Pesan" message="Pesan dari pengirim berikut akan dihapus permanen:" />
@endsection
