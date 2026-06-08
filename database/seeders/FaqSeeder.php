<?php

namespace Database\Seeders;

use App\Models\Faq;
use Illuminate\Database\Seeder;

class FaqSeeder extends Seeder
{
    public function run(): void
    {
        $faqs = [
            [
                'question' => 'Apa saja layanan yang ditawarkan KGP?',
                'answer' => 'KGP menyediakan layanan IT (software & jaringan), desain interior, serta mekanikal-elektrikal dan konstruksi.',
                'keywords' => 'layanan, jasa, service, it, interior, me, konstruksi',
            ],
            [
                'question' => 'Bagaimana cara menghubungi tim KGP?',
                'answer' => 'Anda dapat menghubungi kami melalui email info@kgp.co.id atau WhatsApp di +62 812 3456 7890.',
                'keywords' => 'kontak, hubungi, email, whatsapp, telepon',
            ],
            [
                'question' => 'Di mana lokasi kantor KGP?',
                'answer' => 'Kantor kami berada di Jl. Contoh No. 123, Jakarta Selatan.',
                'keywords' => 'lokasi, alamat, kantor, jakarta',
            ],
            [
                'question' => 'Apakah KGP melayani proyek pemerintah dan militer?',
                'answer' => 'Ya, KGP berpengalaman menangani proyek instansi militer, pemerintah, BUMN, dan swasta.',
                'keywords' => 'pemerintah, militer, bumn, klien, proyek',
            ],
            [
                'question' => 'Bagaimana cara mengajukan penawaran proyek?',
                'answer' => 'Silakan kirim kebutuhan proyek Anda melalui halaman Kontak, tim kami akan menindaklanjuti dengan penawaran.',
                'keywords' => 'penawaran, proyek, quotation, kerjasama',
            ],
            [
                'question' => 'Apakah ada lowongan pekerjaan di KGP?',
                'answer' => 'Info lowongan terbaru tersedia di halaman Karir pada website kami.',
                'keywords' => 'karir, lowongan, kerja, rekrutmen',
            ],
        ];

        foreach ($faqs as $i => $faq) {
            Faq::updateOrCreate(
                ['question' => $faq['question']],
                [
                    'answer' => $faq['answer'],
                    'keywords' => $faq['keywords'],
                    'is_active' => true,
                    'sort_order' => $i,
                ],
            );
        }
    }
}
