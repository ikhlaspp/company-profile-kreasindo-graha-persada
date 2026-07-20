@props([
    'eyebrow' => 'Mari Berkolaborasi',
    'title'   => 'Siap Mewujudkan Proyek Anda Bersama KGP?',
    'body'    => 'Diskusikan kebutuhan IT dan interior instansi Anda dengan tim profesional kami. Kami siap membantu dari perencanaan hingga serah terima.',
])

@php
    // Gambar band dapat diatur lewat admin (Pengaturan → Tampilan); fallback ke bawaan.
    $ctaBand = \App\Models\Setting::where('key', 'cta_band_image')->value('value');
    $ctaBandSrc = $ctaBand ? \Illuminate\Support\Facades\Storage::url($ctaBand) : asset('img/hero/contact-band.jpg');
@endphp

{{-- Shared closing CTA band — same design as the homepage contact band --}}
<section class="relative py-20 lg:py-28 overflow-hidden">
    <img src="{{ $ctaBandSrc }}" alt="" class="absolute inset-0 w-full h-full object-cover" loading="lazy">
    <div class="absolute inset-0 bg-navy-900/85"></div>
    <div class="reveal relative z-10 mx-auto max-w-3xl px-4 sm:px-6 lg:px-8 text-center">
        <p class="text-xs font-sans font-semibold uppercase tracking-widest text-brass-300 mb-3">{{ $eyebrow }}</p>
        <h2 class="font-display text-3xl sm:text-4xl text-white font-semibold leading-tight">{{ $title }}</h2>
        <p class="mt-5 font-sans text-slate-300 leading-relaxed">{{ $body }}</p>
        <div class="mt-8">
            <x-button as="a" href="{{ route('contact') }}" variant="accent" size="lg">Hubungi Kami Sekarang</x-button>
        </div>
    </div>
</section>
