<?php

namespace Database\Seeders;

use App\Models\Client;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ClientSeeder extends Seeder
{
    public function run(): void
    {
        $clients = [
            ['name' => 'TNI Angkatan Darat', 'category' => 'militer'],
            ['name' => 'TNI Angkatan Laut', 'category' => 'militer'],
            ['name' => 'Kepolisian Republik Indonesia', 'category' => 'militer'],
            ['name' => 'Kementerian Pertahanan', 'category' => 'pemerintah'],
            ['name' => 'Pemerintah Provinsi DKI Jakarta', 'category' => 'pemerintah'],
            ['name' => 'Kementerian Keuangan', 'category' => 'pemerintah'],
            ['name' => 'PT Pertamina (Persero)', 'category' => 'bumn'],
            ['name' => 'PT PLN (Persero)', 'category' => 'bumn'],
            ['name' => 'PT Telkom Indonesia', 'category' => 'bumn'],
            ['name' => 'PT Bank Mandiri', 'category' => 'bumn'],
            ['name' => 'PT Astra International', 'category' => 'swasta'],
            ['name' => 'PT Sinar Mas', 'category' => 'swasta'],
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
