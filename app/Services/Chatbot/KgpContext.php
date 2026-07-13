<?php

namespace App\Services\Chatbot;

use App\Models\Client;
use App\Models\Project;
use App\Models\Service;
use App\Models\Setting;
use Illuminate\Support\Facades\Cache;

/**
 * Constructs the grounding context and system prompt for the AI layers.
 *
 * Gathers live data from the CMS, including settings, active services, and
 * project statistics, ensuring the chatbot provides accurate and up-to-date
 * information about the company.
 */
class KgpContext
{
    /**
     * @var array<string, string>
     */
    private const DIVISION_LABELS = [
        'it' => 'Teknologi Informasi (IT)',
        'interior' => 'Desain Interior',
        'me' => 'Mekanikal & Elektrikal',
        'sipil' => 'Konstruksi Sipil',
    ];

    /**
     * Retrieves the cached system prompt or generates a new one.
     *
     * @return string
     */
    public function systemPrompt(): string
    {
        return Cache::remember('chatbot.system_prompt', now()->addMinutes(10), function (): string {
            return $this->build();
        });
    }

    /**
     * Compiles the system prompt using current database records.
     *
     * @return string
     */
    private function build(): string
    {
        $settings = Setting::pluck('value', 'key')->all();

        $siteName = $settings['site_name'] ?? 'PT. Kreasindo Graha Persada (KGP)';
        $address = $settings['contact_address'] ?? 'Jakarta, Indonesia';
        $phone = $settings['contact_phone'] ?? '+62 812 3456 7890';
        $whatsapp = $settings['contact_whatsapp'] ?? $phone;
        $email = $settings['contact_email'] ?? 'info@kgp.co.id';
        $hours = $settings['contact_hours'] ?? 'Senin–Jumat, 08.00–17.00 WIB';

        $history = $settings['company_history']
            ?? 'Berdiri sejak tahun 2016, PT. Kreasindo Graha Persada telah berkembang menjadi perusahaan konsultan dan kontraktor yang dipercaya oleh berbagai instansi pemerintah, militer, dan swasta.';
        $vision = $settings['company_vision']
            ?? 'Menjadi perusahaan penyedia jasa IT dan Interior terdepan yang inovatif, profesional, dan memberikan dampak positif secara berkelanjutan.';
        
        $missionText = collect(explode("\n", $settings['company_mission'] ?? ''))
            ->map(fn (string $m) => trim($m))
            ->filter()
            ->map(fn (string $m) => '- '.$m)
            ->implode("\n");
        $missionText = $missionText !== '' ? $missionText : '- (data misi belum tersedia)';

        $services = Service::query()
            ->where('is_active', true)
            ->orderBy('division')
            ->orderBy('sort_order')
            ->get(['division', 'title', 'excerpt']);

        $servicesText = $services
            ->groupBy('division')
            ->map(function ($group, $division) {
                $label = self::DIVISION_LABELS[$division] ?? ucfirst((string) $division);
                $items = $group->map(fn ($s) => '  - '.$s->title.($s->excerpt ? ': '.$s->excerpt : ''))->implode("\n");

                return "Divisi {$label}:\n{$items}";
            })
            ->implode("\n");

        $projectCount = Project::where('is_active', true)->count();
        $clientCount = Client::where('is_active', true)->count();

        $featured = Project::query()
            ->where('is_active', true)
            ->where('is_featured', true)
            ->latest('year')
            ->take(5)
            ->get(['title', 'location', 'year']);

        $featuredText = $featured->isNotEmpty()
            ? $featured->map(fn ($p) => '  - '.$p->title.($p->location ? ' ('.$p->location.')' : '').($p->year ? ', '.$p->year : ''))->implode("\n")
            : '  - (data proyek unggulan belum tersedia)';

        return <<<PROMPT
        Kamu adalah "KGP Assistant", asisten virtual resmi di website {$siteName}.

        PROFIL PERUSAHAAN:
        {$siteName} berdiri sejak 2016, bergerak sebagai konsultan & kontraktor di bidang
        IT dan Interior, melayani instansi pemerintah, militer, BUMN, dan swasta.

        SEJARAH:
        {$history}

        VISI:
        {$vision}

        MISI:
        {$missionText}

        LAYANAN:
        {$servicesText}

        PORTOFOLIO:
        Telah menyelesaikan {$projectCount} proyek untuk {$clientCount} klien. Proyek unggulan:
        {$featuredText}

        KONTAK:
        - Alamat: {$address}
        - Telepon: {$phone}
        - WhatsApp: {$whatsapp}
        - Email: {$email}
        - Jam operasional: {$hours}

        ATURAN MENJAWAB:
        - Jawab dalam Bahasa Indonesia yang ramah, ringkas, dan profesional (maksimal ~4 kalimat).
        - Jawab langsung sesuai pertanyaan; jangan memperkenalkan diri atau mengulang profil
          perusahaan kecuali pengunjung memang menanyakan hal itu.
        - Hanya jawab seputar KGP (layanan, portofolio, perusahaan, kontak, karir).
        - Jika pertanyaan di luar konteks KGP atau kamu tidak yakin, arahkan pengunjung untuk
          menghubungi tim melalui halaman /kontak.
        - Jangan mengarang data proyek, harga, atau angka yang tidak tersedia di atas.
        PROMPT;
    }
}
