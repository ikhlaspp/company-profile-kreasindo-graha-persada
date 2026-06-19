@extends('layouts.app')
@section('title', 'Berita & Artikel — KGP')
@section('meta_description', 'Berita dan artikel terbaru dari PT. Kreasindo Graha Persada — perkembangan proyek, kegiatan, dan informasi perusahaan.')

@section('content')

{{-- HERO --}}
<section class="bg-navy-900 bg-blueprint pt-32 pb-20">
  <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
    <p class="text-xs font-sans font-semibold uppercase tracking-widest text-brass-300 mb-3">Informasi Terkini</p>
    <h1 class="font-display text-4xl sm:text-5xl text-white font-semibold mb-4 max-w-2xl">
      Berita &amp; Artikel
    </h1>
    <p class="text-navy-100 text-lg max-w-2xl leading-relaxed">
      Ikuti perkembangan terbaru, proyek selesai, dan aktivitas PT. Kreasindo Graha Persada.
    </p>
  </div>
</section>

{{-- CONTENT --}}
<section class="bg-paper py-16 lg:py-24">
  <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

    <div class="lg:grid lg:grid-cols-[1fr_280px] lg:gap-12">

      {{-- Posts grid --}}
      <div>
        @forelse($posts as $post)
        @if($loop->first)
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
        @endif

          <a href="{{ route('news.show', $post->slug) }}"
             class="group block bg-card border border-line rounded-sm shadow-sm hover:shadow-md transition-shadow overflow-hidden">

            {{-- Thumbnail --}}
            <div class="aspect-[16/10] overflow-hidden">
              @if($post->thumbnail)
                <img src="{{ asset('storage/'.$post->thumbnail) }}"
                     alt="{{ $post->title }}"
                     class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
              @else
                <div class="w-full h-full bg-gradient-to-br from-navy-600 to-navy-900 flex items-center justify-center">
                  <svg class="w-10 h-10 text-navy-100/30" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 7.5h1.5m-1.5 3h1.5m-7.5 3h7.5m-7.5 3h7.5m3-9h3.375c.621 0 1.125.504 1.125 1.125V18a2.25 2.25 0 01-2.25 2.25M16.5 7.5V18a2.25 2.25 0 002.25 2.25M16.5 7.5V4.875c0-.621-.504-1.125-1.125-1.125H4.125C3.504 3.75 3 4.254 3 4.875V18a2.25 2.25 0 002.25 2.25h13.5M6 7.5h3v3H6v-3z"/>
                  </svg>
                </div>
              @endif
            </div>

            <div class="p-5">
              {{-- Category badge --}}
              @if($post->category)
              <span class="inline-block px-2 py-0.5 rounded text-xs font-sans font-semibold bg-navy-100 text-navy-700 mb-2">
                {{ $post->category->name }}
              </span>
              @endif

              {{-- Date --}}
              <p class="text-xs font-sans font-semibold text-brass-700 mb-2">
                {{ $post->published_at?->translatedFormat('d F Y') }}
              </p>

              {{-- Title --}}
              <h3 class="font-display text-navy-800 font-semibold text-base leading-snug mb-2 group-hover:text-navy-600 transition-colors line-clamp-2">
                {{ $post->title }}
              </h3>

              {{-- Excerpt --}}
              @if($post->excerpt)
              <p class="text-sm font-sans text-slate-500 leading-relaxed line-clamp-3 mb-3">
                {{ $post->excerpt }}
              </p>
              @endif

              <span class="text-xs font-sans font-semibold text-brass-700 hover:text-brass-500 transition-colors">
                Baca selengkapnya &rarr;
              </span>
            </div>
          </a>

        @if($loop->last)
        </div>
        @endif

        @empty
        <div class="text-center py-20">
          <div class="w-16 h-16 rounded-full bg-navy-100 flex items-center justify-center mx-auto mb-4">
            <svg class="w-8 h-8 text-navy-600" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" d="M12 7.5h1.5m-1.5 3h1.5m-7.5 3h7.5m-7.5 3h7.5m3-9h3.375c.621 0 1.125.504 1.125 1.125V18a2.25 2.25 0 01-2.25 2.25M16.5 7.5V18a2.25 2.25 0 002.25 2.25M16.5 7.5V4.875c0-.621-.504-1.125-1.125-1.125H4.125C3.504 3.75 3 4.254 3 4.875V18a2.25 2.25 0 002.25 2.25h13.5M6 7.5h3v3H6v-3z"/>
            </svg>
          </div>
          <p class="font-sans text-slate-500">Belum ada artikel yang dipublikasikan.</p>
        </div>
        @endforelse

        {{-- Pagination --}}
        @if($posts->hasPages())
        <div class="mt-12">
          {{ $posts->links() }}
        </div>
        @endif
      </div>

      {{-- Sidebar: categories --}}
      @if($categories->isNotEmpty())
      <aside class="mt-12 lg:mt-0">
        <div class="bg-card border border-line rounded-sm shadow-sm p-6 sticky top-28">
          <h2 class="font-display text-navy-800 font-semibold text-lg mb-5">Kategori</h2>
          <ul class="space-y-2">
            @foreach($categories as $cat)
            <li>
              <div class="flex items-center justify-between py-2 border-b border-line last:border-0">
                <span class="font-sans text-sm text-slate-600">{{ $cat->name }}</span>
                <span class="text-xs font-sans font-semibold tabular bg-navy-100 text-navy-700 px-2 py-0.5 rounded-full">
                  {{ $cat->posts_count }}
                </span>
              </div>
            </li>
            @endforeach
          </ul>
        </div>
      </aside>
      @endif

    </div>

  </div>
</section>

@endsection
