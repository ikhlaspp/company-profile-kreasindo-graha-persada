@extends('admin.layouts.admin')
@section('title', 'Log Chatbot')

@section('content')
    <x-admin.page-header eyebrow="Chatbot" title="Log Chatbot" subtitle="Riwayat percakapan pengunjung (read-only)." :breadcrumb="['Log Chatbot' => null]" />

    <x-admin.data-table>
        <x-slot name="toolbar">
            <form method="GET">
                <x-admin.table-toolbar placeholder="Cari sesi…" />
            </form>
        </x-slot>
        <x-slot name="head">
            <th class="px-5 py-3 font-semibold">Sesi</th>
            <th class="px-5 py-3 font-semibold">IP</th>
            <th class="px-5 py-3 font-semibold">Mulai</th>
            <th class="px-5 py-3 font-semibold">Aktivitas Akhir</th>
            <th class="px-5 py-3 font-semibold">Pesan</th>
            <th class="px-5 py-3 text-right font-semibold">Aksi</th>
        </x-slot>
        @forelse ($conversations as $c)
            <tr class="cursor-pointer transition-colors hover:bg-paper2/50" onclick="window.location='{{ route('panel.chatlogs.show', $c->id) }}'">
                <td class="px-5 py-3.5"><span class="rounded bg-paper2 px-2 py-0.5 font-mono text-xs font-semibold text-navy-800">#{{ \Illuminate\Support\Str::substr($c->session_id, 0, 8) }}</span></td>
                <td class="px-5 py-3.5 text-slate-500">{{ $c->visitor_ip ?? '—' }}</td>
                <td class="px-5 py-3.5 text-xs text-slate-500">{{ optional($c->started_at)->format('d M, H:i') ?? '—' }}</td>
                <td class="px-5 py-3.5 text-xs text-slate-500">{{ optional($c->last_activity_at)->format('d M, H:i') ?? '—' }}</td>
                <td class="px-5 py-3.5"><x-admin.badge>{{ $c->logs_count }} pesan</x-admin.badge></td>
                <td class="px-5 py-3.5 text-right">
                    <x-admin.btn variant="ghost" size="icon" :href="route('panel.chatlogs.show', $c->id)"><x-admin.icon name="eye" class="h-4 w-4" /></x-admin.btn>
                </td>
            </tr>
        @empty
            <tr><td colspan="6" class="px-5 py-10 text-center text-sm text-slate-500">Belum ada percakapan.</td></tr>
        @endforelse
        <x-slot name="footer"><x-admin.pagination :paginator="$conversations" /></x-slot>
    </x-admin.data-table>
@endsection
