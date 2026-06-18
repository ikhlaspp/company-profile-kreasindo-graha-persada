@php
    $footerAddress = $site['contact_address'] ?? 'Depok, Jawa Barat';
    $footerPhone = $site['contact_phone'] ?? null;
    $footerEmail = $site['contact_email'] ?? null;
    $footerHours = $site['contact_hours'] ?? null;

    $footerSocials = collect([
        'Instagram' => ['url' => $site['social_instagram'] ?? null, 'icon' => '<path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zM12 0C8.741 0 8.333.014 7.053.072 2.695.272.273 2.69.073 7.052.014 8.333 0 8.741 0 12c0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98C8.333 23.986 8.741 24 12 24c3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98C15.668.014 15.259 0 12 0zm0 5.838a6.162 6.162 0 100 12.324 6.162 6.162 0 000-12.324zM12 16a4 4 0 110-8 4 4 0 010 8zm6.406-11.845a1.44 1.44 0 100 2.881 1.44 1.44 0 000-2.881z"/>'],
        'LinkedIn'  => ['url' => $site['social_linkedin'] ?? null, 'icon' => '<path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433a2.062 2.062 0 01-2.063-2.065 2.064 2.064 0 112.063 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/>'],
        'Facebook'  => ['url' => $site['social_facebook'] ?? null, 'icon' => '<path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>'],
    ])->filter(fn ($s) => filled($s['url']));
@endphp

<footer class="bg-navy-900 text-slate-300">
    <div class="h-0.5 bg-gradient-to-r from-transparent via-brass-500 to-transparent" aria-hidden="true"></div>

    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 pt-16 pb-10 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-12 gap-10">

        {{-- Brand --}}
        <div class="lg:col-span-4">
            <a href="{{ route('home') }}" class="inline-flex items-center gap-3 mb-5">
                <span class="w-10 h-10 border-2 border-brass-500 rounded-sm flex items-center justify-center font-display font-bold text-lg text-white" aria-hidden="true">K</span>
                <span class="leading-tight">
                    <span class="block font-display font-bold text-lg tracking-[0.18em] text-white">KGP</span>
                    <span class="block text-[10px] font-medium tracking-[0.08em] uppercase">Kreasindo Graha Persada</span>
                </span>
            </a>
            <p class="text-sm leading-relaxed mb-6 max-w-sm">
                Perusahaan konsultan dan kontraktor di bidang Teknologi Informasi dan Desain Interior. Dipercaya instansi pemerintah, militer, dan korporasi nasional sejak 2016.
            </p>
            <div class="flex flex-wrap gap-2">
                @foreach(['SBU', 'SIUP', 'SIUJK', 'NIB', 'LPSE'] as $cert)
                    <span class="px-2.5 py-1 text-[11px] font-semibold tracking-wide border border-white/15 rounded-sm text-slate-300">{{ $cert }}</span>
                @endforeach
            </div>
        </div>

        {{-- Navigasi --}}
        <div class="lg:col-span-2">
            <h4 class="text-white font-sans font-semibold text-sm tracking-[0.12em] uppercase mb-5">Perusahaan</h4>
            <ul class="space-y-3 text-sm">
                <li><a href="{{ route('about') }}" class="hover:text-brass-300 transition-colors">Tentang Kami</a></li>
                <li><a href="{{ route('portfolio.index') }}" class="hover:text-brass-300 transition-colors">Portofolio</a></li>
                <li><a href="{{ route('clients') }}" class="hover:text-brass-300 transition-colors">Klien Kami</a></li>
                <li><a href="{{ route('news.index') }}" class="hover:text-brass-300 transition-colors">Berita</a></li>
                <li><a href="{{ route('careers') }}" class="hover:text-brass-300 transition-colors">Karir</a></li>
            </ul>
        </div>

        {{-- Layanan --}}
        <div class="lg:col-span-2">
            <h4 class="text-white font-sans font-semibold text-sm tracking-[0.12em] uppercase mb-5">Layanan</h4>
            <ul class="space-y-3 text-sm">
                <li><a href="{{ route('services.index') }}#it" class="hover:text-brass-300 transition-colors">Divisi IT</a></li>
                <li><a href="{{ route('services.index') }}#interior" class="hover:text-brass-300 transition-colors">Divisi Interior</a></li>
                <li><a href="{{ route('gallery.index') }}" class="hover:text-brass-300 transition-colors">Galeri Kegiatan</a></li>
                <li><a href="{{ route('documents') }}" class="hover:text-brass-300 transition-colors">Dokumen &amp; Unduhan</a></li>
            </ul>
        </div>

        {{-- Kontak --}}
        <div class="lg:col-span-4">
            <h4 class="text-white font-sans font-semibold text-sm tracking-[0.12em] uppercase mb-5">Hubungi Kami</h4>
            <ul class="space-y-4 text-sm">
                <li class="flex items-start gap-3">
                    <svg class="w-4 h-4 mt-0.5 text-brass-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                    <span>{{ $footerAddress }}</span>
                </li>
                @if($footerPhone)
                    <li class="flex items-start gap-3">
                        <svg class="w-4 h-4 mt-0.5 text-brass-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                        <a href="tel:{{ preg_replace('/[^0-9+]/', '', $footerPhone) }}" class="hover:text-brass-300 transition-colors">{{ $footerPhone }}</a>
                    </li>
                @endif
                @if($footerEmail)
                    <li class="flex items-start gap-3">
                        <svg class="w-4 h-4 mt-0.5 text-brass-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                        <a href="mailto:{{ $footerEmail }}" class="hover:text-brass-300 transition-colors">{{ $footerEmail }}</a>
                    </li>
                @endif
                @if($footerHours)
                    <li class="flex items-start gap-3">
                        <svg class="w-4 h-4 mt-0.5 text-brass-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        <span>{{ $footerHours }}</span>
                    </li>
                @endif
            </ul>

            @if($footerSocials->isNotEmpty())
                <div class="flex gap-3 mt-6">
                    @foreach($footerSocials as $platform => $social)
                        <a href="{{ $social['url'] }}" target="_blank" rel="noopener" aria-label="{{ $platform }} KGP"
                           class="w-9 h-9 border border-white/15 rounded-sm flex items-center justify-center text-slate-300 hover:text-navy-900 hover:bg-brass-500 hover:border-brass-500 transition-colors">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">{!! $social['icon'] !!}</svg>
                        </a>
                    @endforeach
                </div>
            @endif
        </div>
    </div>

    <div class="border-t border-white/10">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-6 flex flex-col sm:flex-row items-center justify-between gap-3 text-[13px] text-slate-400">
            <p>&copy; {{ date('Y') }} PT. Kreasindo Graha Persada. All rights reserved.</p>
            <a href="{{ route('contact') }}" class="hover:text-brass-300 transition-colors">Kontak &amp; Lokasi</a>
        </div>
    </div>
</footer>
