@extends('layouts.app')
@section('title', 'Klien Kami — KGP')
@section('meta_description', 'Dipercaya oleh instansi pemerintah, militer, BUMN, dan korporasi swasta di seluruh Indonesia — PT. Kreasindo Graha Persada.')

@section('content')

{{-- PAGE HERO --}}
<section class="relative bg-navy-900 bg-blueprint overflow-hidden pt-32 pb-16">
  <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
    <nav class="flex items-center gap-2 font-sans text-xs font-semibold text-navy-100 mb-6">
      <a href="{{ route('home') }}" class="hover:text-brass-300 transition-colors">Beranda</a>
      <span class="text-white/30">/</span>
      <span class="text-brass-300">Klien Kami</span>
    </nav>
    <p class="font-sans text-xs font-semibold uppercase tracking-widest text-brass-300 mb-3">Kepercayaan</p>
    <h1 class="font-display text-4xl lg:text-5xl font-semibold text-white">Klien Kami</h1>
    <p class="mt-4 font-sans text-base text-navy-100 max-w-2xl">
      Dipercaya oleh instansi pemerintah, militer, BUMN, dan korporasi swasta di seluruh Indonesia.
    </p>
  </div>
</section>

{{-- CLIENT CATEGORIES --}}
<section class="bg-paper py-16 lg:py-24">
  <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

    @foreach($categories as $key => $label)
    @php $group = $clients[$key] ?? []; @endphp

    <div class="py-12 first:pt-0 border-t border-line first:border-t-0">
      {{-- Category heading --}}
      <div class="flex items-center gap-4 mb-8">
        <div class="w-10 h-10 rounded-sm flex items-center justify-center flex-shrink-0 font-sans font-bold text-xs
          @if($key === 'militer') bg-navy-100 text-navy-700
          @elseif($key === 'pemerintah') bg-green-50 text-green-800
          @elseif($key === 'bumn') bg-brass-100 text-brass-700
          @else bg-blue-50 text-blue-800
          @endif">
          {{ strtoupper(substr($key, 0, 3)) }}
        </div>
        <div>
          <h2 class="font-display text-xl font-semibold text-navy-900">{{ $label }}</h2>
          @php $count = is_countable($group) ? count($group) : 0; @endphp
          @if($count > 0)
          <p class="font-sans text-xs text-slate-400 mt-0.5">{{ $count }} instansi</p>
          @endif
        </div>
      </div>

      {{-- Client grid --}}
      @if($count > 0)
      <div class="grid grid-cols-3 sm:grid-cols-4 md:grid-cols-6 lg:grid-cols-8 gap-4">
        @foreach($group as $client)
        @php $cardInner = ''; @endphp

        {{-- Inner content --}}
        @if(!empty($client->logo))
          @php $imgHtml = '<img src="'.asset('storage/'.$client->logo).'" alt="'.e($client->name).'" class="max-h-10 max-w-full object-contain grayscale hover:grayscale-0 transition-all">'; @endphp
        @else
          @php $imgHtml = '<span class="font-sans text-xs font-bold text-slate-400 text-center leading-tight px-1">'.e($client->name).'</span>'; @endphp
        @endif

        @if(!empty($client->website))
          <a href="{{ $client->website }}" target="_blank" rel="noopener"
             class="aspect-[1.6/1] bg-card border border-line rounded-sm flex items-center justify-center p-3
                    hover:border-brass-500 hover:shadow-sm hover:-translate-y-0.5 transition-all">
            {!! $imgHtml !!}
          </a>
        @else
          <div class="aspect-[1.6/1] bg-card border border-line rounded-sm flex items-center justify-center p-3
                      hover:border-brass-500 hover:shadow-sm hover:-translate-y-0.5 transition-all">
            {!! $imgHtml !!}
          </div>
        @endif

        @endforeach
      </div>
      @else
      <p class="font-sans text-sm text-slate-400 italic">Belum ada klien terdaftar pada kategori ini.</p>
      @endif
    </div>

    @endforeach

  </div>
</section>

{{-- CLOSING CTA --}}
<section class="bg-paper2 py-16 text-center">
  <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
    <h2 class="font-display text-2xl lg:text-3xl font-semibold text-navy-900 mb-3">
      Bergabunglah dengan Klien Kami
    </h2>
    <p class="font-sans text-slate-500 max-w-sm mx-auto mb-7">
      Diskusikan kebutuhan IT &amp; interior institusi Anda dengan tim kami.
    </p>
    <x-button as="a" href="{{ route('contact') }}" variant="accent" size="lg">
      Hubungi Kami
    </x-button>
  </div>
</section>

@endsection
