@extends('layouts.app')
@section('title', 'Galeri — KGP')
@section('meta_description', 'Galeri dokumentasi visual proyek-proyek PT. Kreasindo Graha Persada — IT, interior, sipil, dan event.')

@section('content')

{{-- PAGE HERO --}}
<section class="relative bg-navy-900 bg-blueprint overflow-hidden pt-32 pb-20">
  <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
    <nav class="flex items-center gap-2 font-sans text-xs font-semibold text-navy-100 mb-8">
      <a href="{{ route('home') }}" class="hover:text-brass-300 transition-colors">Beranda</a>
      <span class="text-white/30">/</span>
      <span class="text-brass-300">Galeri</span>
    </nav>
    <p class="font-sans text-xs font-semibold uppercase tracking-widest text-brass-300 mb-4">Dokumentasi Visual</p>
    <h1 class="font-display text-4xl lg:text-6xl font-semibold text-white leading-tight mb-6">
      Galeri Proyek
    </h1>
    <p class="font-sans text-lg text-navy-100 max-w-2xl leading-relaxed">
      Dokumentasi visual dari proyek-proyek yang telah kami kerjakan di berbagai divisi —
      IT, interior &amp; furnitur, sipil/konstruksi, hingga mekanikal &amp; elektrikal.
    </p>
  </div>
</section>

{{-- FILTER + GRID --}}
<section class="bg-paper py-16 lg:py-24">
  <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

    {{-- Division filter pills --}}
    <div class="flex flex-wrap gap-2 mb-12 reveal">
      <a href="{{ route('gallery.index') }}"
         class="inline-flex items-center px-5 py-2.5 rounded-full text-sm font-sans font-semibold border transition-all duration-200
                {{ !request('divisi') ? 'bg-navy-800 text-white border-navy-800 shadow-sm' : 'bg-card text-slate-500 border-line hover:border-navy-600 hover:text-navy-700 hover:shadow-sm' }}">
        Semua Album
      </a>
      @foreach($divisions as $dKey => $dLabel)
      <a href="{{ route('gallery.index', ['divisi' => $dKey]) }}"
         class="inline-flex items-center px-5 py-2.5 rounded-full text-sm font-sans font-semibold border transition-all duration-200
                {{ request('divisi') === $dKey ? 'bg-navy-800 text-white border-navy-800 shadow-sm' : 'bg-card text-slate-500 border-line hover:border-navy-600 hover:text-navy-700 hover:shadow-sm' }}">
        {{ $dLabel }}
      </a>
      @endforeach
    </div>

    {{-- Album grid --}}
    @forelse($galleries as $gallery)
    @if($loop->first)
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-5 reveal">
    @endif

      {{-- Image-forward tile: minimal text; on hover the bottom blurs and the title fades in --}}
      <a href="{{ route('gallery.show', $gallery->slug) }}"
         class="group relative block aspect-[16/10] overflow-hidden rounded-sm bg-gradient-to-br from-navy-700 to-navy-900 shadow-sm"
         style="transition-delay: {{ ($loop->index % 3) * 80 }}ms"
         aria-label="{{ $gallery->title }}">

        {{-- Cover image --}}
        @if($gallery->cover_image)
          <img src="{{ kgp_image($gallery->cover_image, 'gallery-'.$gallery->id, 900, 600) }}"
               alt="{{ $gallery->title }}"
               class="absolute inset-0 w-full h-full object-cover transition-transform duration-700 group-hover:scale-105">
        @else
          <div class="absolute inset-0 flex items-center justify-center">
            <svg class="w-14 h-14 text-navy-100/20" fill="none" stroke="currentColor" stroke-width="1" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909M3 20.25h18A2.25 2.25 0 0023.25 18V6A2.25 2.25 0 0021 3.75H3A2.25 2.25 0 00.75 6v12A2.25 2.25 0 003 20.25z"/>
            </svg>
          </div>
        @endif

        {{-- Hover reveal: bottom of the image blurs a little + title fades in --}}
        <div class="absolute bottom-0 inset-x-0 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
          <div class="backdrop-blur-sm bg-gradient-to-t from-navy-900/80 via-navy-900/35 to-transparent px-5 pt-12 pb-4">
            <h3 class="font-display text-white text-base sm:text-lg font-medium leading-snug translate-y-1 group-hover:translate-y-0 transition-transform duration-300">
              {{ $gallery->title }}
            </h3>
          </div>
        </div>
      </a>

    @if($loop->last)
    </div>
    @endif

    @empty
    <div class="text-center py-24 reveal">
      <div class="w-20 h-20 rounded-full bg-navy-100 flex items-center justify-center mx-auto mb-5">
        <svg class="w-10 h-10 text-navy-600/50" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909M3 20.25h18A2.25 2.25 0 0023.25 18V6A2.25 2.25 0 0021 3.75H3A2.25 2.25 0 00.75 6v12A2.25 2.25 0 003 20.25z"/>
        </svg>
      </div>
      <h3 class="font-display text-navy-900 text-xl font-semibold mb-2">Belum Ada Album</h3>
      <p class="font-sans text-slate-500 mb-6">
        @if(request('divisi'))
          Belum ada album galeri untuk divisi ini.
        @else
          Belum ada album galeri untuk ditampilkan.
        @endif
      </p>
      @if(request('divisi'))
      <x-button as="a" href="{{ route('gallery.index') }}" variant="outline" size="md">
        Lihat Semua Album
      </x-button>
      @endif
    </div>
    @endforelse

    {{-- Pagination --}}
    @if($galleries->hasPages())
    <div class="mt-12">
      {{ $galleries->links() }}
    </div>
    @endif

  </div>
</section>

{{-- CTA --}}
<x-cta-band
  eyebrow="Mari Berkolaborasi"
  title="Ingin Proyek Anda Terwujud?"
  body="Konsultasikan kebutuhan IT, interior, atau konstruksi Anda kepada tim kami." />

@endsection
