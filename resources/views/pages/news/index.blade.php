@extends('layouts.app')
@section('title', 'Berita & Artikel — KGP')
@section('meta_description', 'Berita dan artikel terbaru dari PT. Kreasindo Graha Persada — perkembangan proyek, kegiatan, dan informasi perusahaan.')

@section('content')

{{-- HERO --}}
<section class="bg-navy-900 bg-blueprint pt-32 pb-20 relative overflow-hidden">
  <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 relative z-10">
    {{-- Breadcrumb --}}
    <div class="flex items-center gap-2 text-sm text-navy-100 mb-6 font-sans flex-wrap">
      <a href="{{ route('home') }}" class="hover:text-brass-300 transition-colors">Beranda</a>
      <span class="text-navy-100/40">/</span>
      <span class="text-brass-300">Berita</span>
    </div>
    {{-- Eyebrow --}}
    <p class="text-xs font-sans font-semibold uppercase tracking-widest text-brass-300 mb-4">Informasi Terkini</p>
    {{-- Title --}}
    <h1 class="font-display text-4xl sm:text-5xl lg:text-6xl text-white font-semibold mb-6 max-w-3xl leading-tight">
      Berita &amp; Artikel
    </h1>
    {{-- Intro --}}
    <p class="text-navy-100 text-lg max-w-2xl leading-relaxed">
      Ikuti perkembangan terbaru, proyek selesai, dan aktivitas PT. Kreasindo Graha Persada
      di bidang teknologi, konstruksi, dan layanan terpadu.
    </p>
  </div>
</section>

{{-- CATEGORY PILLS --}}
@if($categories->isNotEmpty())
<section class="bg-paper2 border-b border-line py-5">
  <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
    <div class="flex flex-wrap items-center gap-2">
      <span class="text-xs font-sans font-semibold uppercase tracking-widest text-slate-400 mr-2">Kategori:</span>
      @foreach($categories as $cat)
      <span class="inline-flex items-center gap-1.5 px-4 py-1.5 rounded-full text-sm font-sans font-semibold border border-line bg-card text-slate-600 hover:border-navy-600 hover:text-navy-700 transition-all duration-200">
        {{ $cat->name }}
        <span class="inline-flex items-center justify-center w-5 h-5 rounded-full bg-navy-100 text-navy-700 text-xs tabular font-bold">{{ $cat->posts_count }}</span>
      </span>
      @endforeach
    </div>
  </div>
</section>
@endif

{{-- FEATURED ARTICLE HERO --}}
@php
  $firstPost = $posts->first();
  $restPosts = $posts->slice(1);
@endphp

@if($firstPost)
<section class="bg-paper py-14 lg:py-20">
  <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

    {{-- Section label --}}
    <div class="flex items-center gap-3 mb-8">
      <span class="w-8 h-0.5 bg-brass-500"></span>
      <p class="text-xs font-sans font-semibold uppercase tracking-widest text-brass-700">Artikel Utama</p>
    </div>

    {{-- Featured card --}}
    <a href="{{ route('news.show', $firstPost->slug) }}"
       class="group block bg-card border border-line rounded-sm shadow-sm hover:shadow-lg transition-all duration-300 overflow-hidden lg:grid lg:grid-cols-2">

      {{-- Featured thumbnail --}}
      <div class="relative aspect-[16/10] lg:aspect-auto lg:min-h-[380px] overflow-hidden">
        @if($firstPost->thumbnail)
          <img src="{{ asset('storage/'.$firstPost->thumbnail) }}"
               alt="{{ $firstPost->title }}"
               class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500 ease-out">
        @else
          <div class="w-full h-full bg-navy-900 bg-blueprint flex items-center justify-center relative">
            <div class="absolute inset-0 bg-brass-glow opacity-30"></div>
            <div class="relative flex flex-col items-center gap-4 text-center px-8">
              <span class="w-16 h-16 border-2 border-brass-500 rounded-sm flex items-center justify-center font-display font-bold text-3xl text-white">K</span>
              @if($firstPost->category)
              <span class="text-xs font-sans font-semibold uppercase tracking-widest text-brass-300">{{ $firstPost->category->name }}</span>
              @endif
            </div>
          </div>
        @endif
        {{-- Overlay gradient on hover --}}
        <div class="absolute inset-0 bg-gradient-to-r from-navy-900/20 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300 lg:block hidden"></div>
        {{-- "Artikel Terbaru" badge --}}
        <div class="absolute top-4 left-4">
          <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded bg-brass-500 text-navy-900 text-xs font-sans font-semibold shadow">
            <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"/></svg>
            Artikel Terbaru
          </span>
        </div>
      </div>

      {{-- Featured content --}}
      <div class="p-8 lg:p-10 flex flex-col justify-center">
        {{-- Category + date row --}}
        <div class="flex flex-wrap items-center gap-3 mb-4">
          @if($firstPost->category)
          <span class="inline-block px-3 py-1 rounded text-xs font-sans font-semibold bg-navy-100 text-navy-700">
            {{ $firstPost->category->name }}
          </span>
          @endif
          <span class="text-xs font-sans font-semibold text-brass-700">
            {{ $firstPost->published_at?->translatedFormat('d F Y') }}
          </span>
        </div>

        {{-- Title --}}
        <h2 class="font-display text-2xl sm:text-3xl lg:text-4xl text-navy-800 font-semibold leading-tight mb-4 group-hover:text-navy-600 transition-colors">
          {{ $firstPost->title }}
        </h2>

        {{-- Excerpt --}}
        @if($firstPost->excerpt)
        <p class="text-slate-500 font-sans leading-relaxed mb-6 line-clamp-3">
          {{ $firstPost->excerpt }}
        </p>
        @endif

        {{-- CTA --}}
        <div class="flex items-center gap-2 mt-auto">
          <span class="inline-flex items-center gap-2 text-sm font-sans font-semibold text-navy-700 group-hover:text-brass-700 transition-colors">
            Baca Selengkapnya
            <svg class="w-4 h-4 transition-transform group-hover:translate-x-1" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
            </svg>
          </span>
        </div>
      </div>
    </a>

    {{-- REMAINING POSTS GRID --}}
    @if($restPosts->isNotEmpty())
    <div class="mt-10 lg:mt-14">
      <div class="flex items-center gap-3 mb-8">
        <span class="w-8 h-0.5 bg-brass-500"></span>
        <p class="text-xs font-sans font-semibold uppercase tracking-widest text-brass-700">Artikel Lainnya</p>
      </div>

      <div class="reveal grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($restPosts as $i => $post)
        <a href="{{ route('news.show', $post->slug) }}"
           class="group flex flex-col bg-card border border-line rounded-sm shadow-sm hover:shadow-md transition-all duration-300 overflow-hidden"
           style="{{ $i > 0 ? 'transition-delay:' . min(($i * 80), 320) . 'ms' : '' }}">

          {{-- Thumbnail --}}
          <div class="aspect-[16/10] overflow-hidden flex-shrink-0">
            @if($post->thumbnail)
              <img src="{{ asset('storage/'.$post->thumbnail) }}"
                   alt="{{ $post->title }}"
                   class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300"
                   loading="lazy">
            @else
              <div class="w-full h-full bg-gradient-to-br from-navy-600 to-navy-900 flex items-center justify-center">
                <svg class="w-10 h-10 text-navy-100/25" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M12 7.5h1.5m-1.5 3h1.5m-7.5 3h7.5m-7.5 3h7.5m3-9h3.375c.621 0 1.125.504 1.125 1.125V18a2.25 2.25 0 01-2.25 2.25M16.5 7.5V18a2.25 2.25 0 002.25 2.25M16.5 7.5V4.875c0-.621-.504-1.125-1.125-1.125H4.125C3.504 3.75 3 4.254 3 4.875V18a2.25 2.25 0 002.25 2.25h13.5M6 7.5h3v3H6v-3z"/>
                </svg>
              </div>
            @endif
          </div>

          {{-- Card body --}}
          <div class="p-5 flex flex-col flex-1">
            {{-- Category + date --}}
            <div class="flex flex-wrap items-center gap-2 mb-2">
              @if($post->category)
              <span class="inline-block px-2 py-0.5 rounded text-xs font-sans font-semibold bg-navy-100 text-navy-700">
                {{ $post->category->name }}
              </span>
              @endif
              <span class="text-xs font-sans font-semibold text-brass-700">
                {{ $post->published_at?->translatedFormat('d F Y') }}
              </span>
            </div>

            {{-- Title --}}
            <h3 class="font-display text-navy-800 font-semibold text-base leading-snug mb-2 group-hover:text-navy-600 transition-colors line-clamp-2 flex-1">
              {{ $post->title }}
            </h3>

            {{-- Excerpt --}}
            @if($post->excerpt)
            <p class="text-sm font-sans text-slate-500 leading-relaxed line-clamp-2 mb-3">
              {{ $post->excerpt }}
            </p>
            @endif

            {{-- Reading hint --}}
            <div class="flex items-center gap-1.5 mt-auto pt-3 border-t border-line">
              <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.966 8.966 0 00-6 2.292m0-14.25v14.25"/>
              </svg>
              <span class="text-xs font-sans font-semibold text-brass-700 group-hover:text-brass-500 transition-colors">
                Baca selengkapnya &rarr;
              </span>
            </div>
          </div>
        </a>
        @endforeach
      </div>
    </div>
    @endif

    {{-- Pagination --}}
    @if($posts->hasPages())
    <div class="mt-12">
      {{ $posts->links() }}
    </div>
    @endif

  </div>
</section>

@else
{{-- EMPTY STATE --}}
<section class="bg-paper py-24">
  <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
    <div class="text-center reveal">
      <div class="w-20 h-20 rounded-full bg-navy-100 flex items-center justify-center mx-auto mb-6">
        <svg class="w-10 h-10 text-navy-600/50" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" d="M12 7.5h1.5m-1.5 3h1.5m-7.5 3h7.5m-7.5 3h7.5m3-9h3.375c.621 0 1.125.504 1.125 1.125V18a2.25 2.25 0 01-2.25 2.25M16.5 7.5V18a2.25 2.25 0 002.25 2.25M16.5 7.5V4.875c0-.621-.504-1.125-1.125-1.125H4.125C3.504 3.75 3 4.254 3 4.875V18a2.25 2.25 0 002.25 2.25h13.5M6 7.5h3v3H6v-3z"/>
        </svg>
      </div>
      <h3 class="font-display text-2xl text-navy-800 font-semibold mb-2">Belum Ada Artikel</h3>
      <p class="text-slate-400 font-sans text-sm mb-8 max-w-xs mx-auto">Belum ada artikel yang dipublikasikan. Kunjungi kembali nanti.</p>
      <x-button as="a" href="{{ route('home') }}" variant="primary" size="md">Kembali ke Beranda</x-button>
    </div>
  </div>
</section>
@endif

{{-- CTA --}}
<x-cta-band
  eyebrow="Hubungi Kami"
  title="Ada Proyek yang Ingin Anda Diskusikan?"
  body="Tim KGP siap membantu kebutuhan IT, interior, dan konstruksi institusi Anda — dari konsultasi hingga penyelesaian proyek." />

@endsection
