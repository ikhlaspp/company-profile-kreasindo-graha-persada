<?php

namespace Database\Seeders;

use App\Models\Client;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ClientSeeder extends Seeder
{
    public function run(): void
    {
        // Klien nyata berdasarkan Company Profile KGP 2025.
        $clients = [
            // Militer & keamanan
            ['name' => 'Mabes TNI Angkatan Laut', 'category' => 'militer'],
            ['name' => 'Sekolah Staf dan Komando TNI AL (Seskoal)', 'category' => 'militer'],
            ['name' => 'Mako Korps Marinir', 'category' => 'militer'],
            ['name' => 'Komando Lintas Laut Militer (Kolinlamil)', 'category' => 'militer'],
            ['name' => 'Pusjianstra Mabes TNI', 'category' => 'militer'],
            ['name' => 'ETLE Nasional – Polda Jawa Barat', 'category' => 'militer'],
            // Pemerintahan
            ['name' => 'Jakarta Smart City – Diskominfotik DKI Jakarta', 'category' => 'pemerintah'],
            ['name' => 'Biro Hukum Setda Provinsi DKI Jakarta', 'category' => 'pemerintah'],
            ['name' => 'Diklat Kementerian Perhubungan', 'category' => 'pemerintah'],
            ['name' => 'Kementerian Ketenagakerjaan', 'category' => 'pemerintah'],
            ['name' => 'Berita Jakarta', 'category' => 'pemerintah'],
            // BUMN
            ['name' => 'PT Asabri (Persero)', 'category' => 'bumn'],
            ['name' => 'PT Asuransi Jasa Indonesia (Jasindo)', 'category' => 'bumn'],
            // Swasta
            ['name' => 'PT Sinar Mas Group', 'category' => 'swasta'],
            ['name' => 'PT Fujita Corporation', 'category' => 'swasta'],
        ];

        foreach ($clients as $i => $client) {
            Client::updateOrCreate(
                ['slug' => Str::slug($client['name'])],
                [
                    'name' => $client['name'],
                    'category' => $client['category'],
                    'is_active' => true,
                    'sort_order' => $i,
                ],
            );
        }
    }
}
