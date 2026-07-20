@extends('layouts.app')
@section('title', 'Portofolio — KGP')
@section('meta_description', 'Portofolio proyek PT. Kreasindo Graha Persada — IT, interior, dan sipil untuk instansi pemerintah, militer, BUMN, dan korporasi nasional.')

@section('content')

{{-- HERO --}}
<section class="bg-navy-900 bg-blueprint pt-32 pb-20 relative overflow-hidden">
  <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 relative z-10">
    {{-- Breadcrumb --}}
    <div class="flex items-center gap-2 text-sm text-navy-100 mb-6 font-sans">
      <a href="{{ route('home') }}" class="hover:text-brass-300 transition-colors">Beranda</a>
      <span class="text-navy-100/40">/</span>
      <span class="text-brass-300">Portofolio</span>
    </div>

    {{-- Eyebrow --}}
    <p class="text-xs font-sans font-semibold uppercase tracking-widest text-brass-300 mb-4">Rekam Jejak Karya Kami</p>

    {{-- Title --}}
    <h1 class="font-display text-4xl sm:text-5xl lg:text-6xl text-white font-semibold mb-6 max-w-3xl leading-tight">
      Portofolio Proyek
    </h1>

    {{-- Intro --}}
    <p class="text-navy-100 text-lg max-w-2xl leading-relaxed">
      Ratusan proyek telah kami selesaikan untuk mitra nasional — dari instansi pemerintah,
      TNI/Polri, BUMN, hingga korporasi swasta — di bidang IT, interior &amp; furnitur, dan sipil.
    </p>
  </div>
</section>

{{-- FILTER + GRID --}}
<section class="bg-paper py-14 lg:py-20">
  <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

    {{-- Filter bar --}}
    <div class="reveal flex flex-col gap-5 mb-10 lg:mb-14">

      {{-- Division pills row --}}
      <div class="flex flex-wrap items-center gap-2">
        <a href="{{ route('portfolio.index', array_filter(['tahun' => request('tahun'), 'cari' => request('cari')])) }}"
           class="inline-flex items-center px-5 py-2 rounded-full text-sm font-sans font-semibold border transition-all duration-200
                  {{ !request('divisi') ? 'bg-navy-800 text-white border-navy-800 shadow-sm' : 'bg-card text-slate-500 border-line hover:border-navy-600 hover:text-navy-700' }}">
          Semua Proyek
        </a>
        @foreach($divisions as $dKey => $dLabel)
        <a href="{{ route('portfolio.index', array_filter(['divisi' => $dKey, 'tahun' => request('tahun'), 'cari' => request('cari')])) }}"
           class="inline-flex items-center px-5 py-2 rounded-full text-sm font-sans font-semibold border transition-all duration-200
                  {{ request('divisi') === $dKey ? 'bg-navy-800 text-white border-navy-800 shadow-sm' : 'bg-card text-slate-500 border-line hover:border-navy-600 hover:text-navy-700' }}">
          {{ $dLabel }}
        </a>
        @endforeach
      </div>

      {{-- Year select + search row --}}
      <form method="GET" action="{{ route('portfolio.index') }}" class="flex flex-col sm:flex-row items-start sm:items-center gap-3">
        @if(request('divisi'))
        <input type="hidden" name="divisi" value="{{ request('divisi') }}">
        @endif

        {{-- Year select --}}
        @if($years->isNotEmpty())
        <div class="relative">
          <select name="tahun" onchange="this.form.submit()"
                  class="appearance-none text-sm font-sans border border-line rounded-sm pl-4 pr-9 py-2.5 bg-card text-slate-600 focus:outline-none focus:ring-1 focus:ring-navy-600 cursor-pointer min-w-[130px]">
            <option value="">Semua Tahun</option>
            @foreach($years as $yr)
            <option value="{{ $yr }}" {{ request('tahun') == $yr ? 'selected' : '' }}>{{ $yr }}</option>
            @endforeach
          </select>
          <svg class="pointer-events-none absolute right-3 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/>
          </svg>
        </div>
        @endif

        {{-- Search box --}}
        <div class="relative flex-1 sm:max-w-xs">
          <input type="text" name="cari" value="{{ request('cari') }}"
                 placeholder="Cari proyek..."
                 class="w-full text-sm font-sans border border-line rounded-sm pl-10 pr-4 py-2.5 bg-card text-navy-800 placeholder-slate-400 focus:outline-none focus:ring-1 focus:ring-navy-600">
          <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
          </svg>
        </div>

        <button type="submit"
                class="flex-shrink-0 inline-flex items-center gap-2 text-sm font-sans font-semibold px-5 py-2.5 bg-navy-800 text-white rounded-sm hover:bg-navy-700 transition-colors">
          Cari
        </button>
      </form>

      {{-- Active filter notice --}}
      @if(request('divisi') || request('tahun') || request('cari'))
      <div class="flex flex-wrap items-center gap-3 text-sm font-sans text-slate-500 border-t border-line pt-4">
        <span class="font-semibold text-navy-700">Filter aktif:</span>
        @if(request('divisi'))
        <span class="inline-flex items-center gap-1.5 px-3 py-1 bg-navy-100 text-navy-700 rounded-full text-xs font-semibold">
          <svg class="w-3 h-3" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 7h18M6 12h12M9 17h6"/></svg>
          {{ $divisions[request('divisi')] ?? request('divisi') }}
        </span>
        @endif
        @if(request('tahun'))
        <span class="inline-flex items-center gap-1.5 px-3 py-1 bg-navy-100 text-navy-700 rounded-full text-xs font-semibold">
          <svg class="w-3 h-3" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
          {{ request('tahun') }}
        </span>
        @endif
        @if(request('cari'))
        <span class="inline-flex items-center gap-1.5 px-3 py-1 bg-navy-100 text-navy-700 rounded-full text-xs font-semibold">
          <svg class="w-3 h-3" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
          "{{ request('cari') }}"
        </span>
        @endif
        <a href="{{ route('portfolio.index') }}"
           class="ml-auto inline-flex items-center gap-1.5 text-xs font-semibold text-danger hover:text-danger/80 transition-colors">
          <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
          </svg>
          Hapus Semua Filter
        </a>
      </div>
      @endif

    </div>
    {{-- END filter bar --}}

    {{-- Projects grid — uniform 3-column cards --}}
    @forelse($projects as $project)
    @php
      $cover = $project->images->firstWhere('is_cover', true) ?? $project->images->first();
      $divBadgeClass = match($project->division) {
        'it'       => 'bg-navy-700/90 text-brass-300',
        'interior' => 'bg-brass-700/90 text-brass-100',
        'sipil'    => 'bg-navy-600/90 text-navy-100',
        default    => 'bg-navy-700/90 text-navy-100',
      };
      $divBadgeLabel = match($project->division) {
        'it'       => 'Divisi IT',
        'interior' => 'Divisi Interior',
        'sipil'    => 'Sipil',
        default    => ucfirst($project->division),
      };
      $placeholderClass = match($project->division) {
        'interior' => 'from-brass-700 to-navy-900',
        'sipil'    => 'from-navy-600 to-navy-900',
        default    => 'from-navy-700 to-navy-900',
      };
    @endphp
    @if($loop->first)
    <div class="reveal grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5 lg:gap-6 lg:auto-rows-fr">
    @endif

      <a href="{{ route('portfolio.show', $project->slug) }}"
         class="group relative bg-card border border-line rounded-sm shadow-sm hover:shadow-lg transition-all duration-300 overflow-hidden flex flex-col
                {{ $loop->first ? 'sm:col-span-2 lg:col-span-2 lg:row-span-2' : '' }}"
         style="{{ $loop->index > 0 ? 'transition-delay:' . min(($loop->index * 80), 320) . 'ms' : '' }}">

        {{-- Image area --}}
        <div class="relative overflow-hidden {{ $loop->first ? 'flex-1 min-h-[240px]' : 'aspect-[4/3]' }}">
          @if($cover)
          <img src="{{ kgp_image($cover->file_path, 'proj-'.$project->id, 800, 600) }}"
               alt="{{ $project->title }}"
               class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500 ease-out"
               loading="{{ $loop->first ? 'eager' : 'lazy' }}">
          @else
          <div class="w-full h-full bg-gradient-to-br {{ $placeholderClass }} flex items-center justify-center">
            <svg class="w-14 h-14 text-white/15" fill="none" stroke="currentColor" stroke-width="1" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
            </svg>
          </div>
          @endif

          {{-- Gradient overlay on hover --}}
          <div class="absolute inset-0 bg-gradient-to-t from-navy-900/80 via-navy-900/20 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>

          {{-- Hover overlay content --}}
          <div class="absolute bottom-0 left-0 right-0 p-5 translate-y-2 opacity-0 group-hover:translate-y-0 group-hover:opacity-100 transition-all duration-300">
            <p class="text-white text-sm font-sans font-semibold leading-snug line-clamp-2">{{ $project->title }}</p>
            @if($project->client?->name)
            <p class="text-navy-100/80 text-xs font-sans mt-1">{{ $project->client->name }}</p>
            @endif
          </div>

          {{-- Badges --}}
          <div class="absolute top-3 left-3 flex items-center gap-2 flex-wrap">
            <span class="text-xs font-sans font-semibold uppercase tracking-wide px-2.5 py-1 rounded backdrop-blur-sm {{ $divBadgeClass }}">
              {{ $divBadgeLabel }}
            </span>
            @if($project->is_featured)
            <span class="text-xs font-sans font-semibold px-2.5 py-1 rounded bg-brass-500 text-navy-900 backdrop-blur-sm">
              Unggulan
            </span>
            @endif
          </div>

          @if($project->year)
          <span class="absolute top-3 right-3 text-xs font-sans font-semibold tabular px-2.5 py-1 rounded bg-navy-900/60 text-white backdrop-blur-sm">
            {{ $project->year }}
          </span>
          @endif
        </div>

        {{-- Card footer --}}
        <div class="px-5 py-4 flex items-center justify-between gap-3 border-t border-line">
          <div class="min-w-0">
            <h3 class="font-display text-sm sm:text-base text-navy-800 font-semibold group-hover:text-navy-600 transition-colors line-clamp-1">
              {{ $project->title }}
            </h3>
            @if($project->client?->name || $project->location)
            <p class="text-xs text-slate-400 font-sans mt-0.5 line-clamp-1">
              {{ $project->client?->name }}
              @if($project->client?->name && $project->location)<span class="mx-1">&middot;</span>@endif
              {{ $project->location }}
            </p>
            @endif
          </div>
          <span class="flex-shrink-0 w-8 h-8 flex items-center justify-center rounded-full bg-navy-100 text-navy-700 group-hover:bg-navy-800 group-hover:text-white transition-colors">
            <svg class="w-4 h-4 transition-transform group-hover:translate-x-0.5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
            </svg>
          </span>
        </div>

      </a>

    @if($loop->last)
    </div>
    @endif

    @empty
    {{-- Empty state --}}
    <div class="text-center py-24 reveal">
      <div class="w-20 h-20 rounded-full bg-navy-100 flex items-center justify-center mx-auto mb-6">
        <svg class="w-10 h-10 text-navy-600/50" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
        </svg>
      </div>
      <h3 class="font-display text-2xl text-navy-800 font-semibold mb-2">Tidak ada proyek ditemukan</h3>
      <p class="text-slate-400 font-sans text-sm mb-8 max-w-xs mx-auto">Coba ubah atau hapus filter yang aktif untuk melihat lebih banyak proyek.</p>
      <x-button as="a" href="{{ route('portfolio.index') }}" variant="primary" size="md">Lihat Semua Proyek</x-button>
    </div>
    @endforelse

    {{-- Pagination --}}
    @if($projects->hasPages())
    <div class="mt-14">
      {{ $projects->appends(request()->query())->links() }}
    </div>
    @endif

  </div>
</section>

{{-- CTA SECTION --}}
<x-cta-band
  eyebrow="Wujudkan Proyek Anda"
  title="Punya Proyek yang Ingin Direalisasikan?"
  body="Tim ahli kami siap membantu mewujudkan kebutuhan IT, interior, dan konstruksi untuk institusi Anda — dari perencanaan hingga selesai." />

@endsection
