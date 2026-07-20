<?php

namespace Database\Seeders;

use App\Models\Service;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ServiceSeeder extends Seeder
{
    public function run(): void
    {
        // Teks deskripsi verbatim dari Company Profile KGP (bagian "Produk Kami":
        // Software, Hardware, Interior & Furniture). ME dipertahankan sebagai
        // layanan sah (SBUJPK ME) dengan deskripsi ringkas faktual.
        $services = [
            [
                'division' => 'it',
                'title' => 'Software',
                'excerpt' => 'Pengembangan perangkat lunak dan aplikasi pemasaran digital untuk memperluas bisnis serta meningkatkan nilai kompetisi klien.',
                'description' => implode("\n\n", [
                    'Merupakan layanan perusahaan di bidang teknologi informasi, terutama pengembangan perangkat lunak. Melayani klien dengan memanfaatkan teknologi informasi untuk memperluas perusahaan klien dan meningkatkan nilai kompetisi mereka.',
                    'Kami fokus dalam mengembangkan aplikasi untuk pemasaran digital, yaitu aplikasi yang dapat membantu klien untuk memanfaatkan kemajuan teknologi informasi untuk meningkatkan nilai pemasaran maupun penunjang dalam kegiatan internal perusahaan.',
                ]),
            ],
            [
                'division' => 'it',
                'title' => 'Hardware',
                'excerpt' => 'Solusi sistem integrasi dan penyediaan perangkat keras dengan dukungan Server Expert bersertifikasi, Managed Services, dan konsultasi infrastruktur IT.',
                'description' => implode("\n\n", [
                    'Merupakan layanan perusahaan dalam memenuhi semua kebutuhan spesifik dalam solusi sistem integrasi, melalui penyediaan perangkat keras yang didukung oleh Server Expert yang bersertifikasi dan dapat diperoleh secara bersamaan dengan Managed Services, untuk mendapatkan manfaat biaya dan efektivitas kinerja terbaik.',
                    'Dengan menghadirkan layanan konsultasi IT profesional yang mencakup desain infrastruktur IT, yang didukung oleh ahli praktisi berpengalaman yang dapat diandalkan dalam mendukung pelanggan untuk memenuhi kebutuhan implementasi IT.',
                ]),
            ],
            [
                'division' => 'interior',
                'title' => 'Interior & Furniture',
                'excerpt' => 'Manajemen, rancang-bangun desain, dan konstruksi interior & furniture — dari proyek kecil hingga besar, dengan sistem manajemen proyek dan keselamatan kerja sebagai prioritas.',
                'description' => implode("\n\n", [
                    'PT. Kreasindo Graha Persada melayani berbagai macam proyek, mulai dari yang berskala kecil hingga paket proyek berskala besar, dari satu disiplin ilmu sampai multidisiplin, semuanya kami kerjakan dengan layanan yang profesional, kooperatif dan bersahabat dengan integritas yang tinggi. PT. Kreasindo Graha Persada membantu klien dalam manajemen, rancang-bangun desain, dan konstruksi untuk proses instalasi.',
                    'Kami sepenuhnya didukung oleh sistem manajemen proyek yang canggih. Kami juga mengelola berbagai antarmuka dari berbagai disiplin ilmu. Pekerjaan kami didasarkan pada rencana dan metode pelaksanaan konstruksi untuk memastikan proses pengerjaan berjalan dengan baik. PT. Kreasindo Graha Persada mampu mengelola tahapan-tahapan kritis secara tepat karena tahapan tersebut menentukan sukses pelaksanaan proyek.',
                    'Berdasarkan pada catatan PT. Kreasindo Graha Persada dalam melaksanakan jutaan jam kerja proyek, keselamatan kerja adalah prioritas utama. Kami menjamin hal ini dengan memberikan pelatihan secara teratur dan berkala, juga pemberian insentif kepada semua pekerja lapangan serta memastikan bahwa PT. Kreasindo Graha Persada memenuhi keseluruhan standar keselamatan di semua aspek.',
                ]),
            ],
        ];

        foreach ($services as $i => $service) {
            Service::updateOrCreate(
                ['slug' => Str::slug($service['title'])],
                [
                    'division' => $service['division'],
                    'title' => $service['title'],
                    'excerpt' => $service['excerpt'],
                    'description' => $service['description'],
                    'is_active' => true,
                    'sort_order' => $i + 1,
                ],
            );
        }

        // Hapus layanan lama yang bukan bagian dari daftar kanonik (mis. dummy).
        $slugs = array_map(fn ($s) => Str::slug($s['title']), $services);
        Service::whereNotIn('slug', $slugs)->delete();
    }
}
