<aside
    id="kgp-sidebar"
    class="fixed inset-y-0 left-0 z-40 flex w-[260px] flex-col border-r border-navy-800 bg-navy-900 ease-in-out lg:translate-x-0"
    :class="{
        'translate-x-0': sidebarOpen,
        '-translate-x-full': !sidebarOpen,
        'transition-transform duration-300': ready,
    }"
>
    {{-- Brand --}}
    <div class="flex h-16 items-center gap-2.5 px-5" :class="mini ? 'lg:justify-center lg:px-0' : ''">
        <img src="{{ asset('img/Logo KGP_highres.png') }}" alt="Logo Kreasindo" class="h-9 w-auto shrink-0">
        <div class="leading-tight" x-show="!mini" x-cloak>
            <p class="font-display text-sm font-semibold text-white">Kreasindo</p>
            <p class="text-[10px] font-semibold uppercase tracking-[0.22em] text-slate-500">Panel Admin</p>
        </div>
    </div>

    @php $u = auth()->user(); @endphp
    <nav class="no-scrollbar flex-1 space-y-6 overflow-y-auto px-3 py-4">
        <div class="space-y-1">
            <p x-show="!mini" x-cloak class="px-3 pb-1 text-[10px] font-bold uppercase tracking-[0.18em] text-slate-600">Utama</p>
            <x-admin.sidebar-item :href="route('panel.dashboard')" icon="home" :active="request()->routeIs('panel.dashboard')">Dashboard</x-admin.sidebar-item>
        </div>

        @if ($u?->hasRole('admin'))
            <div class="space-y-1">
                <p x-show="!mini" x-cloak class="px-3 pb-1 text-[10px] font-bold uppercase tracking-[0.18em] text-slate-600">Konten Profil</p>
                <x-admin.sidebar-item :href="route('panel.services.index')" icon="briefcase" :active="request()->routeIs('panel.services.*')">Layanan</x-admin.sidebar-item>
                <x-admin.sidebar-item :href="route('panel.projects.index')" icon="grid" :active="request()->routeIs('panel.projects.*')">Portofolio</x-admin.sidebar-item>
                <x-admin.sidebar-item :href="route('panel.clients.index')" icon="users" :active="request()->routeIs('panel.clients.*')">Klien</x-admin.sidebar-item>
                <x-admin.sidebar-item :href="route('panel.galleries.index')" icon="image" :active="request()->routeIs('panel.galleries.*')">Galeri</x-admin.sidebar-item>
            </div>
        @endif

        <div class="space-y-1">
            <p x-show="!mini" x-cloak class="px-3 pb-1 text-[10px] font-bold uppercase tracking-[0.18em] text-slate-600">Publikasi</p>
            <x-admin.sidebar-item :href="route('panel.posts.index')" icon="newspaper" :active="request()->routeIs('panel.posts.*') || request()->routeIs('panel.post-categories.*') || request()->routeIs('panel.tags.*')">Berita</x-admin.sidebar-item>
            @if ($u?->hasRole('admin'))
                <x-admin.sidebar-item :href="route('panel.documents.index')" icon="file-text" :active="request()->routeIs('panel.documents.*') || request()->routeIs('panel.document-categories.*')">Dokumen</x-admin.sidebar-item>
                <x-admin.sidebar-item :href="route('panel.careers.index')" icon="user-plus" :active="request()->routeIs('panel.careers.*')">Karir</x-admin.sidebar-item>
            @endif
        </div>

        @if ($u?->hasRole('admin'))
            <div class="space-y-1">
                <p x-show="!mini" x-cloak class="px-3 pb-1 text-[10px] font-bold uppercase tracking-[0.18em] text-slate-600">Komunikasi</p>
                <x-admin.sidebar-item :href="route('panel.messages.index')" icon="mail" :active="request()->routeIs('panel.messages.*')" :badge="\App\Models\ContactMessage::where('is_read', false)->count()">Pesan Masuk</x-admin.sidebar-item>
            </div>

            <div class="space-y-1">
                <p x-show="!mini" x-cloak class="px-3 pb-1 text-[10px] font-bold uppercase tracking-[0.18em] text-slate-600">Chatbot</p>
                <x-admin.sidebar-item :href="route('panel.faqs.index')" icon="message" :active="request()->routeIs('panel.faqs.*')">FAQ Chatbot</x-admin.sidebar-item>
                <x-admin.sidebar-item :href="route('panel.chatlogs.index')" icon="list" :active="request()->routeIs('panel.chatlogs.*')">Log Chatbot</x-admin.sidebar-item>
            </div>
        @endif

        @if ($u?->isSuperadmin())
            <div class="space-y-1">
                <p x-show="!mini" x-cloak class="px-3 pb-1 text-[10px] font-bold uppercase tracking-[0.18em] text-slate-600">Sistem</p>
                <x-admin.sidebar-item :href="route('panel.settings.edit')" icon="settings" :active="request()->routeIs('panel.settings.*')">Pengaturan</x-admin.sidebar-item>
                <x-admin.sidebar-item :href="route('panel.users.index')" icon="shield" :active="request()->routeIs('panel.users.*')">Admin &amp; Users</x-admin.sidebar-item>
            </div>
        @endif
    </nav>

    {{-- Account footer --}}
    @php
        $roleLabels = ['superadmin' => 'Superadmin', 'admin' => 'Administrator', 'editor' => 'Editor'];
    @endphp
    <div class="border-t border-navy-800 p-3">
        <div class="flex items-center gap-3 rounded-lg px-2 py-2" :class="mini ? 'lg:justify-center lg:px-0' : ''">
            <span class="grid h-9 w-9 shrink-0 place-items-center rounded-full bg-brass-500/15 text-sm font-semibold text-brass-300 ring-1 ring-brass-500/25">{{ strtoupper(\Illuminate\Support\Str::substr($u?->name ?? 'KGP', 0, 2)) }}</span>
            <div class="min-w-0 flex-1 leading-tight" x-show="!mini" x-cloak>
                <p class="truncate text-[13px] font-semibold text-white">{{ $u?->name ?? 'Admin' }}</p>
                <p class="truncate text-[11px] text-slate-500">{{ $roleLabels[$u?->role] ?? 'Pengguna' }}</p>
            </div>
            <form action="{{ route('panel.logout') }}" method="POST" x-show="!mini" x-cloak>
                @csrf
                <button type="submit" class="rounded-md p-1.5 text-slate-500 transition-colors hover:bg-danger/15 hover:text-danger" title="Keluar">
                    <x-admin.icon name="logout" class="h-[18px] w-[18px]" />
                </button>
            </form>
        </div>
    </div>
</aside>
