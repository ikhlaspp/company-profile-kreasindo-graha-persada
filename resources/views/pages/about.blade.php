@extends('layouts.app')
@section('title', 'Tentang Kami — PT. Kreasindo Graha Persada')
@section('meta_description', 'Mengenal lebih dekat PT. Kreasindo Graha Persada — profil, visi, misi, peranan, legalitas, dan struktur manajemen sejak 2016.')

@section('content')

{{-- ============================================================
     HERO
     ============================================================ --}}
<section class="relative bg-navy-900 bg-blueprint overflow-hidden pt-32 pb-20">
  <div class="absolute inset-0 bg-gradient-to-br from-navy-900/90 via-navy-900/70 to-navy-800/60 pointer-events-none"></div>

  <div class="relative mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
    <nav class="flex items-center gap-2 font-sans text-xs font-semibold text-navy-100 mb-8" aria-label="Breadcrumb">
      <a href="{{ route('home') }}" class="hover:text-brass-300 transition-colors">Beranda</a>
      <span class="text-white/30" aria-hidden="true">/</span>
      <span class="text-brass-300">Tentang Kami</span>
    </nav>

    <div class="max-w-3xl">
      <p class="font-sans text-xs font-semibold uppercase tracking-widest text-brass-300 mb-3">
        Profil Perusahaan
      </p>
      <h1 class="font-display text-5xl lg:text-6xl font-semibold text-white leading-tight mb-5">
        Tentang Kami
      </h1>
      <p class="font-sans text-lg text-navy-100 leading-relaxed max-w-xl">
        Mengenal lebih dekat PT. Kreasindo Graha Persada — perjalanan, visi, dan komitmen kami melayani instansi nasional sejak 2016.
      </p>
    </div>

    <div class="mt-10 flex items-center gap-4">
      <div class="h-px w-16 bg-brass-500"></div>
      <div class="h-px w-4 bg-brass-700"></div>
    </div>
  </div>
</section>

{{-- ============================================================
     STICKY TAB BAR
     Pins under the fixed navbar (h-16 = 4rem). Alpine scrollspy
     watches all 5 sections via IntersectionObserver and sets
     `active` to the current section id. Horizontal-scroll on mobile.
     ============================================================ --}}
<div
  x-data="{
    active: 'profil',
    tabs: [
      { id: 'profil',    label: 'Profil Perusahaan' },
      { id: 'visi-misi', label: 'Visi & Misi' },
      { id: 'peranan',   label: 'Peranan & Komitmen' },
      { id: 'legalitas', label: 'Legalitas' },
      { id: 'struktur',  label: 'Struktur & Manajemen' }
    ],
    scrollTo(id) {
      const el = document.getElementById(id);
      if (el) el.scrollIntoView({ behavior: 'smooth', block: 'start' });
    },
    init() {
      const sections = ['profil','visi-misi','peranan','legalitas','struktur']
        .map(id => document.getElementById(id))
        .filter(Boolean);

      if (!('IntersectionObserver' in window) || window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
        return;
      }

      const io = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
          if (entry.isIntersecting) {
            this.active = entry.target.id;
          }
        });
      }, {
        rootMargin: '-20% 0px -60% 0px',
        threshold: 0
      });

      sections.forEach(s => io.observe(s));
    }
  }"
  class="sticky top-16 z-30 w-full bg-paper2/95 backdrop-blur border-y border-line shadow-sm"
>
  <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
    <div class="flex items-center gap-1 overflow-x-auto scrollbar-none py-2" role="tablist" aria-label="Navigasi halaman Tentang Kami">
      <template x-for="tab in tabs" :key="tab.id">
        <button
          type="button"
          role="tab"
          :aria-selected="active === tab.id"
          @click="scrollTo(tab.id)"
          :class="active === tab.id
            ? 'bg-navy-900 text-white'
            : 'text-navy-800 hover:bg-navy-100 hover:text-navy-900'"
          class="flex-shrink-0 font-sans text-sm font-semibold px-4 py-1.5 rounded-sm transition-all duration-200 whitespace-nowrap focus:outline-none focus-visible:ring-2 focus-visible:ring-brass-500"
          x-text="tab.label"
        ></button>
      </template>
    </div>
  </div>
</div>

{{-- ============================================================
     SECTION 1 — PROFIL PERUSAHAAN
     ============================================================ --}}
<section id="profil" class="scroll-mt-32 bg-paper py-16 lg:py-24">
  <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

    <div class="mb-12 reveal">
      <h2 class="font-display text-3xl lg:text-4xl font-semibold text-navy-900">Profil Perusahaan</h2>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 lg:gap-16 items-start">

      {{-- LEFT — text content --}}
      <div class="reveal space-y-8">

        {{-- Main paragraph --}}
        <p class="font-sans text-slate-600 leading-relaxed text-base">
          {{ $profile['paragraph'] }}
        </p>

        {{-- Badge --}}
        <div class="inline-flex items-center gap-2 bg-navy-900 border border-brass-700/30 rounded-sm px-4 py-2 shadow-sm">
          <div class="w-2 h-2 rounded-full bg-brass-500 flex-shrink-0"></div>
          <span class="font-sans text-xs font-bold uppercase tracking-widest text-brass-300">{{ $profile['badge'] }}</span>
        </div>

        {{-- Family quote card --}}
        <blockquote class="relative bg-card border-l-4 border-brass-500 border border-line rounded-sm p-6 shadow-sm">
          <div class="absolute top-4 right-5 font-display text-6xl text-brass-300/30 leading-none select-none pointer-events-none" aria-hidden="true">&ldquo;</div>
          <p class="font-display text-base italic text-navy-800 leading-relaxed relative z-10">
            &ldquo;{{ $profile['familyQuote'] }}&rdquo;
          </p>
          <footer class="mt-4 font-sans text-xs font-semibold uppercase tracking-widest text-brass-700">
            — {{ $profile['signature'] }}
          </footer>
        </blockquote>

        {{-- Collapsible kata pengantar direksi --}}
        <div x-data="{ open: false }">
          <button
            type="button"
            @click="open = !open"
            class="inline-flex items-center gap-2 font-sans text-sm font-semibold text-navy-800 border border-line bg-card hover:bg-navy-100 hover:text-navy-900 rounded-sm px-5 py-2.5 transition-all duration-200 shadow-sm group"
            :aria-expanded="open"
          >
            <svg class="w-4 h-4 text-brass-700 transition-transform duration-300" :class="{ 'rotate-180': open }" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
              <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/>
            </svg>
            <span x-text="open ? 'Sembunyikan Sambutan Direksi' : 'Baca Sambutan Direksi'"></span>
          </button>

          <div
            x-show="open"
            x-transition:enter="transition duration-300 ease-out"
            x-transition:enter-start="opacity-0 -translate-y-2"
            x-transition:enter-end="opacity-100 translate-y-0"
            x-transition:leave="transition duration-200 ease-in"
            x-transition:leave-start="opacity-100 translate-y-0"
            x-transition:leave-end="opacity-0 -translate-y-2"
            class="mt-4 bg-card border border-line rounded-sm p-6 shadow-sm space-y-4"
          >
            <p class="font-sans text-xs font-bold uppercase tracking-widest text-brass-700 mb-2">Kata Pengantar Direksi</p>
            @foreach($profile['kataPengantar'] as $para)
            <p class="font-sans text-sm text-slate-600 leading-relaxed">{{ $para }}</p>
            @endforeach
            <div class="pt-2 border-t border-line">
              <p class="font-sans text-xs font-semibold uppercase tracking-widest text-navy-700">{{ $profile['signature'] }}</p>
            </div>
          </div>
        </div>

      </div>

      {{-- RIGHT — placeholder image --}}
      <div class="reveal relative aspect-[9/7] rounded-sm overflow-hidden shadow-lg" style="transition-delay:120ms">
        <img
          src="{{ kgp_image(null, 'kgp-about', 900, 700) }}"
          alt="PT. Kreasindo Graha Persada — kantor & tim"
          class="w-full h-full object-cover transition-transform duration-700 hover:scale-105"
          loading="lazy">
        {{-- brass corner accents --}}
        <div class="absolute top-0 left-0 w-16 h-1 bg-brass-500" aria-hidden="true"></div>
        <div class="absolute top-0 left-0 w-1 h-16 bg-brass-500" aria-hidden="true"></div>
        <div class="absolute bottom-0 right-0 w-16 h-1 bg-brass-500" aria-hidden="true"></div>
        <div class="absolute bottom-0 right-0 w-1 h-16 bg-brass-500" aria-hidden="true"></div>
        {{-- gradient overlay --}}
        <div class="absolute inset-0 bg-gradient-to-t from-navy-900/40 to-transparent pointer-events-none"></div>
        {{-- est. badge --}}
        <div class="absolute bottom-5 left-5 bg-navy-900/80 backdrop-blur-sm border border-brass-700/40 rounded-sm px-4 py-2">
          <p class="font-sans text-xs font-semibold uppercase tracking-widest text-brass-300">Est. 2016</p>
        </div>
      </div>

    </div>
  </div>
</section>

{{-- ============================================================
     SECTION 2 — VISI & MISI
     ============================================================ --}}
<section id="visi-misi" class="scroll-mt-32 bg-paper2 py-16 lg:py-24">
  <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

    <div class="mb-12 reveal">
      <h2 class="font-display text-3xl lg:text-4xl font-semibold text-navy-900">Visi &amp; Misi</h2>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-5 gap-6 lg:gap-8">

      {{-- VISION — large quote-style dark block --}}
      <div class="reveal lg:col-span-2 relative bg-navy-800 rounded-sm p-8 lg:p-10 flex flex-col overflow-hidden shadow-md" style="transition-delay:80ms">
        <div class="absolute top-4 right-6 font-display text-[120px] font-semibold text-white/5 leading-none select-none pointer-events-none" aria-hidden="true">&ldquo;</div>

        <p class="font-sans text-xs font-semibold uppercase tracking-widest text-brass-300 mb-6">Visi</p>

        <blockquote class="font-display text-xl lg:text-2xl font-medium text-white leading-relaxed flex-1 relative z-10">
          &ldquo;{{ $visi }}&rdquo;
        </blockquote>

        <div class="mt-8 h-px w-12 bg-brass-500"></div>
      </div>

      {{-- MISSION — numbered list --}}
      <div class="reveal lg:col-span-3 bg-card border border-line rounded-sm p-8 lg:p-10 shadow-sm" style="transition-delay:160ms">
        <p class="font-sans text-xs font-semibold uppercase tracking-widest text-brass-700 mb-6">Misi</p>

        <ol class="space-y-0 divide-y divide-line">
          @foreach($misi as $i => $item)
          <li class="flex gap-5 py-5 items-start">
            <span class="font-display font-bold text-brass-700 flex-shrink-0 w-7 text-base tabular leading-relaxed">
              {{ str_pad($i + 1, 2, '0', STR_PAD_LEFT) }}.
            </span>
            <span class="font-sans text-sm text-slate-700 leading-relaxed">{{ $item }}</span>
          </li>
          @endforeach
        </ol>
      </div>

    </div>
  </div>
</section>

{{-- ============================================================
     SECTION 3 — PERANAN & KOMITMEN
     ============================================================ --}}
<section id="peranan" class="scroll-mt-32 bg-paper py-16 lg:py-24">
  <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

    <div class="mb-8 reveal">
      <h2 class="font-display text-3xl lg:text-4xl font-semibold text-navy-900">Peranan &amp; Komitmen</h2>
    </div>

    <p class="reveal font-sans text-slate-600 leading-relaxed max-w-3xl mb-12" style="transition-delay:80ms">
      {{ $peranan['intro'] }}
    </p>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 lg:gap-8">
      @foreach($peranan['cards'] as $i => $card)
      @php
        // card accent: last card (100% Komitmen) gets navy treatment, others get card/line
        $isHighlight = ($card['title'] === '100% Komitmen');
      @endphp
      <div
        class="reveal rounded-sm shadow-sm overflow-hidden transition-all duration-300 hover:shadow-md hover:-translate-y-1 flex flex-col {{ $isHighlight ? 'bg-navy-900 border border-brass-700/30' : 'bg-card border border-line' }}"
        style="transition-delay:{{ $i * 100 }}ms"
      >
        {{-- Icon area --}}
        <div class="p-6 pb-4 flex items-start gap-4">
          <div class="flex-shrink-0 w-11 h-11 rounded-sm {{ $isHighlight ? 'bg-brass-700/30' : 'bg-navy-100' }} flex items-center justify-center">
            @if($card['icon'] === 'users')
            <svg class="w-5 h-5 {{ $isHighlight ? 'text-brass-300' : 'text-navy-700' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
              <path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
            </svg>
            @elseif($card['icon'] === 'badge-check')
            <svg class="w-5 h-5 {{ $isHighlight ? 'text-brass-300' : 'text-navy-700' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
              <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/>
            </svg>
            @else
            <svg class="w-5 h-5 {{ $isHighlight ? 'text-brass-300' : 'text-navy-700' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
              <path stroke-linecap="round" stroke-linejoin="round" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/>
            </svg>
            @endif
          </div>
          <div>
            <h3 class="font-display text-lg font-semibold {{ $isHighlight ? 'text-white' : 'text-navy-900' }} leading-snug">
              {{ $card['title'] }}
            </h3>
          </div>
        </div>

        <div class="px-6 pb-6 flex-1">
          <div class="h-px {{ $isHighlight ? 'bg-brass-700/40' : 'bg-line' }} mb-4"></div>
          <p class="font-sans text-sm leading-relaxed {{ $isHighlight ? 'text-navy-100' : 'text-slate-600' }}">
            {{ $card['body'] }}
          </p>
          @if($isHighlight)
          <div class="mt-5 inline-flex items-center gap-2">
            <div class="w-8 h-8 rounded-full bg-brass-500/20 flex items-center justify-center">
              <span class="font-display text-sm font-bold text-brass-300">✓</span>
            </div>
            <span class="font-sans text-xs font-bold uppercase tracking-widest text-brass-300">Garansi Kualitas</span>
          </div>
          @endif
        </div>
      </div>
      @endforeach
    </div>
  </div>
</section>

{{-- ============================================================
     SECTION 4 — LEGALITAS
     ============================================================ --}}
<section id="legalitas" class="scroll-mt-32 bg-paper2 py-16 lg:py-24">
  <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

    <div class="mb-12 reveal">
      <h2 class="font-display text-3xl lg:text-4xl font-semibold text-navy-900">Dokumen Resmi Perusahaan</h2>
      <p class="mt-3 font-sans text-slate-500 max-w-xl">
        Seluruh dokumen legalitas KGP telah terverifikasi. Klik badge untuk mengunduh pada halaman Dokumen.
      </p>
    </div>

    <div class="reveal grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-3 lg:gap-4" style="transition-delay:80ms">
      @foreach($legalitas as $i => $doc)
      <a
        href="{{ route('documents') }}"
        title="{{ $doc['number'] }}"
        class="group relative flex flex-col bg-card border border-line rounded-sm p-4 shadow-sm hover:shadow-md hover:-translate-y-0.5 hover:border-brass-500/40 transition-all duration-200"
        style="transition-delay:{{ $i * 40 }}ms"
      >
        {{-- green verified dot --}}
        <div class="absolute top-3 right-3 flex items-center gap-1">
          <div class="w-2 h-2 rounded-full bg-success" title="Terverifikasi" aria-label="Terverifikasi"></div>
        </div>

        {{-- label --}}
        <p class="font-sans text-xs font-bold uppercase tracking-wide text-navy-900 leading-tight pr-4 mb-2">
          {{ $doc['label'] }}
        </p>

        {{-- number (small, subtle) --}}
        <p class="font-sans text-[10px] text-slate-400 leading-tight line-clamp-2 tabular mt-auto">
          {{ $doc['number'] }}
        </p>

        {{-- hover: "Lihat Dokumen" --}}
        <div class="mt-3 pt-2 border-t border-line flex items-center gap-1 opacity-0 group-hover:opacity-100 transition-opacity duration-200">
          <span class="font-sans text-[10px] font-semibold uppercase tracking-wide text-brass-700">Lihat Dokumen</span>
          <svg class="w-3 h-3 text-brass-700" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5" aria-hidden="true">
            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
          </svg>
        </div>
      </a>
      @endforeach
    </div>

    <div class="mt-10 reveal" style="transition-delay:240ms">
      <x-button as="a" href="{{ route('documents') }}" variant="primary" size="md">
        Unduh Semua Dokumen Legal &rarr;
      </x-button>
    </div>

  </div>
</section>

{{-- ============================================================
     SECTION 5 — STRUKTUR & MANAJEMEN
     ============================================================ --}}
<section id="struktur" class="scroll-mt-32 bg-paper py-16 lg:py-24">
  <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

    <div class="mb-12 reveal">
      <h2 class="font-display text-3xl lg:text-4xl font-semibold text-navy-900">Struktur &amp; Manajemen</h2>
    </div>

    {{-- Leadership cards — 2 cards (Direktur Utama + Direktur Marketing per spec) --}}
    <div class="reveal grid grid-cols-1 sm:grid-cols-2 gap-6 lg:gap-8 mb-20" style="transition-delay:80ms">
      @foreach($leadership as $i => $leader)
      @php
        // Generate initials from name (up to 2 words)
        $parts    = preg_split('/\s+/', trim($leader['name']));
        $initials = strtoupper(implode('', array_map(fn($w) => substr($w, 0, 1), array_slice($parts, 0, 2))));
      @endphp
      <div
        class="bg-card border border-line rounded-sm shadow-sm hover:shadow-md transition-all duration-300 overflow-hidden group"
        style="transition-delay:{{ $i * 120 }}ms"
      >
        {{-- Photo / initials area --}}
        <div class="relative h-48 bg-gradient-to-br from-navy-700 to-navy-900 overflow-hidden">
          @if(!empty($leader['photo']))
            {{-- TODO: replace with real branded portrait when available --}}
            <img
              src="{{ asset('storage/' . $leader['photo']) }}"
              alt="{{ $leader['name'] }}"
              class="w-full h-full object-cover object-top group-hover:scale-105 transition-transform duration-500"
              loading="lazy">
            <div class="absolute inset-0 bg-gradient-to-t from-navy-900/60 to-transparent"></div>
          @else
            {{-- Placeholder: blueprint bg + initials --}}
            <div class="absolute inset-0 bg-blueprint opacity-25"></div>
            <div class="absolute inset-0 flex items-center justify-center">
              <div class="w-20 h-20 rounded-full bg-navy-800 border-2 border-brass-500/50 flex items-center justify-center shadow-lg">
                <span class="font-display text-3xl font-bold text-brass-300">{{ $initials }}</span>
              </div>
            </div>
            <div class="absolute inset-0 bg-gradient-to-t from-navy-900/60 to-transparent"></div>
          @endif
          {{-- brass corner --}}
          <div class="absolute top-0 right-0 w-8 h-1 bg-brass-500" aria-hidden="true"></div>
          <div class="absolute top-0 right-0 w-1 h-8 bg-brass-500" aria-hidden="true"></div>
        </div>

        {{-- Info --}}
        <div class="p-6">
          <p class="font-sans text-xs font-semibold uppercase tracking-widest text-brass-700 mb-1">
            {{ $leader['position'] }}
          </p>
          <h3 class="font-display text-xl font-semibold text-navy-800 mb-3">
            {{ $leader['name'] }}
          </h3>
          <div class="h-px w-10 bg-brass-500 mb-4"></div>
          <blockquote class="font-sans text-sm italic text-slate-500 leading-relaxed border-l-2 border-line pl-3">
            &ldquo;{{ $leader['quote'] }}&rdquo;
          </blockquote>
        </div>
      </div>
      @endforeach
    </div>

    {{-- ORG CHART (Tailwind-rendered boxes + connectors) --}}
    <div class="reveal" style="transition-delay:160ms">
      <p class="font-sans text-xs font-semibold uppercase tracking-widest text-brass-700 mb-8">Struktur Organisasi</p>

      {{-- Wrapper: horizontal scroll on mobile --}}
      <div class="overflow-x-auto pb-4">
        <div class="min-w-[680px]">

          {{-- LEVEL 1: Direktur Utama --}}
          <div class="flex justify-center mb-0">
            <div class="relative">
              <div class="bg-navy-900 border border-brass-700/40 rounded-sm px-5 py-3 text-center shadow-md min-w-[160px]">
                <p class="font-sans text-[10px] font-bold uppercase tracking-widest text-brass-300 mb-0.5">{{ $orgChart['position'] }}</p>
                <p class="font-display text-sm font-semibold text-white">{{ $orgChart['name'] }}</p>
              </div>
              {{-- connector down --}}
              <div class="absolute left-1/2 -translate-x-1/2 top-full w-px h-8 bg-line"></div>
            </div>
          </div>

          {{-- Horizontal connector bar at level-2 --}}
          <div class="flex justify-center">
            <div class="relative w-[440px] h-8 flex items-center justify-between">
              {{-- horizontal line --}}
              <div class="absolute left-[80px] right-[80px] top-0 h-px bg-line"></div>
              {{-- left drop --}}
              <div class="absolute left-[80px] top-0 w-px h-8 bg-line"></div>
              {{-- right drop --}}
              <div class="absolute right-[80px] top-0 w-px h-8 bg-line"></div>
            </div>
          </div>

          {{-- LEVEL 2: Direktur Operasional + Direktur Marketing --}}
          <div class="flex justify-between gap-4 mb-0 px-10">
            @foreach($orgChart['children'] as $dir)
            <div class="relative flex-1 flex flex-col items-center">
              <div class="bg-navy-800 border border-navy-700 rounded-sm px-4 py-3 text-center shadow-sm min-w-[140px] w-full max-w-[200px]">
                <p class="font-sans text-[10px] font-bold uppercase tracking-widest text-brass-300 mb-0.5">{{ $dir['position'] }}</p>
                <p class="font-display text-sm font-semibold text-white">{{ $dir['name'] }}</p>
              </div>
              {{-- connector down --}}
              <div class="w-px bg-line flex-1 min-h-[2rem]"></div>

              {{-- Horizontal connector for managers under this director --}}
              @if(count($dir['children']) > 1)
              <div class="relative w-full h-0">
                <div class="absolute left-1/4 right-1/4 top-0 h-px bg-line"></div>
              </div>
              @endif
            </div>
            @endforeach
          </div>

          {{-- LEVEL 3: Managers --}}
          <div class="flex justify-between gap-4 px-10 mb-0">
            @foreach($orgChart['children'] as $dirIdx => $dir)
            <div class="flex-1 flex {{ count($dir['children']) > 1 ? 'gap-3 justify-between' : 'justify-center' }}">
              @foreach($dir['children'] as $mgr)
              <div class="flex flex-col items-center flex-1 max-w-[180px]">
                <div class="bg-navy-100 border border-navy-200 rounded-sm px-4 py-2.5 text-center w-full">
                  <p class="font-sans text-[10px] font-semibold uppercase tracking-wide text-navy-600 mb-0.5">{{ $mgr['position'] }}</p>
                  <p class="font-sans text-sm font-semibold text-navy-900">{{ $mgr['name'] }}</p>
                </div>
                {{-- connector down --}}
                <div class="w-px h-6 bg-line"></div>

                {{-- LEVEL 4: Staff (3 generic boxes) --}}
                <div class="flex gap-1.5 justify-center">
                  @foreach($mgr['children'] as $staff)
                  <div class="bg-paper2 border border-line rounded-sm px-2 py-1.5 text-center">
                    <p class="font-sans text-[10px] text-slate-400">Staff</p>
                  </div>
                  @endforeach
                </div>
              </div>
              @endforeach
            </div>
            @endforeach
          </div>

        </div>
      </div>
    </div>

  </div>
</section>

{{-- ============================================================
     CLOSING CTA
     ============================================================ --}}
<section class="bg-navy-900 bg-blueprint py-16 lg:py-20">
  <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
    <div class="reveal max-w-2xl mx-auto text-center">
      <p class="font-sans text-xs font-semibold uppercase tracking-widest text-brass-300 mb-4">
        Siap Berkolaborasi?
      </p>
      <h2 class="font-display text-3xl lg:text-4xl font-semibold text-white mb-5 leading-tight">
        Wujudkan Proyek Anda Bersama KGP
      </h2>
      <p class="font-sans text-navy-100 leading-relaxed mb-8">
        Tim kami siap mendampingi dari konsultasi awal hingga serah terima proyek. Hubungi kami sekarang dan mulailah perjalanan kerja sama yang saling menguntungkan.
      </p>
      <div class="flex flex-wrap gap-3 justify-center">
        <x-button as="a" href="{{ route('contact') }}" variant="accent" size="lg">
          Hubungi Kami Sekarang
        </x-button>
        <x-button as="a" href="{{ route('services.index') }}" variant="outline" size="lg">
          Lihat Layanan
        </x-button>
      </div>
    </div>
  </div>
</section>

@endsection
