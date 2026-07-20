@extends('layouts.app')
@section('title', 'Layanan — KGP')
@section('meta_description', 'Layanan PT. Kreasindo Graha Persada: Software, Hardware, serta Interior & Furniture untuk instansi pemerintah, militer, dan korporasi.')

@section('content')

{{-- HERO --}}
<section class="bg-navy-900 bg-blueprint pt-32 pb-20">
  <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
    {{-- Breadcrumb --}}
    <div class="flex items-center gap-2 text-sm text-navy-100 mb-6 font-sans">
      <a href="{{ route('home') }}" class="hover:text-brass-300 transition-colors">Beranda</a>
      <span class="text-navy-100/50">/</span>
      <span class="text-brass-300">Layanan</span>
    </div>

    <p class="text-xs font-sans font-semibold uppercase tracking-widest text-brass-300 mb-3">Layanan Kami</p>

    <h1 class="font-display text-4xl sm:text-5xl lg:text-6xl text-white font-semibold mb-6 max-w-3xl leading-tight">
      Solusi Terintegrasi untuk Institusi &amp; Korporasi
    </h1>

    <p class="text-navy-100 text-lg max-w-2xl leading-relaxed mb-10">
      Produk utama kami &mdash; Software, Hardware, dan Interior &amp; Furniture &mdash; bekerja sinergis untuk memberikan solusi menyeluruh bagi instansi pemerintah, militer, dan korporasi.
    </p>

    {{-- Division jump links --}}
    @if(count($divisions) > 1)
    <div class="flex flex-wrap gap-3">
      @foreach($divisions as $key => $label)
      <a href="#{{ $key }}"
         class="inline-flex items-center px-5 py-2 rounded-full text-sm font-sans font-semibold border transition-colors
                {{ $key === 'it' ? 'bg-navy-700 border-navy-600 text-white hover:bg-navy-600' : ($key === 'interior' ? 'bg-brass-500 border-brass-500 text-navy-900 hover:bg-brass-300' : 'bg-navy-600 border-navy-500 text-white hover:bg-navy-500') }}">
        {{ $label }}
      </a>
      @endforeach
    </div>
    @endif
  </div>
</section>

{{-- CAPABILITY INTRO BAND --}}
<section class="bg-navy-800 py-16 border-b border-navy-700 reveal">
  <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
    <div class="text-center mb-12">
      <p class="text-xs font-sans font-semibold uppercase tracking-widest text-brass-300 mb-3">Area Keahlian</p>
      <h2 class="font-display text-2xl sm:text-3xl text-white font-semibold max-w-xl mx-auto">
        Tiga Pilar Kompetensi KGP
      </h2>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">

      {{-- Software --}}
      <div class="bg-navy-700/60 border border-navy-600 rounded-sm p-6 reveal" style="transition-delay:0ms">
        <div class="w-12 h-12 rounded-xl bg-navy-600 flex items-center justify-center mb-5">
          <svg class="w-6 h-6 text-brass-300" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"/>
          </svg>
        </div>
        <h3 class="font-display text-white font-semibold text-lg mb-2">Software</h3>
        <p class="text-navy-100 text-sm leading-relaxed">Pengembangan perangkat lunak dan aplikasi pemasaran digital untuk memperluas bisnis serta meningkatkan nilai kompetisi klien.</p>
      </div>

      {{-- Hardware --}}
      <div class="bg-navy-700/60 border border-navy-600 rounded-sm p-6 reveal" style="transition-delay:120ms">
        <div class="w-12 h-12 rounded-xl bg-navy-600 flex items-center justify-center mb-5">
          <svg class="w-6 h-6 text-brass-300" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M5 12h14M5 12a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v4a2 2 0 01-2 2M5 12a2 2 0 00-2 2v4a2 2 0 002 2h14a2 2 0 002-2v-4a2 2 0 00-2-2m-12-2h.01M7 16h.01"/>
          </svg>
        </div>
        <h3 class="font-display text-white font-semibold text-lg mb-2">Hardware</h3>
        <p class="text-navy-100 text-sm leading-relaxed">Solusi sistem integrasi dan penyediaan perangkat keras dengan Server Expert bersertifikasi, Managed Services, dan konsultasi infrastruktur IT.</p>
      </div>

      {{-- Interior & Furniture --}}
      <div class="bg-navy-700/60 border border-navy-600 rounded-sm p-6 reveal" style="transition-delay:240ms">
        <div class="w-12 h-12 rounded-xl bg-brass-700/40 flex items-center justify-center mb-5">
          <svg class="w-6 h-6 text-brass-300" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
          </svg>
        </div>
        <h3 class="font-display text-white font-semibold text-lg mb-2">Interior &amp; Furniture</h3>
        <p class="text-navy-100 text-sm leading-relaxed">Manajemen, rancang-bangun desain, dan konstruksi interior &amp; furniture dengan sistem manajemen proyek dan standar keselamatan kerja.</p>
      </div>

    </div>
  </div>
</section>

{{-- DIVISION SECTIONS --}}
@foreach($divisions as $key => $label)
@php
  $divServices = $services[$key] ?? collect();
  $isAlt = $loop->even;

  $divHeadline = match($key) {
    'it'       => 'Infrastruktur &amp; Sistem Digital yang Aman dan Andal',
    'interior' => 'Desain &amp; Konstruksi Ruang yang Fungsional dan Berkarakter',
    'me'       => 'Sistem Mekanikal &amp; Elektrikal Berstandar Tinggi',
    default    => $label,
  };

  $divDescription = match($key) {
    'it'       => 'Dari pengembangan perangkat lunak khusus hingga infrastruktur jaringan terenkripsi — kami membangun ekosistem digital yang mendukung operasional institusi Anda.',
    'interior' => 'Kami merancang dan membangun ruang kerja, ruang operasional, dan furnitur yang mencerminkan identitas dan standar profesional institusi Anda.',
    'me'       => 'Sistem mekanikal dan elektrikal yang terencana matang adalah fondasi gedung yang efisien, aman, dan berumur panjang.',
    default    => '',
  };

  $iconBadgeClass  = match($key) {
    'interior' => 'bg-brass-100 text-brass-700',
    default    => 'bg-navy-100 text-navy-700',
  };
  $eyebrowClass    = match($key) {
    'interior' => 'bg-brass-100 text-brass-700',
    default    => 'bg-navy-100 text-navy-700',
  };
  $linkClass       = match($key) {
    'interior' => 'text-brass-700',
    default    => 'text-navy-700',
  };
@endphp

<section id="{{ $key }}" class="{{ $isAlt ? 'bg-paper2' : 'bg-paper' }} py-16 lg:py-24 {{ !$loop->first ? 'border-t border-line' : '' }}">
  <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

    {{-- Division header --}}
    <div class="mb-12 reveal">
      <span class="inline-block text-xs font-sans font-semibold uppercase tracking-widest px-4 py-1.5 rounded-full mb-4 {{ $eyebrowClass }}">
        {{ $label }}
      </span>
      <h2 class="font-display text-3xl sm:text-4xl text-navy-800 font-semibold max-w-2xl mb-4">
        {!! $divHeadline !!}
      </h2>
      @if($divDescription)
      <p class="text-slate-500 max-w-2xl leading-relaxed font-sans">{{ $divDescription }}</p>
      @endif
    </div>

    {{-- Services grid --}}
    @if($divServices->isNotEmpty())
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 reveal">
      @foreach($divServices as $i => $service)
      <a href="{{ route('services.show', $service->slug) }}"
         class="group bg-card border border-line rounded-sm shadow-sm hover:shadow-md hover:-translate-y-1 transition-all duration-200 flex flex-col p-7"
         style="transition-delay:{{ $i * 80 }}ms">

        {{-- Icon area --}}
        <div class="mb-5">
          @if($service->icon)
            <div class="w-12 h-12 rounded-xl flex items-center justify-center text-xl {{ $iconBadgeClass }}">
              <i class="{{ $service->icon }}"></i>
            </div>
          @else
            <div class="w-12 h-12 rounded-xl flex items-center justify-center {{ $iconBadgeClass }}">
              <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round"
                  d="{{ $key === 'interior' ? 'M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6' : ($key === 'me' ? 'M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z M15 12a3 3 0 11-6 0 3 3 0 016 0z' : 'M9 3H5a2 2 0 00-2 2v4m6-6h10a2 2 0 012 2v4M9 3v18m0 0h10a2 2 0 002-2V9M9 21H5a2 2 0 01-2-2V9m0 0h18') }}" />
              </svg>
            </div>
          @endif
        </div>

        <h3 class="font-display text-lg text-navy-800 font-semibold mb-2 group-hover:text-navy-600 transition-colors">
          {{ $service->title }}
        </h3>
        @if($service->excerpt)
        <p class="text-slate-500 text-sm leading-relaxed flex-1">{{ $service->excerpt }}</p>
        @endif

        <div class="mt-5 flex items-center gap-1.5 text-sm font-sans font-semibold {{ $linkClass }}">
          Lihat Detail
          <svg class="w-4 h-4 transition-transform group-hover:translate-x-1" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
          </svg>
        </div>
      </a>
      @endforeach
    </div>
    @else
    <p class="text-slate-400 font-sans">Belum ada layanan untuk divisi ini.</p>
    @endif

  </div>
</section>
@endforeach

{{-- CTA --}}
<x-cta-band
  eyebrow="Mulai Proyek Anda"
  title="Siap Mendiskusikan Kebutuhan Anda?"
  body="Tim ahli kami siap membantu mewujudkan proyek IT, interior, konstruksi, atau sistem ME institusi Anda — sesuai standar, anggaran, dan tenggat waktu." />

@endsection
