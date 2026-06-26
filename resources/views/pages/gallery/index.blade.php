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
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6 reveal">
    @endif

      <a href="{{ route('gallery.show', $gallery->slug) }}"
         class="group block bg-card border border-line rounded-sm shadow-sm hover:shadow-md hover:-translate-y-1 transition-all duration-300 overflow-hidden"
         style="transition-delay: {{ ($loop->index % 4) * 80 }}ms">

        {{-- Cover image --}}
        <div class="aspect-[4/3] overflow-hidden relative bg-gradient-to-br from-navy-700 to-navy-900">
          @if($gallery->cover_image)
            <img src="{{ kgp_image($gallery->cover_image, 'gallery-'.$gallery->id, 800, 600) }}"
                 alt="{{ $gallery->title }}"
                 class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
          @else
            <div class="w-full h-full flex items-center justify-center">
              <svg class="w-14 h-14 text-navy-100/20" fill="none" stroke="currentColor" stroke-width="1" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909M3 20.25h18A2.25 2.25 0 0023.25 18V6A2.25 2.25 0 0021 3.75H3A2.25 2.25 0 00.75 6v12A2.25 2.25 0 003 20.25z"/>
              </svg>
            </div>
          @endif

          {{-- Division badge --}}
          @php
            $divLabels = ['it' => 'IT', 'interior' => 'Interior', 'sipil' => 'Sipil', 'event' => 'Event'];
            $divLabel = $divLabels[$gallery->division] ?? ucfirst($gallery->division);
          @endphp
          <span class="absolute top-3 left-3 px-2.5 py-1 rounded text-xs font-sans font-semibold bg-navy-900/85 text-brass-300 backdrop-blur-sm border border-brass-700/30">
            {{ $divLabel }}
          </span>

          {{-- Photo count overlay --}}
          <div class="absolute bottom-0 inset-x-0 bg-gradient-to-t from-navy-900/80 via-navy-900/20 to-transparent p-4 translate-y-full group-hover:translate-y-0 transition-transform duration-300">
            <div class="flex items-center gap-1.5 text-white">
              <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909"/>
              </svg>
              <span class="font-sans text-sm font-semibold">Lihat {{ $gallery->photos_count }} Foto</span>
            </div>
          </div>
        </div>

        {{-- Card body --}}
        <div class="p-5">
          <h3 class="font-display text-navy-800 font-semibold text-base leading-snug mb-1.5 group-hover:text-navy-600 transition-colors">
            {{ $gallery->title }}
          </h3>
          <div class="flex items-center gap-3 text-xs font-sans text-slate-400">
            <span>{{ $gallery->photos_count }} Foto</span>
            <span class="w-1 h-1 rounded-full bg-slate-300"></span>
            <span>Divisi {{ $divLabel }}</span>
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
<section class="bg-paper2 py-16">
  <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 reveal">
    <div class="bg-card border border-line rounded-sm shadow-sm px-8 py-10 flex flex-col lg:flex-row items-center justify-between gap-6">
      <div>
        <h3 class="font-display text-xl lg:text-2xl font-semibold text-navy-900 mb-2">
          Ingin Proyek Anda Terwujud?
        </h3>
        <p class="font-sans text-slate-500 max-w-lg">
          Konsultasikan kebutuhan IT, interior, atau konstruksi Anda kepada tim kami.
        </p>
      </div>
      <div class="flex-shrink-0">
        <x-button as="a" href="{{ route('contact') }}" variant="accent" size="lg">
          Hubungi Kami
        </x-button>
      </div>
    </div>
  </div>
</section>

@endsection
