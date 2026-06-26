<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    public function run(): void
    {
        $mission = implode("\n", [
            'Membangun kemitraan strategis dan bersinergi dengan klien maupun partner dengan prinsip saling menguntungkan.',
            'Mengedepankan profesionalisme dan teamwork dalam menghasilkan layanan yang berkualitas.',
            'Memberikan pelayanan jasa terbaik kepada setiap klien melalui solusi yang inovatif, efektif, dan efisien dalam bidang Teknologi Informasi.',
            'Berperan sebagai prime mover (penggerak utama) bangkitnya industri Teknologi Informasi.',
        ]);

        $settings = [
            ['key' => 'site_name', 'value' => 'PT. Kreasindo Graha Persada', 'type' => 'text', 'group' => 'general'],
            ['key' => 'site_tagline', 'value' => 'Solusi IT, Interior, dan Konstruksi Terpadu', 'type' => 'text', 'group' => 'general'],
            ['key' => 'company_tagline', 'value' => 'Solusi IT & Interior Profesional Sejak 2016', 'type' => 'text', 'group' => 'general'],
            ['key' => 'company_history', 'value' => 'PT. Kreasindo Graha Persada resmi didirikan pada 19 Oktober 2016, bergerak di bidang Teknologi IT (Software, Hardware, dan Network) serta Design Interior & Furniture (Interior Contractor, Design & Build). Didukung tenaga pelaksana yang berkualitas dan berpengalaman, perusahaan kami dipercaya mengerjakan sejumlah proyek yang tersebar di seluruh wilayah Indonesia, dengan mutu yang dapat dipertanggungjawabkan.', 'type' => 'text', 'group' => 'company'],
            ['key' => 'company_vision', 'value' => 'Menjadi perusahaan swasta nasional terdepan di industri Teknologi IT (Software, Hardware dan Network) dan Design Interior & Furniture (Interior Contractor, Design & Build), dengan memberikan layanan dan solusi terkini, terintegrasi, profesional yang terbaik serta bernilai tambah bagi Customer dan Stakeholder.', 'type' => 'text', 'group' => 'company'],
            ['key' => 'company_mission', 'value' => $mission, 'type' => 'text', 'group' => 'company'],
            ['key' => 'contact_email', 'value' => 'info@kreasindograhapersada.com', 'type' => 'text', 'group' => 'contact'],
            ['key' => 'contact_phone', 'value' => '0813 1010 3160', 'type' => 'text', 'group' => 'contact'],
            ['key' => 'contact_whatsapp', 'value' => '0813 1010 3160', 'type' => 'text', 'group' => 'contact'],
            ['key' => 'contact_address', 'value' => 'Jl. Kapuas IV No. 226, Abadijaya, Sukmajaya, Depok, Jawa Barat', 'type' => 'text', 'group' => 'contact'],
            ['key' => 'contact_hours', 'value' => 'Senin – Jumat, 08:00 – 17:00 WIB', 'type' => 'text', 'group' => 'contact'],
            ['key' => 'social_instagram', 'value' => 'https://instagram.com/kreasindograhapersada', 'type' => 'text', 'group' => 'social'],
            ['key' => 'social_linkedin', 'value' => 'https://linkedin.com/company/kreasindo-graha-persada', 'type' => 'text', 'group' => 'social'],
            ['key' => 'chatbot_enabled', 'value' => '1', 'type' => 'boolean', 'group' => 'chatbot'],
            ['key' => 'chatbot_greeting', 'value' => 'Halo! Ada yang bisa kami bantu seputar layanan IT, Interior, atau Konstruksi KGP?', 'type' => 'text', 'group' => 'chatbot'],
        ];

        foreach ($settings as $setting) {
            Setting::updateOrCreate(
                ['key' => $setting['key']],
                $setting,
            );
        }
    }
}
