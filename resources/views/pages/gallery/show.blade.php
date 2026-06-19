@extends('layouts.app')
@section('title', $gallery->title . ' — Galeri KGP')
@section('meta_description', $gallery->description ?? 'Album galeri ' . $gallery->title . ' — PT. Kreasindo Graha Persada.')

@section('content')

@php
  $divLabels = ['it' => 'IT', 'interior' => 'Interior', 'sipil' => 'Sipil', 'event' => 'Event'];
  $divLabel  = $divLabels[$gallery->division] ?? ucfirst($gallery->division);

  $photoData = $gallery->photos->map(fn($p) => [
    'src'     => asset('storage/'.$p->file_path),
    'caption' => $p->caption ?? '',
  ])->values()->all();
@endphp

{{-- HERO --}}
<section class="bg-navy-900 bg-blueprint pt-32 pb-20">
  <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

    {{-- Breadcrumb --}}
    <div class="flex items-center gap-2 text-sm text-navy-100 mb-6 font-sans flex-wrap">
      <a href="{{ route('home') }}" class="hover:text-brass-300 transition-colors">Beranda</a>
      <span class="text-navy-100/50">/</span>
      <a href="{{ route('gallery.index') }}" class="hover:text-brass-300 transition-colors">Galeri</a>
      <span class="text-navy-100/50">/</span>
      <span class="text-brass-300">{{ $gallery->title }}</span>
    </div>

    <span class="inline-block px-3 py-1 rounded text-xs font-sans font-semibold bg-brass-700/30 text-brass-300 border border-brass-700/40 mb-4">
      Divisi {{ $divLabel }}
    </span>
    <h1 class="font-display text-4xl sm:text-5xl text-white font-semibold mb-4 max-w-3xl">
      {{ $gallery->title }}
    </h1>
    @if($gallery->description)
    <p class="text-navy-100 text-lg max-w-2xl leading-relaxed">
      {{ $gallery->description }}
    </p>
    @endif
  </div>
</section>

{{-- PHOTO GRID with Alpine.js lightbox --}}
<section class="bg-paper py-16 lg:py-24"
  x-data="{
    open: false,
    idx: 0,
    photos: {{ Js::from($photoData) }},
    openAt(i) { this.idx = i; this.open = true; },
    prev() { this.idx = (this.idx - 1 + this.photos.length) % this.photos.length; },
    next() { this.idx = (this.idx + 1) % this.photos.length; },
  }"
  @keydown.escape.window="open = false"
  @keydown.arrow-left.window="if(open) prev()"
  @keydown.arrow-right.window="if(open) next()">

  <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

    {{-- Back link --}}
    <div class="mb-8">
      <a href="{{ route('gallery.index') }}"
         class="inline-flex items-center gap-2 text-sm font-sans font-semibold text-slate-500 hover:text-navy-700 transition-colors">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18"/>
        </svg>
        Kembali ke Galeri
      </a>
    </div>

    @if($gallery->photos->isEmpty())
    {{-- Empty state --}}
    <div class="text-center py-20">
      <div class="w-16 h-16 rounded-full bg-navy-100 flex items-center justify-center mx-auto mb-4">
        <svg class="w-8 h-8 text-navy-600" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909M3 20.25h18A2.25 2.25 0 0023.25 18V6A2.25 2.25 0 0021 3.75H3A2.25 2.25 0 00.75 6v12A2.25 2.25 0 003 20.25z"/>
        </svg>
      </div>
      <p class="font-sans text-slate-500">Album ini belum memiliki foto.</p>
    </div>
    @else
    {{-- Photo grid --}}
    <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-3 sm:gap-4">
      @foreach($gallery->photos as $i => $photo)
      <button type="button"
              @click="openAt({{ $i }})"
              class="group relative aspect-square overflow-hidden rounded-sm bg-gradient-to-br from-navy-600 to-navy-900 focus:outline-none focus:ring-2 focus:ring-brass-500 focus:ring-offset-2">
        <img src="{{ asset('storage/'.$photo->file_path) }}"
             alt="{{ $photo->caption ?? $gallery->title }}"
             class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
        @if($photo->caption)
        <div class="absolute inset-x-0 bottom-0 bg-gradient-to-t from-navy-900/80 to-transparent p-3 translate-y-full group-hover:translate-y-0 transition-transform duration-200">
          <p class="text-white text-xs font-sans leading-snug line-clamp-2">{{ $photo->caption }}</p>
        </div>
        @endif
      </button>
      @endforeach
    </div>
    @endif

  </div>

  {{-- Lightbox --}}
  <div x-show="open"
       x-cloak
       class="fixed inset-0 z-50 bg-navy-900/95 flex items-center justify-center p-4 sm:p-10"
       @click.self="open = false">

    {{-- Close button --}}
    <button type="button"
            @click="open = false"
            class="absolute top-4 right-4 sm:top-6 sm:right-6 w-10 h-10 rounded-full bg-white/10 border border-white/20 text-white flex items-center justify-center hover:bg-white/20 transition-colors focus:outline-none focus:ring-2 focus:ring-brass-500">
      <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
      </svg>
    </button>

    {{-- Prev --}}
    <button type="button"
            @click.stop="prev()"
            x-show="photos.length > 1"
            class="absolute left-3 sm:left-6 top-1/2 -translate-y-1/2 w-10 h-10 rounded-full bg-white/10 border border-white/20 text-white flex items-center justify-center hover:bg-white/20 transition-colors focus:outline-none focus:ring-2 focus:ring-brass-500">
      <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5"/>
      </svg>
    </button>

    {{-- Image --}}
    <div class="relative max-w-4xl w-full">
      <template x-if="photos.length > 0">
        <img :src="photos[idx].src"
             :alt="photos[idx].caption || ''"
             class="w-full max-h-[75vh] object-contain rounded-sm shadow-2xl">
      </template>

      {{-- Caption --}}
      <template x-if="photos[idx] && photos[idx].caption">
        <div class="mt-4 text-center">
          <p class="text-navy-100 font-sans text-sm" x-text="photos[idx].caption"></p>
        </div>
      </template>

      {{-- Counter --}}
      <div class="absolute -top-8 left-1/2 -translate-x-1/2 text-navy-100/60 text-xs font-sans tabular">
        <span x-text="idx + 1"></span> / <span x-text="photos.length"></span>
      </div>
    </div>

    {{-- Next --}}
    <button type="button"
            @click.stop="next()"
            x-show="photos.length > 1"
            class="absolute right-3 sm:right-6 top-1/2 -translate-y-1/2 w-10 h-10 rounded-full bg-white/10 border border-white/20 text-white flex items-center justify-center hover:bg-white/20 transition-colors focus:outline-none focus:ring-2 focus:ring-brass-500">
      <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5"/>
      </svg>
    </button>

  </div>

</section>

@endsection
