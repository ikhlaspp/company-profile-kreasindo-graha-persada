@extends('layouts.app')
@section('title', 'Kontak — KGP')
@section('meta_description', 'Hubungi PT. Kreasindo Graha Persada untuk konsultasi solusi IT & interior bagi instansi Anda.')

@section('content')

{{-- PAGE HERO --}}
<section class="relative bg-navy-900 bg-blueprint overflow-hidden pt-32 pb-16">
  <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
    <nav class="flex items-center gap-2 font-sans text-xs font-semibold text-navy-100 mb-6">
      <a href="{{ route('home') }}" class="hover:text-brass-300 transition-colors">Beranda</a>
      <span class="text-white/30">/</span>
      <span class="text-brass-300">Kontak</span>
    </nav>
    <p class="font-sans text-xs font-semibold uppercase tracking-widest text-brass-300 mb-3">Hubungi Kami</p>
    <h1 class="font-display text-4xl lg:text-5xl font-semibold text-white">Kontak</h1>
    <p class="mt-4 font-sans text-base text-navy-100 max-w-2xl">
      Diskusikan kebutuhan IT dan interior institusi Anda dengan tim profesional kami.
    </p>
  </div>
</section>

{{-- MAIN CONTENT --}}
<section class="bg-paper py-16 lg:py-24">
  <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
    <div class="grid grid-cols-1 lg:grid-cols-5 gap-10 items-start">

      {{-- LEFT: Info + Map --}}
      <div class="lg:col-span-2 space-y-4">

        {{-- Address --}}
        @if(!empty($settings['contact_address'] ?? null))
        <div class="bg-card border border-line rounded-sm p-5 flex gap-4 items-start">
          <div class="w-10 h-10 rounded-sm bg-navy-100 flex items-center justify-center flex-shrink-0 text-navy-700">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5">
              <path fill-rule="evenodd" d="M9.69 18.933l.003.001C9.89 19.02 10 19 10 19s.11.02.308-.066l.002-.001.006-.003.018-.008a5.741 5.741 0 00.281-.14c.186-.096.446-.24.757-.433.62-.384 1.445-.966 2.274-1.765C15.302 14.988 17 12.493 17 9A7 7 0 103 9c0 3.492 1.698 5.988 3.355 7.584a13.731 13.731 0 002.273 1.765 11.842 11.842 0 00.976.544l.062.029.018.008.006.003zM10 11.25a2.25 2.25 0 100-4.5 2.25 2.25 0 000 4.5z" clip-rule="evenodd" />
            </svg>
          </div>
          <div>
            <h5 class="font-sans font-semibold text-sm text-navy-800 mb-1">Alamat Kantor</h5>
            <p class="font-sans text-sm text-slate-500 leading-relaxed">{{ $settings['contact_address'] }}</p>
          </div>
        </div>
        @endif

        {{-- Phone --}}
        @if(!empty($settings['contact_phone'] ?? null))
        <div class="bg-card border border-line rounded-sm p-5 flex gap-4 items-start">
          <div class="w-10 h-10 rounded-sm bg-navy-100 flex items-center justify-center flex-shrink-0 text-navy-700">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5">
              <path fill-rule="evenodd" d="M2 3.5A1.5 1.5 0 013.5 2h1.148a1.5 1.5 0 011.465 1.175l.716 3.223a1.5 1.5 0 01-1.052 1.767l-.933.267c-.41.117-.643.555-.48.95a11.542 11.542 0 006.254 6.254c.395.163.833-.07.95-.48l.267-.933a1.5 1.5 0 011.767-1.052l3.223.716A1.5 1.5 0 0118 15.352V16.5a1.5 1.5 0 01-1.5 1.5H15c-1.149 0-2.263-.15-3.326-.43A13.022 13.022 0 012.43 8.326 13.019 13.019 0 012 5V3.5z" clip-rule="evenodd" />
            </svg>
          </div>
          <div>
            <h5 class="font-sans font-semibold text-sm text-navy-800 mb-1">Telepon</h5>
            <p class="font-sans text-sm text-slate-500">{{ $settings['contact_phone'] }}</p>
          </div>
        </div>
        @endif

        {{-- Email --}}
        @if(!empty($settings['contact_email'] ?? null))
        <div class="bg-card border border-line rounded-sm p-5 flex gap-4 items-start">
          <div class="w-10 h-10 rounded-sm bg-navy-100 flex items-center justify-center flex-shrink-0 text-navy-700">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5">
              <path d="M3 4a2 2 0 00-2 2v1.161l8.441 4.221a1.25 1.25 0 001.118 0L19 7.162V6a2 2 0 00-2-2H3z" />
              <path d="M19 8.839l-7.77 3.885a2.75 2.75 0 01-2.46 0L1 8.839V14a2 2 0 002 2h14a2 2 0 002-2V8.839z" />
            </svg>
          </div>
          <div>
            <h5 class="font-sans font-semibold text-sm text-navy-800 mb-1">Email</h5>
            <p class="font-sans text-sm text-slate-500">{{ $settings['contact_email'] }}</p>
          </div>
        </div>
        @endif

        {{-- Hours --}}
        @if(!empty($settings['contact_hours'] ?? null))
        <div class="bg-card border border-line rounded-sm p-5 flex gap-4 items-start">
          <div class="w-10 h-10 rounded-sm bg-navy-100 flex items-center justify-center flex-shrink-0 text-navy-700">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5">
              <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm.75-13a.75.75 0 00-1.5 0v5c0 .414.336.75.75.75h4a.75.75 0 000-1.5h-3.25V5z" clip-rule="evenodd" />
            </svg>
          </div>
          <div>
            <h5 class="font-sans font-semibold text-sm text-navy-800 mb-1">Jam Operasional</h5>
            <p class="font-sans text-sm text-slate-500 leading-relaxed">{{ $settings['contact_hours'] }}</p>
          </div>
        </div>
        @else
        {{-- Default hours if not set --}}
        <div class="bg-card border border-line rounded-sm p-5">
          <h5 class="font-sans font-semibold text-sm text-navy-800 mb-3">Jam Operasional</h5>
          <div class="space-y-1.5">
            <div class="flex justify-between font-sans text-sm">
              <span class="text-slate-500">Senin &ndash; Jumat</span>
              <span class="font-semibold text-navy-800">08:00 &ndash; 17:00 WIB</span>
            </div>
            <div class="flex justify-between font-sans text-sm border-t border-line pt-1.5">
              <span class="text-slate-500">Sabtu</span>
              <span class="font-semibold text-navy-800">08:00 &ndash; 13:00 WIB</span>
            </div>
            <div class="flex justify-between font-sans text-sm border-t border-line pt-1.5">
              <span class="text-slate-500">Minggu &amp; Hari Libur</span>
              <span class="font-semibold text-navy-800">Tutup</span>
            </div>
          </div>
        </div>
        @endif

        {{-- Map placeholder --}}
        <div class="relative aspect-[16/10] rounded-sm overflow-hidden border border-line"
             style="background: linear-gradient(150deg, #DDE5F0, #F2EFE6);">
          <div class="absolute inset-0"
               style="background-image: linear-gradient(rgba(43,78,133,.08) 1px, transparent 1px), linear-gradient(90deg, rgba(43,78,133,.08) 1px, transparent 1px); background-size: 28px 28px;">
          </div>
          <div class="absolute inset-0 flex flex-col items-center justify-center gap-3">
            <div class="w-4 h-4 rounded-full bg-brass-500 border-2 border-navy-800 shadow-lg shadow-brass-500/30"></div>
            <span class="font-sans text-xs font-semibold bg-white px-3 py-1.5 rounded-full shadow-sm text-navy-700">
              Kantor Pusat KGP
            </span>
          </div>
        </div>

        {{-- Social links --}}
        @if(!empty($settings['social_instagram'] ?? null) || !empty($settings['social_linkedin'] ?? null) || !empty($settings['social_facebook'] ?? null))
        <div class="flex flex-wrap gap-3">
          @if(!empty($settings['social_instagram'] ?? null))
          <a href="{{ $settings['social_instagram'] }}" target="_blank" rel="noopener"
             class="font-sans text-xs font-semibold text-navy-700 border border-line rounded-sm px-3 py-2 hover:border-brass-500 hover:text-brass-700 transition-colors">
            Instagram
          </a>
          @endif
          @if(!empty($settings['social_linkedin'] ?? null))
          <a href="{{ $settings['social_linkedin'] }}" target="_blank" rel="noopener"
             class="font-sans text-xs font-semibold text-navy-700 border border-line rounded-sm px-3 py-2 hover:border-brass-500 hover:text-brass-700 transition-colors">
            LinkedIn
          </a>
          @endif
          @if(!empty($settings['social_facebook'] ?? null))
          <a href="{{ $settings['social_facebook'] }}" target="_blank" rel="noopener"
             class="font-sans text-xs font-semibold text-navy-700 border border-line rounded-sm px-3 py-2 hover:border-brass-500 hover:text-brass-700 transition-colors">
            Facebook
          </a>
          @endif
        </div>
        @endif
      </div>

      {{-- RIGHT: Contact Form --}}
      <div class="lg:col-span-3 bg-card border border-line rounded-sm shadow-sm p-8">
        <h3 class="font-display text-2xl font-semibold text-navy-800 mb-1">Kirim Pesan</h3>
        <p class="font-sans text-sm text-slate-500 mb-7">
          Lengkapi formulir berikut, tim kami akan merespons dalam 1&ndash;2 hari kerja.
        </p>

        <form onsubmit="event.preventDefault()">
          <div class="grid grid-cols-1 sm:grid-cols-2 gap-5 mb-5">
            {{-- Nama Lengkap --}}
            <div class="flex flex-col gap-1.5">
              <label class="font-sans font-semibold text-xs text-navy-800">
                Nama Lengkap <span class="text-danger">*</span>
              </label>
              <input type="text" placeholder="Nama Anda" required
                     class="font-sans text-sm px-3.5 py-2.5 border border-line rounded-sm bg-white text-ink
                            focus:outline-none focus:border-brass-500 focus:ring-2 focus:ring-brass-500/20 transition-colors">
            </div>

            {{-- Nama Instansi --}}
            <div class="flex flex-col gap-1.5">
              <label class="font-sans font-semibold text-xs text-navy-800">Nama Instansi</label>
              <input type="text" placeholder="PT / Instansi Anda"
                     class="font-sans text-sm px-3.5 py-2.5 border border-line rounded-sm bg-white text-ink
                            focus:outline-none focus:border-brass-500 focus:ring-2 focus:ring-brass-500/20 transition-colors">
            </div>
          </div>

          <div class="grid grid-cols-1 sm:grid-cols-2 gap-5 mb-5">
            {{-- Email --}}
            <div class="flex flex-col gap-1.5">
              <label class="font-sans font-semibold text-xs text-navy-800">
                Email <span class="text-danger">*</span>
              </label>
              <input type="email" placeholder="nama@email.com" required
                     class="font-sans text-sm px-3.5 py-2.5 border border-line rounded-sm bg-white text-ink
                            focus:outline-none focus:border-brass-500 focus:ring-2 focus:ring-brass-500/20 transition-colors">
            </div>

            {{-- Nomor Telepon --}}
            <div class="flex flex-col gap-1.5">
              <label class="font-sans font-semibold text-xs text-navy-800">
                Nomor Telepon <span class="text-danger">*</span>
              </label>
              <input type="tel" placeholder="08xx-xxxx-xxxx" required
                     class="font-sans text-sm px-3.5 py-2.5 border border-line rounded-sm bg-white text-ink
                            focus:outline-none focus:border-brass-500 focus:ring-2 focus:ring-brass-500/20 transition-colors">
            </div>
          </div>

          {{-- Minat Layanan --}}
          <div class="flex flex-col gap-1.5 mb-5">
            <label class="font-sans font-semibold text-xs text-navy-800">Minat Layanan</label>
            <select class="font-sans text-sm px-3.5 py-2.5 border border-line rounded-sm bg-white text-ink
                           focus:outline-none focus:border-brass-500 focus:ring-2 focus:ring-brass-500/20 transition-colors">
              <option value="">— Pilih Layanan —</option>
              <option value="it">Divisi IT &mdash; Infrastruktur Jaringan</option>
              <option value="it-security">Divisi IT &mdash; Keamanan Siber</option>
              <option value="interior">Divisi Interior &mdash; Desain Ruang</option>
              <option value="interior-renovasi">Divisi Interior &mdash; Renovasi</option>
              <option value="lainnya">Lainnya / Konsultasi Umum</option>
            </select>
          </div>

          {{-- Pesan --}}
          <div class="flex flex-col gap-1.5 mb-6">
            <label class="font-sans font-semibold text-xs text-navy-800">
              Pesan <span class="text-danger">*</span>
            </label>
            <textarea rows="5" placeholder="Jelaskan kebutuhan proyek Anda secara singkat..." required
                      class="font-sans text-sm px-3.5 py-2.5 border border-line rounded-sm bg-white text-ink resize-vertical
                             focus:outline-none focus:border-brass-500 focus:ring-2 focus:ring-brass-500/20 transition-colors min-h-[120px]">
            </textarea>
          </div>

          <x-button type="submit" variant="accent" size="lg" class="w-full justify-center">
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
</section>

@endsection
