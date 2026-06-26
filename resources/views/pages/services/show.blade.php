@extends('layouts.app')
@section('title', $service->title . ' — KGP')
@section('meta_description', $service->excerpt ?? 'Detail layanan ' . $service->title . ' dari PT. Kreasindo Graha Persada.')

@section('content')

@php
  $divLabel = match($service->division) {
    'it'       => 'Divisi IT',
    'interior' => 'Divisi Interior & Furniture',
    'me'       => 'Mekanikal & Elektrikal',
    default    => ucfirst($service->division),
  };
  $divBadgeClass = match($service->division) {
    'it'       => 'bg-navy-700 text-navy-100',
    'interior' => 'bg-brass-700 text-brass-100',
    'me'       => 'bg-navy-700 text-navy-100',
    default    => 'bg-navy-700 text-navy-100',
  };
  $accentClass = match($service->division) {
    'interior' => 'text-brass-700',
    default    => 'text-navy-700',
  };
  $iconBgClass = match($service->division) {
    'interior' => 'bg-brass-100 text-brass-700',
    default    => 'bg-navy-100 text-navy-700',
  };
@endphp

{{-- HERO --}}
<section class="bg-navy-900 bg-blueprint pt-32 pb-20">
  <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

    {{-- Breadcrumb --}}
    <div class="flex items-center gap-2 text-sm text-navy-100 mb-6 font-sans flex-wrap">
      <a href="{{ route('home') }}" class="hover:text-brass-300 transition-colors">Beranda</a>
      <span class="text-navy-100/50">/</span>
      <a href="{{ route('services.index') }}" class="hover:text-brass-300 transition-colors">Layanan</a>
      <span class="text-navy-100/50">/</span>
      <span class="text-brass-300">{{ $service->title }}</span>
    </div>

    {{-- Division badge --}}
    <span class="inline-flex items-center gap-2 text-xs font-sans font-semibold uppercase tracking-widest px-4 py-1.5 rounded-full mb-5 {{ $divBadgeClass }}">
      @if($service->icon)
        <i class="{{ $service->icon }} text-sm"></i>
      @endif
      {{ $divLabel }}
    </span>

    <h1 class="font-display text-4xl sm:text-5xl lg:text-6xl text-white font-semibold max-w-3xl mb-6 leading-tight">
      {{ $service->title }}
    </h1>

    @if($service->excerpt)
    <p class="text-navy-100 text-lg max-w-2xl leading-relaxed">{{ $service->excerpt }}</p>
    @endif

  </div>
</section>

{{-- COVER IMAGE --}}
@if($service->cover_image)
<div class="bg-navy-800">
  <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
    <div class="relative -mt-10 rounded-sm overflow-hidden shadow-xl aspect-video max-h-[480px]">
      <img src="{{ kgp_image($service->cover_image, $service->id, 1280, 480) }}"
           alt="{{ $service->title }}"
           class="w-full h-full object-cover">
    </div>
  </div>
</div>
@endif

{{-- BODY --}}
<section class="bg-paper py-16 lg:py-24">
  <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-12">

      {{-- Main description --}}
      <div class="lg:col-span-2 reveal">
        <p class="text-xs font-sans font-semibold uppercase tracking-widest {{ $accentClass }} mb-3">Tentang Layanan</p>
        <h2 class="font-display text-2xl sm:text-3xl text-navy-800 font-semibold mb-8">
          Deskripsi Layanan
        </h2>

        @if($service->description)
        <div class="rich-text">
          {!! nl2br(e($service->description)) !!}
        </div>
        @else
        <p class="text-slate-400 font-sans italic">Deskripsi layanan belum tersedia.</p>
        @endif
      </div>

      {{-- Sidebar --}}
      <aside class="lg:col-span-1 space-y-6 reveal" style="transition-delay:120ms">

        {{-- Service meta card --}}
        <div class="bg-card border border-line rounded-sm shadow-sm p-6">
          <h3 class="font-display text-lg text-navy-800 font-semibold mb-4">Informasi Layanan</h3>
          <dl class="space-y-3 text-sm font-sans">
            <div>
              <dt class="text-slate-400 uppercase tracking-wide text-xs font-semibold mb-0.5">Divisi</dt>
              <dd class="text-navy-800 font-medium">{{ $divLabel }}</dd>
            </div>
            @if($service->icon)
            <div>
              <dt class="text-slate-400 uppercase tracking-wide text-xs font-semibold mb-0.5">Kategori</dt>
              <dd>
                <span class="inline-flex items-center justify-center w-8 h-8 rounded-lg {{ $iconBgClass }}">
                  <i class="{{ $service->icon }}"></i>
                </span>
              </dd>
            </div>
            @endif
          </dl>
        </div>

        {{-- CTA card --}}
        <div class="bg-navy-900 rounded-sm p-6">
          <h3 class="font-display text-lg text-white font-semibold mb-3">
            Butuh Layanan Ini?
          </h3>
          <p class="text-navy-100 text-sm leading-relaxed mb-5">
            Tim kami siap mendiskusikan kebutuhan dan menyiapkan penawaran terbaik untuk institusi Anda.
          </p>
          <x-button as="a" href="{{ route('contact') }}" variant="accent" size="md">Hubungi Kami</x-button>
          <div class="mt-3">
            <a href="{{ route('portfolio.index') }}" class="text-sm text-navy-100 hover:text-brass-300 transition-colors font-sans">
              Lihat proyek terkait &rarr;
            </a>
          </div>
        </div>

        {{-- Back link (desktop sidebar) --}}
        <div class="hidden lg:block">
          <a href="{{ route('services.index') }}"
             class="inline-flex items-center gap-2 text-sm font-sans font-semibold text-navy-700 hover:text-brass-700 transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/>
            </svg>
            Kembali ke Semua Layanan
          </a>
        </div>

      </aside>
    </div>
  </div>
</section>

{{-- PROCESS STRIP — Alur Kerja Kami --}}
<section class="bg-paper2 py-16 lg:py-24 border-t border-line">
  <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

    <div class="text-center mb-14 reveal">
      <p class="text-xs font-sans font-semibold uppercase tracking-widest text-brass-700 mb-3">Cara Kami Bekerja</p>
      <h2 class="font-display text-2xl sm:text-3xl text-navy-800 font-semibold">
        Alur Kerja Kami
      </h2>
      <p class="text-slate-500 mt-3 max-w-lg mx-auto font-sans text-sm leading-relaxed">
        Setiap proyek dijalankan dengan proses terstruktur dan transparan — memastikan hasil yang sesuai harapan.
      </p>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-0 relative reveal">

      {{-- Connector line (desktop only) --}}
      <div class="hidden lg:block absolute top-10 left-[12.5%] right-[12.5%] h-px bg-line z-0"></div>

      @php
        $steps = [
          ['num' => '01', 'title' => 'Konsultasi', 'desc' => 'Kami memahami kebutuhan, tujuan, dan kendala proyek Anda secara mendalam melalui diskusi awal.'],
          ['num' => '02', 'title' => 'Perencanaan', 'desc' => 'Tim menyusun desain, spesifikasi teknis, dan rencana anggaran biaya yang terperinci dan terukur.'],
          ['num' => '03', 'title' => 'Pelaksanaan', 'desc' => 'Pengerjaan dilakukan oleh tenaga ahli bersertifikat dengan pengawasan ketat dan laporan berkala.'],
          ['num' => '04', 'title' => 'Serah Terima', 'desc' => 'Hasil pekerjaan diserahkan dengan dokumentasi lengkap, uji fungsi, dan garansi purna jual.'],
        ];
      @endphp

      @foreach($steps as $i => $step)
      <div class="flex flex-col items-center text-center px-6 py-8 relative z-10"
           style="transition-delay:{{ $i * 100 }}ms">
        {{-- Step number circle --}}
        <div class="w-20 h-20 rounded-full bg-navy-800 border-4 border-paper2 flex items-center justify-center mb-5 shadow-md">
          <span class="font-display text-2xl font-bold text-brass-300 tabular">{{ $step['num'] }}</span>
        </div>
        <h3 class="font-display text-lg text-navy-800 font-semibold mb-2">{{ $step['title'] }}</h3>
        <p class="text-slate-500 text-sm leading-relaxed font-sans">{{ $step['desc'] }}</p>
      </div>
      @endforeach

    </div>
  </div>
</section>

{{-- CTA BAND --}}
<section class="bg-navy-900 bg-brass-glow py-16 lg:py-20 reveal">
  <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 text-center">
    <h2 class="font-display text-3xl sm:text-4xl text-white font-semibold mb-4">
      Tertarik dengan Layanan Ini?
    </h2>
    <p class="text-navy-100 max-w-lg mx-auto mb-8 leading-relaxed font-sans">
      Hubungi kami sekarang dan dapatkan konsultasi awal secara gratis. Bersama KGP, proyek Anda dikerjakan profesional dari awal hingga selesai.
    </p>
    <div class="flex flex-col sm:flex-row gap-4 justify-center">
      <x-button as="a" href="{{ route('contact') }}" variant="accent" size="lg">Konsultasi Gratis</x-button>
      <x-button as="a" href="{{ route('services.index') }}" variant="light" size="lg">Layanan Lainnya</x-button>
    </div>
  </div>
</section>

{{-- BACK LINK (mobile) --}}
<section class="bg-paper2 py-8 border-t border-line lg:hidden">
  <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
    <a href="{{ route('services.index') }}"
       class="inline-flex items-center gap-2 text-sm font-sans font-semibold text-navy-700 hover:text-brass-700 transition-colors">
      <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/>
      </svg>
      Kembali ke Layanan
    </a>
  </div>
</section>

@endsection
