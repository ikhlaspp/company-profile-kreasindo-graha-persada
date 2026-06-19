@extends('layouts.app')
@section('title', 'Dokumen Legal — KGP')
@section('meta_description', 'Dokumen legalitas resmi PT. Kreasindo Graha Persada tersedia untuk diunduh — NIB, SIUP, SBU, dan sertifikasi lainnya.')

@section('content')

{{-- PAGE HERO --}}
<section class="relative bg-navy-900 bg-blueprint overflow-hidden pt-32 pb-16">
  <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
    <nav class="flex items-center gap-2 font-sans text-xs font-semibold text-navy-100 mb-6">
      <a href="{{ route('home') }}" class="hover:text-brass-300 transition-colors">Beranda</a>
      <span class="text-white/30">/</span>
      <span class="text-brass-300">Dokumen</span>
    </nav>
    <p class="font-sans text-xs font-semibold uppercase tracking-widest text-brass-300 mb-3">Legalitas &amp; Kepatuhan</p>
    <h1 class="font-display text-4xl lg:text-5xl font-semibold text-white">Dokumen Legal Perusahaan</h1>
    <p class="mt-4 font-sans text-base text-navy-100 max-w-2xl">
      Seluruh dokumen legalitas resmi PT. Kreasindo Graha Persada tersedia untuk diunduh. Transparansi dan kepatuhan hukum adalah landasan kepercayaan kemitraan kami.
    </p>
  </div>
</section>

{{-- INFO BAND --}}
<section class="bg-paper py-10">
  <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
    <div class="flex items-start gap-5 bg-navy-800 rounded-sm px-6 py-5">
      <div class="flex-shrink-0 w-10 h-10 rounded-full bg-brass-500/20 border border-brass-500/40 flex items-center justify-center text-brass-300 text-lg">
        &#9432;
      </div>
      <p class="font-sans text-sm text-navy-100 leading-relaxed">
        <strong class="text-white">Catatan:</strong>
        Seluruh dokumen di halaman ini adalah salinan resmi yang telah diverifikasi.
        Untuk keperluan tender atau <em>due-diligence</em>, hubungi tim legal kami melalui halaman
        <a href="{{ route('contact') }}" class="text-brass-300 font-semibold hover:text-brass-100 transition-colors">Kontak</a>
        untuk dokumen asli bermaterai.
      </p>
    </div>
  </div>
</section>

{{-- DOCUMENT CATEGORIES --}}
@if($documents->isEmpty())
  <section class="bg-paper2 py-24 text-center">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
      <p class="font-sans text-slate-400 text-base mb-2">Belum ada dokumen yang tersedia saat ini.</p>
      <p class="font-sans text-slate-400 text-sm">Silakan kunjungi kembali halaman ini atau hubungi kami untuk informasi lebih lanjut.</p>
    </div>
  </section>
@else
  @foreach($documents as $categoryName => $docs)
  <section class="{{ $loop->even ? 'bg-paper2' : 'bg-paper' }} py-12 lg:py-16">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

      {{-- Category heading --}}
      <div class="flex items-center gap-4 mb-8">
        <h2 class="font-display text-xl lg:text-2xl font-semibold text-navy-800">{{ $categoryName }}</h2>
        <div class="flex-1 h-px bg-brass-500/40"></div>
        <span class="font-sans text-xs font-semibold text-brass-700 uppercase tracking-widest">{{ $docs->count() }} dokumen</span>
      </div>

      {{-- Document grid --}}
      <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5">
        @foreach($docs as $document)
          @php
            $ext = strtoupper(pathinfo($document->file_path ?? '', PATHINFO_EXTENSION));
            if (!$ext && $document->mime_type) {
              $ext = match(true) {
                str_contains($document->mime_type, 'pdf')  => 'PDF',
                str_contains($document->mime_type, 'word') => 'DOC',
                str_contains($document->mime_type, 'excel') || str_contains($document->mime_type, 'spreadsheet') => 'XLS',
                str_contains($document->mime_type, 'image') => 'IMG',
                default => 'FILE',
              };
            }
            if (!$ext) $ext = 'DOC';

            $iconBg = match($ext) {
              'PDF'  => 'bg-danger/10 text-danger',
              'DOC', 'DOCX' => 'bg-info/10 text-info',
              'XLS', 'XLSX' => 'bg-success/10 text-success',
              default => 'bg-navy-100 text-navy-700',
            };

            if ($document->file_size_kb !== null) {
              if ($document->file_size_kb >= 1024) {
                $sizeLabel = number_format($document->file_size_kb / 1024, 1) . ' MB';
              } else {
                $sizeLabel = $document->file_size_kb . ' KB';
              }
            } else {
              $sizeLabel = null;
            }
          @endphp

          <div class="bg-card border border-line rounded-sm shadow-sm hover:shadow-md hover:-translate-y-0.5 transition-all duration-200 p-5 flex flex-col gap-4">

            {{-- Icon + title row --}}
            <div class="flex items-start gap-4">
              <div class="flex-shrink-0 w-12 h-12 rounded-md {{ $iconBg }} flex items-center justify-center font-sans font-bold text-xs text-center">
                {{ $ext }}
              </div>
              <div class="flex-1 min-w-0">
                <h3 class="font-display text-sm lg:text-base font-semibold text-navy-800 leading-snug line-clamp-2">
                  {{ $document->title }}
                </h3>
              </div>
            </div>

            {{-- Meta --}}
            <div class="flex items-center gap-3 font-sans text-xs text-slate-400 flex-wrap">
              @if($document->year)
                <span class="inline-flex items-center gap-1">
                  <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2"/><path d="M16 2v4M8 2v4M3 10h18"/></svg>
                  {{ $document->year }}
                </span>
              @endif
              @if($sizeLabel)
                <span class="inline-flex items-center gap-1">
                  <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
                  {{ $sizeLabel }}
                </span>
              @endif
              @if($document->download_count > 0)
                <span class="inline-flex items-center gap-1 ml-auto text-slate-300">
                  <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M12 5v14M5 12l7 7 7-7"/></svg>
                  {{ number_format($document->download_count) }}×
                </span>
              @endif
            </div>

            {{-- Download button --}}
            <div class="mt-auto">
              <x-button as="a" href="{{ route('documents.download', $document) }}" variant="primary" size="sm" class="w-full justify-center">
                <svg class="w-4 h-4 mr-1.5 inline-block" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M12 5v14M5 12l7 7 7-7"/><path d="M3 20h18"/></svg>
                Unduh Dokumen
              </x-button>
            </div>

          </div>
        @endforeach
      </div>
    </div>
  </section>
  @endforeach
@endif

{{-- CLOSING CTA --}}
<section class="bg-navy-800 py-16 text-center">
  <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
    <p class="font-sans text-xs font-semibold uppercase tracking-widest text-brass-300 mb-3">Bantuan Lebih Lanjut</p>
    <h2 class="font-display text-3xl lg:text-4xl font-semibold text-white mb-4">
      Membutuhkan Dokumen Lainnya?
    </h2>
    <p class="font-sans text-base text-navy-100 max-w-xl mx-auto mb-8">
      Tim legal kami siap membantu menyediakan dokumen tambahan untuk keperluan kemitraan, tender, maupun due-diligence Anda.
    </p>
    <x-button as="a" href="{{ route('contact') }}" variant="accent" size="lg">
      Hubungi Tim Legal
    </x-button>
  </div>
</section>

@endsection
