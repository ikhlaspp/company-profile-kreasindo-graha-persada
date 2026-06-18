@php
    $phone = $site['contact_phone'] ?? null;
    $email = $site['contact_email'] ?? null;

    // Tautan utama + grup "Profil" agar navigasi tetap ringkas dan profesional.
    $primaryLinks = [
        ['route' => 'home', 'pattern' => 'home', 'label' => 'Beranda'],
        ['route' => 'services.index', 'pattern' => 'services.*', 'label' => 'Layanan'],
        ['route' => 'portfolio.index', 'pattern' => 'portfolio.*', 'label' => 'Portofolio'],
        ['route' => 'gallery.index', 'pattern' => 'gallery.*', 'label' => 'Galeri'],
        ['route' => 'news.index', 'pattern' => 'news.*', 'label' => 'Berita'],
    ];

    $profileLinks = [
        ['route' => 'about', 'pattern' => 'about', 'label' => 'Tentang Kami'],
        ['route' => 'clients', 'pattern' => 'clients', 'label' => 'Klien Kami'],
        ['route' => 'documents', 'pattern' => 'documents', 'label' => 'Dokumen'],
        ['route' => 'careers', 'pattern' => 'careers', 'label' => 'Karir'],
    ];

    $profileActive = collect($profileLinks)->contains(fn ($l) => request()->routeIs($l['pattern']));
@endphp

<header x-data="{ open: false, drop: false, scrolled: false }"
        @scroll.window="scrolled = window.scrollY > 40"
        @keydown.escape.window="open = false; drop = false"
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
                <span class="w-10 h-10 border-2 border-brass-500 rounded-sm flex items-center justify-center font-display font-bold text-lg tracking-wider group-hover:bg-brass-500 group-hover:text-navy-900 transition-colors" aria-hidden="true">K</span>
                <span class="leading-tight">
                    <span class="block font-display font-bold text-lg tracking-[0.18em]">KGP</span>
                    <span class="block text-[10px] font-medium tracking-[0.08em] text-slate-300 uppercase">Kreasindo Graha Persada</span>
                </span>
            </a>

            {{-- Menu desktop --}}
            <div class="hidden lg:flex items-center gap-1 text-sm font-medium">
                @foreach($primaryLinks as $link)
                    <a href="{{ route($link['route']) }}"
                       @class([
                           'relative px-3 py-2 rounded-sm transition-colors hover:text-brass-300 focus:outline-none focus-visible:ring-2 focus-visible:ring-brass-500',
                           'text-brass-300 after:absolute after:left-3 after:right-3 after:-bottom-0.5 after:h-0.5 after:bg-brass-500' => request()->routeIs($link['pattern']),
                       ])
                       @if(request()->routeIs($link['pattern'])) aria-current="page" @endif>
                        {{ $link['label'] }}
                    </a>
                @endforeach

                {{-- Dropdown Profil --}}
                <div class="relative" @click.outside="drop = false">
                    <button @click="drop = !drop" :aria-expanded="drop" aria-haspopup="true"
                            @class([
                                'inline-flex items-center gap-1 px-3 py-2 rounded-sm transition-colors hover:text-brass-300 cursor-pointer focus:outline-none focus-visible:ring-2 focus-visible:ring-brass-500',
                                'text-brass-300' => $profileActive,
                            ])>
                        Profil
                        <svg class="w-4 h-4 transition-transform" :class="drop ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </button>
                    <div x-show="drop" x-cloak x-transition.origin.top
                         class="absolute right-0 mt-2 w-52 bg-white text-navy-900 rounded-sm shadow-lg border border-line py-2">
                        @foreach($profileLinks as $link)
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
                @foreach($primaryLinks as $link)
                    <a href="{{ route($link['route']) }}"
                       @class([
                           'block px-3 py-2.5 rounded-sm text-white hover:bg-white/5 hover:text-brass-300 transition-colors',
                           'text-brass-300 bg-white/5 font-semibold' => request()->routeIs($link['pattern']),
                       ])>
                        {{ $link['label'] }}
                    </a>
                @endforeach

                <p class="px-3 pt-4 pb-1 text-[11px] font-semibold tracking-[0.2em] uppercase text-slate-400">Profil Perusahaan</p>
                @foreach($profileLinks as $link)
                    <a href="{{ route($link['route']) }}"
                       @class([
                           'block px-3 py-2.5 rounded-sm text-white hover:bg-white/5 hover:text-brass-300 transition-colors',
                           'text-brass-300 bg-white/5 font-semibold' => request()->routeIs($link['pattern']),
                       ])>
                        {{ $link['label'] }}
                    </a>
                @endforeach

                <div class="pt-4 pb-2">
                    <x-button variant="accent" as="a" href="{{ route('contact') }}" class="w-full">Hubungi Kami</x-button>
                </div>
            </div>
        </div>
    </nav>
</header>
