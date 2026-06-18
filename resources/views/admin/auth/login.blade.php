@extends('admin.layouts.auth')

@section('content')
    <div class="mb-8 lg:hidden">
        <span class="font-display text-2xl font-bold text-navy-900">K<span class="text-brass-500">G</span>P</span>
    </div>

    <p class="text-[11px] font-semibold uppercase tracking-[0.25em] text-brass-700">Gerbang Aman</p>
    <h1 class="mt-2 font-display text-3xl font-semibold tracking-tight text-navy-900">Masuk ke Panel</h1>
    <p class="mt-2 text-sm text-slate-500">Akses dibatasi untuk akun administrator.</p>

    @if ($errors->any())
        <div class="mt-6 rounded-lg border border-danger/20 bg-danger/5 px-4 py-3 text-sm font-medium text-danger">
            {{ $errors->first() }}
        </div>
    @endif

    <form action="{{ route('panel.login.attempt') }}" method="POST" class="mt-8 space-y-5">
        @csrf
        <x-admin.form.input label="Alamat Email" name="email" type="email" placeholder="admin@kgp.co.id" required />
        <x-admin.form.input label="Kata Sandi" name="password" type="password" placeholder="••••••••" required />

        <div class="flex items-center justify-between">
            <label class="flex cursor-pointer items-center gap-2">
                <input type="checkbox" name="remember" value="1" class="h-4 w-4 rounded border-line text-brass-500 focus:ring-brass-500/30">
                <span class="text-[13px] font-medium text-slate-500">Ingat saya</span>
            </label>
            <a href="#" class="text-[13px] font-semibold text-brass-700 hover:text-brass-500">Lupa sandi?</a>
        </div>

        <x-admin.btn type="submit" variant="primary" size="lg" class="w-full">Masuk ke Panel</x-admin.btn>
    </form>

    <p class="mt-8 text-center text-xs text-slate-500">Dilindungi rate-limit 5×/menit · hanya role admin.</p>
@endsection
