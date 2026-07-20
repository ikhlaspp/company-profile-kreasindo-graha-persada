@extends('admin.layouts.admin')
@section('title', 'Detail Pesan')

@php
    $serviceLabels = [
        'it' => 'IT — Software, Hardware & Jaringan',
        'interior' => 'Interior & Furniture',
        'me' => 'Mekanikal & Elektrikal',
        'lainnya' => 'Lainnya / Konsultasi Umum',
    ];
    $waDigits = preg_replace('/\D/', '', $item->phone ?? '');
    $wa = \Illuminate\Support\Str::startsWith($waDigits, '0') ? '62'.substr($waDigits, 1) : $waDigits;
    $mailSubject = rawurlencode('Balasan dari PT. Kreasindo Graha Persada');
@endphp

@section('content')
    <x-admin.page-header title="Detail Pesan"
        :breadcrumb="['Pesan Masuk' => route('panel.messages.index'), $item->name => null]">
        <x-admin.btn variant="ghost" size="sm" :href="route('panel.messages.index')">Kembali</x-admin.btn>
    </x-admin.page-header>

    <div class="grid grid-cols-1 gap-6 lg:grid-cols-3">
        {{-- Message body --}}
        <div class="lg:col-span-2">
            <div class="rounded-xl border border-line bg-card p-6 shadow-sm">
                <p class="mb-2 text-[11px] font-semibold uppercase tracking-wider text-slate-500">Isi Pesan</p>
                <p class="whitespace-pre-line font-sans text-sm leading-relaxed text-navy-900">{{ $item->message }}</p>
            </div>
        </div>

        {{-- Sender info + actions --}}
        <div class="space-y-6">
            <div class="rounded-xl border border-line bg-card p-5 shadow-sm">
                <h2 class="font-display text-base font-semibold text-navy-900">Info Pengirim</h2>
                <dl class="mt-4 space-y-2.5 text-sm">
                    <div class="flex justify-between gap-3"><dt class="text-slate-500">Nama</dt><dd class="text-right font-semibold text-navy-800">{{ $item->name }}</dd></div>
                    <div class="flex justify-between gap-3"><dt class="text-slate-500">Instansi</dt><dd class="text-right text-slate-600">{{ $item->company ?: '—' }}</dd></div>
                    <div class="flex justify-between gap-3"><dt class="text-slate-500">Email</dt><dd class="text-right text-slate-600 break-all">{{ $item->email }}</dd></div>
                    <div class="flex justify-between gap-3"><dt class="text-slate-500">Telepon</dt><dd class="text-right text-slate-600">{{ $item->phone }}</dd></div>
                    <div class="flex justify-between gap-3"><dt class="text-slate-500">Minat Layanan</dt><dd class="text-right text-slate-600">{{ $serviceLabels[$item->service_interest] ?? '—' }}</dd></div>
                    <div class="flex justify-between gap-3"><dt class="text-slate-500">Dikirim</dt><dd class="text-right text-slate-600">{{ $item->created_at?->format('d M Y, H:i') ?? '—' }}</dd></div>
                    <div class="flex justify-between gap-3"><dt class="text-slate-500">IP</dt><dd class="text-right text-slate-600">{{ $item->ip_address ?? '—' }}</dd></div>
                </dl>
            </div>

            <div class="rounded-xl border border-line bg-card p-5 shadow-sm">
                <h2 class="mb-4 font-display text-base font-semibold text-navy-900">Tindakan</h2>
                <div class="space-y-2">
                    <x-admin.btn variant="primary" class="w-full justify-center" :href="'mailto:'.$item->email.'?subject='.$mailSubject">
                        <x-admin.icon name="mail" class="h-4 w-4" />Balas via Email
                    </x-admin.btn>
                    @if ($wa)
                        <a href="https://wa.me/{{ $wa }}" target="_blank" rel="noopener"
                           class="flex w-full items-center justify-center gap-2 rounded-lg border border-success/40 bg-success/10 px-4 py-2 text-sm font-semibold text-success transition-colors hover:bg-success/20">
                            <x-admin.icon name="message" class="h-4 w-4" />Hubungi via WhatsApp
                        </a>
                    @endif
                    <button type="button" @click="$dispatch('open-modal-delete', { label: @js($item->name), url: @js(route('panel.messages.destroy', $item->id)) })"
                        class="flex w-full items-center justify-center gap-2 rounded-lg border border-danger/30 px-4 py-2 text-sm font-semibold text-danger transition-colors hover:bg-danger/10">
                        <x-admin.icon name="trash" class="h-4 w-4" />Hapus Pesan
                    </button>
                </div>
            </div>
        </div>
    </div>

    <x-admin.modal name="delete" title="Hapus Pesan" message="Pesan dari pengirim berikut akan dihapus permanen:" />
@endsection
