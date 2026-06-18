@extends('admin.layouts.admin')
@section('title', 'Dashboard')

@section('content')
    <x-admin.page-header title="Dashboard" subtitle="Ringkasan aktivitas dan konten KGP.">
        <x-admin.btn variant="outline" :href="route('home')"><x-admin.icon name="external" class="h-4 w-4" />Lihat Situs</x-admin.btn>
        @if (auth()->user()?->hasRole('admin'))
            <x-admin.btn variant="accent" :href="route('panel.projects.create')"><x-admin.icon name="plus" class="h-4 w-4" />Tambah Konten</x-admin.btn>
        @elseif (auth()->user()?->hasRole('editor'))
            <x-admin.btn variant="accent" :href="route('panel.posts.create')"><x-admin.icon name="plus" class="h-4 w-4" />Tambah Berita</x-admin.btn>
        @endif
    </x-admin.page-header>

    <div class="grid grid-cols-2 gap-4 lg:grid-cols-3 xl:grid-cols-6">
        @foreach ($stats as $s)
            <x-admin.stat-card :label="$s['label']" :value="$s['value']" :icon="$s['icon']" />
        @endforeach
    </div>

    <div class="mt-6 grid grid-cols-1 gap-6 lg:grid-cols-3">
        {{-- Recent activity --}}
        <div class="lg:col-span-2">
            <x-admin.data-table>
                <x-slot name="toolbar">
                    <div class="flex items-center justify-between">
                        <h2 class="font-display text-base font-semibold text-navy-900">Aktivitas Terbaru</h2>
                        <a href="{{ route('panel.posts.index') }}" class="text-xs font-semibold text-brass-700 hover:text-brass-500">Lihat semua</a>
                    </div>
                </x-slot>
                <x-slot name="head">
                    <th class="px-5 py-3 font-semibold">Konten</th>
                    <th class="px-5 py-3 font-semibold">Tipe</th>
                    <th class="px-5 py-3 font-semibold">Waktu</th>
                    <th class="px-5 py-3 font-semibold">Status</th>
                </x-slot>
                @foreach ($recentActivity as $a)
                    <tr class="transition-colors hover:bg-paper2/50">
                        <td class="px-5 py-3.5"><span class="font-semibold text-navy-900">{{ $a['title'] }}</span></td>
                        <td class="px-5 py-3.5"><x-admin.badge :type="$a['badge']" dot>{{ $a['type'] }}</x-admin.badge></td>
                        <td class="px-5 py-3.5 text-xs text-slate-500">{{ $a['time'] }}</td>
                        <td class="px-5 py-3.5"><x-admin.badge :type="$a['status']">{{ $a['statusLabel'] }}</x-admin.badge></td>
                    </tr>
                @endforeach
            </x-admin.data-table>
        </div>

        {{-- Chatbot source breakdown --}}
        <div class="rounded-xl border border-line bg-card p-5 shadow-sm">
            <h2 class="font-display text-base font-semibold text-navy-900">Sumber Jawaban Chatbot</h2>
            <p class="mt-0.5 text-xs text-slate-500">Dari {{ number_format($chatbotSourceBreakdown['total'], 0, ',', '.') }} interaksi terakhir</p>

            @php
                $donut = [['faq', $chatbotSourceBreakdown['faq'], '#2F8F63'], ['gemini', $chatbotSourceBreakdown['gemini'], '#2563C9'], ['grok', $chatbotSourceBreakdown['grok'], '#A855F7']];
                $donutCum = 0;
            @endphp
            <div class="mt-5 flex items-center justify-center">
                <div class="relative h-36 w-36">
                    <svg class="h-full w-full -rotate-90" viewBox="0 0 36 36">
                        <circle cx="18" cy="18" r="15.9" fill="none" stroke="#E4E1D8" stroke-width="3.5" pathLength="100"/>
                        @foreach ($donut as [$key, $val, $color])
                            @if ($val > 0)
                                <circle cx="18" cy="18" r="15.9" fill="none" stroke="{{ $color }}" stroke-width="3.5" pathLength="100"
                                        stroke-dasharray="{{ $val }} {{ 100 - $val }}" stroke-dashoffset="{{ -$donutCum }}"/>
                                @php $donutCum += $val; @endphp
                            @endif
                        @endforeach
                    </svg>
                    <div class="absolute inset-0 flex flex-col items-center justify-center">
                        <span class="tabular font-display text-2xl font-semibold text-navy-900">{{ number_format($chatbotSourceBreakdown['total'], 0, ',', '.') }}</span>
                        <span class="text-[10px] font-semibold uppercase tracking-wider text-slate-500">Interaksi</span>
                    </div>
                </div>
            </div>

            <div class="mt-5 space-y-3">
                <div class="flex items-center justify-between text-sm">
                    <span class="flex items-center gap-2 text-slate-600"><span class="h-2.5 w-2.5 rounded-full bg-success"></span>FAQ Internal</span>
                    <span class="font-semibold text-navy-900">{{ $chatbotSourceBreakdown['faq'] }}%</span>
                </div>
                <div class="flex items-center justify-between text-sm">
                    <span class="flex items-center gap-2 text-slate-600"><span class="h-2.5 w-2.5 rounded-full bg-info"></span>AI Gemini</span>
                    <span class="font-semibold text-navy-900">{{ $chatbotSourceBreakdown['gemini'] }}%</span>
                </div>
                <div class="flex items-center justify-between text-sm">
                    <span class="flex items-center gap-2 text-slate-600"><span class="h-2.5 w-2.5 rounded-full bg-purple-500"></span>AI Grok</span>
                    <span class="font-semibold text-navy-900">{{ $chatbotSourceBreakdown['grok'] }}%</span>
                </div>
            </div>

            <x-admin.btn variant="outline" size="md" class="mt-5 w-full" :href="route('panel.chatlogs.index')">Lihat Log Chatbot</x-admin.btn>
        </div>
    </div>
@endsection
