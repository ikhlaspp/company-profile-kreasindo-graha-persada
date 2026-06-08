<?php

namespace Database\Seeders;

use App\Models\Career;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CareerSeeder extends Seeder
{
    public function run(): void
    {
        $careers = [
            ['division' => 'it', 'title' => 'Backend Developer (Laravel)', 'type' => 'full_time'],
            ['division' => 'it', 'title' => 'Network Engineer', 'type' => 'full_time'],
            ['division' => 'interior', 'title' => 'Interior Designer', 'type' => 'full_time'],
            ['division' => 'me', 'title' => 'Drafter ME', 'type' => 'contract'],
            ['division' => 'umum', 'title' => 'Staff Administrasi', 'type' => 'full_time'],
            ['division' => 'umum', 'title' => 'Magang Marketing', 'type' => 'internship'],
        ];

        foreach ($careers as $career) {
            Career::updateOrCreate(
                ['slug' => Str::slug($career['title'])],
                [
                    'division' => $career['division'],
                    'title' => $career['title'],
                    'description' => fake()->paragraph(4),
                    'requirements' => "- Pendidikan minimal D3/S1\n- Pengalaman minimal 1 tahun\n- Mampu bekerja dalam tim",
                    'employment_type' => $career['type'],
                    'location' => 'Jakarta',
                    'deadline' => now()->addDays(fake()->numberBetween(14, 60))->format('Y-m-d'),
                    'is_active' => true,
                ],
            );
        }
    }
}
