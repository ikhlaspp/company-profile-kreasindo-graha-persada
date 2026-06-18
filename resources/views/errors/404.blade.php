@extends('layouts.app')

@section('title', 'Halaman Tidak Ditemukan - KGP')

@section('content')

<section class="relative overflow-hidden min-h-screen flex items-center justify-center bg-navy-900 text-white py-20">
    <div class="absolute inset-0 bg-blueprint" aria-hidden="true"></div>
    <div class="absolute -top-40 -right-40 w-[560px] h-[560px] bg-brass-glow" aria-hidden="true"></div>

    <div class="relative mx-auto max-w-2xl px-4 sm:px-6 lg:px-8 text-center">
        <p class="font-display text-8xl md:text-9xl font-bold text-brass-500 mb-4 tabular" aria-hidden="true">404</p>
        <h1 class="font-display text-3xl md:text-4xl font-semibold tracking-tight mb-5">Halaman Tidak Ditemukan</h1>
        <p class="text-lg text-slate-300 leading-relaxed mb-10">Maaf, halaman yang Anda cari mungkin telah dihapus, namanya diubah, atau tidak tersedia untuk sementara waktu.</p>
        <div class="flex flex-wrap justify-center gap-4">
            <x-button as="a" href="{{ route('home') }}" variant="accent" size="lg">Kembali ke Beranda</x-button>
            <x-button as="a" href="{{ route('contact') }}" variant="light" size="lg">Hubungi Kami</x-button>
        </div>
    </div>
</section>

@endsection
