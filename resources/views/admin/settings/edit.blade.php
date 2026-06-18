@extends('admin.layouts.admin')
@section('title', 'Pengaturan')

@section('content')
    <x-admin.page-header title="Pengaturan" subtitle="Konfigurasi situs & chatbot." :breadcrumb="['Pengaturan' => null]" />

    <form action="{{ route('panel.settings.update') }}" method="POST" enctype="multipart/form-data" x-data="{ tab: 'umum' }" class="grid grid-cols-1 gap-6 lg:grid-cols-4">
        @csrf @method('PUT')

        {{-- Tab rail --}}
        <aside class="lg:col-span-1">
            <nav class="space-y-1 rounded-xl border border-line bg-card p-2 shadow-sm">
                @foreach (['umum'=>['Umum','settings'],'kontak'=>['Kontak','users'],'perusahaan'=>['Perusahaan','briefcase'],'sosmed'=>['Sosial Media','external'],'chatbot'=>['Chatbot','message']] as $key => $t)
                    <button type="button" @click="tab='{{ $key }}'" :class="tab==='{{ $key }}' ? 'bg-navy-800 text-white' : 'text-slate-500 hover:bg-paper2'" class="flex w-full items-center gap-2.5 rounded-lg px-3 py-2 text-sm font-semibold transition-colors">
                        <x-admin.icon :name="$t[1]" class="h-4 w-4" />{{ $t[0] }}
                    </button>
                @endforeach
            </nav>
        </aside>

        <div class="lg:col-span-3">
            {{-- Umum --}}
            <div x-show="tab==='umum'" class="space-y-5 rounded-xl border border-line bg-card p-6 shadow-sm">
                <h2 class="font-display text-base font-semibold text-navy-900">Informasi Umum</h2>
                <x-admin.form.input label="Nama Situs" name="site_name" :value="$settings['site_name']" />
                <x-admin.form.input label="Tagline" name="site_tagline" :value="$settings['site_tagline']" />
                <x-admin.form.file label="Logo" name="logo" :preview="$settings['logo'] ? \Illuminate\Support\Facades\Storage::url($settings['logo']) : null" />
            </div>

            {{-- Kontak --}}
            <div x-show="tab==='kontak'" x-cloak class="space-y-5 rounded-xl border border-line bg-card p-6 shadow-sm">
                <h2 class="font-display text-base font-semibold text-navy-900">Kontak</h2>
                <x-admin.form.textarea label="Alamat" name="contact_address" rows="2" :value="$settings['contact_address']" />
                <div class="grid grid-cols-1 gap-5 sm:grid-cols-2">
                    <x-admin.form.input label="Telepon" name="contact_phone" :value="$settings['contact_phone']" />
                    <x-admin.form.input label="WhatsApp" name="contact_whatsapp" :value="$settings['contact_whatsapp']" />
                </div>
                <div class="grid grid-cols-1 gap-5 sm:grid-cols-2">
                    <x-admin.form.input label="Email" name="contact_email" type="email" :value="$settings['contact_email']" />
                    <x-admin.form.input label="Jam Operasional" name="contact_hours" :value="$settings['contact_hours']" />
                </div>
            </div>

            {{-- Perusahaan --}}
            <div x-show="tab==='perusahaan'" x-cloak class="space-y-5 rounded-xl border border-line bg-card p-6 shadow-sm">
                <h2 class="font-display text-base font-semibold text-navy-900">Profil Perusahaan</h2>
                <p class="text-sm text-slate-500">Dipakai di halaman Tentang Kami dan sebagai pengetahuan chatbot.</p>
                <x-admin.form.textarea label="Sejarah" name="company_history" rows="4" :value="$settings['company_history']" />
                <x-admin.form.textarea label="Visi" name="company_vision" rows="2" :value="$settings['company_vision']" />
                <x-admin.form.textarea label="Misi" name="company_mission" rows="5" :value="$settings['company_mission']" hint="Satu poin misi per baris." />
            </div>

            {{-- Sosmed --}}
            <div x-show="tab==='sosmed'" x-cloak class="space-y-5 rounded-xl border border-line bg-card p-6 shadow-sm">
                <h2 class="font-display text-base font-semibold text-navy-900">Sosial Media</h2>
                <x-admin.form.input label="Instagram" name="social_instagram" :value="$settings['social_instagram']" placeholder="URL profil" />
                <x-admin.form.input label="LinkedIn" name="social_linkedin" :value="$settings['social_linkedin']" />
                <x-admin.form.input label="Facebook" name="social_facebook" :value="$settings['social_facebook']" />
                <x-admin.form.input label="YouTube" name="social_youtube" :value="$settings['social_youtube']" placeholder="URL kanal" />
            </div>

            {{-- Chatbot --}}
            <div x-show="tab==='chatbot'" x-cloak class="space-y-5 rounded-xl border border-line bg-card p-6 shadow-sm">
                <h2 class="font-display text-base font-semibold text-navy-900">Chatbot</h2>
                <x-admin.form.textarea label="Sapaan Awal" name="chatbot_greeting" rows="2" :value="$settings['chatbot_greeting']" />
                <x-admin.form.toggle label="Aktifkan Chatbot" name="chatbot_enabled" :checked="(bool) $settings['chatbot_enabled']" hint="Tampilkan widget chatbot di situs publik." />
            </div>

            <div class="mt-6 flex justify-end">
                <x-admin.btn variant="primary" type="submit"><x-admin.icon name="check" class="h-4 w-4" />Simpan Pengaturan</x-admin.btn>
            </div>
        </div>
    </form>
@endsection
