<?php

namespace Database\Seeders;

use App\Models\Gallery;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class GallerySeeder extends Seeder
{
    public function run(): void
    {
        $galleries = [
            ['title' => 'Instalasi Data Center 2024', 'division' => 'it'],
            ['title' => 'Dokumentasi Sistem ETLE Polda Jabar', 'division' => 'it'],
            ['title' => 'Renovasi Kantor Pusat', 'division' => 'interior'],
            ['title' => 'Pembangunan Gedung Serbaguna', 'division' => 'sipil'],
            ['title' => 'Gathering & Pelatihan Internal', 'division' => 'event'],
        ];

        foreach ($galleries as $i => $data) {
            $gallery = Gallery::updateOrCreate(
                ['slug' => Str::slug($data['title'])],
                [
                    'title' => $data['title'],
                    'division' => $data['division'],
                    'description' => fake()->sentence(12),
                    'is_active' => true,
                    'sort_order' => $i,
                ],
            );

            if ($gallery->photos()->count() === 0) {
                for ($j = 1; $j <= 6; $j++) {
                    $gallery->photos()->create([
                        'file_path' => "galleries/{$gallery->slug}-{$j}.jpg",
                        'caption' => "Foto {$j}",
                        'sort_order' => $j,
                    ]);
                }
            }
        }
    }
}
