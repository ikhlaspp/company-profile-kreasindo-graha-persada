<?php

namespace Database\Seeders;

use App\Models\Client;
use App\Models\Project;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ProjectSeeder extends Seeder
{
    public function run(): void
    {
        // 5 proyek unggulan nyata (Company Profile KGP 2025).
        $projects = [
            [
                'title' => 'Pengembangan Sistem Informasi Seskoal',
                'division' => 'it',
                'client' => 'Sekolah Staff dan Komando TNI AL',
                'contract_value' => 4_900_000_000,
                'year' => 2017,
                'location' => 'Jakarta',
                'description' => "Pengembangan sistem informasi terintegrasi untuk Sekolah Staf dan Komando TNI Angkatan Laut (Seskoal). Mencakup analisis kebutuhan, perancangan basis data, pengembangan aplikasi, hingga pelatihan pengguna dengan standar keamanan institusi militer.",
            ],
            [
                'title' => 'Pengembangan Website TNI Angkatan Laut',
                'division' => 'it',
                'client' => 'Disinfolahtal Mabes AL',
                'contract_value' => 4_339_238_800,
                'year' => 2019,
                'location' => 'Jakarta',
                'description' => "Pengembangan dan peremajaan website resmi TNI Angkatan Laut beserta sarana kerja pendukungnya. Proyek mencakup pembaruan infrastruktur, desain antarmuka, serta integrasi konten untuk kebutuhan informasi publik institusi.",
            ],
            [
                'title' => 'Pembangunan Sistem Informasi Marinir',
                'division' => 'it',
                'client' => 'Marinir AL',
                'contract_value' => 2_439_220_000,
                'year' => 2018,
                'location' => 'Jakarta',
                'description' => "Pembangunan sistem informasi untuk Markas Komando Korps Marinir. Solusi dirancang untuk menunjang administrasi dan pengelolaan data internal secara efisien, aman, dan terintegrasi.",
            ],
            [
                'title' => 'Renovasi Lobby Gedung Kantor Sinar Mas Group',
                'division' => 'interior',
                'client' => 'PT. Sinar Mas Group (Kandis - Riau)',
                'contract_value' => 750_000_000,
                'year' => 2018,
                'location' => 'Kandis, Riau',
                'description' => "Renovasi lobby gedung kantor Sinar Mas Group dengan konsep interior modern dan representatif. Meliputi pekerjaan desain, konstruksi, dan penyelesaian akhir dengan material berkualitas.",
            ],
            [
                'title' => 'Instalasi ETLE Polda Jawa Barat (18 Unit Kamera)',
                'division' => 'it',
                'client' => 'ETLE Nasional',
                'contract_value' => 472_500_000,
                'year' => 2020,
                'location' => 'Bandung, Jawa Barat',
                'description' => "Instalasi perangkat software dan hardware Electronic Traffic Law Enforcement (ETLE) untuk 18 unit kamera di wilayah Polda Jawa Barat, termasuk konfigurasi front-end hingga back-end sistem tilang elektronik.",
            ],
        ];

        foreach ($projects as $i => $data) {
            $project = Project::updateOrCreate(
                ['slug' => Str::slug($data['title'])],
                [
                    'client_id' => Client::where('name', $data['client'])->value('id'),
                    'service_id' => null,
                    'division' => $data['division'],
                    'title' => $data['title'],
                    'description' => $data['description'],
                    'contract_value' => $data['contract_value'],
                    'location' => $data['location'],
                    'year' => $data['year'],
                    'completed_at' => $data['year'].'-12-01',
                    'is_featured' => $i < 3,
                    'is_active' => true,
                    'sort_order' => $i + 1,
                ],
            );

            // Foto proyek diunggah manual lewat admin (Portofolio → Ubah → Galeri Foto).
            // Tidak menyeed foto contoh agar kartu menampilkan placeholder rapi, bukan
            // gambar stok acak.
        }
    }
}
