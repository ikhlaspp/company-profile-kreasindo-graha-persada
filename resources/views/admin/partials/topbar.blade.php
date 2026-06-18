<header class="sticky top-0 z-20 flex h-16 items-center gap-3 border-b border-line bg-paper/85 px-5 backdrop-blur-md sm:px-8">
    {{-- Sidebar toggle (mini on desktop, off-canvas on mobile) --}}
    <button @click="toggleSidebar()" class="rounded-lg p-2 text-slate-500 transition-colors hover:bg-paper2 hover:text-navy-900" title="Tampilkan/ciutkan sidebar">
        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" stroke-linecap="round"><path d="M4 6h16M4 12h16M4 18h16"/></svg>
    </button>

    {{-- Brand + current section (links home; brand mark appears only when sidebar collapsed) --}}
    <a href="{{ route('panel.dashboard') }}" class="flex min-w-0 items-center gap-2.5" title="Ke Dashboard">
        <span class="grid h-7 w-7 shrink-0 place-items-center rounded-md bg-navy-900 font-display text-[11px] font-bold leading-none text-white lg:hidden">K<span class="text-brass-300">G</span></span>
        <span class="truncate font-display text-[15px] font-semibold text-navy-900">@yield('title', 'Panel')</span>
    </a>

    {{-- Search --}}
    <button @click="palette = true" class="ml-auto flex items-center gap-2 rounded-lg border border-line bg-card px-3 py-2 text-sm text-slate-500 transition-colors hover:border-slate-300 sm:w-64">
        <x-admin.icon name="search" class="h-4 w-4" />
        <span class="hidden flex-1 text-left sm:inline">Cari…</span>
        <kbd class="hidden rounded border border-line bg-paper2 px-1.5 py-0.5 text-[10px] font-semibold sm:inline">⌘K</kbd>
    </button>

    {{-- User dropdown --}}
    <div class="relative" x-data="{ open: false }" @click.outside="open = false">
        @php $authUser = auth()->user(); @endphp
        <button @click="open = !open" class="flex items-center gap-2 rounded-lg py-1 pl-1 pr-2 transition-colors hover:bg-paper2">
            <span class="grid h-8 w-8 place-items-center rounded-full bg-navy-800 text-xs font-semibold text-white">{{ strtoupper(\Illuminate\Support\Str::substr($authUser?->name ?? 'KGP', 0, 2)) }}</span>
            <x-admin.icon name="chevron" class="h-4 w-4 text-slate-500" />
        </button>
        <div x-show="open" x-cloak x-transition.origin.top.right
             class="absolute right-0 mt-2 w-52 overflow-hidden rounded-xl border border-line bg-card py-1.5 shadow-lg">
            <div class="border-b border-line px-4 py-2.5">
                <p class="text-sm font-semibold text-navy-900">{{ $authUser?->name ?? 'Admin' }}</p>
                <p class="text-xs text-slate-500">{{ $authUser?->email }}</p>
            </div>
            <a href="{{ route('home') }}" class="flex items-center gap-2.5 px-4 py-2 text-sm font-medium text-slate-600 hover:bg-paper2"><x-admin.icon name="external" class="h-4 w-4 text-slate-500"/>Ke Situs Publik</a>
            <div class="my-1 border-t border-line"></div>
            <form action="{{ route('panel.logout') }}" method="POST">
                @csrf
                <button type="submit" class="flex w-full items-center gap-2.5 px-4 py-2 text-left text-sm font-medium text-danger hover:bg-danger/5"><x-admin.icon name="logout" class="h-4 w-4"/>Keluar</button>
            </form>
        </div>
    </div>
</header>
