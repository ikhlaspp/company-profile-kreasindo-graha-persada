<?php

namespace Database\Seeders;

use App\Models\Document;
use App\Models\DocumentCategory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class DocumentSeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            'SBU' => ['Sertifikat Badan Usaha Konstruksi', 'SBU Bidang IT'],
            'Perizinan' => ['NIB (Nomor Induk Berusaha)', 'Izin Usaha Jasa Konstruksi'],
            'Legalitas' => ['Akta Pendirian Perusahaan', 'NPWP Perusahaan'],
            'Laporan' => ['Laporan Tahunan 2024', 'Company Profile 2025'],
        ];

        foreach ($categories as $categoryName => $documents) {
            $category = DocumentCategory::updateOrCreate(
                ['slug' => Str::slug($categoryName)],
                ['name' => $categoryName],
            );

            foreach ($documents as $i => $title) {
                Document::updateOrCreate(
                    ['title' => $title],
                    [
                        'document_category_id' => $category->id,
                        'file_path' => 'documents/'.Str::slug($title).'.pdf',
                        'file_size_kb' => fake()->numberBetween(200, 5000),
                        'mime_type' => 'application/pdf',
                        'year' => fake()->numberBetween(2020, 2025),
                        'is_active' => true,
                        'sort_order' => $i,
                    ],
                );
            }
        }
    }
}
