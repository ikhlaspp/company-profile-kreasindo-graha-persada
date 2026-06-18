@extends('admin.layouts.admin')

@php $suggest = collect($messages)->firstWhere('role', 'user')['text'] ?? ''; @endphp

@section('content')
    <x-admin.page-header title="Transkrip Percakapan" :breadcrumb="['Log Chatbot' => route('panel.chatlogs.index'), '#'.\Illuminate\Support\Str::substr($conversation->session_id,0,8) => null]">
        <x-admin.btn variant="ghost" size="sm" :href="route('panel.chatlogs.index')">Kembali</x-admin.btn>
    </x-admin.page-header>

    <div class="grid grid-cols-1 gap-6 lg:grid-cols-3">
        <div class="lg:col-span-2">
            <div class="rounded-xl border border-line bg-card p-5 shadow-sm">
                <div class="space-y-4">
                    @forelse ($messages as $m)
                        @if ($m['role'] === 'user')
                            <div class="flex justify-end">
                                <div class="max-w-[80%]">
                                    <div class="rounded-2xl rounded-tr-sm bg-navy-800 px-4 py-2.5 text-sm text-white">{{ $m['text'] }}</div>
                                    <p class="mt-1 text-right text-[10px] text-slate-500">{{ $m['time'] }}</p>
                                </div>
                            </div>
                        @else
                            <div class="flex justify-start">
                                <div class="max-w-[80%]">
                                    <div class="rounded-2xl rounded-tl-sm border border-line bg-paper2/60 px-4 py-2.5 text-sm text-navy-900">{{ $m['text'] }}</div>
                                    <div class="mt-1 flex items-center gap-2">
                                        <x-admin.badge :type="$m['source']" dot>{{ ['faq' => 'FAQ', 'gemini' => 'AI Gemini', 'grok' => 'AI Grok', 'fallback' => 'Fallback'][$m['source']] ?? $m['source'] }}</x-admin.badge>
                                        <span class="text-[10px] text-slate-500">{{ $m['time'] }}</span>
                                    </div>
                                </div>
                            </div>
                        @endif
                    @empty
                        <p class="py-6 text-center text-sm text-slate-500">Tidak ada pesan.</p>
                    @endforelse
                </div>
            </div>
        </div>

        <div class="space-y-6">
            <div class="rounded-xl border border-line bg-card p-5 shadow-sm">
                <h2 class="font-display text-base font-semibold text-navy-900">Info Sesi</h2>
                <dl class="mt-4 space-y-2.5 text-sm">
                    <div class="flex justify-between"><dt class="text-slate-500">Sesi</dt><dd class="font-mono font-semibold text-navy-800">#{{ \Illuminate\Support\Str::substr($conversation->session_id,0,8) }}</dd></div>
                    <div class="flex justify-between"><dt class="text-slate-500">IP</dt><dd class="text-slate-600">{{ $conversation->visitor_ip ?? '—' }}</dd></div>
                    <div class="flex justify-between"><dt class="text-slate-500">Mulai</dt><dd class="text-slate-600">{{ optional($conversation->started_at)->format('d M Y, H:i') ?? '—' }}</dd></div>
                    <div class="flex justify-between"><dt class="text-slate-500">Total Pesan</dt><dd class="text-slate-600">{{ count($messages) }}</dd></div>
                </dl>
            </div>
            @if ($suggest)
                <div class="rounded-xl border border-brass-300 bg-brass-100/50 p-5">
                    <h2 class="font-display text-base font-semibold text-brass-700">Pertanyaan Baru?</h2>
                    <p class="mt-1 text-sm text-slate-600">Jika pertanyaan pengunjung dijawab AI, pertimbangkan menjadikannya FAQ tetap.</p>
                    <x-admin.btn variant="accent" class="mt-4 w-full" :href="route('panel.faqs.create', ['q' => $suggest])"><x-admin.icon name="plus" class="h-4 w-4" />Jadikan FAQ</x-admin.btn>
                </div>
            @endif
        </div>
    </div>
@endsection
