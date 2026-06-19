@extends('layouts.app')
@section('title', $project->title . ' — KGP')
@section('meta_description', 'Detail proyek ' . $project->title . ($project->client ? ' untuk ' . $project->client->name : '') . ' oleh PT. Kreasindo Graha Persada.')

@section('content')

@php
  $cover = $project->images->firstWhere('is_cover', true) ?? $project->images->first();
  $otherImages = $project->images->filter(fn($img) => $img !== $cover);
  $divBadgeLabel = match($project->division) {
    'it' => 'Divisi IT',
    'interior' => 'Divisi Interior',
    'sipil' => 'Sipil',
    default => ucfirst($project->division),
  };
  $divBadgeClass = match($project->division) {
    'it' => 'bg-navy-700 text-navy-100',
    'interior' => 'bg-brass-700 text-brass-100',
    'sipil' => 'bg-navy-600 text-navy-100',
    default => 'bg-navy-700 text-navy-100',
  };
  $placeholderClass = match($project->division) {
    'interior' => 'from-brass-700 to-navy-900',
    'sipil' => 'from-navy-600 to-navy-900',
    default => 'from-navy-700 to-navy-900',
  };
@endphp

{{-- HERO --}}
<section class="bg-navy-900 bg-blueprint pt-32 pb-20">
  <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
    {{-- Breadcrumb --}}
    <div class="flex items-center gap-2 text-sm text-navy-100 mb-6 font-sans flex-wrap">
      <a href="{{ route('home') }}" class="hover:text-brass-300 transition-colors">Beranda</a>
      <span class="text-navy-100/50">/</span>
      <a href="{{ route('portfolio.index') }}" class="hover:text-brass-300 transition-colors">Portofolio</a>
      <span class="text-navy-100/50">/</span>
      <span class="text-brass-300">{{ $project->title }}</span>
    </div>

    {{-- Division badge --}}
    <span class="inline-block text-xs font-sans font-semibold uppercase tracking-widest px-4 py-1.5 rounded-full mb-5 {{ $divBadgeClass }}">
      {{ $divBadgeLabel }}
    </span>

    <h1 class="font-display text-4xl sm:text-5xl text-white font-semibold max-w-3xl mb-8">
      {{ $project->title }}
    </h1>

    {{-- Meta row --}}
    <div class="flex flex-wrap gap-6 text-sm font-sans text-navy-100">
      @if($project->client?->name)
      <div class="flex items-center gap-2">
        <svg class="w-4 h-4 text-brass-500 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
        </svg>
        <span>{{ $project->client->name }}</span>
      </div>
      @endif
      @if($project->location)
      <div class="flex items-center gap-2">
        <svg class="w-4 h-4 text-brass-500 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
          <path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
        </svg>
        <span>{{ $project->location }}</span>
      </div>
      @endif
      @if($project->year)
      <div class="flex items-center gap-2">
        <svg class="w-4 h-4 text-brass-500 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
        </svg>
        <span>{{ $project->year }}</span>
      </div>
      @endif
      @if($project->contract_value)
      <div class="flex items-center gap-2">
        <svg class="w-4 h-4 text-brass-500 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/>
        </svg>
        <span class="tabular">Rp {{ number_format($project->contract_value, 0, ',', '.') }}</span>
      </div>
      @endif
    </div>
  </div>
</section>

{{-- IMAGE GALLERY --}}
<section class="bg-navy-800 py-10">
  <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
    @if($cover)
    <div class="rounded-sm overflow-hidden shadow-xl mb-4 aspect-video max-h-[520px]">
      <img src="{{ asset('storage/' . $cover->file_path) }}"
           alt="{{ $cover->caption ?? $project->title }}"
           class="w-full h-full object-cover">
    </div>
    @else
    <div class="rounded-sm overflow-hidden bg-gradient-to-br {{ $placeholderClass }} flex items-center justify-center aspect-video max-h-[520px] mb-4">
      <svg class="w-20 h-20 text-white/10" fill="none" stroke="currentColor" stroke-width="1" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
      </svg>
    </div>
    @endif

    @if($otherImages->isNotEmpty())
    <div class="grid grid-cols-3 sm:grid-cols-4 lg:grid-cols-6 gap-2">
      @foreach($otherImages->take(12) as $img)
      <div class="aspect-square rounded-sm overflow-hidden bg-navy-700">
        <img src="{{ asset('storage/' . $img->file_path) }}"
             alt="{{ $img->caption ?? $project->title }}"
             class="w-full h-full object-cover hover:scale-105 transition-transform duration-300 cursor-pointer">
      </div>
      @endforeach
    </div>
    @endif
  </div>
</section>

{{-- BODY --}}
<section class="bg-paper py-16 lg:py-24">
  <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-12">

      {{-- Description --}}
      <div class="lg:col-span-2">
        <p class="text-xs font-sans font-semibold uppercase tracking-widest text-brass-700 mb-3">Tentang Proyek</p>
        <h2 class="font-display text-2xl sm:text-3xl text-navy-800 font-semibold mb-8">
          Deskripsi Proyek
        </h2>
        @if($project->description)
        <div class="rich-text text-slate-700 leading-relaxed">
          {!! nl2br(e($project->description)) !!}
        </div>
        @else
        <p class="text-slate-400 font-sans italic">Deskripsi proyek belum tersedia.</p>
        @endif
      </div>

      {{-- Sidebar --}}
      <aside class="lg:col-span-1 space-y-6">

        {{-- Detail card --}}
        <div class="bg-card border border-line rounded-sm shadow-sm p-6">
          <h3 class="font-display text-lg text-navy-800 font-semibold mb-5">Detail Proyek</h3>
          <dl class="space-y-4 text-sm font-sans">
            @if($project->client?->name)
            <div class="flex flex-col gap-0.5">
              <dt class="text-slate-400 uppercase tracking-wide text-xs font-semibold">Klien</dt>
              <dd class="text-navy-800 font-medium">{{ $project->client->name }}</dd>
            </div>
            @endif
            @if($project->service?->title)
            <div class="flex flex-col gap-0.5">
              <dt class="text-slate-400 uppercase tracking-wide text-xs font-semibold">Layanan</dt>
              <dd class="text-navy-800 font-medium">{{ $project->service->title }}</dd>
            </div>
            @endif
            <div class="flex flex-col gap-0.5">
              <dt class="text-slate-400 uppercase tracking-wide text-xs font-semibold">Divisi</dt>
              <dd class="text-navy-800 font-medium">{{ $divBadgeLabel }}</dd>
            </div>
            @if($project->location)
            <div class="flex flex-col gap-0.5">
              <dt class="text-slate-400 uppercase tracking-wide text-xs font-semibold">Lokasi</dt>
              <dd class="text-navy-800 font-medium">{{ $project->location }}</dd>
            </div>
            @endif
            @if($project->year)
            <div class="flex flex-col gap-0.5">
              <dt class="text-slate-400 uppercase tracking-wide text-xs font-semibold">Tahun</dt>
              <dd class="text-navy-800 font-medium">{{ $project->year }}</dd>
            </div>
            @endif
            @if($project->completed_at)
            <div class="flex flex-col gap-0.5">
              <dt class="text-slate-400 uppercase tracking-wide text-xs font-semibold">Selesai</dt>
              <dd class="text-navy-800 font-medium">{{ \Carbon\Carbon::parse($project->completed_at)->translatedFormat('d F Y') }}</dd>
            </div>
            @endif
            @if($project->contract_value)
            <div class="flex flex-col gap-0.5 pt-3 border-t border-line">
              <dt class="text-slate-400 uppercase tracking-wide text-xs font-semibold">Nilai Kontrak</dt>
              <dd class="text-navy-800 font-semibold tabular text-base">Rp {{ number_format($project->contract_value, 0, ',', '.') }}</dd>
            </div>
            @endif
          </dl>
        </div>

        {{-- CTA card --}}
        <div class="bg-navy-900 rounded-sm p-6">
          <h3 class="font-display text-lg text-white font-semibold mb-3">
            Tertarik dengan Proyek Ini?
          </h3>
          <p class="text-navy-100 text-sm leading-relaxed mb-5">
            Diskusikan kebutuhan serupa untuk institusi Anda bersama tim ahli kami.
          </p>
          <x-button as="a" href="{{ route('contact') }}" variant="accent" size="md">Hubungi Kami</x-button>
        </div>

      </aside>
    </div>
  </div>
</section>

{{-- BACK LINK --}}
<section class="bg-paper2 py-8 border-t border-line">
  <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
    <a href="{{ route('portfolio.index') }}"
       class="inline-flex items-center gap-2 text-sm font-sans font-semibold text-navy-700 hover:text-brass-700 transition-colors">
      <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/>
      </svg>
      Kembali ke Portofolio
    </a>
  </div>
</section>

@endsection
