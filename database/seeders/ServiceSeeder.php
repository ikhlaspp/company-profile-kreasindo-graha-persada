<?php

namespace Database\Seeders;

use App\Models\Service;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ServiceSeeder extends Seeder
{
    public function run(): void
    {
        $services = [
            ['division' => 'it', 'title' => 'Pengembangan Perangkat Lunak', 'excerpt' => 'Aplikasi web & mobile custom sesuai kebutuhan bisnis.'],
            ['division' => 'it', 'title' => 'Infrastruktur Jaringan & Server', 'excerpt' => 'Instalasi dan pemeliharaan jaringan serta data center.'],
            ['division' => 'interior', 'title' => 'Desain Interior Kantor', 'excerpt' => 'Perencanaan dan desain ruang kerja modern.'],
            ['division' => 'interior', 'title' => 'Furniture & Fit Out', 'excerpt' => 'Pengadaan furniture custom dan pekerjaan fit out.'],
            ['division' => 'me', 'title' => 'Mekanikal & Elektrikal', 'excerpt' => 'Instalasi sistem ME untuk gedung dan fasilitas.'],
        ];

        foreach ($services as $i => $service) {
            Service::updateOrCreate(
                ['slug' => Str::slug($service['title'])],
                [
                    'division' => $service['division'],
                    'title' => $service['title'],
                    'excerpt' => $service['excerpt'],
                    'description' => $service['excerpt'].' '.fake()->paragraph(4),
                    'is_active' => true,
                    'sort_order' => $i,
                ],
            );
        }
    }
}
