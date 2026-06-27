@extends('layouts.app')
@section('title', $post->title . ' — KGP')
@section('meta_description', $post->excerpt)

@section('content')

{{-- ARTICLE HERO --}}
<section class="bg-navy-900 bg-blueprint pt-32 pb-20 relative overflow-hidden">
  <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 relative z-10">

    {{-- Breadcrumb --}}
    <div class="flex items-center gap-2 text-sm text-navy-100 mb-6 font-sans flex-wrap">
      <a href="{{ route('home') }}" class="hover:text-brass-300 transition-colors">Beranda</a>
      <span class="text-navy-100/40">/</span>
      <a href="{{ route('news.index') }}" class="hover:text-brass-300 transition-colors">Berita</a>
      <span class="text-navy-100/40">/</span>
      <span class="text-brass-300">{{ Str::limit($post->title, 40) }}</span>
    </div>

    {{-- Category badge --}}
    @if($post->category)
    <span class="inline-block px-3 py-1 rounded text-xs font-sans font-semibold bg-brass-700/30 text-brass-300 border border-brass-700/40 mb-5">
      {{ $post->category->name }}
    </span>
    @endif

    {{-- Title --}}
    <h1 class="font-display text-4xl sm:text-5xl text-white font-semibold mb-8 max-w-3xl leading-tight">
      {{ $post->title }}
    </h1>

    {{-- Meta row --}}
    <div class="flex flex-wrap items-center gap-x-6 gap-y-3 text-sm font-sans text-navy-100/70 pt-6 border-t border-navy-700/60">
      @if($post->author)
      <span class="flex items-center gap-2">
        <span class="w-7 h-7 rounded-full bg-navy-700 border border-navy-600 flex items-center justify-center flex-shrink-0">
          <svg class="w-3.5 h-3.5 text-brass-400" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z"/>
          </svg>
        </span>
        <span class="text-navy-100/90">{{ $post->author->name }}</span>
      </span>
      @endif

      <span class="flex items-center gap-2">
        <span class="w-7 h-7 rounded-full bg-navy-700 border border-navy-600 flex items-center justify-center flex-shrink-0">
          <svg class="w-3.5 h-3.5 text-brass-400" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5"/>
          </svg>
        </span>
        {{ $post->published_at?->translatedFormat('d F Y') }}
      </span>

      <span class="flex items-center gap-2">
        <span class="w-7 h-7 rounded-full bg-navy-700 border border-navy-600 flex items-center justify-center flex-shrink-0">
          <svg class="w-3.5 h-3.5 text-brass-400" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.964-7.178z"/>
            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
          </svg>
        </span>
        <span class="tabular">{{ number_format($post->views_count) }}</span>&nbsp;kali dibaca
      </span>
    </div>

  </div>
</section>

{{-- ARTICLE BODY --}}
<section class="bg-paper py-16 lg:py-24">
  <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
    <div class="max-w-3xl mx-auto">

      {{-- Featured thumbnail (branded placeholder when none uploaded) --}}
      <div class="aspect-[16/8] overflow-hidden rounded-sm mb-10 shadow-md">
        @if($post->thumbnail)
          <img src="{{ asset('storage/'.$post->thumbnail) }}"
               alt="{{ $post->title }}"
               class="w-full h-full object-cover">
        @else
          <div class="w-full h-full bg-navy-900 bg-blueprint flex items-center justify-center relative">
            <div class="absolute inset-0 bg-brass-glow opacity-40"></div>
            <div class="relative flex flex-col items-center gap-3 text-center px-6">
              <span class="w-14 h-14 border-2 border-brass-500 rounded-sm flex items-center justify-center font-display font-bold text-2xl text-white">K</span>
              @if($post->category)
              <span class="text-xs font-sans font-semibold uppercase tracking-widest text-brass-300">{{ $post->category->name }}</span>
              @endif
            </div>
          </div>
        @endif
      </div>

      {{-- Article content --}}
      @if($post->content)
      <div class="rich-text">
        {!! nl2br(e($post->content)) !!}
      </div>
      @endif

      {{-- Tags --}}
      @if($post->tags->isNotEmpty())
      <div class="mt-10 pt-8 border-t border-line reveal">
        <p class="text-xs font-sans font-semibold uppercase tracking-widest text-slate-400 mb-3">Tag</p>
        <div class="flex flex-wrap gap-2">
          @foreach($post->tags as $tag)
          <span class="px-3 py-1 rounded-full text-xs font-sans font-semibold bg-navy-100 text-navy-700 border border-navy-100 hover:bg-navy-200 transition-colors">
            #{{ $tag->name }}
          </span>
          @endforeach
        </div>
      </div>
      @endif

      {{-- Back link --}}
      <div class="mt-10 pt-8 border-t border-line">
        <a href="{{ route('news.index') }}"
           class="inline-flex items-center gap-2 text-sm font-sans font-semibold text-slate-500 hover:text-navy-700 transition-colors group">
          <svg class="w-4 h-4 transition-transform group-hover:-translate-x-0.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18"/>
          </svg>
          Kembali ke Berita
        </a>
      </div>

    </div>
  </div>
</section>

{{-- RELATED POSTS --}}
@if($related->isNotEmpty())
<section class="bg-paper2 py-16 lg:py-24">
  <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

    <div class="flex items-center gap-3 mb-10">
      <span class="w-8 h-0.5 bg-brass-500"></span>
      <p class="text-xs font-sans font-semibold uppercase tracking-widest text-brass-700">Baca Juga</p>
    </div>
    <h2 class="font-display text-2xl sm:text-3xl text-navy-800 font-semibold mb-8 -mt-6">Artikel Terkait</h2>

    <div class="reveal grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
      @foreach($related as $i => $rel)
      <a href="{{ route('news.show', $rel->slug) }}"
         class="group flex flex-col bg-card border border-line rounded-sm shadow-sm hover:shadow-md transition-all duration-300 overflow-hidden"
         style="{{ $i > 0 ? 'transition-delay:' . ($i * 120) . 'ms' : '' }}">

        {{-- Thumbnail --}}
        <div class="aspect-[16/10] overflow-hidden flex-shrink-0">
          @if($rel->thumbnail)
            <img src="{{ asset('storage/'.$rel->thumbnail) }}"
                 alt="{{ $rel->title }}"
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
          @if($rel->category)
          <span class="inline-block px-2 py-0.5 rounded text-xs font-sans font-semibold bg-navy-100 text-navy-700 mb-2 self-start">
            {{ $rel->category->name }}
          </span>
          @endif
          <p class="text-xs font-sans font-semibold text-brass-700 mb-2">
            {{ $rel->published_at?->translatedFormat('d F Y') }}
          </p>
          <h3 class="font-display text-navy-800 font-semibold text-base leading-snug group-hover:text-navy-600 transition-colors line-clamp-2 flex-1">
            {{ $rel->title }}
          </h3>
          <div class="flex items-center gap-1.5 mt-4 pt-3 border-t border-line">
            <span class="text-xs font-sans font-semibold text-brass-700 group-hover:text-brass-500 transition-colors">
              Baca selengkapnya &rarr;
            </span>
          </div>
        </div>
      </a>
      @endforeach
    </div>

  </div>
</section>
@endif

{{-- CTA --}}
<x-cta-band
  eyebrow="Hubungi Kami"
  title="Siap Mendiskusikan Proyek Anda?"
  body="Dari teknologi IT, interior, hingga konstruksi — tim KGP hadir untuk solusi terpadu institusi Anda." />

@endsection
