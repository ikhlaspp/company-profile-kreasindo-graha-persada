@extends('layouts.app')
@section('title', 'Tentang Kami — PT. Kreasindo Graha Persada')
@section('meta_description', 'Mengenal lebih dekat PT. Kreasindo Graha Persada — perjalanan, visi, misi, dan komitmen kami melayani instansi nasional sejak 2016.')

@section('content')

{{-- ============================================================
     1. PAGE HERO
     ============================================================ --}}
<section class="relative bg-navy-900 bg-blueprint overflow-hidden pt-32 pb-20">
  {{-- subtle diagonal overlay --}}
  <div class="absolute inset-0 bg-gradient-to-br from-navy-900/90 via-navy-900/70 to-navy-800/60 pointer-events-none"></div>

  <div class="relative mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
    {{-- Breadcrumb --}}
    <nav class="flex items-center gap-2 font-sans text-xs font-semibold text-navy-100 mb-8">
      <a href="{{ route('home') }}" class="hover:text-brass-300 transition-colors">Beranda</a>
      <span class="text-white/30">/</span>
      <span class="text-brass-300">Tentang Kami</span>
    </nav>

    <div class="max-w-3xl">
      <p class="font-sans text-xs font-semibold uppercase tracking-widest text-brass-300 mb-3">
        Profil Perusahaan
      </p>
      <h1 class="font-display text-5xl lg:text-6xl font-semibold text-white leading-tight mb-5">
        Tentang Kami
      </h1>
      <p class="font-sans text-lg text-navy-100 leading-relaxed max-w-xl">
        Mengenal lebih dekat PT. Kreasindo Graha Persada — perjalanan, visi, dan komitmen kami melayani instansi nasional sejak 2016.
      </p>
    </div>

    {{-- Decorative rule --}}
    <div class="mt-10 flex items-center gap-4">
      <div class="h-px w-16 bg-brass-500"></div>
      <div class="h-px w-4 bg-brass-700"></div>
    </div>
  </div>
</section>

{{-- ============================================================
     2. COMPANY HISTORY — two-column
     ============================================================ --}}
<section class="bg-paper py-16 lg:py-24">
  <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 lg:gap-16 items-center">

      {{-- Image --}}
      <div class="reveal relative aspect-[4/3] rounded-sm overflow-hidden shadow-lg">
        <img
          src="{{ kgp_image('about/company-profile.jpg', 'kgp-about-2', 800, 600) }}"
          alt="Kantor PT. Kreasindo Graha Persada"
          class="w-full h-full object-cover transition-transform duration-700 hover:scale-105"
          loading="lazy">
        {{-- brass corner accent --}}
        <div class="absolute top-0 left-0 w-16 h-1 bg-brass-500"></div>
        <div class="absolute top-0 left-0 w-1 h-16 bg-brass-500"></div>
        {{-- dark vignette bottom --}}
        <div class="absolute inset-0 bg-gradient-to-t from-navy-900/40 to-transparent pointer-events-none"></div>
        {{-- badge --}}
        <div class="absolute bottom-5 left-5 bg-navy-900/80 backdrop-blur-sm border border-brass-700/40 rounded-sm px-4 py-2">
          <p class="font-sans text-xs font-semibold uppercase tracking-widest text-brass-300">Est. 2016</p>
        </div>
      </div>

      {{-- Text --}}
      <div class="reveal" style="transition-delay:120ms">
        <p class="font-sans text-xs font-semibold uppercase tracking-widest text-brass-700 mb-2">Profil Singkat</p>
        <h2 class="font-display text-3xl lg:text-4xl font-semibold text-navy-900 mb-5">
          {{ $company['name'] }}
        </h2>
        <div class="w-12 h-1 bg-brass-500 mb-6"></div>
        <div class="font-sans text-slate-600 leading-relaxed space-y-4 rich-text">
          {!! nl2br(e($company['history'])) !!}
        </div>

        {{-- Quick capability badges --}}
        <div class="mt-8 flex flex-wrap gap-2">
          @foreach(['Teknologi IT', 'Interior & Furnitur', 'Sipil & Konstruksi', 'Mekanikal & Elektrikal'] as $cap)
          <span class="inline-block font-sans text-xs font-semibold uppercase tracking-wide text-navy-700 bg-navy-100 border border-navy-100 rounded-sm px-3 py-1">
            {{ $cap }}
          </span>
          @endforeach
        </div>
      </div>

    </div>
  </div>
</section>

{{-- ============================================================
     3. STATS COUNTER BAND
     ============================================================ --}}
<section class="bg-navy-900 py-14 lg:py-16">
  <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-px bg-white/10 rounded-sm overflow-hidden">

      @php
      $stats = [
        ['figure' => '2016',  'label' => 'Tahun Berdiri',       'suffix' => ''],
        ['figure' => '100+',  'label' => 'Proyek Nasional',     'suffix' => ''],
        ['figure' => '4',     'label' => 'Divisi Layanan',      'suffix' => ''],
        ['figure' => '100',   'label' => 'Komitmen Kualitas',   'suffix' => '%'],
      ];
      @endphp

      @foreach($stats as $i => $stat)
      <div class="bg-navy-900 px-8 py-10 text-center reveal" style="transition-delay:{{ $i * 80 }}ms">
        <p class="font-display tabular text-4xl lg:text-5xl font-semibold text-brass-300 leading-none">
          {{ $stat['figure'] }}<span class="text-brass-500 text-3xl">{{ $stat['suffix'] }}</span>
        </p>
        <p class="font-sans text-xs font-semibold uppercase tracking-widest text-navy-100 mt-3">
          {{ $stat['label'] }}
        </p>
      </div>
      @endforeach

    </div>
  </div>
</section>

{{-- ============================================================
     4. VISION & MISSION — bold statement blocks
     ============================================================ --}}
<section class="bg-paper2 py-16 lg:py-24">
  <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

    {{-- Section header --}}
    <div class="mb-14 reveal">
      <p class="font-sans text-xs font-semibold uppercase tracking-widest text-brass-700 mb-2">01 — Arah Perusahaan</p>
      <h2 class="font-display text-3xl lg:text-4xl font-semibold text-navy-900">Visi &amp; Misi</h2>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-5 gap-6 lg:gap-8">

      {{-- VISION — large quote-style block (dark) --}}
      <div class="reveal lg:col-span-2 relative bg-navy-800 rounded-sm p-8 lg:p-10 flex flex-col overflow-hidden" style="transition-delay:80ms">
        {{-- decorative quote mark --}}
        <div class="absolute top-4 right-6 font-display text-[120px] font-semibold text-white/5 leading-none select-none pointer-events-none" aria-hidden="true">&ldquo;</div>

        <p class="font-sans text-xs font-semibold uppercase tracking-widest text-brass-300 mb-6">Visi</p>

        <blockquote class="font-display text-xl lg:text-2xl font-medium text-white leading-relaxed flex-1 relative z-10">
          &ldquo;{{ $company['vision'] }}&rdquo;
        </blockquote>

        <div class="mt-8 h-px w-12 bg-brass-500"></div>
      </div>

      {{-- MISSION — numbered list --}}
      <div class="reveal lg:col-span-3 bg-card border border-line rounded-sm p-8 lg:p-10" style="transition-delay:160ms">
        <p class="font-sans text-xs font-semibold uppercase tracking-widest text-brass-700 mb-6">Misi</p>

        <ol class="space-y-0 divide-y divide-line">
          @foreach($company['mission'] as $i => $item)
          <li class="flex gap-5 py-4 items-start">
            <span class="font-display font-bold text-brass-700 flex-shrink-0 w-7 text-base tabular leading-relaxed">
              {{ str_pad($i + 1, 2, '0', STR_PAD_LEFT) }}.
            </span>
            <span class="font-sans text-sm text-slate-700 leading-relaxed">{{ $item }}</span>
          </li>
          @endforeach
        </ol>
      </div>

    </div>
  </div>
</section>

{{-- ============================================================
     5. COMPANY HISTORY TIMELINE
     ============================================================ --}}
<section class="bg-paper py-16 lg:py-24">
  <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

    <div class="mb-14 reveal">
      <p class="font-sans text-xs font-semibold uppercase tracking-widest text-brass-700 mb-2">02 — Perjalanan Kami</p>
      <h2 class="font-display text-3xl lg:text-4xl font-semibold text-navy-900">Linimasa Perusahaan</h2>
      <p class="mt-3 font-sans text-slate-500 max-w-lg">
        Setiap tonggak adalah bukti komitmen kami tumbuh bersama kepercayaan klien.
      </p>
    </div>

    @php
    $milestones = [
      ['year' => '2016', 'title' => 'Pendirian Perusahaan',
       'desc'  => 'PT. Kreasindo Graha Persada resmi berdiri dan memulai operasional sebagai penyedia solusi IT & Interior untuk instansi nasional.'],
      ['year' => '2017', 'title' => 'Proyek Perdana TNI AL',
       'desc'  => 'Berhasil menyelesaikan proyek IT pertama untuk lingkungan TNI Angkatan Laut — awal kemitraan jangka panjang dengan instansi pertahanan.'],
      ['year' => '2018', 'title' => 'Ekspansi Divisi Interior',
       'desc'  => 'Membuka Divisi Interior & Furnitur, memperluas kapabilitas layanan desain dan pengadaan untuk ruang kantor pemerintahan.'],
      ['year' => '2020', 'title' => 'Penambahan Divisi Sipil & ME',
       'desc'  => 'Memperluas lini layanan ke Sipil/Konstruksi dan Mekanikal & Elektrikal, menjadikan KGP penyedia solusi terpadu.'],
      ['year' => '2022', 'title' => 'Penghargaan Informasi TNI AL',
       'desc'  => 'Menerima Penghargaan TNI Angkatan Laut di bidang Informasi atas kontribusi nyata dalam modernisasi sistem teknologi informasi.'],
      ['year' => '2024', 'title' => 'Lulus Seskoal & Kolinlamil',
       'desc'  => 'Memperoleh Bukti Tanda Lulus dari Seskoal dan Kolinlamil, memperkuat posisi sebagai mitra strategis institusi angkatan laut.'],
    ];
    @endphp

    <div class="relative">
      {{-- Vertical line --}}
      <div class="hidden lg:block absolute left-[120px] top-0 bottom-0 w-px bg-line"></div>

      <div class="space-y-0">
        @foreach($milestones as $i => $milestone)
        <div class="reveal relative flex flex-col lg:flex-row gap-6 lg:gap-0 pb-10 lg:pb-12 last:pb-0" style="transition-delay:{{ $i * 80 }}ms">

          {{-- Year column --}}
          <div class="lg:w-[120px] lg:pr-8 flex-shrink-0 flex lg:flex-col items-center lg:items-end gap-3 lg:gap-0">
            <span class="font-display text-sm font-bold text-brass-700 lg:mb-4 tabular">{{ $milestone['year'] }}</span>
            {{-- Dot --}}
            <div class="hidden lg:flex absolute left-[116px] top-1 w-2.5 h-2.5 rounded-full bg-brass-500 border-2 border-paper ring-4 ring-paper"></div>
          </div>

          {{-- Content card --}}
          <div class="flex-1 lg:pl-10">
            <div class="bg-card border border-line rounded-sm p-6 hover:shadow-md transition-shadow">
              <h3 class="font-display text-base font-semibold text-navy-800 mb-2">{{ $milestone['title'] }}</h3>
              <p class="font-sans text-sm text-slate-500 leading-relaxed">{{ $milestone['desc'] }}</p>
            </div>
          </div>
        </div>
        @endforeach
      </div>
    </div>
  </div>
</section>

{{-- ============================================================
     6. BOARD OF DIRECTORS
     ============================================================ --}}
<section class="bg-paper2 py-16 lg:py-24">
  <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

    <div class="mb-14 text-center reveal">
      <p class="font-sans text-xs font-semibold uppercase tracking-widest text-brass-700 mb-2">03 — Kepemimpinan</p>
      <h2 class="font-display text-3xl lg:text-4xl font-semibold text-navy-900">Dewan Direksi</h2>
      <p class="mt-3 font-sans text-slate-500 max-w-md mx-auto">
        Tim manajemen inti yang mengarahkan strategi dan operasional perusahaan.
      </p>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 lg:gap-8">
      @foreach($directors as $i => $director)

      @php
        // Initials: first letter of each word (up to 2)
        $words    = preg_split('/\s+/', trim($director['name']));
        $initials = strtoupper(
          implode('', array_map(fn($w) => substr($w, 0, 1), array_slice($words, 0, 2)))
        );
      @endphp

      <div class="reveal bg-card border border-line rounded-sm shadow-sm hover:shadow-md transition-all duration-300 overflow-hidden group"
           style="transition-delay:{{ $i * 100 }}ms">

        {{-- Photo / initials block --}}
        <div class="relative aspect-[3/2] bg-gradient-to-br from-navy-700 to-navy-900 overflow-hidden">
          @if(!empty($director['photo']))
            <img src="{{ asset('storage/'.$director['photo']) }}"
                 alt="{{ $director['name'] }}"
                 class="w-full h-full object-cover object-top group-hover:scale-105 transition-transform duration-500"
                 loading="lazy">
            <div class="absolute inset-0 bg-gradient-to-t from-navy-900/60 to-transparent"></div>
          @else
            {{-- Blueprint-pattern bg + large initials --}}
            <div class="absolute inset-0 bg-blueprint opacity-30"></div>
            <div class="absolute inset-0 flex items-center justify-center">
              <div class="w-20 h-20 rounded-full bg-navy-800 border-2 border-brass-500/40 flex items-center justify-center shadow-lg">
                <span class="font-display text-3xl font-bold text-brass-300">{{ $initials }}</span>
              </div>
            </div>
            <div class="absolute inset-0 bg-gradient-to-t from-navy-900/70 to-transparent"></div>
          @endif

          {{-- Brass corner accent --}}
          <div class="absolute top-0 right-0 w-8 h-1 bg-brass-500"></div>
          <div class="absolute top-0 right-0 w-1 h-8 bg-brass-500"></div>
        </div>

        {{-- Info --}}
        <div class="p-6">
          <p class="font-sans text-xs font-semibold uppercase tracking-wider text-brass-700 mb-1">
            {{ $director['position'] }}
          </p>
          <h3 class="font-display text-lg font-semibold text-navy-800">
            {{ $director['name'] }}
          </h3>
          <div class="mt-3 h-px w-8 bg-brass-500"></div>
        </div>
      </div>

      @endforeach
    </div>
  </div>
</section>

{{-- ============================================================
     7. LEGALITIES / CERTIFICATIONS GRID
     ============================================================ --}}
<section class="bg-paper py-16 lg:py-24">
  <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

    <div class="mb-14 reveal">
      <p class="font-sans text-xs font-semibold uppercase tracking-widest text-brass-700 mb-2">04 — Legalitas</p>
      <h2 class="font-display text-3xl lg:text-4xl font-semibold text-navy-900">Dokumen Resmi Perusahaan</h2>
      <p class="mt-3 font-sans text-slate-500 max-w-xl">
        Seluruh legalitas KGP terverifikasi dan dapat diunduh pada halaman Dokumen Legal.
      </p>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
      @foreach($legalities as $i => $legal)
      <div class="reveal flex items-start gap-4 bg-card border border-line rounded-sm p-5 hover:shadow-md hover:-translate-y-0.5 transition-all duration-200"
           style="transition-delay:{{ $i * 60 }}ms">

        {{-- Code badge --}}
        <div class="flex-shrink-0 w-12 h-12 rounded-sm bg-navy-900 flex items-center justify-center shadow-sm">
          <span class="font-sans text-[10px] font-bold text-brass-300 text-center leading-tight px-1">{{ $legal['code'] }}</span>
        </div>

        <div class="min-w-0">
          <p class="font-display text-sm font-semibold text-navy-800 leading-snug">{{ $legal['label'] }}</p>
          <div class="mt-1.5 flex items-center gap-1.5">
            <div class="w-1.5 h-1.5 rounded-full bg-success"></div>
            <span class="font-sans text-xs text-slate-400">Terverifikasi</span>
          </div>
        </div>

      </div>
      @endforeach
    </div>

    <div class="mt-10 reveal" style="transition-delay:120ms">
      <x-button as="a" href="{{ route('documents') }}" variant="primary" size="md">
        Lihat Semua Dokumen Legal &rarr;
      </x-button>
    </div>
  </div>
</section>

{{-- ============================================================
     8. CLOSING CTA BAND
     ============================================================ --}}
<section class="bg-navy-900 bg-blueprint py-16 lg:py-20">
  <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
    <div class="reveal max-w-2xl mx-auto text-center">
      <p class="font-sans text-xs font-semibold uppercase tracking-widest text-brass-300 mb-4">
        Siap Berkolaborasi?
      </p>
      <h2 class="font-display text-3xl lg:text-4xl font-semibold text-white mb-5 leading-tight">
        Wujudkan Proyek Anda Bersama KGP
      </h2>
      <p class="font-sans text-navy-100 leading-relaxed mb-8">
        Tim kami siap mendampingi dari konsultasi awal hingga serah terima proyek. Hubungi kami sekarang dan mulailah perjalanan kerja sama yang saling menguntungkan.
      </p>
      <div class="flex flex-wrap gap-3 justify-center">
        <x-button as="a" href="{{ route('contact') }}" variant="accent" size="lg">
          Hubungi Kami Sekarang
        </x-button>
        <x-button as="a" href="{{ route('services.index') }}" variant="outline" size="lg">
          Lihat Layanan
        </x-button>
      </div>
    </div>
  </div>
</section>

@endsection
