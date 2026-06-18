@extends('admin.layouts.admin')
@section('title', 'Galeri')

@section('content')
    <x-admin.page-header eyebrow="Konten Profil" title="Kelola Galeri" subtitle="Album foto per divisi." :breadcrumb="['Galeri' => null]">
        <x-admin.btn variant="accent" :href="route('panel.galleries.create')"><x-admin.icon name="plus" class="h-4 w-4" />Tambah Album</x-admin.btn>
    </x-admin.page-header>

    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
        @forelse ($items as $item)
            <div class="group overflow-hidden rounded-xl border border-line bg-card shadow-sm transition-shadow hover:shadow-md">
                <div class="relative grid aspect-[4/3] place-items-center overflow-hidden bg-gradient-to-br from-navy-700 to-navy-600">
                    @if ($item->cover_image)
                        <img src="{{ \Illuminate\Support\Facades\Storage::url($item->cover_image) }}" class="absolute inset-0 h-full w-full object-cover" alt="" loading="lazy">
                    @else
                        <x-admin.icon name="photo-stack" class="h-10 w-10 text-white/30" />
                    @endif
                    <span class="absolute left-3 top-3"><x-admin.badge :type="$item->division" dot>{{ strtoupper($item->division) }}</x-admin.badge></span>
                    <span class="absolute bottom-3 right-3 rounded-md bg-navy-900/70 px-2 py-0.5 text-[11px] font-semibold text-white backdrop-blur">{{ $item->photos_count }} foto</span>
                </div>
                <div class="flex items-center justify-between gap-2 p-4">
                    <div class="min-w-0">
                        <p class="truncate font-semibold text-navy-900">{{ $item->title }}</p>
                        <x-admin.badge :type="$item->is_active ? 'ok' : 'off'" dot>{{ $item->is_active ? 'Aktif' : 'Nonaktif' }}</x-admin.badge>
                    </div>
                    <div class="flex shrink-0 items-center gap-1">
                        <x-admin.btn variant="ghost" size="icon" :href="route('panel.galleries.photos', $item->id)" title="Kelola foto"><x-admin.icon name="image" class="h-4 w-4" /></x-admin.btn>
                        <x-admin.btn variant="ghost" size="icon" :href="route('panel.galleries.edit', $item->id)"><x-admin.icon name="edit" class="h-4 w-4" /></x-admin.btn>
                        <button @click="$dispatch('open-modal-delete', { label: @js($item->title), url: @js(route('panel.galleries.destroy', $item->id)) })" class="rounded-lg p-2 text-danger transition-colors hover:bg-danger/10"><x-admin.icon name="trash" class="h-4 w-4" /></button>
                    </div>
                </div>
            </div>
        @empty
            <p class="col-span-full py-10 text-center text-sm text-slate-500">Belum ada album.</p>
        @endforelse
    </div>

    <div class="mt-6"><x-admin.pagination :paginator="$items" /></div>

    <x-admin.modal name="delete" title="Hapus Album" message="Album berikut beserta seluruh fotonya akan dihapus:" />
@endsection
