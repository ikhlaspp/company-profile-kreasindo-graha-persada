@extends('layouts.app')
@section('title', $service->title . ' — KGP')
@section('meta_description', $service->excerpt ?? 'Detail layanan ' . $service->title . ' dari PT. Kreasindo Graha Persada.')

@section('content')

{{-- HERO --}}
<section class="bg-navy-900 bg-blueprint pt-32 pb-20">
  <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
    {{-- Breadcrumb --}}
    <div class="flex items-center gap-2 text-sm text-navy-100 mb-6 font-sans flex-wrap">
      <a href="{{ route('home') }}" class="hover:text-brass-300 transition-colors">Beranda</a>
      <span class="text-navy-100/50">/</span>
      <a href="{{ route('services.index') }}" class="hover:text-brass-300 transition-colors">Layanan</a>
      <span class="text-navy-100/50">/</span>
      <span class="text-brass-300">{{ $service->title }}</span>
    </div>

    {{-- Division badge --}}
    @php
      $divLabel = match($service->division) {
        'it' => 'Divisi IT',
        'interior' => 'Divisi Interior',
        'me' => 'Mekanikal & Elektrikal',
        default => ucfirst($service->division),
      };
      $divClass = match($service->division) {
        'it' => 'bg-navy-700 text-navy-100',
        'interior' => 'bg-brass-700 text-brass-100',
        default => 'bg-navy-700 text-navy-100',
      };
    @endphp
    <span class="inline-block text-xs font-sans font-semibold uppercase tracking-widest px-4 py-1.5 rounded-full mb-5 {{ $divClass }}">
      {{ $divLabel }}
    </span>

    <h1 class="font-display text-4xl sm:text-5xl text-white font-semibold max-w-3xl mb-6">
      {{ $service->title }}
    </h1>

    @if($service->excerpt)
    <p class="text-navy-100 text-lg max-w-2xl leading-relaxed">{{ $service->excerpt }}</p>
    @endif
  </div>
</section>

{{-- COVER IMAGE --}}
@if($service->cover_image)
<div class="bg-navy-800">
  <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
    <div class="relative -mt-10 rounded-sm overflow-hidden shadow-xl aspect-video max-h-[480px]">
      <img src="{{ asset('storage/' . $service->cover_image) }}"
           alt="{{ $service->title }}"
           class="w-full h-full object-cover">
    </div>
  </div>
</div>
@endif

{{-- BODY --}}
<section class="bg-paper py-16 lg:py-24">
  <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-12">

      {{-- Main description --}}
      <div class="lg:col-span-2">
        <p class="text-xs font-sans font-semibold uppercase tracking-widest text-brass-700 mb-3">Tentang Layanan</p>
        <h2 class="font-display text-2xl sm:text-3xl text-navy-800 font-semibold mb-8">
          Deskripsi Layanan
        </h2>

        @if($service->description)
        <div class="rich-text text-slate-700 leading-relaxed">
          {!! nl2br(e($service->description)) !!}
        </div>
        @else
        <p class="text-slate-400 font-sans italic">Deskripsi layanan belum tersedia.</p>
        @endif
      </div>

      {{-- Sidebar --}}
      <aside class="lg:col-span-1">
        {{-- Service meta card --}}
        <div class="bg-card border border-line rounded-sm shadow-sm p-6 mb-6">
          <h3 class="font-display text-lg text-navy-800 font-semibold mb-4">Informasi Layanan</h3>
          <dl class="space-y-3 text-sm font-sans">
            <div>
              <dt class="text-slate-400 uppercase tracking-wide text-xs font-semibold mb-0.5">Divisi</dt>
              <dd class="text-navy-800 font-medium">{{ $divLabel }}</dd>
            </div>
            @if($service->icon)
            <div>
              <dt class="text-slate-400 uppercase tracking-wide text-xs font-semibold mb-0.5">Kategori</dt>
              <dd class="text-navy-800"><i class="{{ $service->icon }}"></i></dd>
            </div>
            @endif
          </dl>
        </div>

        {{-- CTA card --}}
        <div class="bg-navy-900 rounded-sm p-6">
          <h3 class="font-display text-lg text-white font-semibold mb-3">
            Butuh Layanan Ini?
          </h3>
          <p class="text-navy-100 text-sm leading-relaxed mb-5">
            Tim kami siap mendiskusikan kebutuhan dan menyiapkan penawaran terbaik untuk institusi Anda.
          </p>
          <x-button as="a" href="{{ route('contact') }}" variant="accent" size="md">Hubungi Kami</x-button>
          <div class="mt-3">
            <a href="{{ route('portfolio.index') }}" class="text-sm text-navy-100 hover:text-brass-300 transition-colors font-sans">
              Lihat proyek terkait &rarr;
            </a>
          </div>
        </div>
      </aside>

    </div>
  </div>
</section>

{{-- BACK LINK --}}
<section class="bg-paper2 py-8 border-t border-line">
  <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
    <a href="{{ route('services.index') }}"
       class="inline-flex items-center gap-2 text-sm font-sans font-semibold text-navy-700 hover:text-brass-700 transition-colors">
      <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/>
      </svg>
      Kembali ke Layanan
    </a>
  </div>
</section>

@endsection
