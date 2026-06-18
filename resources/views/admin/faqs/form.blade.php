@extends('admin.layouts.admin')

@php
    $item ??= null;
    $editing = $item !== null;
    $prefill = $editing ? $item->question : request('q', '');
@endphp

@section('content')
    <x-admin.page-header :title="$editing ? 'Ubah FAQ' : 'Tambah FAQ'" :breadcrumb="['FAQ Chatbot' => route('panel.faqs.index'), ($editing ? 'Ubah' : 'Tambah') => null]" />

    @if (! $editing && request('q'))
        <div class="mx-auto mb-4 max-w-2xl rounded-lg border border-info/20 bg-info/5 px-4 py-3 text-sm text-info">Diisi otomatis dari log chatbot.</div>
    @endif

    <form action="{{ $editing ? route('panel.faqs.update', $item->id) : route('panel.faqs.store') }}" method="POST" class="mx-auto max-w-2xl space-y-6">
        @csrf
        @if ($editing) @method('PUT') @endif
        <div class="space-y-5 rounded-xl border border-line bg-card p-6 shadow-sm">
            @if ($editing)
                <div class="flex items-center justify-between rounded-lg bg-paper2/60 px-4 py-2.5 text-sm">
                    <span class="text-slate-500">Popularitas</span>
                    <span class="inline-flex items-center gap-1.5 font-semibold text-navy-800"><x-admin.icon name="spark" class="h-4 w-4 text-brass-500" />{{ number_format($item->hit_count, 0, ',', '.') }} hit</span>
                </div>
            @endif
            <x-admin.form.input label="Pertanyaan" name="question" :value="$prefill" required placeholder="mis. Apa saja layanan KGP?" />
            <x-admin.form.textarea label="Jawaban" name="answer" rows="5" :value="$item?->answer" required placeholder="Jawaban yang akan diberikan chatbot." />
            <x-admin.form.input label="Kata Kunci" name="keywords" :value="$item?->keywords" hint="Pisahkan dengan koma — membantu pencocokan." />
            <div class="grid grid-cols-2 gap-4">
                <x-admin.form.input label="Urutan" name="sort_order" type="number" :value="$item?->sort_order ?? 0" />
                <div class="flex items-end pb-1"><x-admin.form.toggle label="Aktif" name="is_active" :checked="$item?->is_active ?? true" /></div>
            </div>
        </div>
        <div class="flex items-center justify-end gap-2">
            <x-admin.btn variant="ghost" :href="route('panel.faqs.index')">Batal</x-admin.btn>
            <x-admin.btn variant="primary" type="submit"><x-admin.icon name="check" class="h-4 w-4" />{{ $editing ? 'Simpan Perubahan' : 'Simpan FAQ' }}</x-admin.btn>
        </div>
    </form>
@endsection
