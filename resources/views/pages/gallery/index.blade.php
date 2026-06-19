@extends('layouts.app')
@section('title', 'Galeri — KGP')
@section('meta_description', 'Galeri dokumentasi visual proyek-proyek PT. Kreasindo Graha Persada — IT, interior, sipil, dan event.')

@section('content')

{{-- HERO --}}
<section class="bg-navy-900 bg-blueprint pt-32 pb-20">
  <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
    <p class="text-xs font-sans font-semibold uppercase tracking-widest text-brass-300 mb-3">Dokumentasi Visual</p>
    <h1 class="font-display text-4xl sm:text-5xl text-white font-semibold mb-4 max-w-2xl">
      Galeri
    </h1>
    <p class="text-navy-100 text-lg max-w-2xl leading-relaxed">
      Dokumentasi visual dari proyek-proyek yang telah kami kerjakan di berbagai divisi.
    </p>
  </div>
</section>

{{-- FILTER + GRID --}}
<section class="bg-paper py-16 lg:py-24">
  <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

    {{-- Division filter pills --}}
    <div class="flex flex-wrap gap-2 mb-10">
      <a href="{{ route('gallery.index') }}"
         class="inline-flex items-center px-5 py-2 rounded-full text-sm font-sans font-semibold border transition-colors
                {{ !request('divisi') ? 'bg-navy-800 text-white border-navy-800' : 'bg-card text-slate-500 border-line hover:border-navy-600 hover:text-navy-700' }}">
        Semua Album
      </a>
      @foreach($divisions as $dKey => $dLabel)
      <a href="{{ route('gallery.index', ['divisi' => $dKey]) }}"
         class="inline-flex items-center px-5 py-2 rounded-full text-sm font-sans font-semibold border transition-colors
                {{ request('divisi') === $dKey ? 'bg-navy-800 text-white border-navy-800' : 'bg-card text-slate-500 border-line hover:border-navy-600 hover:text-navy-700' }}">
        {{ $dLabel }}
      </a>
      @endforeach
    </div>

    {{-- Album grid --}}
    @forelse($galleries as $gallery)
    @if($loop->first)
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
    @endif

      <a href="{{ route('gallery.show', $gallery->slug) }}"
         class="group block bg-card border border-line rounded-sm shadow-sm hover:shadow-md transition-shadow overflow-hidden">

        {{-- Cover image --}}
        <div class="aspect-[4/3] overflow-hidden relative">
          @if($gallery->cover_image)
            <img src="{{ asset('storage/'.$gallery->cover_image) }}"
                 alt="{{ $gallery->title }}"
                 class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
          @else
            <div class="w-full h-full bg-gradient-to-br from-navy-600 to-navy-900 flex items-center justify-center">
              <svg class="w-12 h-12 text-navy-100/30" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909M3 20.25h18A2.25 2.25 0 0023.25 18V6A2.25 2.25 0 0021 3.75H3A2.25 2.25 0 00.75 6v12A2.25 2.25 0 003 20.25z"/>
              </svg>
            </div>
          @endif

          {{-- Division badge --}}
          @php
            $divLabels = ['it' => 'IT', 'interior' => 'Interior', 'sipil' => 'Sipil', 'event' => 'Event'];
            $divLabel = $divLabels[$gallery->division] ?? ucfirst($gallery->division);
          @endphp
          <span class="absolute top-3 left-3 px-2 py-1 rounded text-xs font-sans font-semibold bg-navy-800/90 text-brass-300 backdrop-blur-sm">
            {{ $divLabel }}
          </span>
        </div>

        {{-- Card body --}}
        <div class="p-4">
          <h3 class="font-display text-navy-800 font-semibold text-base leading-snug mb-1 group-hover:text-navy-600 transition-colors">
            {{ $gallery->title }}
          </h3>
          <p class="text-xs font-sans text-slate-400">{{ $gallery->photos_count }} Foto</p>
        </div>
      </a>

    @if($loop->last)
    </div>
    @endif

    @empty
    <div class="text-center py-20">
      <div class="w-16 h-16 rounded-full bg-navy-100 flex items-center justify-center mx-auto mb-4">
        <svg class="w-8 h-8 text-navy-600" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909M3 20.25h18A2.25 2.25 0 0023.25 18V6A2.25 2.25 0 0021 3.75H3A2.25 2.25 0 00.75 6v12A2.25 2.25 0 003 20.25z"/>
        </svg>
      </div>
      <p class="font-sans text-slate-500">Belum ada album galeri untuk ditampilkan.</p>
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

@endsection
