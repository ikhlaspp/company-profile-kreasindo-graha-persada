@extends('admin.layouts.admin')

@php $item ??= null; $editing = $item !== null; @endphp

@section('content')
    <x-admin.page-header :title="$editing ? 'Ubah Berita' : 'Tulis Berita'" :breadcrumb="['Berita' => route('panel.posts.index'), ($editing ? 'Ubah' : 'Tulis') => null]" />

    <form action="{{ $editing ? route('panel.posts.update', $item->id) : route('panel.posts.store') }}" method="POST" enctype="multipart/form-data" x-data="{ tab: 'konten' }" class="grid grid-cols-1 gap-6 lg:grid-cols-3">
        @csrf
        @if ($editing) @method('PUT') @endif
        <div class="space-y-6 lg:col-span-2">
            <div class="rounded-xl border border-line bg-card shadow-sm">
                <div class="flex gap-1 border-b border-line p-2">
                    <button type="button" @click="tab='konten'" :class="tab==='konten' ? 'bg-navy-800 text-white' : 'text-slate-500 hover:bg-paper2'" class="rounded-lg px-4 py-2 text-sm font-semibold transition-colors">Konten</button>
                    <button type="button" @click="tab='meta'" :class="tab==='meta' ? 'bg-navy-800 text-white' : 'text-slate-500 hover:bg-paper2'" class="rounded-lg px-4 py-2 text-sm font-semibold transition-colors">Tag</button>
                </div>
                <div class="space-y-5 p-6">
                    <div x-show="tab==='konten'" class="space-y-5">
                        <x-admin.form.input label="Judul" name="title" :value="$item?->title" required placeholder="Judul berita yang menarik…" />
                        <x-admin.form.input label="Slug" name="slug" prefix="/" :value="$item?->slug" hint="Otomatis dari judul bila dikosongkan." />
                        <x-admin.form.textarea label="Excerpt" name="excerpt" rows="2" :value="$item?->excerpt" placeholder="Ringkasan untuk daftar & SEO." />
                        <x-admin.form.textarea label="Konten" name="content" rows="12" :value="$item?->content" placeholder="Tulis isi artikel di sini…" />
                    </div>
                    <div x-show="tab==='meta'" x-cloak class="space-y-5">
                        <x-admin.form.tag-input :tags="$editing ? $item->tags->pluck('name')->all() : []" />
                    </div>
                </div>
            </div>
        </div>

        <div class="space-y-6">
            <div class="space-y-5 rounded-xl border border-line bg-card p-6 shadow-sm">
                <h2 class="font-display text-base font-semibold text-navy-900">Publikasi</h2>
                <x-admin.form.select label="Status" name="status" :placeholder="null" :selected="$item?->status ?? 'draft'" :options="['draft'=>'Draft','published'=>'Terbit','archived'=>'Arsip']" />
                <x-admin.form.input label="Tanggal Terbit" name="published_at" type="datetime-local" :value="$item?->published_at?->format('Y-m-d\TH:i')" />
            </div>
            <div class="space-y-5 rounded-xl border border-line bg-card p-6 shadow-sm">
                <h2 class="font-display text-base font-semibold text-navy-900">Organisasi</h2>
                <x-admin.form.select label="Kategori" name="category_id" required :selected="$item?->post_category_id" :options="$categories" />
                <x-admin.form.select label="Penulis" name="author_id" :selected="$item?->user_id" :options="$authors" />
            </div>
            <div class="space-y-5 rounded-xl border border-line bg-card p-6 shadow-sm">
                <h2 class="font-display text-base font-semibold text-navy-900">Thumbnail</h2>
                <x-admin.form.file label="" name="thumbnail" :preview="$editing && $item->thumbnail ? \Illuminate\Support\Facades\Storage::url($item->thumbnail) : null" />
            </div>
        </div>

        <div class="flex items-center justify-end gap-2 lg:col-span-3">
            <x-admin.btn variant="ghost" :href="route('panel.posts.index')">Batal</x-admin.btn>
            <x-admin.btn variant="primary" type="submit"><x-admin.icon name="check" class="h-4 w-4" />{{ $editing ? 'Simpan Perubahan' : 'Simpan Berita' }}</x-admin.btn>
        </div>
    </form>
@endsection
