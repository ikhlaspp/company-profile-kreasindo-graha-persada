@extends('layouts.app')
@section('title', 'Beranda — PT. Kreasindo Graha Persada')
@section('meta_description', 'PT. Kreasindo Graha Persada — solusi IT & Interior terpadu untuk instansi pemerintah, militer, dan korporasi sejak 2016.')

@php
    $addr  = $org['contact_address'] ?? '16000 Trade Zone Avenue, Upper Marlboro';
    $phone = $org['contact_phone'] ?? null;
    $email = $org['contact_email'] ?? null;

    $divisionLabels = ['it' => 'Divisi IT', 'interior' => 'Divisi Interior', 'sipil' => 'Divisi Sipil'];
@endphp

@section('content')

{{-- 1. HERO SLIDESHOW --}}
<section
    x-data="{
        active: 0,
        count: {{ count($heroSlides) }},
        timer: null,
        start() { this.timer = setInterval(() => this.next(), 6000); },
        stop() { clearInterval(this.timer); },
        next() { this.active = (this.active + 1) % this.count; },
        prev() { this.active = (this.active - 1 + this.count) % this.count; },
        go(i) { this.active = i; }
    }"
    x-init="start()" @mouseenter="stop()" @mouseleave="start()"
    class="relative h-[92vh] min-h-[600px] w-full overflow-hidden bg-navy-900">

    {{-- Slides --}}
    @foreach($heroSlides as $i => $slide)
    <div x-show="active === {{ $i }}" x-transition.opacity.duration.700ms class="absolute inset-0" @if($i>0) x-cloak @endif>
        <img src="{{ asset($slide['img']) }}"
             alt="" class="w-full h-full object-cover" @if($i>0) loading="lazy" @endif>
        <div class="absolute inset-0 bg-gradient-to-b from-navy-900/70 via-navy-900/40 to-navy-900/80"></div>
    </div>
    @endforeach

    {{-- Overlaid words (static, per brand) --}}
    <div class="relative z-10 h-full flex flex-col items-center justify-center text-center px-4">
        <p class="font-display tracking-[0.3em] text-brass-300 text-sm sm:text-base uppercase mb-5">Sejak 2016</p>
        <p class="text-xs font-sans font-semibold uppercase tracking-widest text-brass-300/90 mb-4">Divisi IT &amp; Interior</p>
        <h1 class="font-display text-white font-semibold leading-tight text-3xl sm:text-5xl lg:text-6xl max-w-4xl">
            Solusi <span class="italic text-brass-300">IT &amp; Interior</span> Terpadu untuk Instansi Anda
        </h1>
        <div class="mt-9 flex flex-wrap gap-3 justify-center">
            <x-button as="a" href="{{ route('portfolio.index') }}" variant="accent" size="lg">Lihat Portofolio</x-button>
            <x-button as="a" href="{{ route('contact') }}" variant="outline" size="lg">Hubungi Kami</x-button>
        </div>
    </div>

    {{-- Prev / Next --}}
    <button @click="prev()" aria-label="Sebelumnya"
            class="absolute left-3 sm:left-6 top-1/2 -translate-y-1/2 z-20 w-11 h-11 rounded-full bg-white/10 hover:bg-brass-500 hover:text-navy-900 text-white flex items-center justify-center backdrop-blur transition-colors">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5"/></svg>
    </button>
    <button @click="next()" aria-label="Berikutnya"
            class="absolute right-3 sm:right-6 top-1/2 -translate-y-1/2 z-20 w-11 h-11 rounded-full bg-white/10 hover:bg-brass-500 hover:text-navy-900 text-white flex items-center justify-center backdrop-blur transition-colors">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5"/></svg>
    </button>

    {{-- Dots --}}
    <div class="absolute bottom-24 left-1/2 -translate-x-1/2 z-20 flex gap-2.5">
        @foreach($heroSlides as $i => $slide)
        <button @click="go({{ $i }})" :class="active === {{ $i }} ? 'bg-brass-500 w-6' : 'bg-white/50 w-2.5'"
                class="h-2.5 rounded-full transition-all" aria-label="Slide {{ $i + 1 }}"></button>
        @endforeach
    </div>

    {{-- Contact strip --}}
    <div class="absolute bottom-0 inset-x-0 z-20 bg-navy-900/70 backdrop-blur border-t border-white/10">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-3.5 flex flex-wrap items-center justify-center gap-x-8 gap-y-1.5 text-sm text-slate-300">
            <span class="flex items-center gap-2"><span class="text-brass-500">&#9679;</span>{{ $addr }}</span>
            @if($phone)<a href="tel:{{ preg_replace('/[^0-9+]/','',$phone) }}" class="hover:text-brass-300 transition-colors">{{ $phone }}</a>@endif
            @if($email)<a href="mailto:{{ $email }}" class="hover:text-brass-300 transition-colors">{{ $email }}</a>@endif
        </div>
    </div>
</section>

{{-- 2. PORTFOLIO GALLERY --}}
<section class="bg-paper py-16 lg:py-24">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="reveal flex flex-col md:flex-row md:items-end md:justify-between gap-6 mb-10">
            <div class="max-w-2xl">
                <p class="text-xs font-sans font-semibold uppercase tracking-widest text-brass-700 mb-2">Portofolio</p>
                <h2 class="font-display text-3xl sm:text-4xl text-navy-800 font-semibold">Proyek Unggulan</h2>
                <p class="mt-4 font-sans text-slate-500 leading-relaxed">
                    Sebagian dari proyek strategis yang telah kami rancang, bangun, dan renovasi untuk mitra nasional di berbagai sektor.
                </p>
            </div>
            <x-button as="a" href="{{ route('portfolio.index') }}" variant="ghost">Lihat Semua Proyek &rarr;</x-button>
        </div>

        @if(count($galleryProjects))
        <div class="reveal grid grid-cols-2 lg:grid-cols-3 gap-4 auto-rows-[200px] sm:auto-rows-[240px]">
            @foreach($galleryProjects as $i => $p)
            <a href="{{ route('portfolio.show', $p['slug']) }}"
               @class([
                   'group relative overflow-hidden rounded-sm shadow-sm',
                   'col-span-2 row-span-2' => $i === 0,
               ])>
                <img src="{{ kgp_image($p['path'], $p['seed'], 800, 600) }}" alt="{{ $p['title'] }}"
                     class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105" loading="lazy">
                <div class="absolute inset-0 bg-gradient-to-t from-navy-900/85 via-navy-900/10 to-transparent"></div>
                <div class="absolute bottom-0 inset-x-0 p-4">
                    <span class="inline-block mb-1.5 px-2 py-0.5 rounded text-[10px] font-sans font-semibold uppercase tracking-wide bg-brass-500 text-navy-900">
                        {{ $divisionLabels[$p['division']] ?? ucfirst($p['division']) }}
                    </span>
                    <h3 class="font-display text-white font-semibold leading-snug {{ $i === 0 ? 'text-xl' : 'text-sm' }}">{{ $p['title'] }}</h3>
                </div>
            </a>
            @endforeach
        </div>
        @else
        <p class="text-slate-400 font-sans">Belum ada proyek untuk ditampilkan.</p>
        @endif
    </div>
</section>

{{-- 3. ABOUT PREVIEW --}}
<section class="bg-paper2 py-16 lg:py-24">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 grid lg:grid-cols-2 gap-12 items-center">
        <div class="reveal">
            <p class="text-xs font-sans font-semibold uppercase tracking-widest text-brass-700 mb-3">Tentang Kami</p>
            <h2 class="font-display text-3xl sm:text-4xl text-navy-800 font-semibold leading-tight">{{ $about['name'] }}</h2>
            <p class="mt-6 font-sans text-slate-500 leading-relaxed max-w-xl">{{ \Illuminate\Support\Str::limit($about['excerpt'], 360) }}</p>
            <div class="mt-8">
                <x-button as="a" href="{{ route('about') }}" variant="primary" size="lg">Selengkapnya</x-button>
            </div>
        </div>
        <div class="reveal aspect-[4/3] overflow-hidden rounded-sm shadow-lg" style="transition-delay:120ms">
            <img src="{{ $about['image'] }}" alt="Gedung {{ $about['name'] }}" class="w-full h-full object-cover" loading="lazy">
        </div>
    </div>
</section>

{{-- 4. CLIENTS --}}
<section class="bg-paper py-16 lg:py-24">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="reveal text-center max-w-2xl mx-auto mb-12">
            <p class="text-xs font-sans font-semibold uppercase tracking-widest text-brass-700 mb-2">Klien Kami</p>
            <h2 class="font-display text-3xl sm:text-4xl text-navy-800 font-semibold">Dipercaya Instansi Terkemuka</h2>
            <p class="mt-4 font-sans text-slate-500 leading-relaxed">
                Kami berkesempatan melayani berbagai instansi pemerintah, militer, BUMN, universitas, dan korporasi nasional.
            </p>
        </div>

        @if(count($clients))
        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-x-6 gap-y-10">
            @foreach($clients as $c)
            <div class="p-4 flex flex-col items-center text-center gap-4">
                <div class="w-28 h-28 sm:w-32 sm:h-32 rounded-full overflow-hidden flex items-center justify-center">
                    <img src="{{ kgp_image($c['path'], $c['seed'], 200, 200) }}" alt="{{ $c['name'] }}" class="w-full h-full object-cover transition-transform duration-300 hover:scale-105" loading="lazy">
                </div>
                <p class="font-sans text-sm sm:text-base font-semibold text-navy-800 leading-snug">{{ $c['name'] }}</p>
            </div>
            @endforeach
        </div>
        @else
        <p class="text-center text-slate-400 font-sans">Daftar klien akan segera ditampilkan.</p>
        @endif
    </div>
</section>

{{-- 5. CONTACT BAND --}}
<section class="relative py-20 lg:py-28 overflow-hidden">
    <img src="{{ !empty($org['cta_band_image']) ? \Illuminate\Support\Facades\Storage::url($org['cta_band_image']) : asset('img/hero/contact-band.jpg') }}" alt="" class="absolute inset-0 w-full h-full object-cover" loading="lazy">
    <div class="absolute inset-0 bg-navy-900/85"></div>
    <div class="reveal relative z-10 mx-auto max-w-3xl px-4 sm:px-6 lg:px-8 text-center">
        <p class="text-xs font-sans font-semibold uppercase tracking-widest text-brass-300 mb-3">Mari Berkolaborasi</p>
        <h2 class="font-display text-3xl sm:text-4xl text-white font-semibold leading-tight">Siap Mewujudkan Proyek Anda Bersama KGP?</h2>
        <p class="mt-5 font-sans text-slate-300 leading-relaxed">
            Diskusikan kebutuhan IT dan interior instansi Anda dengan tim profesional kami. Kami siap membantu dari perencanaan hingga serah terima.
        </p>
        <div class="mt-8">
            <x-button as="a" href="{{ route('contact') }}" variant="accent" size="lg">Hubungi Kami Sekarang</x-button>
        </div>
    </div>
</section>

@endsection
