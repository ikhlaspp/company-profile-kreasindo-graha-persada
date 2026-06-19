@extends('layouts.app')
@section('title', 'Beranda — KGP')
@section('meta_description', 'PT. Kreasindo Graha Persada — solusi IT & Interior terpadu untuk instansi pemerintah, militer, dan korporasi sejak 2016.')

@section('content')

{{-- HERO --}}
<section class="relative bg-navy-900 bg-blueprint overflow-hidden pt-32 pb-20">
  <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">

      {{-- Left: copy --}}
      <div>
        <p class="text-xs font-sans font-semibold uppercase tracking-widest text-brass-300 mb-5">
          Divisi IT &amp; Interior &middot; Sejak 2016
        </p>
        <h1 class="font-display text-4xl sm:text-5xl lg:text-6xl font-semibold leading-tight text-white">
          Solusi <em class="italic text-brass-300">IT &amp; Interior</em><br>
          Terpadu untuk<br>Instansi Anda
        </h1>
        <p class="mt-6 font-sans text-base text-navy-100 max-w-lg leading-relaxed">
          PT. Kreasindo Graha Persada melayani pemerintah, militer, BUMN, dan korporasi swasta
          dengan standar profesional — dari infrastruktur jaringan hingga desain interior kelas atas.
        </p>
        <div class="mt-8 flex flex-wrap gap-4">
          <x-button as="a" href="{{ route('services.index') }}" variant="accent" size="lg">
            Lihat Layanan Kami
          </x-button>
          <x-button as="a" href="{{ route('contact') }}" variant="outline" size="lg">
            Hubungi Kami
          </x-button>
        </div>
      </div>

      {{-- Right: visual placeholder --}}
      <div class="relative aspect-[4/3.1] rounded-sm overflow-hidden bg-gradient-to-br from-navy-600 to-navy-900 shadow-lg">
        <div class="absolute inset-0"
             style="background-image: repeating-linear-gradient(135deg, rgba(255,255,255,.05) 0 2px, transparent 2px 26px);">
        </div>
        <div class="absolute left-5 bottom-5 bg-navy-900/70 backdrop-blur-sm border border-white/20 rounded-sm px-4 py-3">
          <p class="font-display font-semibold text-sm text-white">
            {{ $org['site_name'] ?? 'PT. Kreasindo Graha Persada' }}
          </p>
          <p class="font-sans text-xs text-navy-100 mt-0.5">
            {{ $org['company_tagline'] ?? 'Solusi IT & Interior Profesional' }}
          </p>
        </div>
      </div>
    </div>
  </div>
</section>

{{-- STATS BAND --}}
<section class="bg-navy-900 border-t border-white/10">
  <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
    <div class="grid grid-cols-2 lg:grid-cols-4 divide-x divide-white/10">
      @foreach($stats as $stat)
      <div class="py-8 px-6 text-center">
        <div class="font-display font-semibold text-3xl sm:text-4xl text-brass-300 tabular-nums">
          {{ $stat['value'] }}{{ $stat['suffix'] ?? '' }}
        </div>
        <div class="font-sans text-xs font-semibold uppercase tracking-widest text-navy-100 mt-2">
          {{ $stat['label'] }}
        </div>
      </div>
      @endforeach
    </div>
  </div>
</section>

{{-- DIVISIONS --}}
<section class="bg-paper py-16 lg:py-24">
  <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
    <div class="mb-12">
      <p class="font-sans text-xs font-semibold uppercase tracking-widest text-brass-700 mb-2">01 — Layanan Utama</p>
      <h2 class="font-display text-3xl lg:text-4xl font-semibold text-navy-900">Dua Divisi, Satu Standar Kualitas</h2>
      <p class="mt-3 font-sans text-slate-500 max-w-xl">
        Kami menggabungkan keahlian teknologi informasi dan desain interior dalam satu kemitraan terpadu.
      </p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
      @foreach($divisions as $div)
      <a href="{{ route('services.index') }}#{{ $div['slug'] }}"
         class="relative min-h-[320px] flex flex-col justify-end p-8 rounded-sm overflow-hidden bg-navy-700 group">
        {{-- gradient overlay --}}
        <div class="absolute inset-0 bg-gradient-to-t from-navy-900/80 to-transparent"></div>
        <div class="relative z-10">
          <p class="font-sans text-xs font-semibold uppercase tracking-widest text-brass-300 mb-2">Divisi</p>
          <div class="mb-3 text-white w-8 h-8 [&_svg]:w-8 [&_svg]:h-8">{!! $div['icon'] !!}</div>
          <h3 class="font-display text-2xl font-semibold text-white mb-2">{{ $div['title'] }}</h3>
          <p class="font-sans text-sm text-navy-100 max-w-sm mb-4">{{ $div['desc'] }}</p>
          <span class="font-sans text-sm font-semibold text-brass-300 group-hover:text-brass-100 transition-colors">
            Lihat Layanan &rarr;
          </span>
        </div>
      </a>
      @endforeach
    </div>
  </div>
</section>

{{-- FEATURED PROJECTS --}}
<section class="bg-paper2 py-16 lg:py-24">
  <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
    <div class="mb-12">
      <p class="font-sans text-xs font-semibold uppercase tracking-widest text-brass-700 mb-2">02 — Bukti Karya</p>
      <h2 class="font-display text-3xl lg:text-4xl font-semibold text-navy-900">Proyek Unggulan Terbaru</h2>
      <p class="mt-3 font-sans text-slate-500 max-w-xl">
        Sebagian dari proyek strategis yang telah kami selesaikan untuk mitra nasional.
      </p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
      @forelse($featured as $project)
      <a href="{{ route('portfolio.show', $project['slug']) }}"
         class="bg-card border border-line rounded-sm shadow-sm hover:shadow-md transition-shadow overflow-hidden group">
        {{-- Thumbnail --}}
        @if(!empty($project['cover']))
          <img src="{{ asset('storage/'.$project['cover']) }}"
               alt="{{ $project['title'] }}"
               class="w-full aspect-[4/2.7] object-cover">
        @else
          <div class="w-full aspect-[4/2.7] bg-gradient-to-br from-navy-600 to-navy-900 flex items-end p-4">
            <span class="font-sans text-xs font-semibold text-brass-300 uppercase tracking-wider">
              {{ $project['division'] ?? 'Proyek' }}
            </span>
          </div>
        @endif

        <div class="p-5">
          <div class="flex items-center justify-between mb-2">
            <span class="font-sans text-xs font-semibold uppercase tracking-wider text-brass-700">
              {{ $project['division'] ?? '' }}
            </span>
            <span class="font-sans text-xs text-slate-400">{{ $project['year'] ?? '' }}</span>
          </div>
          <h4 class="font-display text-base font-semibold text-navy-800 mb-1 group-hover:text-brass-700 transition-colors">
            {{ $project['title'] }}
          </h4>
          <p class="font-sans text-sm text-slate-500">{{ $project['client'] ?? '' }}</p>
        </div>
      </a>
      @empty
      <p class="col-span-3 font-sans text-slate-400 text-center py-8">Belum ada proyek unggulan.</p>
      @endforelse
    </div>

    <div class="mt-10 text-center">
      <x-button as="a" href="{{ route('portfolio.index') }}" variant="primary" size="lg">
        Lihat Semua Portofolio
      </x-button>
    </div>
  </div>
</section>

{{-- CLIENT LOGOS STRIP --}}
<section class="bg-paper py-16 lg:py-20">
  <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
    <div class="mb-10 text-center">
      <p class="font-sans text-xs font-semibold uppercase tracking-widest text-brass-700 mb-2">03 — Kepercayaan</p>
      <h2 class="font-display text-2xl lg:text-3xl font-semibold text-navy-900">Dipercaya oleh Instansi Terkemuka</h2>
    </div>

    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-8 gap-4">
      @foreach($clients as $client)
      <div class="h-16 bg-card border border-line rounded-sm flex items-center justify-center px-3 hover:border-brass-500 hover:shadow-sm transition-all">
        @if(!empty($client['logo']))
          <img src="{{ asset('storage/'.$client['logo']) }}"
               alt="{{ $client['name'] }}"
               class="max-h-10 max-w-full object-contain grayscale hover:grayscale-0 transition-all">
        @else
          <span class="font-sans text-xs font-bold text-slate-400 text-center leading-tight">
            {{ $client['name'] }}
          </span>
        @endif
      </div>
      @endforeach
    </div>
  </div>
</section>

{{-- CLOSING CTA --}}
<section class="bg-navy-800 py-16 lg:py-20">
  <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
    <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-8">
      <div>
        <h2 class="font-display text-2xl lg:text-3xl font-semibold text-white italic max-w-2xl leading-snug">
          Siap berdiskusi tentang kebutuhan IT &amp; interior institusi Anda?
        </h2>
        <p class="mt-3 font-sans text-sm font-semibold text-brass-300">
          Tim profesional kami siap membantu — hubungi kami sekarang.
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
