@extends('layouts.app')
@section('title', 'Karir — KGP')
@section('meta_description', 'Bergabunglah bersama tim profesional PT. Kreasindo Graha Persada dan kembangkan karier Anda dalam proyek-proyek strategis nasional.')

@section('content')

{{-- PAGE HERO --}}
<section class="relative bg-navy-900 bg-blueprint overflow-hidden pt-32 pb-20">
  <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
    <nav class="flex items-center gap-2 font-sans text-xs font-semibold text-navy-100 mb-6">
      <a href="{{ route('home') }}" class="hover:text-brass-300 transition-colors">Beranda</a>
      <span class="text-white/30">/</span>
      <span class="text-brass-300">Karir</span>
    </nav>
    <p class="font-sans text-xs font-semibold uppercase tracking-widest text-brass-300 mb-3">Bergabung Bersama Kami</p>
    <h1 class="font-display text-4xl lg:text-5xl font-semibold text-white leading-tight">Karir di KGP</h1>
    <p class="mt-4 font-sans text-base text-navy-100 max-w-2xl leading-relaxed">
      Kembangkan karier Anda bersama tim profesional PT. Kreasindo Graha Persada yang melayani instansi pemerintah, militer, dan korporasi terkemuka di Indonesia.
    </p>
    <div class="mt-8 flex flex-wrap gap-6 font-sans text-xs text-navy-100">
      <span class="flex items-center gap-2">
        <svg class="w-4 h-4 text-brass-300" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 00-3-3.87M16 3.13a4 4 0 010 7.75"/></svg>
        Tim Solid Lintas Divisi
      </span>
      <span class="flex items-center gap-2">
        <svg class="w-4 h-4 text-brass-300" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M22 12h-4l-3 9L9 3l-3 9H2"/></svg>
        Proyek Berskala Nasional
      </span>
      <span class="flex items-center gap-2">
        <svg class="w-4 h-4 text-brass-300" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="8" r="6"/><path d="M15.477 12.89L17 22l-5-3-5 3 1.523-9.11"/></svg>
        Penghargaan TNI AL
      </span>
    </div>
  </div>
</section>

{{-- WHY KGP — CULTURE & VALUES --}}
<section class="bg-paper py-16 lg:py-24">
  <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

    <div class="reveal text-center mb-14">
      <p class="font-sans text-xs font-semibold uppercase tracking-widest text-brass-700 mb-2">Mengapa Bergabung</p>
      <h2 class="font-display text-3xl lg:text-4xl font-semibold text-navy-800">Nilai &amp; Budaya Kerja KGP</h2>
      <p class="mt-3 font-sans text-sm text-slate-500 max-w-xl mx-auto leading-relaxed">
        Bukan sekadar tempat kerja — KGP adalah lingkungan yang mendorong pertumbuhan pribadi dan kontribusi nyata bagi bangsa.
      </p>
    </div>

    <div class="reveal grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">

      {{-- Value 1 --}}
      <div class="bg-card border border-line rounded-sm p-7 text-center hover:shadow-md hover:-translate-y-0.5 transition-all duration-200 flex flex-col items-center gap-4">
        <div class="w-14 h-14 rounded-full bg-navy-900 border border-brass-500/30 flex items-center justify-center">
          <svg class="w-6 h-6 text-brass-300" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path d="M3 21h18M3 10h18M12 3L2 10h20L12 3zM7 21v-8h10v8"/></svg>
        </div>
        <div>
          <h5 class="font-display text-base font-semibold text-navy-800 mb-2">Proyek Berskala Nasional</h5>
          <p class="font-sans text-xs text-slate-500 leading-relaxed">Terlibat langsung dalam proyek strategis untuk institusi pemerintah, TNI/Polri, dan korporasi besar di seluruh Indonesia.</p>
        </div>
      </div>

      {{-- Value 2 --}}
      <div class="bg-card border border-line rounded-sm p-7 text-center hover:shadow-md hover:-translate-y-0.5 transition-all duration-200 flex flex-col items-center gap-4" style="transition-delay:80ms">
        <div class="w-14 h-14 rounded-full bg-navy-900 border border-brass-500/30 flex items-center justify-center">
          <svg class="w-6 h-6 text-brass-300" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path d="M12 22c5.523 0 10-4.477 10-10S17.523 2 12 2 2 6.477 2 12s4.477 10 10 10z"/><path d="M12 6v6l4 2"/></svg>
        </div>
        <div>
          <h5 class="font-display text-base font-semibold text-navy-800 mb-2">Lingkungan Profesional</h5>
          <p class="font-sans text-xs text-slate-500 leading-relaxed">Budaya kerja yang profesional, terstruktur, dan berorientasi pada kualitas — didukung manajemen berpengalaman lintas sektor.</p>
        </div>
      </div>

      {{-- Value 3 --}}
      <div class="bg-card border border-line rounded-sm p-7 text-center hover:shadow-md hover:-translate-y-0.5 transition-all duration-200 flex flex-col items-center gap-4" style="transition-delay:160ms">
        <div class="w-14 h-14 rounded-full bg-navy-900 border border-brass-500/30 flex items-center justify-center">
          <svg class="w-6 h-6 text-brass-300" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path d="M4 19.5A2.5 2.5 0 016.5 17H20"/><path d="M6.5 2H20v20H6.5A2.5 2.5 0 014 19.5v-15A2.5 2.5 0 016.5 2z"/></svg>
        </div>
        <div>
          <h5 class="font-display text-base font-semibold text-navy-800 mb-2">Pengembangan Karier</h5>
          <p class="font-sans text-xs text-slate-500 leading-relaxed">Pelatihan, sertifikasi, dan jalur karier yang jelas di bidang IT, Interior, Konstruksi, serta Mekanikal &amp; Elektrikal.</p>
        </div>
      </div>

      {{-- Value 4 --}}
      <div class="bg-card border border-line rounded-sm p-7 text-center hover:shadow-md hover:-translate-y-0.5 transition-all duration-200 flex flex-col items-center gap-4" style="transition-delay:240ms">
        <div class="w-14 h-14 rounded-full bg-navy-900 border border-brass-500/30 flex items-center justify-center">
          <svg class="w-6 h-6 text-brass-300" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 00-3-3.87M16 3.13a4 4 0 010 7.75"/></svg>
        </div>
        <div>
          <h5 class="font-display text-base font-semibold text-navy-800 mb-2">Tim Solid</h5>
          <p class="font-sans text-xs text-slate-500 leading-relaxed">Rekan kerja berdedikasi dari berbagai latar belakang — IT, desain interior, sipil, hingga mekanikal — bekerja sebagai satu tim.</p>
        </div>
      </div>

    </div>

  </div>
</section>

{{-- CAREER LISTINGS --}}
<section class="bg-paper2 py-16 lg:py-24">
  <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

    <div class="reveal mb-12">
      <p class="font-sans text-xs font-semibold uppercase tracking-widest text-brass-700 mb-2">Lowongan Tersedia</p>
      <h2 class="font-display text-3xl lg:text-4xl font-semibold text-navy-800">Posisi yang Sedang Dibuka</h2>
      <p class="mt-3 font-sans text-sm text-slate-500 max-w-xl leading-relaxed">
        Klik pada setiap posisi untuk melihat deskripsi lengkap dan persyaratan yang dibutuhkan.
      </p>
    </div>

    <div class="reveal space-y-4">
    @forelse($careers as $career)
      @php
        // Map division to human-readable label and color
        $divisionLabel = match($career->division) {
          'it'       => 'Divisi IT',
          'interior' => 'Divisi Interior',
          'me'       => 'Mekanikal & Elektrikal',
          'umum'     => 'Umum',
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
        $isOpen = $career->is_active ?? true;
      @endphp

      <div
        x-data="{ open: false }"
        class="bg-card border border-line rounded-sm shadow-sm overflow-hidden"
      >
        {{-- Card header (always visible) --}}
        <button
          type="button"
          @click="open = !open"
          class="w-full text-left px-6 py-5 flex items-start justify-between gap-6 hover:bg-navy-900/5 transition-colors focus:outline-none group"
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
            <h3 class="font-display text-lg lg:text-xl font-semibold text-navy-800 mb-2 group-hover:text-brass-700 transition-colors">
              {{ $career->title }}
            </h3>

            {{-- Meta row --}}
            <div class="flex items-center gap-4 font-sans text-xs text-slate-400 flex-wrap">
              @if($career->location)
                <span class="flex items-center gap-1">
                  <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0118 0z"/><circle cx="12" cy="10" r="3"/></svg>
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
          <div class="flex-shrink-0 w-9 h-9 rounded-full bg-navy-100/60 flex items-center justify-center transition-colors group-hover:bg-brass-100 mt-0.5">
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
          class="border-t border-line px-6 py-7 bg-paper/50"
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
                <ul class="space-y-2.5">
                  @foreach(array_filter(array_map('trim', explode("\n", $career->requirements))) as $req)
                    <li class="flex items-start gap-2.5 font-sans text-sm text-slate-600 leading-relaxed">
                      <svg class="w-4 h-4 text-brass-500 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M20 6L9 17l-5-5"/></svg>
                      {{ $req }}
                    </li>
                  @endforeach
                </ul>
              </div>
            @endif

          </div>

          {{-- Apply CTA --}}
          <div class="mt-7 pt-5 border-t border-line flex items-center justify-between flex-wrap gap-4">
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
      <div class="py-20 text-center bg-card border border-line rounded-sm">
        <div class="w-16 h-16 rounded-full bg-navy-100 flex items-center justify-center mx-auto mb-4">
          <svg class="w-8 h-8 text-navy-400" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414A1 1 0 0119 9.414V19a2 2 0 01-2 2z"/></svg>
        </div>
        <p class="font-display text-lg text-navy-700 mb-2">Belum ada lowongan saat ini</p>
        <p class="font-sans text-sm text-slate-400 max-w-sm mx-auto leading-relaxed">
          Pantau terus halaman ini untuk informasi lowongan terbaru, atau kirimkan CV spontan Anda kepada kami.
        </p>
      </div>
    @endforelse
    </div>

  </div>
</section>

{{-- SPONTANEOUS CV CTA BAND --}}
<x-cta-band
  eyebrow="CV Spontan"
  title="Tidak Menemukan Posisi yang Cocok?"
  body="Kirimkan CV terbaikmu dan kami akan menghubungi kembali bila ada posisi yang sesuai dengan profil Anda. Talenta terbaik selalu kami sambut." />

@endsection
