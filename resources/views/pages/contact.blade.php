@extends('layouts.app')
@section('title', 'Kontak — KGP')
@section('meta_description', 'Hubungi PT. Kreasindo Graha Persada untuk konsultasi solusi IT, interior, konstruksi, dan mekanikal & elektrikal bagi instansi Anda.')

@section('content')

{{-- PAGE HERO --}}
<section class="relative bg-navy-900 bg-blueprint overflow-hidden pt-32 pb-20">
  <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
    <nav class="flex items-center gap-2 font-sans text-xs font-semibold text-navy-100 mb-6">
      <a href="{{ route('home') }}" class="hover:text-brass-300 transition-colors">Beranda</a>
      <span class="text-white/30">/</span>
      <span class="text-brass-300">Kontak</span>
    </nav>
    <p class="font-sans text-xs font-semibold uppercase tracking-widest text-brass-300 mb-3">Hubungi Kami</p>
    <h1 class="font-display text-4xl lg:text-5xl font-semibold text-white leading-tight">Kontak</h1>
    <p class="mt-4 font-sans text-base text-navy-100 max-w-2xl leading-relaxed">
      Diskusikan kebutuhan IT, interior, konstruksi, atau mekanikal &amp; elektrikal institusi Anda dengan tim profesional kami. Kami siap merespons dalam 1&ndash;2 hari kerja.
    </p>
  </div>
</section>

{{-- MAIN CONTENT --}}
<section class="bg-paper py-16 lg:py-24">
  <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
    <div class="grid grid-cols-1 lg:grid-cols-5 gap-10 items-start">

      {{-- LEFT: Info + Map + Social --}}
      <div class="lg:col-span-2 space-y-5 reveal">

        {{-- Address --}}
        @if(!empty($settings['contact_address'] ?? null))
        <div class="bg-card border border-line rounded-sm p-5 flex gap-4 items-start hover:shadow-sm transition-shadow">
          <div class="w-10 h-10 rounded-sm bg-navy-900 border border-navy-700 flex items-center justify-center flex-shrink-0 text-brass-300">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5">
              <path fill-rule="evenodd" d="M9.69 18.933l.003.001C9.89 19.02 10 19 10 19s.11.02.308-.066l.002-.001.006-.003.018-.008a5.741 5.741 0 00.281-.14c.186-.096.446-.24.757-.433.62-.384 1.445-.966 2.274-1.765C15.302 14.988 17 12.493 17 9A7 7 0 103 9c0 3.492 1.698 5.988 3.355 7.584a13.731 13.731 0 002.273 1.765 11.842 11.842 0 00.976.544l.062.029.018.008.006.003zM10 11.25a2.25 2.25 0 100-4.5 2.25 2.25 0 000 4.5z" clip-rule="evenodd" />
            </svg>
          </div>
          <div>
            <h5 class="font-sans font-semibold text-xs uppercase tracking-widest text-slate-400 mb-1">Alamat Kantor</h5>
            <p class="font-sans text-sm text-navy-800 leading-relaxed font-medium">{{ $settings['contact_address'] }}</p>
          </div>
        </div>
        @endif

        {{-- Phone --}}
        @if(!empty($settings['contact_phone'] ?? null))
        <div class="bg-card border border-line rounded-sm p-5 flex gap-4 items-start hover:shadow-sm transition-shadow">
          <div class="w-10 h-10 rounded-sm bg-navy-900 border border-navy-700 flex items-center justify-center flex-shrink-0 text-brass-300">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5">
              <path fill-rule="evenodd" d="M2 3.5A1.5 1.5 0 013.5 2h1.148a1.5 1.5 0 011.465 1.175l.716 3.223a1.5 1.5 0 01-1.052 1.767l-.933.267c-.41.117-.643.555-.48.95a11.542 11.542 0 006.254 6.254c.395.163.833-.07.95-.48l.267-.933a1.5 1.5 0 011.767-1.052l3.223.716A1.5 1.5 0 0118 15.352V16.5a1.5 1.5 0 01-1.5 1.5H15c-1.149 0-2.263-.15-3.326-.43A13.022 13.022 0 012.43 8.326 13.019 13.019 0 012 5V3.5z" clip-rule="evenodd" />
            </svg>
          </div>
          <div>
            <h5 class="font-sans font-semibold text-xs uppercase tracking-widest text-slate-400 mb-1">Telepon</h5>
            <p class="font-sans text-sm text-navy-800 font-medium">{{ $settings['contact_phone'] }}</p>
          </div>
        </div>
        @endif

        {{-- Email --}}
        @if(!empty($settings['contact_email'] ?? null))
        <div class="bg-card border border-line rounded-sm p-5 flex gap-4 items-start hover:shadow-sm transition-shadow">
          <div class="w-10 h-10 rounded-sm bg-navy-900 border border-navy-700 flex items-center justify-center flex-shrink-0 text-brass-300">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5">
              <path d="M3 4a2 2 0 00-2 2v1.161l8.441 4.221a1.25 1.25 0 001.118 0L19 7.162V6a2 2 0 00-2-2H3z" />
              <path d="M19 8.839l-7.77 3.885a2.75 2.75 0 01-2.46 0L1 8.839V14a2 2 0 002 2h14a2 2 0 002-2V8.839z" />
            </svg>
          </div>
          <div>
            <h5 class="font-sans font-semibold text-xs uppercase tracking-widest text-slate-400 mb-1">Email</h5>
            <p class="font-sans text-sm text-navy-800 font-medium">{{ $settings['contact_email'] }}</p>
          </div>
        </div>
        @endif

        {{-- Office Hours --}}
        <div class="bg-card border border-line rounded-sm p-5 flex gap-4 items-start hover:shadow-sm transition-shadow">
          <div class="w-10 h-10 rounded-sm bg-navy-900 border border-navy-700 flex items-center justify-center flex-shrink-0 text-brass-300">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="9"/><path d="M12 7v5l3 2"/></svg>
          </div>
          <div>
            <h5 class="font-sans font-semibold text-xs uppercase tracking-widest text-slate-400 mb-1">Jam Operasional</h5>
            <p class="font-sans text-sm text-navy-800 font-medium leading-relaxed">{{ $settings['contact_hours'] ?? 'Senin – Jumat, 08:00 – 17:00 WIB' }}</p>
          </div>
        </div>

        {{-- Map --}}
        @php
          $mapQuery = trim($settings['contact_map'] ?? '') !== '' ? trim($settings['contact_map']) : trim($settings['contact_address'] ?? '');
          $mapSrc = null;
          if ($mapQuery !== '') {
            if (\Illuminate\Support\Str::contains($mapQuery, '<iframe')) {
              if (preg_match('/src="([^"]+)"/', $mapQuery, $mm)) { $mapSrc = $mm[1]; }
            } elseif (\Illuminate\Support\Str::startsWith($mapQuery, 'http') && \Illuminate\Support\Str::contains($mapQuery, 'output=embed')) {
              $mapSrc = $mapQuery;
            } else {
              $mapSrc = 'https://maps.google.com/maps?q='.urlencode($mapQuery).'&z=16&output=embed';
            }
          }
          $addressText = trim($settings['contact_address'] ?? '');
          $mapLink = $addressText !== '' ? 'https://www.google.com/maps/search/?api=1&query='.urlencode($addressText) : null;
        @endphp

        @if($mapSrc)
        <div class="rounded-sm overflow-hidden border border-line bg-card">
          <iframe
            src="{{ $mapSrc }}"
            class="w-full aspect-[16/10] block"
            style="border:0"
            loading="lazy"
            referrerpolicy="no-referrer-when-downgrade"
            allowfullscreen
            title="Lokasi Kantor PT. Kreasindo Graha Persada"></iframe>
          @if($mapLink)
          <a href="{{ $mapLink }}" target="_blank" rel="noopener"
             class="flex items-center justify-center gap-2 border-t border-line px-4 py-3 font-sans text-xs font-semibold text-navy-700 hover:text-brass-700 hover:bg-brass-100/30 transition-colors">
            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0Z"/><circle cx="12" cy="10" r="3"/></svg>
            Buka di Google Maps
          </a>
          @endif
        </div>
        @else
        <div class="relative aspect-[16/10] rounded-sm overflow-hidden border border-line">
          <div class="absolute inset-0 bg-blueprint"></div>
          <div class="absolute inset-0"
               style="background: linear-gradient(150deg, rgba(10,30,60,0.85) 0%, rgba(10,30,60,0.6) 100%);">
          </div>
          <div class="absolute inset-0 flex flex-col items-center justify-center gap-3 p-6 text-center">
            <div class="w-5 h-5 rounded-full bg-brass-500 border-2 border-white shadow-lg shadow-brass-500/40 animate-pulse"></div>
            <div>
              <span class="block font-sans text-xs font-semibold bg-white/10 backdrop-blur-sm text-white px-4 py-2 rounded-full border border-white/20">
                Kantor Pusat KGP
              </span>
              <p class="mt-2 font-sans text-xs text-navy-100/60">Hubungi kami untuk lokasi lengkap</p>
            </div>
          </div>
        </div>
        @endif

        {{-- Social links --}}
        @if(!empty($settings['social_instagram'] ?? null) || !empty($settings['social_linkedin'] ?? null) || !empty($settings['social_facebook'] ?? null))
        <div>
          <p class="font-sans text-xs font-semibold uppercase tracking-widest text-slate-400 mb-3">Ikuti Kami</p>
          <div class="flex flex-wrap gap-3">
            @if(!empty($settings['social_instagram'] ?? null))
            <a href="{{ $settings['social_instagram'] }}" target="_blank" rel="noopener"
               class="inline-flex items-center gap-2 font-sans text-xs font-semibold text-navy-700 bg-card border border-line rounded-sm px-4 py-2.5 hover:border-brass-500 hover:text-brass-700 hover:bg-brass-100/30 transition-all">
              <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zM12 0C8.741 0 8.333.014 7.053.072 2.695.272.273 2.69.073 7.052.014 8.333 0 8.741 0 12c0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98C8.333 23.986 8.741 24 12 24c3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98C15.668.014 15.259 0 12 0zm0 5.838a6.162 6.162 0 100 12.324 6.162 6.162 0 000-12.324zM12 16a4 4 0 110-8 4 4 0 010 8zm6.406-11.845a1.44 1.44 0 100 2.881 1.44 1.44 0 000-2.881z"/></svg>
              Instagram
            </a>
            @endif
            @if(!empty($settings['social_linkedin'] ?? null))
            <a href="{{ $settings['social_linkedin'] }}" target="_blank" rel="noopener"
               class="inline-flex items-center gap-2 font-sans text-xs font-semibold text-navy-700 bg-card border border-line rounded-sm px-4 py-2.5 hover:border-brass-500 hover:text-brass-700 hover:bg-brass-100/30 transition-all">
              <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 24 24"><path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433a2.062 2.062 0 01-2.063-2.065 2.064 2.064 0 112.063 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/></svg>
              LinkedIn
            </a>
            @endif
            @if(!empty($settings['social_facebook'] ?? null))
            <a href="{{ $settings['social_facebook'] }}" target="_blank" rel="noopener"
               class="inline-flex items-center gap-2 font-sans text-xs font-semibold text-navy-700 bg-card border border-line rounded-sm px-4 py-2.5 hover:border-brass-500 hover:text-brass-700 hover:bg-brass-100/30 transition-all">
              <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
              Facebook
            </a>
            @endif
          </div>
        </div>
        @endif
      </div>

      {{-- RIGHT: Contact Form --}}
      <div class="lg:col-span-3 reveal" style="transition-delay:120ms">
        <div class="bg-card border border-line rounded-sm shadow-sm p-8">
          <div class="mb-7">
            <p class="font-sans text-xs font-semibold uppercase tracking-widest text-brass-700 mb-2">Formulir Kontak</p>
            <h3 class="font-display text-2xl font-semibold text-navy-800 mb-1">Kirim Pesan</h3>
            <p class="font-sans text-sm text-slate-500">
              Lengkapi formulir berikut, tim kami akan merespons dalam 1&ndash;2 hari kerja.
            </p>
          </div>

          @if (session('contact_success'))
            <div class="mb-6 flex items-start gap-3 rounded-sm border border-success/30 bg-success/10 px-4 py-3">
              <svg class="mt-0.5 h-5 w-5 flex-shrink-0 text-success" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M20 6L9 17l-5-5"/></svg>
              <div>
                <p class="font-sans text-sm font-semibold text-navy-800">Pesan Anda terkirim.</p>
                <p class="font-sans text-xs text-slate-500">Terima kasih. Tim kami akan merespons dalam 1&ndash;2 hari kerja.</p>
              </div>
            </div>
          @endif

          @if ($errors->any())
            <div class="mb-6 rounded-sm border border-danger/30 bg-danger/10 px-4 py-3">
              <p class="mb-1 font-sans text-sm font-semibold text-danger">Mohon periksa kembali isian Anda:</p>
              <ul class="list-inside list-disc space-y-0.5 font-sans text-xs text-danger/90">
                @foreach ($errors->all() as $error)
                  <li>{{ $error }}</li>
                @endforeach
              </ul>
            </div>
          @endif

          <form action="{{ route('contact.submit') }}" method="POST" novalidate>
            @csrf
            {{-- Honeypot anti-spam: biarkan kosong; disembunyikan dari pengguna --}}
            <div class="hidden" aria-hidden="true">
              <label>Jangan isi kolom ini
                <input type="text" name="website" tabindex="-1" autocomplete="off">
              </label>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5 mb-5">
              {{-- Nama Lengkap --}}
              <div class="flex flex-col gap-1.5">
                <label class="font-sans font-semibold text-xs text-navy-800">
                  Nama Lengkap <span class="text-danger">*</span>
                </label>
                <input type="text" name="name" value="{{ old('name') }}" placeholder="Nama Anda" required
                       class="font-sans text-sm px-3.5 py-2.5 border border-line rounded-sm bg-white text-ink
                              focus:outline-none focus:border-brass-500 focus:ring-2 focus:ring-brass-500/20 transition-colors placeholder:text-slate-300">
              </div>

              {{-- Nama Instansi --}}
              <div class="flex flex-col gap-1.5">
                <label class="font-sans font-semibold text-xs text-navy-800">Nama Instansi</label>
                <input type="text" name="company" value="{{ old('company') }}" placeholder="PT / Instansi Anda"
                       class="font-sans text-sm px-3.5 py-2.5 border border-line rounded-sm bg-white text-ink
                              focus:outline-none focus:border-brass-500 focus:ring-2 focus:ring-brass-500/20 transition-colors placeholder:text-slate-300">
              </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5 mb-5">
              {{-- Email --}}
              <div class="flex flex-col gap-1.5">
                <label class="font-sans font-semibold text-xs text-navy-800">
                  Email <span class="text-danger">*</span>
                </label>
                <input type="email" name="email" value="{{ old('email') }}" placeholder="nama@email.com" required
                       class="font-sans text-sm px-3.5 py-2.5 border border-line rounded-sm bg-white text-ink
                              focus:outline-none focus:border-brass-500 focus:ring-2 focus:ring-brass-500/20 transition-colors placeholder:text-slate-300">
              </div>

              {{-- Nomor Telepon --}}
              <div class="flex flex-col gap-1.5">
                <label class="font-sans font-semibold text-xs text-navy-800">
                  Nomor Telepon <span class="text-danger">*</span>
                </label>
                <input type="tel" name="phone" value="{{ old('phone') }}" placeholder="08xx-xxxx-xxxx" required
                       class="font-sans text-sm px-3.5 py-2.5 border border-line rounded-sm bg-white text-ink
                              focus:outline-none focus:border-brass-500 focus:ring-2 focus:ring-brass-500/20 transition-colors placeholder:text-slate-300">
              </div>
            </div>

            {{-- Minat Layanan --}}
            <div class="flex flex-col gap-1.5 mb-5">
              <label class="font-sans font-semibold text-xs text-navy-800">Minat Layanan</label>
              <select name="service_interest" class="font-sans text-sm px-3.5 py-2.5 border border-line rounded-sm bg-white text-ink
                             focus:outline-none focus:border-brass-500 focus:ring-2 focus:ring-brass-500/20 transition-colors">
                <option value="">— Pilih Layanan —</option>
                <option value="it" @selected(old('service_interest') === 'it')>IT &mdash; Software &amp; Hardware</option>
                <option value="interior" @selected(old('service_interest') === 'interior')>Interior &amp; Furniture</option>
                <option value="lainnya" @selected(old('service_interest') === 'lainnya')>Lainnya / Konsultasi Umum</option>
              </select>
            </div>

            {{-- Pesan --}}
            <div class="flex flex-col gap-1.5 mb-7">
              <label class="font-sans font-semibold text-xs text-navy-800">
                Pesan <span class="text-danger">*</span>
              </label>
              <textarea name="message" rows="5" placeholder="Jelaskan kebutuhan proyek Anda secara singkat..." required
                        class="font-sans text-sm px-3.5 py-2.5 border border-line rounded-sm bg-white text-ink resize-vertical
                               focus:outline-none focus:border-brass-500 focus:ring-2 focus:ring-brass-500/20 transition-colors placeholder:text-slate-300 min-h-[120px]">{{ old('message') }}</textarea>
            </div>

            <x-button type="submit" variant="accent" size="lg" class="w-full justify-center">
              <svg class="w-4 h-4 mr-2 inline-block" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M22 2L11 13M22 2l-7 20-4-9-9-4 20-7z"/></svg>
              Kirim Pesan
            </x-button>

            <p class="font-sans text-xs text-slate-400 mt-4 text-center leading-relaxed">
              Dengan mengirimkan formulir ini, Anda menyetujui kebijakan privasi data
              PT. Kreasindo Graha Persada.
            </p>
          </form>
        </div>

      </div>

    </div>
  </div>
</section>

@endsection
