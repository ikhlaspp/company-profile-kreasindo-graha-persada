@extends('layouts.app')
@section('title', 'Portofolio — KGP')
@section('meta_description', 'Portofolio proyek PT. Kreasindo Graha Persada — IT, interior, dan sipil untuk instansi pemerintah, militer, BUMN, dan korporasi.')

@section('content')

{{-- HERO --}}
<section class="bg-navy-900 bg-blueprint pt-32 pb-20">
  <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
    <div class="flex items-center gap-2 text-sm text-navy-100 mb-6 font-sans">
      <a href="{{ route('home') }}" class="hover:text-brass-300 transition-colors">Beranda</a>
      <span class="text-navy-100/50">/</span>
      <span class="text-brass-300">Portofolio</span>
    </div>
    <p class="text-xs font-sans font-semibold uppercase tracking-widest text-brass-300 mb-3">Bukti Karya Kami</p>
    <h1 class="font-display text-4xl sm:text-5xl text-white font-semibold mb-4 max-w-2xl">
      Portofolio Proyek
    </h1>
    <p class="text-navy-100 text-lg max-w-2xl leading-relaxed">
      Proyek yang telah kami selesaikan untuk instansi pemerintah, militer, BUMN, dan korporasi swasta.
    </p>
  </div>
</section>

{{-- FILTER + GRID --}}
<section class="bg-paper py-16 lg:py-24">
  <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

    {{-- Filter bar --}}
    <div class="flex flex-col sm:flex-row sm:items-center gap-4 mb-10">

      {{-- Division pills --}}
      <div class="flex flex-wrap gap-2 flex-1">
        <a href="{{ route('portfolio.index', array_filter(['tahun' => request('tahun'), 'cari' => request('cari')])) }}"
           class="inline-flex items-center px-5 py-2 rounded-full text-sm font-sans font-semibold border transition-colors
                  {{ !request('divisi') ? 'bg-navy-800 text-white border-navy-800' : 'bg-card text-slate-500 border-line hover:border-navy-600 hover:text-navy-700' }}">
          Semua
        </a>
        @foreach($divisions as $dKey => $dLabel)
        <a href="{{ route('portfolio.index', array_filter(['divisi' => $dKey, 'tahun' => request('tahun'), 'cari' => request('cari')])) }}"
           class="inline-flex items-center px-5 py-2 rounded-full text-sm font-sans font-semibold border transition-colors
                  {{ request('divisi') === $dKey ? 'bg-navy-800 text-white border-navy-800' : 'bg-card text-slate-500 border-line hover:border-navy-600 hover:text-navy-700' }}">
          {{ $dLabel }}
        </a>
        @endforeach
      </div>

      {{-- Search + Year filters --}}
      <form method="GET" action="{{ route('portfolio.index') }}" class="flex items-center gap-2 flex-shrink-0">
        @if(request('divisi'))
        <input type="hidden" name="divisi" value="{{ request('divisi') }}">
        @endif

        @if($years->isNotEmpty())
        <select name="tahun" onchange="this.form.submit()"
                class="text-sm font-sans border border-line rounded-sm px-3 py-2 bg-card text-slate-600 focus:outline-none focus:ring-1 focus:ring-navy-600">
          <option value="">Semua Tahun</option>
          @foreach($years as $yr)
          <option value="{{ $yr }}" {{ request('tahun') == $yr ? 'selected' : '' }}>{{ $yr }}</option>
          @endforeach
        </select>
        @endif

        <div class="relative">
          <input type="text" name="cari" value="{{ request('cari') }}"
                 placeholder="Cari proyek..."
                 class="text-sm font-sans border border-line rounded-sm pl-9 pr-3 py-2 bg-card text-navy-800 placeholder-slate-400 focus:outline-none focus:ring-1 focus:ring-navy-600 w-48">
          <svg class="absolute left-2.5 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
          </svg>
        </div>
        <button type="submit" class="sr-only">Cari</button>
      </form>
    </div>

    {{-- Active filter info --}}
    @if(request('divisi') || request('tahun') || request('cari'))
    <div class="flex items-center gap-3 mb-6 text-sm font-sans text-slate-500">
      <span>Filter aktif:</span>
      @if(request('divisi'))<span class="px-3 py-1 bg-navy-100 text-navy-700 rounded-full text-xs font-semibold">{{ $divisions[request('divisi')] ?? request('divisi') }}</span>@endif
      @if(request('tahun'))<span class="px-3 py-1 bg-navy-100 text-navy-700 rounded-full text-xs font-semibold">{{ request('tahun') }}</span>@endif
      @if(request('cari'))<span class="px-3 py-1 bg-navy-100 text-navy-700 rounded-full text-xs font-semibold">"{{ request('cari') }}"</span>@endif
      <a href="{{ route('portfolio.index') }}" class="text-danger hover:underline ml-1">Hapus filter</a>
    </div>
    @endif

    {{-- Projects grid --}}
    @forelse($projects as $project)
    @php
      $cover = $project->images->firstWhere('is_cover', true) ?? $project->images->first();
      $divBadgeClass = match($project->division) {
        'it' => 'bg-navy-100 text-navy-700',
        'interior' => 'bg-brass-100 text-brass-700',
        'sipil' => 'bg-slate-100 text-slate-700',
        default => 'bg-navy-100 text-navy-700',
      };
      $divBadgeLabel = match($project->division) {
        'it' => 'Divisi IT',
        'interior' => 'Divisi Interior',
        'sipil' => 'Sipil',
        default => ucfirst($project->division),
      };
      $placeholderClass = match($project->division) {
        'interior' => 'from-brass-700 to-navy-900',
        'sipil' => 'from-navy-600 to-navy-900',
        default => 'from-navy-700 to-navy-900',
      };
    @endphp
    @if($loop->first)
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
    @endif

      <a href="{{ route('portfolio.show', $project->slug) }}"
         class="group bg-card border border-line rounded-sm shadow-sm hover:shadow-md transition-shadow overflow-hidden flex flex-col">

        {{-- Thumbnail --}}
        <div class="relative aspect-[4/2.8] overflow-hidden">
          @if($cover)
          <img src="{{ asset('storage/' . $cover->file_path) }}"
               alt="{{ $project->title }}"
               class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
          @else
          <div class="w-full h-full bg-gradient-to-br {{ $placeholderClass }} flex items-center justify-center">
            <svg class="w-12 h-12 text-white/20" fill="none" stroke="currentColor" stroke-width="1" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
            </svg>
          </div>
          @endif

          {{-- Year badge --}}
          @if($project->year)
          <span class="absolute top-3 right-3 bg-navy-900/60 backdrop-blur-sm text-white text-xs font-sans font-semibold px-3 py-1 rounded-full">
            {{ $project->year }}
          </span>
          @endif

          {{-- Featured badge --}}
          @if($project->is_featured)
          <span class="absolute top-3 left-3 bg-brass-500 text-navy-900 text-xs font-sans font-semibold px-3 py-1 rounded-full">
            Unggulan
          </span>
          @endif
        </div>

        {{-- Card body --}}
        <div class="p-5 flex flex-col flex-1">
          <span class="inline-block text-xs font-sans font-semibold uppercase tracking-widest px-3 py-1 rounded-full mb-3 {{ $divBadgeClass }}">
            {{ $divBadgeLabel }}
          </span>
          <h3 class="font-display text-base text-navy-800 font-semibold mb-1.5 group-hover:text-navy-600 transition-colors line-clamp-2">
            {{ $project->title }}
          </h3>
          <p class="text-slate-400 text-xs font-sans flex-1">
            {{ $project->client?->name }}
            @if($project->location)
            <span class="mx-1">&middot;</span>{{ $project->location }}
            @endif
          </p>
          <div class="mt-3 flex items-center gap-1 text-xs font-sans font-semibold text-navy-700">
            Lihat Detail
            <svg class="w-3.5 h-3.5 transition-transform group-hover:translate-x-1" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
            </svg>
          </div>
        </div>
      </a>

    @if($loop->last)
    </div>
    @endif

    @empty
    <div class="text-center py-20">
      <svg class="w-16 h-16 text-slate-200 mx-auto mb-4" fill="none" stroke="currentColor" stroke-width="1" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
      </svg>
      <h3 class="font-display text-xl text-navy-800 mb-2">Tidak ada proyek ditemukan</h3>
      <p class="text-slate-400 font-sans text-sm mb-6">Coba ubah atau hapus filter yang aktif.</p>
      <a href="{{ route('portfolio.index') }}"
         class="inline-flex items-center gap-2 text-sm font-sans font-semibold text-navy-700 hover:text-brass-700 transition-colors">
        Lihat semua proyek &rarr;
      </a>
    </div>
    @endforelse

    {{-- Pagination --}}
    @if($projects->hasPages())
    <div class="mt-12">
      {{ $projects->appends(request()->query())->links() }}
    </div>
    @endif

  </div>
</section>

{{-- CTA --}}
<section class="bg-navy-900 py-16 lg:py-20">
  <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 text-center">
    <h2 class="font-display text-3xl sm:text-4xl text-white font-semibold mb-4">
      Punya Proyek yang Ingin Direalisasikan?
    </h2>
    <p class="text-navy-100 max-w-xl mx-auto mb-8 leading-relaxed">
      Tim kami siap membantu mewujudkan kebutuhan IT dan interior institusi Anda.
    </p>
    <x-button as="a" href="{{ route('contact') }}" variant="accent" size="lg">Konsultasi Gratis</x-button>
  </div>
</section>

@endsection
