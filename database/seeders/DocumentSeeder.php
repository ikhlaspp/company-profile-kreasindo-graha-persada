<?php

namespace Database\Seeders;

use App\Models\Document;
use App\Models\DocumentCategory;
use Illuminate\Database\Seeder;

class DocumentSeeder extends Seeder
{
    public function run(): void
    {
        $this->removeLegacyDummies();

        // slug => [display name, is_legal]
        $categories = [
            'akta-pengesahan'       => ['Akta & Pengesahan Badan Hukum', true],
            'perpajakan'            => ['Perpajakan', true],
            'perizinan-usaha'       => ['Perizinan Usaha', true],
            'sertifikat-konstruksi' => ['Sertifikat Jasa Konstruksi', true],
        ];

        $catIds = [];
        foreach ($categories as $slug => [$name, $isLegal]) {
            $catIds[$slug] = DocumentCategory::updateOrCreate(
                ['slug' => $slug],
                ['name' => $name, 'is_legal' => $isLegal],
            )->id;
        }

        // [title, number, category slug, year]
        $documents = [
            ['SK Notaris — Rakhmat Musawwir Rasyidi, S.H., M.Kn.', 'No: 52-19.10, Tahun 2016', 'akta-pengesahan', 2016],
            ['KEP. MENKUMHAM RI', 'No: AHU-0047336.AH.01.01, Tahun 2016', 'akta-pengesahan', 2016],
            ['Akta Perubahan — SK Notaris Irma Bonita, S.H.', 'No: 60, 24 Juli 2020', 'akta-pengesahan', 2020],
            ['KEP. MENKUMHAM RI (Perubahan)', 'No: AHU-0054675.AH.01.02, Tahun 2020', 'akta-pengesahan', 2020],
            ['NPWP', '80.457.164.4-403.000', 'perpajakan', null],
            ['SP-PKP', 'S-698PKP/WPJ.33/KP.0703/2020', 'perpajakan', 2020],
            ['NIB', '8120010232725', 'perizinan-usaha', null],
            ['SKDU', '503/019/2001/VI/2020', 'perizinan-usaha', 2020],
            ['SIUP', '510.41/028/03801/BPMPTSP/2016', 'perizinan-usaha', 2016],
            ['SIUJK', '1-3201-2-00130-107572', 'sertifikat-konstruksi', null],
            ['SBUJPK Gedung', '0-3201-06-002-1-10-107572', 'sertifikat-konstruksi', null],
            ['SBUJPK ME', '0-3201-09-153-1-10-107572', 'sertifikat-konstruksi', null],
            ['SBUJPK ME', '0-3201-08-153-1-10-107572', 'sertifikat-konstruksi', null],
        ];

        foreach ($documents as $i => [$title, $number, $catSlug, $year]) {
            // Keyed on the (unique) legal number so the two "SBUJPK ME" rows stay
            // distinct while sharing a display title.
            $doc = Document::firstOrNew(['number' => $number]);
            $doc->title = $title;
            $doc->document_category_id = $catIds[$catSlug];
            $doc->year = $year;
            $doc->is_active = true;
            $doc->sort_order = $i;

            // Only set file fields on first insert — never wipe a PDF that an
            // admin has already uploaded to this record.
            if (! $doc->exists) {
                $doc->file_path = null;
                $doc->file_size_kb = null;
                $doc->mime_type = null;
            }

            $doc->save();
        }
    }

    /**
     * Remove the old placeholder documents/categories from earlier seeds so a
     * re-seed on the live database does not leave stale rows behind.
     * Targeted by exact legacy names — admin-added documents are untouched.
     */
    private function removeLegacyDummies(): void
    {
        $dummyTitles = [
            'Sertifikat Badan Usaha Konstruksi',
            'SBU Bidang IT',
            'NIB (Nomor Induk Berusaha)',
            'Izin Usaha Jasa Konstruksi',
            'Akta Pendirian Perusahaan',
            'NPWP Perusahaan',
            'Laporan Tahunan 2024',
            'Company Profile 2025',
        ];
        Document::whereIn('title', $dummyTitles)->delete();

        // Legacy dummy category slugs (distinct from the new canonical slugs);
        // only removed when they hold no remaining documents.
        DocumentCategory::whereIn('slug', ['sbu', 'perizinan', 'legalitas', 'laporan'])
            ->whereDoesntHave('documents')
            ->delete();
    }
}
