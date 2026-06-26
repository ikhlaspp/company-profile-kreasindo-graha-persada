@php
    $phone = $site['contact_phone'] ?? null;
    $email = $site['contact_email'] ?? null;

    // Navigasi dikelompokkan agar ringkas: Beranda + 3 grup dropdown + CTA.
    $groups = [
        'perusahaan' => [
            'label' => 'Perusahaan',
            'patterns' => ['about', 'clients', 'careers'],
            'links' => [
                ['route' => 'about', 'pattern' => 'about', 'label' => 'Tentang Kami'],
                ['route' => 'clients', 'pattern' => 'clients', 'label' => 'Klien Kami'],
                ['route' => 'careers', 'pattern' => 'careers', 'label' => 'Karir'],
            ],
        ],
        'proyek' => [
            'label' => 'Proyek',
            'patterns' => ['portfolio.*', 'gallery.*', 'services.*'],
            'links' => [
                ['route' => 'portfolio.index', 'pattern' => 'portfolio.*', 'label' => 'Portofolio'],
                ['route' => 'gallery.index', 'pattern' => 'gallery.*', 'label' => 'Galeri'],
                ['route' => 'services.index', 'pattern' => 'services.*', 'label' => 'Layanan'],
            ],
        ],
        'media' => [
            'label' => 'Media',
            'patterns' => ['news.*', 'documents'],
            'links' => [
                ['route' => 'news.index', 'pattern' => 'news.*', 'label' => 'Berita'],
                ['route' => 'documents', 'pattern' => 'documents', 'label' => 'Dokumen'],
            ],
        ],
    ];

    $groupActive = fn (array $g) => collect($g['patterns'])->contains(fn ($p) => request()->routeIs($p));
@endphp

<header x-data="{ open: false, menu: null, scrolled: false }"
        @scroll.window="scrolled = window.scrollY > 40"
        @keydown.escape.window="open = false; menu = null"
        class="fixed inset-x-0 top-0 z-50">

    {{-- Bar utilitas: kontak resmi (desktop, menyusut saat scroll) --}}
    <div x-show="!scrolled" x-transition.opacity.duration.200ms
         class="hidden lg:block bg-navy-900 border-b border-white/10 text-slate-300">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 h-9 flex items-center justify-between text-xs">
            <p class="tracking-wide">Mitra Terdaftar LPSE &mdash; Melayani Instansi Pemerintah, Militer, dan Korporasi</p>
            <div class="flex items-center gap-6">
                @if($phone)
                    <a href="tel:{{ preg_replace('/[^0-9+]/', '', $phone) }}" class="inline-flex items-center gap-1.5 hover:text-brass-300 transition-colors">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                        {{ $phone }}
                    </a>
                @endif
                @if($email)
                    <a href="mailto:{{ $email }}" class="inline-flex items-center gap-1.5 hover:text-brass-300 transition-colors">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                        {{ $email }}
                    </a>
                @endif
            </div>
        </div>
    </div>

    {{-- Navigasi utama --}}
    <nav :class="scrolled ? 'bg-navy-900/95 backdrop-blur shadow-lg py-3' : 'bg-transparent py-4'"
         class="transition-all duration-300 text-white" aria-label="Navigasi utama">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 flex justify-between items-center">

            {{-- Logo --}}
            <a href="{{ route('home') }}" class="flex items-center gap-3 group focus:outline-none focus-visible:ring-2 focus-visible:ring-brass-500 rounded-sm">
                <img src="{{ asset('img/kgp-logo.png') }}" alt="Logo PT. Kreasindo Graha Persada" class="w-11 h-11 object-contain flex-shrink-0">
                <span class="leading-tight">
                    <span class="block font-display font-bold text-lg tracking-[0.18em]">KGP</span>
                    <span class="block text-[10px] font-medium tracking-[0.08em] text-slate-300 uppercase">Kreasindo Graha Persada</span>
                </span>
            </a>

            {{-- Menu desktop --}}
            <div class="hidden lg:flex items-center gap-1 text-sm font-medium" @click.outside="menu = null">
                {{-- Beranda --}}
                <a href="{{ route('home') }}"
                   @class([
                       'relative px-3 py-2 rounded-sm transition-colors hover:text-brass-300 focus:outline-none focus-visible:ring-2 focus-visible:ring-brass-500',
                       'text-brass-300 after:absolute after:left-3 after:right-3 after:-bottom-0.5 after:h-0.5 after:bg-brass-500' => request()->routeIs('home'),
                   ])
                   @if(request()->routeIs('home')) aria-current="page" @endif>
                    Beranda
                </a>

                {{-- Grup dropdown --}}
                @foreach($groups as $key => $group)
                    <div class="relative">
                        <button @click="menu = (menu === '{{ $key }}' ? null : '{{ $key }}')" :aria-expanded="menu === '{{ $key }}'" aria-haspopup="true"
                                @class([
                                    'inline-flex items-center gap-1 px-3 py-2 rounded-sm transition-colors hover:text-brass-300 cursor-pointer focus:outline-none focus-visible:ring-2 focus-visible:ring-brass-500',
                                    'text-brass-300' => $groupActive($group),
                                ])>
                            {{ $group['label'] }}
                            <svg class="w-4 h-4 transition-transform" :class="menu === '{{ $key }}' ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                        </button>
                        <div x-show="menu === '{{ $key }}'" x-cloak x-transition.origin.top
                             class="absolute left-0 mt-2 w-52 bg-white text-navy-900 rounded-sm shadow-lg border border-line py-2">
                            @foreach($group['links'] as $link)
                                <a href="{{ route($link['route']) }}"
                                   @class([
                                       'block px-4 py-2.5 text-sm hover:bg-paper2 hover:text-brass-700 transition-colors',
                                       'text-brass-700 font-semibold' => request()->routeIs($link['pattern']),
                                   ])>
                                    {{ $link['label'] }}
                                </a>
                            @endforeach
                        </div>
                    </div>
                @endforeach

                <x-button variant="accent" as="a" href="{{ route('contact') }}" class="ml-3">Hubungi Kami</x-button>
            </div>

            {{-- Toggle mobile --}}
            <button @click="open = !open" :aria-expanded="open" aria-label="Buka menu navigasi" aria-controls="menu-mobile"
                    class="lg:hidden p-2 -mr-2 text-white cursor-pointer focus:outline-none focus-visible:ring-2 focus-visible:ring-brass-500 rounded-sm">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                    <path x-show="!open" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                    <path x-show="open" x-cloak stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>

        {{-- Drawer mobile --}}
        <div id="menu-mobile" x-show="open" x-cloak x-transition.origin.top
             class="lg:hidden bg-navy-900 absolute top-full left-0 w-full shadow-lg border-t border-white/10 max-h-[calc(100vh-4rem)] overflow-y-auto">
            <div class="px-4 sm:px-6 py-5 space-y-1">
                {{-- Beranda --}}
                <a href="{{ route('home') }}"
                   @class([
                       'block px-3 py-2.5 rounded-sm text-white hover:bg-white/5 hover:text-brass-300 transition-colors',
                       'text-brass-300 bg-white/5 font-semibold' => request()->routeIs('home'),
                   ])>
                    Beranda
                </a>

                @foreach($groups as $group)
                    <p class="px-3 pt-4 pb-1 text-[11px] font-semibold tracking-[0.2em] uppercase text-slate-400">{{ $group['label'] }}</p>
                    @foreach($group['links'] as $link)
                        <a href="{{ route($link['route']) }}"
                           @class([
                               'block px-3 py-2.5 rounded-sm text-white hover:bg-white/5 hover:text-brass-300 transition-colors',
                               'text-brass-300 bg-white/5 font-semibold' => request()->routeIs($link['pattern']),
                           ])>
                            {{ $link['label'] }}
                        </a>
                    @endforeach
                @endforeach

                <div class="pt-4 pb-2">
                    <x-button variant="accent" as="a" href="{{ route('contact') }}" class="w-full">Hubungi Kami</x-button>
                </div>
            </div>
        </div>
    </nav>
</header>
