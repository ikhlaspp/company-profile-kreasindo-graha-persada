<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    public function run(): void
    {
        $settings = [
            ['key' => 'site_name', 'value' => 'PT. Kreasindo Graha Persada', 'type' => 'text', 'group' => 'general'],
            ['key' => 'site_tagline', 'value' => 'Solusi IT, Interior, dan Konstruksi Terpercaya', 'type' => 'text', 'group' => 'general'],
            ['key' => 'contact_email', 'value' => 'info@kgp.co.id', 'type' => 'text', 'group' => 'contact'],
            ['key' => 'contact_phone', 'value' => '+62 21 1234567', 'type' => 'text', 'group' => 'contact'],
            ['key' => 'contact_whatsapp', 'value' => '+62 812 3456 7890', 'type' => 'text', 'group' => 'contact'],
            ['key' => 'contact_address', 'value' => 'Jl. Contoh No. 123, Jakarta Selatan', 'type' => 'text', 'group' => 'contact'],
            ['key' => 'social_instagram', 'value' => 'https://instagram.com/kgp', 'type' => 'text', 'group' => 'social'],
            ['key' => 'social_linkedin', 'value' => 'https://linkedin.com/company/kgp', 'type' => 'text', 'group' => 'social'],
            ['key' => 'chatbot_enabled', 'value' => '1', 'type' => 'boolean', 'group' => 'chatbot'],
            ['key' => 'chatbot_greeting', 'value' => 'Halo! Ada yang bisa kami bantu seputar layanan KGP?', 'type' => 'text', 'group' => 'chatbot'],
        ];

        foreach ($settings as $setting) {
            Setting::updateOrCreate(
                ['key' => $setting['key']],
                $setting,
            );
        }
    }
}
