<!DOCTYPE html>
<html lang="id" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Masuk' }} · KGP Panel</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Archivo:wght@400;500;600;700&family=Fraunces:opsz,wght@9..144,500;9..144,600;9..144,700&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="h-full bg-navy-900 font-sans text-slate-300 antialiased">
    <div class="relative grid min-h-full lg:grid-cols-2">
        {{-- Left brand panel --}}
        <div class="relative hidden overflow-hidden bg-navy-900 lg:block">
            <div class="absolute inset-0 opacity-[0.5]"
                 style="background-image:linear-gradient(rgba(255,255,255,.04) 1px,transparent 1px),linear-gradient(90deg,rgba(255,255,255,.04) 1px,transparent 1px);background-size:46px 46px;mask-image:radial-gradient(circle at 30% 30%,#000,transparent 75%)"></div>
            <div class="absolute -left-24 top-1/3 h-72 w-72 rounded-full bg-brass-500/10 blur-3xl"></div>
            <div class="relative flex h-full flex-col justify-between p-12">
                <span class="font-display text-2xl font-bold text-white">K<span class="text-brass-300">G</span>P</span>
                <div>
                    <p class="text-[11px] font-semibold uppercase tracking-[0.3em] text-brass-300">Panel Admin · CMS</p>
                    <h1 class="mt-4 max-w-md font-display text-4xl font-semibold leading-tight text-white">Kelola seluruh konten perusahaan dari satu konsol.</h1>
                    <p class="mt-4 max-w-sm text-sm text-slate-500">PT. Kreasindo Graha Persada — solusi IT &amp; Interior terpadu.</p>
                </div>
                <p class="text-xs text-slate-500">© {{ date('Y') }} Kreasindo Graha Persada</p>
            </div>
        </div>

        {{-- Right form panel --}}
        <div class="flex items-center justify-center bg-paper2 px-6 py-12">
            <div class="w-full max-w-sm">
                @yield('content')
            </div>
        </div>
    </div>
    @stack('scripts')
</body>
</html>
