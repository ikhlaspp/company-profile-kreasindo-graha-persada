@extends('layouts.app')
@section('title', 'Klien Kami — KGP')
@section('meta_description', 'Dipercaya oleh instansi pemerintah, militer, BUMN, dan korporasi swasta di seluruh Indonesia — PT. Kreasindo Graha Persada.')

@section('content')

{{-- PAGE HERO --}}
<section class="relative bg-navy-900 bg-blueprint overflow-hidden pt-32 pb-20">
  <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
    {{-- Breadcrumb --}}
    <nav class="flex items-center gap-2 font-sans text-xs font-semibold text-navy-100 mb-8">
      <a href="{{ route('home') }}" class="hover:text-brass-300 transition-colors">Beranda</a>
      <span class="text-white/30">/</span>
      <span class="text-brass-300">Klien Kami</span>
    </nav>

    <p class="font-sans text-xs font-semibold uppercase tracking-widest text-brass-300 mb-4">Kepercayaan</p>
    <h1 class="font-display text-4xl lg:text-6xl font-semibold text-white leading-tight mb-6">
      Klien Kami
    </h1>
    <p class="font-sans text-lg text-navy-100 max-w-2xl leading-relaxed">
      Dipercaya oleh instansi pemerintah, TNI/Polri, BUMN, dan korporasi nasional
      untuk solusi IT, interior, sipil, dan mekanikal &amp; elektrikal di seluruh Indonesia.
    </p>

    {{-- Trust stats --}}
    <div class="mt-10 flex flex-wrap gap-6 lg:gap-12">
      <div>
        <p class="font-display text-3xl font-semibold text-brass-300 tabular">10+</p>
        <p class="font-sans text-xs text-navy-100 mt-1 uppercase tracking-widest">Tahun Pengalaman</p>
      </div>
      <div>
        <p class="font-display text-3xl font-semibold text-brass-300 tabular">{{ count($categories) }}+</p>
        <p class="font-sans text-xs text-navy-100 mt-1 uppercase tracking-widest">Kategori Klien</p>
      </div>
      <div>
        <p class="font-display text-3xl font-semibold text-brass-300 tabular">TNI/Polri</p>
        <p class="font-sans text-xs text-navy-100 mt-1 uppercase tracking-widest">Penghargaan Militer</p>
      </div>
    </div>
  </div>
</section>

{{-- CLIENT CATEGORIES --}}
@foreach($categories as $key => $label)
@php $group = $clients[$key] ?? []; $count = is_countable($group) ? count($group) : 0; @endphp

<section class="{{ $loop->even ? 'bg-paper2' : 'bg-paper' }} py-16 lg:py-20">
  <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 reveal">

    {{-- Category heading --}}
    <div class="flex items-center gap-4 mb-10">
      <div class="w-12 h-12 rounded-sm flex items-center justify-center flex-shrink-0 font-sans font-bold text-xs border
        @if($key === 'militer') bg-navy-100 text-navy-800 border-navy-200
        @elseif($key === 'pemerintah') bg-green-50 text-green-800 border-green-100
        @elseif($key === 'bumn') bg-brass-100 text-brass-700 border-brass-200
        @else bg-blue-50 text-blue-800 border-blue-100
        @endif">
        {{ strtoupper(substr($key, 0, 3)) }}
      </div>
      <div>
        <p class="font-sans text-xs font-semibold uppercase tracking-widest text-brass-700 mb-1">
          @if($key === 'militer') TNI / Polri
          @elseif($key === 'pemerintah') Instansi Pemerintah
          @elseif($key === 'bumn') Perusahaan Negara
          @else Sektor Swasta
          @endif
        </p>
        <h2 class="font-display text-2xl lg:text-3xl font-semibold text-navy-900">{{ $label }}</h2>
        @if($count > 0)
        <p class="font-sans text-sm text-slate-400 mt-0.5">{{ $count }} instansi terdaftar</p>
        @endif
      </div>
    </div>

    {{-- Client logo wall --}}
    @if($count > 0)
    <div class="grid grid-cols-3 sm:grid-cols-4 md:grid-cols-5 lg:grid-cols-6 xl:grid-cols-8 gap-4 lg:gap-5">
      @foreach($group as $i => $client)
      @php
        $delay = ($i % 8) * 60;
      @endphp

      @if(!empty($client->website))
      <a href="{{ $client->website }}" target="_blank" rel="noopener"
         class="group flex flex-col items-center gap-3 p-4 bg-card border border-line rounded-sm shadow-sm
                hover:border-brass-500/50 hover:shadow-md hover:-translate-y-1 transition-all duration-200"
         style="transition-delay: {{ $delay }}ms"
         title="{{ $client->name }}">
      @else
      <div class="group flex flex-col items-center gap-3 p-4 bg-card border border-line rounded-sm shadow-sm
                  hover:border-brass-500/50 hover:shadow-md hover:-translate-y-1 transition-all duration-200"
           style="transition-delay: {{ $delay }}ms">
      @endif

        {{-- Logo circle --}}
        <div class="w-14 h-14 rounded-full bg-paper2 border border-line flex items-center justify-center overflow-hidden flex-shrink-0 group-hover:border-brass-300/40 transition-colors">
          @if(!empty($client->logo))
            <img src="{{ kgp_image($client->logo, 'client-'.$client->id, 200, 200) }}"
                 alt="{{ $client->name }}"
                 class="w-10 h-10 object-contain grayscale group-hover:grayscale-0 transition-all duration-300">
          @else
            <span class="font-display text-lg font-semibold text-navy-700 group-hover:text-navy-900 transition-colors">
              {{ strtoupper(substr($client->name, 0, 1)) }}
            </span>
          @endif
        </div>

        {{-- Client name --}}
        <p class="font-sans text-xs text-slate-500 group-hover:text-navy-700 text-center leading-tight transition-colors line-clamp-2">
          {{ $client->name }}
        </p>

      @if(!empty($client->website))
      </a>
      @else
      </div>
      @endif

      @endforeach
    </div>
    @else
    <p class="font-sans text-sm text-slate-400 italic">Belum ada klien terdaftar pada kategori ini.</p>
    @endif

  </div>
</section>

@endforeach

{{-- TRUST STATEMENT --}}
<section class="bg-navy-900 bg-blueprint py-16 lg:py-24">
  <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 reveal">
    <div class="max-w-3xl mx-auto text-center">
      <p class="font-sans text-xs font-semibold uppercase tracking-widest text-brass-300 mb-4">Bukti Kepercayaan</p>
      <h2 class="font-display text-3xl lg:text-4xl font-semibold text-white mb-6 leading-snug">
        Penghargaan dari TNI AL &amp; Rekam Jejak Nasional
      </h2>
      <p class="font-sans text-navy-100 text-lg leading-relaxed mb-8">
        KGP telah menerima Penghargaan TNI AL Bidang Informasi (IT) dan Bukti Tanda Lulus Seskoal &amp; Kolinlamil —
        bukti nyata komitmen kami melayani institusi strategis nasional dengan standar tertinggi.
      </p>
      <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
        <x-button as="a" href="{{ route('contact') }}" variant="accent" size="lg">
          Hubungi Kami
        </x-button>
        <x-button as="a" href="{{ route('documents') }}" variant="light" size="lg">
          Lihat Legalitas
        </x-button>
      </div>
    </div>
  </div>
</section>

{{-- CLOSING CTA --}}
<section class="bg-paper2 py-16">
  <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 reveal">
    <div class="bg-card border border-line rounded-sm shadow-sm px-8 py-10 flex flex-col lg:flex-row items-center justify-between gap-6">
      <div>
        <h3 class="font-display text-xl lg:text-2xl font-semibold text-navy-900 mb-2">
          Bergabunglah dengan Klien Kami
        </h3>
        <p class="font-sans text-slate-500 max-w-lg">
          Diskusikan kebutuhan IT, interior, konstruksi, atau ME institusi Anda bersama tim profesional kami.
        </p>
      </div>
      <div class="flex-shrink-0">
        <x-button as="a" href="{{ route('contact') }}" variant="accent" size="lg">
          Mulai Diskusi
        </x-button>
      </div>
    </div>
  </div>
</section>

@endsection
