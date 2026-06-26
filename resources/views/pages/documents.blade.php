@extends('layouts.app')
@section('title', 'Dokumen Legal — KGP')
@section('meta_description', 'Dokumen legalitas resmi PT. Kreasindo Graha Persada tersedia untuk diunduh — NIB, SIUP, SBU, dan sertifikasi lainnya.')

@section('content')

{{-- PAGE HERO --}}
<section class="relative bg-navy-900 bg-blueprint overflow-hidden pt-32 pb-20">
  <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
    <nav class="flex items-center gap-2 font-sans text-xs font-semibold text-navy-100 mb-6">
      <a href="{{ route('home') }}" class="hover:text-brass-300 transition-colors">Beranda</a>
      <span class="text-white/30">/</span>
      <span class="text-brass-300">Dokumen</span>
    </nav>
    <p class="font-sans text-xs font-semibold uppercase tracking-widest text-brass-300 mb-3">Legalitas &amp; Kepatuhan</p>
    <h1 class="font-display text-4xl lg:text-5xl font-semibold text-white leading-tight">Dokumen Legal Perusahaan</h1>
    <p class="mt-4 font-sans text-base text-navy-100 max-w-2xl leading-relaxed">
      Seluruh dokumen legalitas resmi PT. Kreasindo Graha Persada tersedia untuk diunduh. Transparansi dan kepatuhan hukum adalah landasan kepercayaan kemitraan kami.
    </p>
    <div class="mt-8 flex flex-wrap gap-6 font-sans text-xs text-navy-100">
      <span class="flex items-center gap-2">
        <svg class="w-4 h-4 text-brass-300" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M9 12l2 2 4-4"/><path d="M12 22C6.477 22 2 17.523 2 12S6.477 2 12 2s10 4.477 10 10-4.477 10-10 10z"/></svg>
        Dokumen Terverifikasi
      </span>
      <span class="flex items-center gap-2">
        <svg class="w-4 h-4 text-brass-300" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect x="3" y="11" width="18" height="11" rx="2"/><path d="M7 11V7a5 5 0 0110 0v4"/></svg>
        Salinan Resmi
      </span>
      <span class="flex items-center gap-2">
        <svg class="w-4 h-4 text-brass-300" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M12 5v14M5 12l7 7 7-7"/><path d="M3 20h18"/></svg>
        Unduh Bebas
      </span>
    </div>
  </div>
</section>

{{-- INFO BAND --}}
<section class="bg-navy-800 py-4">
  <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
    <div class="flex items-center gap-4">
      <div class="flex-shrink-0 w-8 h-8 rounded-full bg-brass-500/20 border border-brass-500/40 flex items-center justify-center text-brass-300 text-sm">
        &#9432;
      </div>
      <p class="font-sans text-sm text-navy-100 leading-relaxed">
        <strong class="text-white">Catatan:</strong>
        Seluruh dokumen adalah salinan resmi yang telah diverifikasi.
        Untuk keperluan tender atau <em>due-diligence</em>, hubungi tim legal kami melalui halaman
        <a href="{{ route('contact') }}" class="text-brass-300 font-semibold hover:text-brass-100 transition-colors">Kontak</a>
        untuk dokumen asli bermaterai.
      </p>
    </div>
  </div>
</section>

{{-- LEGALITAS PERUSAHAAN CREDENTIAL GRID --}}
<section class="bg-paper py-16 lg:py-20">
  <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

    <div class="reveal mb-12 max-w-2xl">
      <p class="font-sans text-xs font-semibold uppercase tracking-widest text-brass-700 mb-2">Identitas Legal</p>
      <h2 class="font-display text-3xl lg:text-4xl font-semibold text-navy-800 leading-snug">Legalitas Perusahaan</h2>
      <p class="mt-3 font-sans text-sm text-slate-500 leading-relaxed">
        PT. Kreasindo Graha Persada beroperasi dengan seluruh perizinan yang sah dan telah memenuhi kewajiban hukum sebagai badan usaha di Indonesia.
      </p>
    </div>

    <div class="reveal grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5">

      {{-- NPWP --}}
      <div class="bg-card border border-line rounded-sm p-5 hover:shadow-md hover:-translate-y-0.5 transition-all duration-200 flex flex-col gap-3">
        <div class="flex items-start justify-between gap-3">
          <div class="w-10 h-10 rounded-sm bg-navy-100 flex items-center justify-center flex-shrink-0">
            <svg class="w-5 h-5 text-navy-700" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><rect x="2" y="5" width="20" height="14" rx="2"/><path d="M2 10h20"/></svg>
          </div>
          <span class="inline-flex items-center gap-1 font-sans text-xs font-semibold text-success bg-success/10 border border-success/20 rounded-full px-2.5 py-0.5">
            <svg class="w-3 h-3" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M20 6L9 17l-5-5"/></svg>
            Terverifikasi
          </span>
        </div>
        <div>
          <p class="font-sans text-xs font-semibold uppercase tracking-widest text-slate-400 mb-1">NPWP</p>
          <p class="font-display text-base font-semibold text-navy-800 tabular">80.457.164.4-403.000</p>
        </div>
      </div>

      {{-- NIB --}}
      <div class="bg-card border border-line rounded-sm p-5 hover:shadow-md hover:-translate-y-0.5 transition-all duration-200 flex flex-col gap-3" style="transition-delay:60ms">
        <div class="flex items-start justify-between gap-3">
          <div class="w-10 h-10 rounded-sm bg-navy-100 flex items-center justify-center flex-shrink-0">
            <svg class="w-5 h-5 text-navy-700" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414A1 1 0 0119 9.414V19a2 2 0 01-2 2z"/></svg>
          </div>
          <span class="inline-flex items-center gap-1 font-sans text-xs font-semibold text-success bg-success/10 border border-success/20 rounded-full px-2.5 py-0.5">
            <svg class="w-3 h-3" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M20 6L9 17l-5-5"/></svg>
            Terverifikasi
          </span>
        </div>
        <div>
          <p class="font-sans text-xs font-semibold uppercase tracking-widest text-slate-400 mb-1">NIB — Nomor Induk Berusaha</p>
          <p class="font-display text-base font-semibold text-navy-800 tabular">8120010232725</p>
        </div>
      </div>

      {{-- SIUP --}}
      <div class="bg-card border border-line rounded-sm p-5 hover:shadow-md hover:-translate-y-0.5 transition-all duration-200 flex flex-col gap-3" style="transition-delay:120ms">
        <div class="flex items-start justify-between gap-3">
          <div class="w-10 h-10 rounded-sm bg-navy-100 flex items-center justify-center flex-shrink-0">
            <svg class="w-5 h-5 text-navy-700" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/></svg>
          </div>
          <span class="inline-flex items-center gap-1 font-sans text-xs font-semibold text-success bg-success/10 border border-success/20 rounded-full px-2.5 py-0.5">
            <svg class="w-3 h-3" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M20 6L9 17l-5-5"/></svg>
            Terverifikasi
          </span>
        </div>
        <div>
          <p class="font-sans text-xs font-semibold uppercase tracking-widest text-slate-400 mb-1">SIUP</p>
          <p class="font-display text-base font-semibold text-navy-800">Surat Izin Usaha Perdagangan</p>
        </div>
      </div>

      {{-- SIUJK --}}
      <div class="bg-card border border-line rounded-sm p-5 hover:shadow-md hover:-translate-y-0.5 transition-all duration-200 flex flex-col gap-3" style="transition-delay:60ms">
        <div class="flex items-start justify-between gap-3">
          <div class="w-10 h-10 rounded-sm bg-navy-100 flex items-center justify-center flex-shrink-0">
            <svg class="w-5 h-5 text-navy-700" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path d="M3 9l9-7 9 7v11a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"/><path d="M9 22V12h6v10"/></svg>
          </div>
          <span class="inline-flex items-center gap-1 font-sans text-xs font-semibold text-success bg-success/10 border border-success/20 rounded-full px-2.5 py-0.5">
            <svg class="w-3 h-3" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M20 6L9 17l-5-5"/></svg>
            Terverifikasi
          </span>
        </div>
        <div>
          <p class="font-sans text-xs font-semibold uppercase tracking-widest text-slate-400 mb-1">SIUJK</p>
          <p class="font-display text-base font-semibold text-navy-800">Surat Izin Usaha Jasa Konstruksi</p>
        </div>
      </div>

      {{-- SBU Gedung --}}
      <div class="bg-card border border-line rounded-sm p-5 hover:shadow-md hover:-translate-y-0.5 transition-all duration-200 flex flex-col gap-3" style="transition-delay:120ms">
        <div class="flex items-start justify-between gap-3">
          <div class="w-10 h-10 rounded-sm bg-navy-100 flex items-center justify-center flex-shrink-0">
            <svg class="w-5 h-5 text-navy-700" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path d="M2 22V8l10-6 10 6v14H2z"/><path d="M8 22v-4h8v4M12 2v4"/></svg>
          </div>
          <span class="inline-flex items-center gap-1 font-sans text-xs font-semibold text-success bg-success/10 border border-success/20 rounded-full px-2.5 py-0.5">
            <svg class="w-3 h-3" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M20 6L9 17l-5-5"/></svg>
            Terverifikasi
          </span>
        </div>
        <div>
          <p class="font-sans text-xs font-semibold uppercase tracking-widest text-slate-400 mb-1">SBU — Bidang Gedung</p>
          <p class="font-display text-base font-semibold text-navy-800">Sertifikat Badan Usaha Konstruksi Gedung</p>
        </div>
      </div>

      {{-- SBU ME --}}
      <div class="bg-card border border-line rounded-sm p-5 hover:shadow-md hover:-translate-y-0.5 transition-all duration-200 flex flex-col gap-3" style="transition-delay:180ms">
        <div class="flex items-start justify-between gap-3">
          <div class="w-10 h-10 rounded-sm bg-navy-100 flex items-center justify-center flex-shrink-0">
            <svg class="w-5 h-5 text-navy-700" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path d="M13 2L3 14h9l-1 8 10-12h-9l1-8z"/></svg>
          </div>
          <span class="inline-flex items-center gap-1 font-sans text-xs font-semibold text-success bg-success/10 border border-success/20 rounded-full px-2.5 py-0.5">
            <svg class="w-3 h-3" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M20 6L9 17l-5-5"/></svg>
            Terverifikasi
          </span>
        </div>
        <div>
          <p class="font-sans text-xs font-semibold uppercase tracking-widest text-slate-400 mb-1">SBU — Mekanikal &amp; Elektrikal</p>
          <p class="font-display text-base font-semibold text-navy-800">Sertifikat Badan Usaha Mekanikal &amp; Elektrikal</p>
        </div>
      </div>

    </div>

    {{-- Kekayaan Bersih highlight --}}
    <div class="reveal mt-8 bg-navy-800 rounded-sm p-6 flex flex-col sm:flex-row items-start sm:items-center gap-4">
      <div class="flex-shrink-0 w-12 h-12 rounded-sm bg-brass-500/20 border border-brass-500/40 flex items-center justify-center">
        <svg class="w-6 h-6 text-brass-300" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path d="M12 2l2.4 7.4H22l-6.2 4.5 2.4 7.4L12 17l-6.2 4.3 2.4-7.4L2 9.4h7.6L12 2z"/></svg>
      </div>
      <div class="flex-1">
        <p class="font-sans text-xs font-semibold uppercase tracking-widest text-brass-300 mb-1">Kapasitas Keuangan</p>
        <p class="font-display text-xl font-semibold text-white">Kekayaan Bersih <span class="text-brass-300 tabular">Rp 5.000.000.000</span></p>
        <p class="font-sans text-sm text-navy-100 mt-1">Menunjukkan kemampuan finansial yang kuat untuk mendukung proyek berskala nasional.</p>
      </div>
      <span class="inline-flex items-center gap-1.5 font-sans text-xs font-semibold text-success bg-success/10 border border-success/20 rounded-full px-3 py-1.5">
        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M20 6L9 17l-5-5"/></svg>
        Terverifikasi
      </span>
    </div>

  </div>
</section>

{{-- DOCUMENT CATEGORIES --}}
@if($documents->isEmpty())
  <section class="bg-paper2 py-24 text-center">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
      <div class="w-16 h-16 rounded-full bg-navy-100 flex items-center justify-center mx-auto mb-4">
        <svg class="w-8 h-8 text-navy-400" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414A1 1 0 0119 9.414V19a2 2 0 01-2 2z"/></svg>
      </div>
      <p class="font-display text-lg text-navy-700 mb-2">Belum ada dokumen tersedia</p>
      <p class="font-sans text-slate-400 text-sm max-w-sm mx-auto">Silakan kunjungi kembali halaman ini atau hubungi kami untuk informasi lebih lanjut.</p>
    </div>
  </section>
@else
  @foreach($documents as $categoryName => $docs)
  <section class="{{ $loop->even ? 'bg-paper2' : 'bg-paper' }} py-14 lg:py-20">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

      {{-- Category heading --}}
      <div class="reveal flex items-center gap-4 mb-10">
        <div class="flex-shrink-0 w-1 h-8 bg-brass-500 rounded-full"></div>
        <h2 class="font-display text-xl lg:text-2xl font-semibold text-navy-800">{{ $categoryName }}</h2>
        <div class="flex-1 h-px bg-line"></div>
        <span class="font-sans text-xs font-semibold text-brass-700 uppercase tracking-widest bg-brass-100 border border-brass-300/40 rounded-full px-3 py-1">{{ $docs->count() }} dok</span>
      </div>

      {{-- Document grid --}}
      <div class="reveal grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5">
        @foreach($docs as $document)
          @php
            // Derive extension from file path or mime type
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

            // Color-code by type
            $iconBg = match($ext) {
              'PDF'  => 'bg-danger/10 text-danger border-danger/20',
              'DOC', 'DOCX' => 'bg-info/10 text-info border-info/20',
              'XLS', 'XLSX' => 'bg-success/10 text-success border-success/20',
              default => 'bg-navy-100 text-navy-700 border-navy-100',
            };

            // Human-readable file size
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
              <div class="flex-shrink-0 w-12 h-12 rounded-md border {{ $iconBg }} flex items-center justify-center font-sans font-bold text-xs text-center">
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
                  <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
                  {{ $sizeLabel }}
                </span>
              @endif
              @if($document->download_count > 0)
                <span class="inline-flex items-center gap-1 ml-auto text-slate-300">
                  <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M12 5v14M5 12l7 7 7-7"/></svg>
                  {{ number_format($document->download_count) }}&times;
                </span>
              @endif
            </div>

            {{-- Divider --}}
            <div class="h-px bg-line"></div>

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
<section class="relative bg-navy-900 py-20 overflow-hidden">
  <div class="absolute inset-0 bg-blueprint opacity-40"></div>
  <div class="relative mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 text-center">
    <div class="reveal">
      <p class="font-sans text-xs font-semibold uppercase tracking-widest text-brass-300 mb-3">Bantuan Lebih Lanjut</p>
      <h2 class="font-display text-3xl lg:text-4xl font-semibold text-white mb-4">
        Membutuhkan Dokumen Asli?
      </h2>
      <p class="font-sans text-base text-navy-100 max-w-xl mx-auto mb-8 leading-relaxed">
        Untuk keperluan tender, kemitraan, atau <em>due-diligence</em> formal, tim legal kami siap menyediakan dokumen asli bermaterai sesuai kebutuhan Anda.
      </p>
      <div class="flex flex-wrap gap-4 justify-center">
        <x-button as="a" href="{{ route('contact') }}" variant="accent" size="lg">
          Hubungi Tim Legal
        </x-button>
        <x-button as="a" href="{{ route('about') }}" variant="light" size="lg">
          Tentang Perusahaan
        </x-button>
      </div>
    </div>
  </div>
</section>

@endsection
