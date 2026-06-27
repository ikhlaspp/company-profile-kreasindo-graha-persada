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

{{-- CLIENT LOGO GRID — flat layout: logo on top, client name underneath --}}
@php
  // Flatten the category-grouped collection into one ordered list.
  $allClients = collect($clients)->flatten(1)->sortBy('sort_order')->values();

  // Initials (max 2 words, skips PT./CV.) for the placeholder badge until a real logo is uploaded.
  $clientInitials = function ($name) {
      $clean = preg_replace('/^(PT\.?|CV\.?)\s+/i', '', trim($name));
      $words = preg_split('/\s+/', $clean);
      return strtoupper(implode('', array_map(fn ($w) => substr($w, 0, 1), array_slice($words, 0, 2))));
  };
@endphp

<section class="bg-paper py-16 lg:py-24">
  <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

    <div class="text-center max-w-2xl mx-auto mb-14 reveal">
      <p class="font-sans text-xs font-semibold uppercase tracking-widest text-brass-700 mb-3">Klien Kami</p>
      <h2 class="font-display text-3xl lg:text-4xl font-semibold text-navy-900 mb-4">Dipercaya Instansi Terkemuka</h2>
      <p class="font-sans text-slate-500 leading-relaxed">
        Kami berkesempatan melayani berbagai instansi pemerintah, TNI/Polri, BUMN, universitas,
        dan korporasi nasional di seluruh Indonesia.
      </p>
    </div>

    @if($allClients->isNotEmpty())
    <div class="reveal grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-x-6 gap-y-12">
      @foreach($allClients as $i => $client)
      @php $delay = ($i % 5) * 60; @endphp

      @if(!empty($client->website))
      <a href="{{ $client->website }}" target="_blank" rel="noopener"
         class="group flex flex-col items-center text-center gap-4" title="{{ $client->name }}"
         style="transition-delay: {{ $delay }}ms">
      @else
      <div class="group flex flex-col items-center text-center gap-4" style="transition-delay: {{ $delay }}ms">
      @endif

        {{-- Logo (real upload if present, else initials placeholder) --}}
        <div class="w-24 h-24 rounded-full bg-card border border-line shadow-sm flex items-center justify-center overflow-hidden
                    group-hover:border-brass-500/50 group-hover:shadow-md transition-all duration-300">
          @if(!empty($client->logo))
            <img src="{{ asset('storage/'.$client->logo) }}" alt="{{ $client->name }}"
                 class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
          @else
            <span class="font-display text-2xl font-bold text-navy-700 group-hover:text-brass-700 transition-colors">
              {{ $clientInitials($client->name) }}
            </span>
          @endif
        </div>

        {{-- Client name --}}
        <p class="font-sans text-sm font-semibold text-navy-800 leading-snug max-w-[12rem]">
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
    <p class="text-center font-sans text-slate-400 italic">Daftar klien akan segera ditampilkan.</p>
    @endif

  </div>
</section>

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
