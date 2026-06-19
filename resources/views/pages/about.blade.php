@extends('layouts.app')
@section('title', 'Tentang Kami — KGP')
@section('meta_description', 'Mengenal lebih dekat PT. Kreasindo Graha Persada — perjalanan, visi, misi, dan komitmen kami melayani instansi nasional sejak 2016.')

@section('content')

{{-- PAGE HERO --}}
<section class="relative bg-navy-900 bg-blueprint overflow-hidden pt-32 pb-16">
  <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
    <nav class="flex items-center gap-2 font-sans text-xs font-semibold text-navy-100 mb-6">
      <a href="{{ route('home') }}" class="hover:text-brass-300 transition-colors">Beranda</a>
      <span class="text-white/30">/</span>
      <span class="text-brass-300">Tentang Kami</span>
    </nav>
    <p class="font-sans text-xs font-semibold uppercase tracking-widest text-brass-300 mb-3">Profil Perusahaan</p>
    <h1 class="font-display text-4xl lg:text-5xl font-semibold text-white">Tentang Kami</h1>
    <p class="mt-4 font-sans text-base text-navy-100 max-w-2xl">
      Mengenal lebih dekat PT. Kreasindo Graha Persada — perjalanan, visi, dan komitmen kami melayani instansi nasional.
    </p>
  </div>
</section>

{{-- COMPANY HISTORY --}}
<section class="bg-paper py-16 lg:py-24">
  <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-start">

      {{-- Visual placeholder --}}
      <div class="relative aspect-[4/3.2] rounded-sm overflow-hidden bg-gradient-to-br from-navy-600 to-navy-900 shadow-md">
        <div class="absolute inset-0"
             style="background-image: repeating-linear-gradient(135deg, rgba(255,255,255,.05) 0 2px, transparent 2px 26px);">
        </div>
      </div>

      {{-- Text --}}
      <div>
        <p class="font-sans text-xs font-semibold uppercase tracking-widest text-brass-700 mb-2">Profil Singkat</p>
        <h2 class="font-display text-3xl lg:text-4xl font-semibold text-navy-900 mb-4">
          {{ $company['name'] }}
        </h2>
        <div class="font-sans text-slate-500 leading-relaxed space-y-4 rich-text">
          <p>{{ $company['history'] }}</p>
        </div>
      </div>
    </div>
  </div>
</section>

{{-- VISION & MISSION --}}
<section class="bg-paper2 py-16 lg:py-24">
  <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
    <div class="mb-12">
      <p class="font-sans text-xs font-semibold uppercase tracking-widest text-brass-700 mb-2">01 — Arah Perusahaan</p>
      <h2 class="font-display text-3xl lg:text-4xl font-semibold text-navy-900">Visi &amp; Misi</h2>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-5 gap-6">

      {{-- Vision card (dark) --}}
      <div class="lg:col-span-2 bg-navy-800 rounded-sm p-8 flex flex-col">
        <p class="font-sans text-xs font-semibold uppercase tracking-widest text-brass-300 mb-4">Visi</p>
        <p class="font-display text-xl font-medium text-white leading-relaxed flex-1">
          {{ $company['vision'] }}
        </p>
      </div>

      {{-- Mission card (light) --}}
      <div class="lg:col-span-3 bg-card border border-line rounded-sm p-8">
        <p class="font-sans text-xs font-semibold uppercase tracking-widest text-brass-700 mb-4">Misi</p>
        <ul class="space-y-0 divide-y divide-line">
          @foreach($company['mission'] as $i => $item)
          <li class="flex gap-4 py-4">
            <span class="font-display font-semibold text-brass-700 flex-shrink-0 w-6 text-sm">
              {{ str_pad($i + 1, 2, '0', STR_PAD_LEFT) }}
            </span>
            <span class="font-sans text-sm text-slate-700 leading-relaxed">{{ $item }}</span>
          </li>
          @endforeach
        </ul>
      </div>
    </div>
  </div>
</section>

{{-- BOARD OF DIRECTORS --}}
<section class="bg-paper py-16 lg:py-24">
  <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
    <div class="mb-12 text-center">
      <p class="font-sans text-xs font-semibold uppercase tracking-widest text-brass-700 mb-2">02 — Kepemimpinan</p>
      <h2 class="font-display text-3xl lg:text-4xl font-semibold text-navy-900">Dewan Direksi</h2>
      <p class="mt-3 font-sans text-slate-500 max-w-md mx-auto">
        Tim manajemen inti yang mengarahkan strategi dan operasional perusahaan.
      </p>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
      @foreach($directors as $director)
      <div class="bg-card border border-line rounded-sm shadow-sm hover:shadow-md transition-shadow p-6 text-center">
        {{-- Photo or initial placeholder --}}
        @if(!empty($director['photo']))
          <img src="{{ asset('storage/'.$director['photo']) }}"
               alt="{{ $director['name'] }}"
               class="w-24 h-24 rounded-full object-cover mx-auto mb-4 border-4 border-line">
        @else
          <div class="w-24 h-24 rounded-full bg-gradient-to-br from-navy-600 to-navy-800 mx-auto mb-4 border-4 border-line flex items-center justify-center">
            <span class="font-display text-2xl font-semibold text-brass-300">
              {{ strtoupper(substr($director['name'], 0, 1)) }}
            </span>
          </div>
        @endif

        <p class="font-sans text-xs font-semibold uppercase tracking-wider text-brass-700 mb-1">
          {{ $director['position'] }}
        </p>
        <h3 class="font-display text-base font-semibold text-navy-800">
          {{ $director['name'] }}
        </h3>
      </div>
      @endforeach
    </div>
  </div>
</section>

{{-- LEGALITIES --}}
<section class="bg-paper2 py-16 lg:py-24">
  <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
    <div class="mb-12">
      <p class="font-sans text-xs font-semibold uppercase tracking-widest text-brass-700 mb-2">03 — Legalitas</p>
      <h2 class="font-display text-3xl lg:text-4xl font-semibold text-navy-900">Dokumen Resmi Perusahaan</h2>
      <p class="mt-3 font-sans text-slate-500 max-w-xl">
        Seluruh legalitas KGP terverifikasi dan dapat diunduh pada halaman Dokumen Legal.
      </p>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
      @foreach($legalities as $legal)
      <div class="bg-card border border-line rounded-sm p-5 flex items-center gap-4 hover:shadow-sm transition-shadow">
        <div class="w-11 h-11 rounded-sm bg-navy-100 flex items-center justify-center flex-shrink-0">
          <span class="font-sans text-xs font-bold text-navy-700">{{ $legal['code'] }}</span>
        </div>
        <div>
          <p class="font-display text-sm font-semibold text-navy-800">{{ $legal['label'] }}</p>
        </div>
      </div>
      @endforeach
    </div>

    <div class="mt-8">
      <x-button as="a" href="{{ route('documents') }}" variant="primary" size="md">
        Lihat Semua Dokumen Legal &rarr;
      </x-button>
    </div>
  </div>
</section>

@endsection
