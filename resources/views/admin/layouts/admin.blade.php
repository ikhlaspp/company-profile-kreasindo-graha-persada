<!DOCTYPE html>
<html lang="id" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Console') · KGP Panel</title>

    {{-- Apply collapsed sidebar state before first paint to prevent layout flash --}}
    <script>
        if (localStorage.getItem('kgp_sidebar_collapsed') === '1') {
            document.documentElement.classList.add('sidebar-collapsed');
        }
    </script>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Archivo:wght@400;500;600;700&family=Fraunces:opsz,wght@9..144,500;9..144,600;9..144,700&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body
    class="h-full bg-paper2 font-sans text-slate-700 antialiased [-webkit-font-smoothing:antialiased]"
    x-data="{
        sidebarOpen: false,
        sidebarCollapsed: localStorage.getItem('kgp_sidebar_collapsed') === '1',
        isDesktop: window.innerWidth >= 1024,
        palette: false,
        ready: false,
        get mini() { return this.sidebarCollapsed && this.isDesktop },
        toggleSidebar() {
            if (window.innerWidth >= 1024) {
                this.sidebarCollapsed = !this.sidebarCollapsed;
                document.documentElement.classList.toggle('sidebar-collapsed', this.sidebarCollapsed);
                localStorage.setItem('kgp_sidebar_collapsed', this.sidebarCollapsed ? '1' : '0');
            } else {
                this.sidebarOpen = !this.sidebarOpen;
            }
        },
    }"
    x-init="requestAnimationFrame(() => requestAnimationFrame(() => { ready = true; document.documentElement.classList.add('sidebar-anim') }))"
    @resize.window.debounce.150ms="isDesktop = window.innerWidth >= 1024"
    @keydown.window.cmd.k.prevent="palette = true"
    @keydown.window.ctrl.k.prevent="palette = true"
>
    <div class="flex h-full">
        @include('admin.partials.sidebar')

        <!-- Mobile overlay -->
        <div
            x-show="sidebarOpen"
            x-cloak
            @click="sidebarOpen = false"
            class="fixed inset-0 z-30 bg-navy-900/50 backdrop-blur-sm lg:hidden"
            x-transition.opacity
        ></div>

        <div id="kgp-shell" class="flex min-w-0 flex-1 flex-col">
            @include('admin.partials.topbar')

            <main class="flex-1 overflow-y-auto px-5 py-6 sm:px-8 sm:py-8">
                <div class="mx-auto w-full max-w-[1320px]">
                    @include('admin.partials.flash')
                    @yield('content')
                </div>
            </main>
        </div>
    </div>

    {{-- ⌘K command palette (role-aware quick nav) --}}
    @php
        $paletteUser = auth()->user();
        $paletteItems = collect([
            ['Dashboard', 'panel.dashboard', true],
            ['Layanan', 'panel.services.index', (bool) $paletteUser?->hasRole('admin')],
            ['Portofolio', 'panel.projects.index', (bool) $paletteUser?->hasRole('admin')],
            ['Klien', 'panel.clients.index', (bool) $paletteUser?->hasRole('admin')],
            ['Galeri', 'panel.galleries.index', (bool) $paletteUser?->hasRole('admin')],
            ['Berita', 'panel.posts.index', (bool) $paletteUser?->hasRole('admin', 'editor')],
            ['Dokumen', 'panel.documents.index', (bool) $paletteUser?->hasRole('admin')],
            ['Karir', 'panel.careers.index', (bool) $paletteUser?->hasRole('admin')],
            ['FAQ Chatbot', 'panel.faqs.index', (bool) $paletteUser?->hasRole('admin')],
            ['Log Chatbot', 'panel.chatlogs.index', (bool) $paletteUser?->hasRole('admin')],
            ['Pengaturan', 'panel.settings.edit', (bool) $paletteUser?->isSuperadmin()],
            ['Admin & Users', 'panel.users.index', (bool) $paletteUser?->isSuperadmin()],
        ])->filter(fn ($i) => $i[2])->map(fn ($i) => ['label' => $i[0], 'url' => route($i[1])])->values();
    @endphp
    <div
        x-show="palette"
        x-cloak
        class="fixed inset-0 z-[60] flex items-start justify-center px-4 pt-[12vh]"
        @keydown.escape.window="palette = false"
    >
        <div class="absolute inset-0 bg-navy-900/40 backdrop-blur-sm" @click="palette = false" x-transition.opacity></div>
        <div class="relative w-full max-w-xl overflow-hidden rounded-xl border border-line bg-card shadow-lg"
             x-data="{ q: '', items: @js($paletteItems), get results() { return this.items.filter(i => i.label.toLowerCase().includes(this.q.toLowerCase())) } }"
             x-effect="if (palette) { q = ''; $nextTick(() => $refs.search?.focus()) }"
             @keydown.enter="results.length && (window.location = results[0].url)"
             x-transition:enter="transition ease-out duration-150" x-transition:enter-start="opacity-0 -translate-y-2" x-transition:enter-end="opacity-100 translate-y-0">
            <div class="flex items-center gap-3 border-b border-line px-4">
                <x-admin.icon name="search" class="h-4 w-4 text-slate-500" />
                <input x-ref="search" x-model="q" type="text" placeholder="Cari halaman…" class="w-full border-0 bg-transparent py-3.5 text-sm text-navy-900 placeholder:text-slate-500 focus:ring-0">
                <kbd class="rounded border border-line bg-paper2 px-1.5 py-0.5 text-[10px] font-semibold text-slate-500">ESC</kbd>
            </div>
            <div class="max-h-80 overflow-y-auto px-3 py-3">
                <p class="px-2 pb-2 text-[10px] font-bold uppercase tracking-widest text-slate-500">Navigasi cepat</p>
                <template x-for="i in results" :key="i.url">
                    <a :href="i.url" class="flex items-center gap-3 rounded-lg px-2 py-2 text-sm font-medium text-slate-600 hover:bg-paper2 hover:text-navy-900">
                        <span class="grid h-6 w-6 place-items-center rounded-md bg-paper2 text-slate-500"><x-admin.icon name="corner-down-right" class="h-3.5 w-3.5" /></span>
                        <span x-text="i.label"></span>
                    </a>
                </template>
                <p x-show="!results.length" class="px-2 py-6 text-center text-sm text-slate-500">Tidak ada hasil.</p>
            </div>
        </div>
    </div>

    {{-- Idle logout (Task 4.5): logout otomatis setelah 30 menit tanpa aktivitas,
         selaras SESSION_LIFETIME server. --}}
    <form id="kgp-idle-logout" action="{{ route('panel.logout') }}" method="POST" class="hidden">
        @csrf
    </form>
    <div
        x-data="{
            idleMs: 30 * 60 * 1000,
            timer: null,
            reset() {
                clearTimeout(this.timer);
                this.timer = setTimeout(() => document.getElementById('kgp-idle-logout').submit(), this.idleMs);
            },
        }"
        x-init="reset()"
        @mousemove.window.throttle.5000ms="reset()"
        @keydown.window.throttle.5000ms="reset()"
        @click.window="reset()"
        @scroll.window.throttle.5000ms="reset()"
    ></div>

    @stack('scripts')
</body>
</html>
