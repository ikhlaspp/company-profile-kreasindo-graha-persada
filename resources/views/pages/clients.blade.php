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
      Kami berkesempatan melayani berbagai instansi pemerintah, TNI/Polri, BUMN, universitas,
      dan korporasi nasional di seluruh Indonesia.
    </p>

    {{-- Trust stats --}}
    <div class="mt-10 flex flex-wrap gap-6 lg:gap-12">
      <div>
        <p class="font-display text-3xl font-semibold text-brass-300 tabular">{{ collect($clients)->flatten(1)->count() }}+</p>
        <p class="font-sans text-xs text-navy-100 mt-1 uppercase tracking-widest">Klien &amp; Mitra</p>
      </div>
      <div>
        <p class="font-display text-3xl font-semibold text-brass-300 tabular">10+</p>
        <p class="font-sans text-xs text-navy-100 mt-1 uppercase tracking-widest">Tahun Pengalaman</p>
      </div>
      <div>
        <p class="font-display text-3xl font-semibold text-brass-300 tabular">Nasional</p>
        <p class="font-sans text-xs text-navy-100 mt-1 uppercase tracking-widest">Jangkauan Layanan</p>
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

{{-- CLOSING CTA --}}
<x-cta-band
  eyebrow="Bergabung Bersama Kami"
  title="Bergabunglah dengan Klien Kami"
  body="Diskusikan kebutuhan IT, interior, konstruksi, atau ME institusi Anda bersama tim profesional kami." />

@endsection
