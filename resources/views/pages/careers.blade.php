@extends('layouts.app')
@section('title', 'Karir — KGP')
@section('meta_description', 'Bergabunglah bersama tim profesional PT. Kreasindo Graha Persada dan kembangkan karier Anda dalam proyek-proyek strategis nasional.')

@section('content')

{{-- PAGE HERO --}}
<section class="relative bg-navy-900 bg-blueprint overflow-hidden pt-32 pb-16">
  <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
    <nav class="flex items-center gap-2 font-sans text-xs font-semibold text-navy-100 mb-6">
      <a href="{{ route('home') }}" class="hover:text-brass-300 transition-colors">Beranda</a>
      <span class="text-white/30">/</span>
      <span class="text-brass-300">Karir</span>
    </nav>
    <p class="font-sans text-xs font-semibold uppercase tracking-widest text-brass-300 mb-3">Bergabung Bersama Kami</p>
    <h1 class="font-display text-4xl lg:text-5xl font-semibold text-white">Karir di KGP</h1>
    <p class="mt-4 font-sans text-base text-navy-100 max-w-2xl">
      Kembangkan karier Anda bersama tim profesional PT. Kreasindo Graha Persada yang melayani instansi pemerintah, militer, dan korporasi terkemuka di Indonesia.
    </p>
  </div>
</section>

{{-- WHY KGP --}}
<section class="bg-paper py-16 lg:py-20">
  <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
    <div class="text-center mb-12">
      <p class="font-sans text-xs font-semibold uppercase tracking-widest text-brass-700 mb-2">Mengapa KGP</p>
      <h2 class="font-display text-3xl lg:text-4xl font-semibold text-navy-800">Lingkungan Kerja yang Mendukung Pertumbuhan</h2>
    </div>
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
      <div class="bg-card border border-line rounded-sm p-6 text-center">
        <div class="w-11 h-11 rounded-full bg-brass-100 text-brass-700 flex items-center justify-center mx-auto mb-4 text-xl">&#127942;</div>
        <h5 class="font-sans font-semibold text-sm text-navy-800 mb-2">Proyek Bergengsi</h5>
        <p class="font-sans text-xs text-slate-500 leading-relaxed">Terlibat langsung dalam proyek strategis nasional yang berdampak luas.</p>
      </div>
      <div class="bg-card border border-line rounded-sm p-6 text-center">
        <div class="w-11 h-11 rounded-full bg-brass-100 text-brass-700 flex items-center justify-center mx-auto mb-4 text-xl">&#128218;</div>
        <h5 class="font-sans font-semibold text-sm text-navy-800 mb-2">Pengembangan Diri</h5>
        <p class="font-sans text-xs text-slate-500 leading-relaxed">Pelatihan dan sertifikasi berkelanjutan untuk mendukung kemajuan karier Anda.</p>
      </div>
      <div class="bg-card border border-line rounded-sm p-6 text-center">
        <div class="w-11 h-11 rounded-full bg-brass-100 text-brass-700 flex items-center justify-center mx-auto mb-4 text-xl">&#129309;</div>
        <h5 class="font-sans font-semibold text-sm text-navy-800 mb-2">Budaya Kolaboratif</h5>
        <p class="font-sans text-xs text-slate-500 leading-relaxed">Tim solid lintas divisi IT, Interior, dan Mekanikal &amp; Elektrikal.</p>
      </div>
      <div class="bg-card border border-line rounded-sm p-6 text-center">
        <div class="w-11 h-11 rounded-full bg-brass-100 text-brass-700 flex items-center justify-center mx-auto mb-4 text-xl">&#128176;</div>
        <h5 class="font-sans font-semibold text-sm text-navy-800 mb-2">Kompensasi Kompetitif</h5>
        <p class="font-sans text-xs text-slate-500 leading-relaxed">Remunerasi yang kompetitif sesuai standar industri dan pengalaman Anda.</p>
      </div>
    </div>
  </div>
</section>

{{-- CAREER LISTINGS --}}
<section class="bg-paper2 py-16 lg:py-24">
  <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

    <div class="mb-10">
      <p class="font-sans text-xs font-semibold uppercase tracking-widest text-brass-700 mb-2">Lowongan Tersedia</p>
      <h2 class="font-display text-3xl lg:text-4xl font-semibold text-navy-800">Posisi yang Sedang Dibuka</h2>
    </div>

    @forelse($careers as $career)
      @php
        $divisionLabel = match($career->division) {
          'it'       => 'Divisi IT',
          'interior' => 'Divisi Interior',
          'me'       => 'Mekanikal & Elektrikal',
          default    => 'Umum',
        };
        $divisionColor = match($career->division) {
          'it'       => 'bg-info/10 text-info border-info/20',
          'interior' => 'bg-brass-100 text-brass-700 border-brass-300/40',
          'me'       => 'bg-success/10 text-success border-success/20',
          default    => 'bg-slate-100 text-slate-500 border-slate-200',
        };
        $typeLabel = match($career->employment_type) {
          'full_time'  => 'Penuh Waktu',
          'part_time'  => 'Paruh Waktu',
          'contract'   => 'Kontrak',
          'internship' => 'Magang',
          default      => $career->employment_type,
        };
        $deadlineDisplay = $career->deadline?->translatedFormat('d F Y') ?? 'Terbuka';
        $isOpen = $career->is_active;
      @endphp

      <div
        x-data="{ open: false }"
        class="bg-card border border-line rounded-sm shadow-sm mb-4 overflow-hidden"
      >
        {{-- Card header (always visible) --}}
        <button
          type="button"
          @click="open = !open"
          class="w-full text-left px-6 py-5 flex items-start justify-between gap-6 hover:bg-paper/50 transition-colors focus:outline-none group"
          :aria-expanded="open"
        >
          <div class="flex-1 min-w-0">

            {{-- Badges --}}
            <div class="flex items-center gap-2 flex-wrap mb-3">
              <span class="inline-block font-sans text-xs font-semibold px-2.5 py-0.5 rounded-full border {{ $divisionColor }}">
                {{ $divisionLabel }}
              </span>
              <span class="inline-block font-sans text-xs font-medium px-2.5 py-0.5 rounded-full border bg-navy-100/60 text-navy-700 border-navy-100">
                {{ $typeLabel }}
              </span>
              @if(!$isOpen)
                <span class="inline-block font-sans text-xs font-medium px-2.5 py-0.5 rounded-full border bg-slate-100 text-slate-400 border-slate-200">
                  Tutup
                </span>
              @endif
            </div>

            {{-- Title --}}
            <h3 class="font-display text-lg lg:text-xl font-semibold text-navy-800 mb-2 group-hover:text-navy-600 transition-colors">
              {{ $career->title }}
            </h3>

            {{-- Meta row --}}
            <div class="flex items-center gap-4 font-sans text-xs text-slate-400 flex-wrap">
              @if($career->location)
                <span class="flex items-center gap-1">
                  <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
                  {{ $career->location }}
                </span>
              @endif
              <span class="flex items-center gap-1">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2"/><path d="M16 2v4M8 2v4M3 10h18"/></svg>
                Batas: <span class="{{ $career->deadline && $career->deadline->isPast() ? 'text-danger font-semibold' : '' }}">{{ $deadlineDisplay }}</span>
              </span>
              @if($career->description)
                <span class="hidden sm:block text-slate-300 truncate max-w-xs lg:max-w-sm">
                  {{ Str::limit(strip_tags($career->description), 80) }}
                </span>
              @endif
            </div>
          </div>

          {{-- Expand chevron --}}
          <div class="flex-shrink-0 w-8 h-8 rounded-full bg-navy-100/60 flex items-center justify-center transition-colors group-hover:bg-brass-100 mt-0.5">
            <svg
              class="w-4 h-4 text-navy-600 transition-transform duration-200"
              :class="{ 'rotate-180': open }"
              fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"
            >
              <path d="M6 9l6 6 6-6"/>
            </svg>
          </div>
        </button>

        {{-- Expandable detail --}}
        <div
          x-show="open"
          x-transition:enter="transition ease-out duration-200"
          x-transition:enter-start="opacity-0 -translate-y-2"
          x-transition:enter-end="opacity-100 translate-y-0"
          x-transition:leave="transition ease-in duration-150"
          x-transition:leave-start="opacity-100 translate-y-0"
          x-transition:leave-end="opacity-0 -translate-y-2"
          class="border-t border-line px-6 py-6 bg-paper/40"
          x-cloak
        >
          <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">

            {{-- Description --}}
            @if($career->description)
              <div>
                <h4 class="font-sans text-xs font-semibold uppercase tracking-widest text-brass-700 mb-3">Deskripsi Pekerjaan</h4>
                <div class="font-sans text-sm text-slate-600 leading-relaxed space-y-2 rich-text">
                  @foreach(array_filter(array_map('trim', explode("\n", $career->description))) as $line)
                    <p>{{ $line }}</p>
                  @endforeach
                </div>
              </div>
            @endif

            {{-- Requirements --}}
            @if($career->requirements)
              <div>
                <h4 class="font-sans text-xs font-semibold uppercase tracking-widest text-brass-700 mb-3">Persyaratan</h4>
                <ul class="space-y-2">
                  @foreach(array_filter(array_map('trim', explode("\n", $career->requirements))) as $req)
                    <li class="flex items-start gap-2 font-sans text-sm text-slate-600 leading-relaxed">
                      <svg class="w-4 h-4 text-brass-500 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M20 6L9 17l-5-5"/></svg>
                      {{ $req }}
                    </li>
                  @endforeach
                </ul>
              </div>
            @endif

          </div>

          {{-- Apply CTA --}}
          <div class="mt-6 pt-5 border-t border-line flex items-center justify-between flex-wrap gap-4">
            <p class="font-sans text-sm text-slate-500">
              Tertarik? Kirimkan lamaran Anda melalui halaman kontak kami.
            </p>
            <x-button as="a" href="{{ route('contact') }}" variant="accent" size="md">
              Lamar Sekarang
            </x-button>
          </div>
        </div>

      </div>
    @empty
      <div class="py-20 text-center">
        <div class="w-16 h-16 rounded-full bg-navy-100 flex items-center justify-center mx-auto mb-4 text-2xl">
          &#128196;
        </div>
        <p class="font-display text-lg text-navy-700 mb-2">Belum ada lowongan saat ini</p>
        <p class="font-sans text-sm text-slate-400 max-w-sm mx-auto">
          Pantau terus halaman ini untuk informasi lowongan terbaru, atau kirimkan CV spontan Anda kepada kami.
        </p>
      </div>
    @endforelse

  </div>
</section>

{{-- SPONTANEOUS CV CTA BAND --}}
<section class="bg-navy-800 py-16">
  <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
    <div class="flex flex-col lg:flex-row items-center justify-between gap-8">
      <div>
        <p class="font-sans text-xs font-semibold uppercase tracking-widest text-brass-300 mb-2">CV Spontan</p>
        <h2 class="font-display text-2xl lg:text-3xl font-semibold text-white mb-2">
          Tidak menemukan posisi yang cocok?
        </h2>
        <p class="font-sans text-base text-navy-100 max-w-lg">
          Kirimkan CV terbaikmu dan kami akan menghubungi kembali bila ada posisi yang sesuai dengan profil Anda.
        </p>
      </div>
      <div class="flex-shrink-0">
        <x-button as="a" href="{{ route('contact') }}" variant="accent" size="lg">
          Kirim CV Spontan
        </x-button>
      </div>
    </div>
  </div>
</section>

@endsection
