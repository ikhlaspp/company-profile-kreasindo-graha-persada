@extends('layouts.app')
@section('title', $project->title . ' — KGP')
@section('meta_description', 'Detail proyek ' . $project->title . ($project->client ? ' untuk ' . $project->client->name : '') . ' oleh PT. Kreasindo Graha Persada.')

@section('content')

@php
  $cover = $project->images->firstWhere('is_cover', true) ?? $project->images->first();
  $otherImages = $project->images->filter(fn($img) => $img !== $cover);
  $divBadgeLabel = match($project->division) {
    'it'       => 'Divisi IT',
    'interior' => 'Divisi Interior',
    'sipil'    => 'Sipil',
    default    => ucfirst($project->division),
  };
  $divBadgeClass = match($project->division) {
    'it'       => 'bg-navy-700 text-brass-300',
    'interior' => 'bg-brass-700 text-brass-100',
    'sipil'    => 'bg-navy-600 text-navy-100',
    default    => 'bg-navy-700 text-navy-100',
  };
  $placeholderClass = match($project->division) {
    'interior' => 'from-brass-700 to-navy-900',
    'sipil'    => 'from-navy-600 to-navy-900',
    default    => 'from-navy-700 to-navy-900',
  };
@endphp

{{-- HERO --}}
<section class="bg-navy-900 bg-blueprint pt-32 pb-20 relative overflow-hidden">
  <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 relative z-10">

    {{-- Breadcrumb --}}
    <div class="flex items-center gap-2 text-sm text-navy-100 mb-6 font-sans flex-wrap">
      <a href="{{ route('home') }}" class="hover:text-brass-300 transition-colors">Beranda</a>
      <span class="text-navy-100/40">/</span>
      <a href="{{ route('portfolio.index') }}" class="hover:text-brass-300 transition-colors">Portofolio</a>
      <span class="text-navy-100/40">/</span>
      <span class="text-brass-300 line-clamp-1 max-w-xs">{{ $project->title }}</span>
    </div>

    {{-- Division badge --}}
    <span class="inline-block text-xs font-sans font-semibold uppercase tracking-widest px-4 py-1.5 rounded mb-5 {{ $divBadgeClass }}">
      {{ $divBadgeLabel }}
    </span>

    {{-- Project title --}}
    <h1 class="font-display text-4xl sm:text-5xl lg:text-6xl text-white font-semibold max-w-4xl mb-8 leading-tight">
      {{ $project->title }}
    </h1>

    {{-- Meta row --}}
    <div class="flex flex-wrap gap-x-8 gap-y-3 text-sm font-sans text-navy-100">
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
        <span class="tabular">{{ $project->year }}</span>
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

    {{-- Main image --}}
    @if($cover)
    <div class="rounded-sm overflow-hidden shadow-2xl mb-3 aspect-video max-h-[560px]">
      <img src="{{ kgp_image($cover->file_path, 'proj-cover-'.$project->id, 1280, 720) }}"
           alt="{{ $cover->caption ?? $project->title }}"
           class="w-full h-full object-cover"
           loading="eager">
    </div>
    @else
    <div class="rounded-sm overflow-hidden bg-gradient-to-br {{ $placeholderClass }} flex items-center justify-center aspect-video max-h-[560px] mb-3">
      <svg class="w-24 h-24 text-white/10" fill="none" stroke="currentColor" stroke-width="1" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
      </svg>
    </div>
    @endif

    {{-- Thumbnail strip --}}
    @if($otherImages->isNotEmpty())
    <div class="grid grid-cols-4 sm:grid-cols-6 lg:grid-cols-8 gap-2">
      @foreach($otherImages->take(16) as $img)
      <div class="aspect-square rounded-sm overflow-hidden bg-navy-700 cursor-pointer group">
        <img src="{{ kgp_image($img->file_path, 'proj-thumb-'.$project->id.'-'.$loop->index, 300, 300) }}"
             alt="{{ $img->caption ?? $project->title }}"
             class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300"
             loading="lazy">
      </div>
      @endforeach
    </div>
    @endif

  </div>
</section>

{{-- BODY: Description + Sidebar --}}
<section class="bg-paper py-16 lg:py-24">
  <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-12 xl:gap-16">

      {{-- Left: Description --}}
      <div class="lg:col-span-2 reveal">
        <p class="text-xs font-sans font-semibold uppercase tracking-widest text-brass-700 mb-3">Tentang Proyek</p>
        <h2 class="font-display text-2xl sm:text-3xl text-navy-800 font-semibold mb-8 leading-snug">
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

      {{-- Right: Sidebar --}}
      <aside class="lg:col-span-1 space-y-5 reveal" style="transition-delay:160ms">

        {{-- Project facts card --}}
        <div class="bg-card border border-line rounded-sm shadow-sm overflow-hidden">
          <div class="bg-navy-900 px-6 py-4">
            <h3 class="font-display text-base text-white font-semibold">Detail Proyek</h3>
          </div>
          <dl class="divide-y divide-line text-sm font-sans">
            @if($project->client?->name)
            <div class="flex gap-3 px-6 py-4">
              <dt class="w-28 flex-shrink-0 text-slate-400 text-xs font-semibold uppercase tracking-wide pt-0.5">Klien</dt>
              <dd class="text-navy-800 font-medium leading-snug">{{ $project->client->name }}</dd>
            </div>
            @endif
            @if($project->service?->title)
            <div class="flex gap-3 px-6 py-4">
              <dt class="w-28 flex-shrink-0 text-slate-400 text-xs font-semibold uppercase tracking-wide pt-0.5">Layanan</dt>
              <dd class="text-navy-800 font-medium leading-snug">{{ $project->service->title }}</dd>
            </div>
            @endif
            <div class="flex gap-3 px-6 py-4">
              <dt class="w-28 flex-shrink-0 text-slate-400 text-xs font-semibold uppercase tracking-wide pt-0.5">Divisi</dt>
              <dd>
                <span class="inline-block text-xs font-sans font-semibold px-2.5 py-1 rounded {{ $divBadgeClass }}">{{ $divBadgeLabel }}</span>
              </dd>
            </div>
            @if($project->location)
            <div class="flex gap-3 px-6 py-4">
              <dt class="w-28 flex-shrink-0 text-slate-400 text-xs font-semibold uppercase tracking-wide pt-0.5">Lokasi</dt>
              <dd class="text-navy-800 font-medium leading-snug">{{ $project->location }}</dd>
            </div>
            @endif
            @if($project->year)
            <div class="flex gap-3 px-6 py-4">
              <dt class="w-28 flex-shrink-0 text-slate-400 text-xs font-semibold uppercase tracking-wide pt-0.5">Tahun</dt>
              <dd class="text-navy-800 font-medium tabular">{{ $project->year }}</dd>
            </div>
            @endif
            @if($project->completed_at)
            <div class="flex gap-3 px-6 py-4">
              <dt class="w-28 flex-shrink-0 text-slate-400 text-xs font-semibold uppercase tracking-wide pt-0.5">Selesai</dt>
              <dd class="text-navy-800 font-medium">{{ $project->completed_at?->translatedFormat('d F Y') }}</dd>
            </div>
            @endif
            @if($project->contract_value)
            <div class="flex gap-3 px-6 py-5 bg-paper2">
              <dt class="w-28 flex-shrink-0 text-slate-400 text-xs font-semibold uppercase tracking-wide pt-0.5">Nilai Kontrak</dt>
              <dd class="text-navy-800 font-semibold tabular text-base">Rp {{ number_format($project->contract_value, 0, ',', '.') }}</dd>
            </div>
            @endif
          </dl>
        </div>

        {{-- CTA card --}}
        <div class="bg-navy-900 rounded-sm p-6">
          <h3 class="font-display text-base text-white font-semibold mb-2">
            Tertarik dengan Proyek Ini?
          </h3>
          <p class="text-navy-100 text-sm leading-relaxed mb-5">
            Diskusikan kebutuhan serupa untuk institusi Anda bersama tim ahli kami.
          </p>
          <x-button as="a" href="{{ route('contact') }}" variant="accent" size="md">Hubungi Kami</x-button>
        </div>

        {{-- Back link --}}
        <a href="{{ route('portfolio.index') }}"
           class="flex items-center gap-2 text-sm font-sans font-semibold text-navy-700 hover:text-brass-700 transition-colors group">
          <svg class="w-4 h-4 transition-transform group-hover:-translate-x-1" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/>
          </svg>
          Kembali ke Portofolio
        </a>

      </aside>
    </div>
  </div>
</section>

{{-- CLOSING CTA --}}
<x-cta-band
  eyebrow="Wujudkan Proyek Anda"
  title="Punya Proyek yang Ingin Direalisasikan?"
  body="Tim ahli kami siap membantu mewujudkan kebutuhan IT, interior, dan konstruksi untuk institusi Anda — dari perencanaan hingga selesai." />

@endsection
