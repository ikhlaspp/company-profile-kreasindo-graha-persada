<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'KGP - PT. Kreasindo Graha Persada')</title>
    <meta name="description" content="@yield('meta_description', 'PT. Kreasindo Graha Persada — solusi IT & Interior profesional untuk instansi pemerintah dan swasta sejak 2016.')">

    {{-- SEO: canonical + Open Graph + Twitter card (Task 4.4) --}}
    <link rel="canonical" href="@yield('canonical', url()->current())">
    <meta property="og:site_name" content="PT. Kreasindo Graha Persada">
    <meta property="og:type" content="@yield('og_type', 'website')">
    <meta property="og:title" content="@yield('title', 'KGP - PT. Kreasindo Graha Persada')">
    <meta property="og:description" content="@yield('meta_description', 'PT. Kreasindo Graha Persada — solusi IT & Interior profesional untuk instansi pemerintah dan swasta sejak 2016.')">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:image" content="@yield('og_image', asset('favicon.ico'))">
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="@yield('title', 'KGP - PT. Kreasindo Graha Persada')">
    <meta name="twitter:description" content="@yield('meta_description', 'PT. Kreasindo Graha Persada — solusi IT & Interior profesional untuk instansi pemerintah dan swasta sejak 2016.')">
    @stack('head')

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Fraunces:opsz,wght@9..144,400;9..144,500;9..144,600;9..144,700&family=Archivo:wght@400;500;600;700&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-paper text-ink font-sans antialiased">
    <a href="#konten-utama" class="skip-link">Lewati ke konten utama</a>

    @php
        // Kontak & sosial resmi untuk navbar/footer — satu query ringan per render.
        $site = \App\Models\Setting::query()
            ->whereIn('group', ['general', 'contact', 'social'])
            ->pluck('value', 'key');
    @endphp

    @include('partials.navbar', ['site' => $site])

    <main id="konten-utama" class="min-h-screen">
        @yield('content')
    </main>

    @include('partials.footer', ['site' => $site])
    @include('partials.chatbot')

    @stack('scripts')
</body>
</html>
