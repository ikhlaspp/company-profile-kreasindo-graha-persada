<?php

namespace Database\Seeders;

use App\Models\Client;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ClientSeeder extends Seeder
{
    public function run(): void
    {
        // Klien — sesuai daftar "CLIENT KAMI" pada Company Profile KGP 2025.
        // Ejaan mengikuti screenshot company profile; hanya "Nasiaonal" diperbaiki -> "Nasional".
        $clients = [
            ['name' => 'Pujianstra Mabes TNI', 'category' => 'militer'],
            ['name' => 'Sekolah Staff dan Komando TNI AL', 'category' => 'militer'],
            ['name' => 'Komando Lintas Laut Militer', 'category' => 'militer'],
            ['name' => 'Disinfolahtal Mabes AL', 'category' => 'militer'],
            ['name' => 'Marinir AL', 'category' => 'militer'],
            ['name' => 'ETLE Nasional', 'category' => 'militer'],
            ['name' => 'Jakarta Smart City', 'category' => 'pemerintah'],
            ['name' => 'Berita Jakarta', 'category' => 'pemerintah'],
            ['name' => 'Dinas Kominfotik DKI Jakarta', 'category' => 'pemerintah'],
            ['name' => 'Diklat Kementerian Perhubungan', 'category' => 'pemerintah'],
            ['name' => 'Kementerian Tenaga Kerja', 'category' => 'pemerintah'],
            ['name' => 'PT. Asabri (Kerawang - Jabar)', 'category' => 'bumn'],
            ['name' => 'PT. Sinar Mas Group (Kandis - Riau)', 'category' => 'swasta'],
            ['name' => 'Fujita Corporation', 'category' => 'swasta'],
            ['name' => 'Crestron', 'category' => 'swasta'],
            ['name' => 'JBL', 'category' => 'swasta'],
            ['name' => 'Marshall', 'category' => 'swasta'],
            ['name' => 'Unilumin', 'category' => 'swasta'],
            ['name' => 'Electro Voice', 'category' => 'swasta'],
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
