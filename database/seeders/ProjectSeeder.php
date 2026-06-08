<?php

namespace Database\Seeders;

use App\Models\Client;
use App\Models\Project;
use App\Models\Service;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ProjectSeeder extends Seeder
{
    public function run(): void
    {
        $clients = Client::pluck('id')->all();
        $services = Service::pluck('id')->all();
        $divisions = ['it', 'interior', 'sipil'];
        $locations = ['Jakarta', 'Bandung', 'Surabaya', 'Bekasi', 'Bogor', 'Semarang'];

        for ($i = 1; $i <= 24; $i++) {
            $division = $divisions[array_rand($divisions)];
            $title = match ($division) {
                'it' => 'Implementasi Sistem '.fake()->company().' #'.$i,
                'interior' => 'Renovasi Interior Kantor '.fake()->city().' #'.$i,
                default => 'Pembangunan Gedung '.fake()->city().' #'.$i,
            };

            $project = Project::updateOrCreate(
                ['slug' => Str::slug($title)],
                [
                    'client_id' => $clients ? $clients[array_rand($clients)] : null,
                    'service_id' => $services ? $services[array_rand($services)] : null,
                    'division' => $division,
                    'title' => $title,
                    'description' => fake()->paragraphs(3, true),
                    'contract_value' => fake()->numberBetween(50_000_000, 5_000_000_000),
                    'location' => $locations[array_rand($locations)],
                    'year' => fake()->numberBetween(2019, 2025),
                    'completed_at' => fake()->dateTimeBetween('-5 years', 'now')->format('Y-m-d'),
                    'is_featured' => $i <= 6,
                    'is_active' => true,
                    'sort_order' => $i,
                ],
            );

            // Avoid duplicating images on re-seed.
            if ($project->images()->count() === 0) {
                for ($j = 1; $j <= 3; $j++) {
                    $project->images()->create([
                        'file_path' => "projects/sample-{$i}-{$j}.jpg",
                        'caption' => "Dokumentasi proyek {$j}",
                        'is_cover' => $j === 1,
                        'sort_order' => $j,
                    ]);
                }
            }
        }
    }
}
