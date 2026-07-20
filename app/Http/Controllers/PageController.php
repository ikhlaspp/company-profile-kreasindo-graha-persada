<?php

namespace App\Http\Controllers;

use App\Models\Career;
use App\Models\Client;
use App\Models\ContactMessage;
use App\Models\Document;
use App\Models\Gallery;
use App\Models\Post;
use App\Models\PostCategory;
use App\Models\Project;
use App\Models\Service;
use App\Models\Setting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\StreamedResponse;

/**
 * Controller responsible for rendering the public-facing pages of the website.
 */
class PageController extends Controller
{
    /**
     * Display the home page with statistics, featured projects, divisions, and active clients.
     *
     * @return \Illuminate\View\View
     */
    public function home(): View
    {
        // Hero slideshow — gambar dapat diatur lewat admin (Pengaturan → Tampilan);
        // fallback ke foto bawaan di public/img/hero bila belum diunggah.
        $heroMedia = Setting::query()
            ->whereIn('key', ['hero_slide_1', 'hero_slide_2', 'hero_slide_3'])
            ->pluck('value', 'key');

        $heroSlides = [];
        foreach (['hero_slide_1' => 'slide-1', 'hero_slide_2' => 'slide-2', 'hero_slide_3' => 'slide-3'] as $key => $default) {
            $stored = $heroMedia[$key] ?? null;
            $heroSlides[] = ['img' => $stored ? 'storage/'.$stored : 'img/hero/'.$default.'.jpg'];
        }

        // Portfolio gallery — featured (fallback to latest active) projects.
        $galleryProjects = Project::query()
            ->with(['client', 'images'])
            ->where('is_active', true)
            ->orderByDesc('is_featured')
            ->orderBy('sort_order')
            ->latest('id')
            ->take(6)
            ->get()
            ->map(function (Project $project) {
                $cover = $project->images->firstWhere('is_cover', true) ?? $project->images->first();

                return [
                    'title' => $project->title,
                    'slug' => $project->slug,
                    'division' => $project->division,
                    'path' => $cover?->file_path,
                    'seed' => 'proj-'.$project->id,
                ];
            })
            ->all();

        $settings = Setting::query()
            ->whereIn('group', ['general', 'company'])
            ->pluck('value', 'key');

        // About preview block.
        $about = [
            'name' => $settings['site_name'] ?? 'PT. Kreasindo Graha Persada',
            'excerpt' => $settings['company_history']
                ?? 'Sejak 2016, PT. Kreasindo Graha Persada dipercaya instansi pemerintah, militer, BUMN, dan korporasi untuk solusi IT dan Interior terpadu. Kami dikenal karena inovasi, personalisasi, dan komitmen melampaui ekspektasi.',
            'image' => ! empty($settings['about_image'])
                ? Storage::url($settings['about_image'])
                : asset('img/hero/slide-1.jpg'),
        ];

        // Clients grid.
        $clients = Client::query()
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->take(12)
            ->get()
            ->map(fn (Client $client) => [
                'name' => $client->name,
                'path' => $client->logo,
                'seed' => 'client-'.$client->id,
            ])
            ->all();

        $org = Setting::query()
            ->whereIn('group', ['general', 'contact', 'social'])
            ->pluck('value', 'key');

        return view('pages.home', compact('heroSlides', 'galleryProjects', 'about', 'clients', 'org'));
    }

    /**
     * Generate an XML sitemap comprising static routes and dynamic content.
     *
     * @return \Illuminate\Http\Response
     */
    public function sitemap(): Response
    {
        $urls = [
            ['loc' => route('home'), 'priority' => '1.0'],
            ['loc' => route('about'), 'priority' => '0.8'],
            ['loc' => route('services.index'), 'priority' => '0.8'],
            ['loc' => route('portfolio.index'), 'priority' => '0.8'],
            ['loc' => route('clients'), 'priority' => '0.6'],
            ['loc' => route('gallery.index'), 'priority' => '0.6'],
            ['loc' => route('news.index'), 'priority' => '0.8'],
            ['loc' => route('documents'), 'priority' => '0.5'],
            ['loc' => route('careers'), 'priority' => '0.5'],
            ['loc' => route('contact'), 'priority' => '0.6'],
        ];

        Service::query()->where('is_active', true)->orderBy('sort_order')->get()
            ->each(function (Service $service) use (&$urls) {
                $urls[] = [
                    'loc' => route('services.show', $service->slug),
                    'lastmod' => $service->updated_at?->toAtomString(),
                    'priority' => '0.7',
                ];
            });

        Project::query()->where('is_active', true)->orderBy('sort_order')->get()
            ->each(function (Project $project) use (&$urls) {
                $urls[] = [
                    'loc' => route('portfolio.show', $project->slug),
                    'lastmod' => $project->updated_at?->toAtomString(),
                    'priority' => '0.7',
                ];
            });

        Gallery::query()->where('is_active', true)->orderBy('sort_order')->get()
            ->each(function (Gallery $gallery) use (&$urls) {
                $urls[] = [
                    'loc' => route('gallery.show', $gallery->slug),
                    'lastmod' => $gallery->updated_at?->toAtomString(),
                    'priority' => '0.5',
                ];
            });

        $this->publishedPosts()->latest('published_at')->get()
            ->each(function (Post $post) use (&$urls) {
                $urls[] = [
                    'loc' => route('news.show', $post->slug),
                    'lastmod' => ($post->updated_at ?? $post->published_at)?->toAtomString(),
                    'priority' => '0.6',
                ];
            });

        $xml = '<?xml version="1.0" encoding="UTF-8"?>'."\n";
        $xml .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">'."\n";

        foreach ($urls as $url) {
            $xml .= "  <url>\n";
            $xml .= '    <loc>'.e($url['loc'])."</loc>\n";

            if (! empty($url['lastmod'])) {
                $xml .= '    <lastmod>'.e($url['lastmod'])."</lastmod>\n";
            }

            $xml .= '    <priority>'.$url['priority']."</priority>\n";
            $xml .= "  </url>\n";
        }

        $xml .= '</urlset>';

        return response($xml, 200, ['Content-Type' => 'application/xml; charset=UTF-8']);
    }

    /**
     * Display the 'About Us' page containing company profile, directors, and legalities.
     * Rebuilt 2026-06-27: structured arrays from verbatim PDF spec (2026-06-19-tentang-kami-redesign.md).
     *
     * @return \Illuminate\View\View
     */
    public function about(): View
    {
        // Narasi utama & gambar dapat diatur lewat admin (Pengaturan); fallback ke teks/gambar di bawah.
        $cfg = Setting::query()
            ->whereIn('key', ['company_history', 'company_vision', 'company_mission', 'about_image', 'leader_1_photo', 'leader_2_photo'])
            ->pluck('value', 'key');
        $aboutImage = ! empty($cfg['about_image'])
            ? Storage::url($cfg['about_image'])
            : asset('img/hero/slide-1.jpg');

        // --- Profil Perusahaan (verbatim from spec) ---
        $profile = [
            'paragraph'     => 'PT. Kreasindo Graha Persada yang resmi didirikan pada tanggal 19 Oktober 2016, dalam usahanya bergerak dibidang Teknologi IT (Software, Hardware dan Network) dan Design Interior & Furniture (Interior Contractor, Design & Build). Dengan didukung tenaga-tenaga dan pelaksana yang berkualitas serta berpengalaman dalam menangani proyek, sehingga menghasilkan mutu dan kualitas pekerjaan yang memuaskan pihak pengguna jasa, menjadikan PT. Kreasindo Graha Persada mendapatkan kepercayaan 100% untuk mengerjakan sejumlah proyek yang lingkup pengerjaannya tersebar di seluruh wilayah di Indonesia.',
            'badge'         => 'Berdiri sejak 2016',
            'familyQuote'   => 'Kami selalu menganggap klien kami adalah bagian dari anggota keluarga, dimana kami selalu ingin memberikan yang terbaik bagi keluarga.',
            'kataPengantar' => [
                'Segenap Direksi PT. Kreasindo Graha Persada sebelumnya mengucapkan banyak terima kasih atas berkenannya Bapak/Ibu sekalian untuk tahu tentang kami. PT. Kreasindo Graha Persada adalah salah satu Perusahaan Swasta Nasional yang bergerak dibidang Teknologi IT (Software, Hardware dan Network) dan Design Interior & Furniture (Interior Contractor, Design & Build) yang memulai usahanya sejak tanggal 19 Oktober 2016 hingga sekarang.',
                'Dengan didukung oleh personil yang handal dengan latar belakang pendidikan yang sesuai, sangat berpengalaman pada bidangnya serta dengan dedikasi dalam menangani pekerjaan-pekerjaan tersebut.',
                'Perusahaan kami sangat memperhatikan kualitas dari hasil pekerjaan dan memberikan pelayanan yang sangat baik serta dengan metode kerja yang tepat dan selalu menerapkan system manajemen project yang tepat untuk penanganan proyek.',
                'Kami selalu mengganggap klien kami adalah bagian dari anggota keluarga, dimana kami selalu ingin memberikan yang terbaik bagi keluarga.',
                'Demikian prakata dari kami mudah-mudahan bisa menjadi gambaran tentang PT. Kreasindo Graha Persada, sehingga Bapak/Ibu sekalian akan mengenali dan memberikan perhatian terhadap perusahaan kami, atas kerjasamanya diucapkan terima kasih.',
            ],
            'signature' => 'Dewan Direksi, PT Kreasindo Graha Persada',
        ];

        // --- Visi (verbatim) ---
        $visi = 'Menjadi perusahaan swasta nasional terdepan di industri Teknologi IT (Software, Hardware dan Network) dan Design Interior & Furniture (Interior Contractor, Design & Build), dengan memberikan layanan dan solusi terkini, terintegrasi, profesional yang terbaik serta bernilai tambah bagi Customer dan Stakeholder.';

        // --- Misi — 4 items (verbatim) ---
        $misi = [
            'Membangun kemitraan strategis dan bersinergi dengan klien maupun partner dengan prinsip saling menguntungkan.',
            'Mengedepankan profesionalisme dan teamwork dalam menghasilkan layanan yang berkualitas.',
            'Memberikan pelayanan jasa terbaik kepada setiap klien melalui solusi yang inovatif, efektif, dan efisien dalam bidang Teknologi Informasi.',
            'Berperan sebagai prime mover (penggerak utama) bangkitnya industri Teknologi Informasi.',
        ];

        // Sambungkan ke Pengaturan → Perusahaan (bila diisi admin; jika kosong, pakai teks di atas).
        if (filled($cfg['company_history'] ?? null)) {
            $profile['paragraph'] = $cfg['company_history'];
        }
        if (filled($cfg['company_vision'] ?? null)) {
            $visi = $cfg['company_vision'];
        }
        if (filled($cfg['company_mission'] ?? null)) {
            $misiLines = array_values(array_filter(array_map('trim', preg_split('/\r\n|\r|\n/', $cfg['company_mission']))));
            if ($misiLines) {
                $misi = $misiLines;
            }
        }

        // --- Peranan & Komitmen — intro + 3 cards (verbatim) ---
        $peranan = [
            'intro' => 'Sebagai Perusahaan yang bergerak dibidang Teknologi IT (Software, Hardware dan Network) dan Design Interior & Furniture (Interior Contractor, Design & Build), pengerjaan serta pengendalian mutu produk merupakan prioritas paling utama untuk menjawab tantangan secara ekonomis serta efektif waktu.',
            'cards' => [
                [
                    'title' => 'Tenaga Ahli Berpengalaman',
                    'body'  => 'Didukung personil ahli dalam pengerjaan project pembangunan konstruksi sipil, interior & furniture, serta dukungan material yang diproduksi oleh grup perusahaan — cocok untuk pembangunan gedung perkantoran, pabrik, maupun perumahan.',
                    'icon'  => 'users',
                ],
                [
                    'title' => 'Kualitas Teruji',
                    'body'  => 'Material dasar dan program kerja telah melewati hasil uji di Balai Struktur dan Konstruksi, Pusat Penelitian dan Pengembangan Permukiman, dan Badan Penelitian dengan hasil baik dan handal, dengan mutu yang bisa dipertanggungjawabkan.',
                    'icon'  => 'badge-check',
                ],
                [
                    'title' => '100% Komitmen',
                    'body'  => 'Perusahaan kami sangat memperhatikan kualitas dari hasil pekerjaan dan memberikan pelayanan yang sangat baik serta dengan metode kerja yang tepat dan selalu menerapkan system manajemen project yang tepat untuk penanganan proyek.',
                    'icon'  => 'star',
                ],
            ],
        ];

        // --- Legalitas — sourced from the Document module (single source of truth).
        // Documents in categories flagged `is_legal` appear here, grouped by category.
        // Adding/editing/removing documents in the admin panel is reflected automatically. ---
        $legalitas = Document::query()
            ->whereHas('category', fn ($q) => $q->where('is_legal', true))
            ->where('is_active', true)
            ->with('category')
            ->orderBy('sort_order')
            ->get()
            ->groupBy(fn (Document $doc) => $doc->category->name);

        // --- Leadership — 2 cards (verbatim quotes) ---
        // TODO: Yoyon vs Toyon — spec confirms "Yoyon Setiawan" (cross-check with HR/legal)
        // TODO: replace placeholder photos with real branded portraits when available
        $leadership = [
            [
                'name'     => 'Razzif Eka Darma',
                'position' => 'Direktur Utama',
                'quote'    => 'Ketika anda melakukan sesuatu dan gagal maka kegagalan itu bukan saja akan membuahkan kesuksesan, tetapi yang pasti kegagalan itu lebih berguna ketimbang anda tidak melakukan apapun.',
                'photo'    => $cfg['leader_1_photo'] ?? '',
            ],
            [
                'name'     => 'Yoyon Setiawan',
                'position' => 'Direktur Marketing',
                'quote'    => 'Kemenangan dari sebuah kesuksesan sudah setengah dimenangkan ketika seseorang mencapai kebiasaan bekerja.',
                'photo'    => $cfg['leader_2_photo'] ?? '',
            ],
        ];

        // --- Org chart hierarchy (nested array — rendered in Blade as Tailwind boxes) ---
        $orgChart = [
            'name'     => 'Razzif Eka Darma',
            'position' => 'Direktur Utama',
            'children' => [
                [
                    'name'     => 'Muhammad Rido',
                    'position' => 'Direktur Operasional',
                    'children' => [
                        [
                            'name'     => 'Muhammad Teguh',
                            'position' => 'Manager Operasional',
                            'children' => [
                                ['name' => 'Staff', 'position' => ''],
                                ['name' => 'Staff', 'position' => ''],
                                ['name' => 'Staff', 'position' => ''],
                            ],
                        ],
                        [
                            'name'     => 'Salahudin Syam',
                            'position' => 'Manager Adm dan Keuangan',
                            'children' => [
                                ['name' => 'Staff', 'position' => ''],
                                ['name' => 'Staff', 'position' => ''],
                                ['name' => 'Staff', 'position' => ''],
                            ],
                        ],
                    ],
                ],
                [
                    'name'     => 'Yoyon Setiawan',
                    'position' => 'Direktur Marketing',
                    'children' => [
                        [
                            'name'     => 'Malvin',
                            'position' => 'Manager Marketing',
                            'children' => [
                                ['name' => 'Staff', 'position' => ''],
                                ['name' => 'Staff', 'position' => ''],
                                ['name' => 'Staff', 'position' => ''],
                            ],
                        ],
                    ],
                ],
            ],
        ];

        return view('pages.about', compact(
            'profile',
            'visi',
            'misi',
            'peranan',
            'legalitas',
            'leadership',
            'orgChart',
            'aboutImage',
        ));
    }

    /**
     * Labels for service divisions used in tabs or section headings.
     *
     * @var array<string, string>
     */
    private const DIVISION_LABELS = [
        'it' => 'Divisi IT',
        'interior' => 'Divisi Interior',
        'me' => 'Mekanikal & Elektrikal',
    ];

    /**
     * Display the services list, filtered by active status and grouped by division.
     *
     * @return \Illuminate\View\View
     */
    public function services(): View
    {
        $services = Service::query()
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->get()
            ->groupBy('division');

        $divisions = array_filter(
            self::DIVISION_LABELS,
            fn (string $key) => $services->has($key),
            ARRAY_FILTER_USE_KEY,
        );

        return view('pages.services.index', compact('services', 'divisions'));
    }

    /**
     * Display details of a specific active service.
     *
     * @param string $slug
     * @return \Illuminate\View\View
     */
    public function serviceShow(string $slug): View
    {
        $service = Service::query()
            ->where('slug', $slug)
            ->where('is_active', true)
            ->firstOrFail();

        return view('pages.services.show', compact('service'));
    }

    /**
     * Labels for project divisions used for filtering.
     *
     * @var array<string, string>
     */
    private const PROJECT_DIVISION_LABELS = [
        'it' => 'Divisi IT',
        'interior' => 'Divisi Interior',
        'sipil' => 'Divisi Sipil',
    ];

    /**
     * Display the portfolio with server-side filtering and pagination.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\View\View
     */
    public function portfolio(Request $request): View
    {
        $base = Project::query()->where('is_active', true);

        $activeDivisions = (clone $base)->distinct()->pluck('division');
        $divisions = array_filter(
            self::PROJECT_DIVISION_LABELS,
            fn (string $key) => $activeDivisions->contains($key),
            ARRAY_FILTER_USE_KEY,
        );

        $years = (clone $base)->whereNotNull('year')->distinct()->orderByDesc('year')->pluck('year');

        $division = (string) $request->query('divisi', '');
        $division = isset(self::PROJECT_DIVISION_LABELS[$division]) ? $division : '';

        $projects = (clone $base)
            ->with(['client', 'images'])
            ->when($division !== '', fn ($q) => $q->where('division', $division))
            ->when($request->filled('tahun'), fn ($q) => $q->where('year', (int) $request->query('tahun')))
            ->when($request->filled('cari'), fn ($q) => $q->where('title', 'like', '%'.$request->string('cari')->trim().'%'))
            ->orderBy('sort_order')
            ->paginate(9)
            ->withQueryString();

        return view('pages.portfolio.index', compact('projects', 'divisions', 'years'));
    }

    /**
     * Display details of an active project.
     *
     * @param string $slug
     * @return \Illuminate\View\View
     */
    public function portfolioShow(string $slug): View
    {
        $project = Project::query()
            ->with(['client', 'service', 'images' => fn ($q) => $q->orderBy('sort_order')])
            ->where('slug', $slug)
            ->where('is_active', true)
            ->firstOrFail();

        return view('pages.portfolio.show', compact('project'));
    }

    /**
     * Labels for client categories.
     *
     * @var array<string, string>
     */
    private const CLIENT_CATEGORY_LABELS = [
        'militer' => 'Militer & Keamanan',
        'pemerintah' => 'Pemerintahan',
        'bumn' => 'BUMN',
        'swasta' => 'Swasta',
    ];

    /**
     * Display the active clients grouped by category.
     *
     * @return \Illuminate\View\View
     */
    public function clients(): View
    {
        $clients = Client::query()
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->get()
            ->groupBy('category');

        $categories = array_filter(
            self::CLIENT_CATEGORY_LABELS,
            fn (string $key) => $clients->has($key),
            ARRAY_FILTER_USE_KEY,
        );

        return view('pages.clients', compact('clients', 'categories'));
    }

    /**
     * Labels for gallery divisions used for filtering.
     *
     * @var array<string, string>
     */
    private const GALLERY_DIVISION_LABELS = [
        'it' => 'Divisi IT',
        'interior' => 'Divisi Interior',
        'sipil' => 'Divisi Sipil',
        'event' => 'Event',
    ];

    /**
     * Generate a display-friendly label for a gallery division.
     *
     * @param string $division
     * @return string
     */
    public static function galleryDivisionLabel(string $division): string
    {
        return self::GALLERY_DIVISION_LABELS[$division] ?? ucfirst($division);
    }

    /**
     * Display the gallery albums with server-side filtering and pagination.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\View\View
     */
    public function gallery(Request $request): View
    {
        $base = Gallery::query()->where('is_active', true);

        $activeDivisions = (clone $base)->distinct()->pluck('division');
        $divisions = array_filter(
            self::GALLERY_DIVISION_LABELS,
            fn (string $key) => $activeDivisions->contains($key),
            ARRAY_FILTER_USE_KEY,
        );

        $division = (string) $request->query('divisi', '');
        $division = isset(self::GALLERY_DIVISION_LABELS[$division]) ? $division : '';

        $galleries = (clone $base)
            ->withCount('photos')
            ->when($division !== '', fn ($q) => $q->where('division', $division))
            ->orderBy('sort_order')
            ->paginate(9)
            ->withQueryString();

        return view('pages.gallery.index', compact('galleries', 'divisions'));
    }

    /**
     * Display an active gallery album and its ordered photos.
     *
     * @param string $slug
     * @return \Illuminate\View\View
     */
    public function galleryShow(string $slug): View
    {
        $gallery = Gallery::query()
            ->with(['photos' => fn ($q) => $q->orderBy('sort_order')])
            ->where('slug', $slug)
            ->where('is_active', true)
            ->firstOrFail();

        return view('pages.gallery.show', compact('gallery'));
    }

    /**
     * Retrieve the base query for publicly accessible posts.
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    private function publishedPosts()
    {
        return Post::query()
            ->where('status', 'published')
            ->whereNotNull('published_at')
            ->where('published_at', '<=', now());
    }

    /**
     * Display the news listing with categories and pagination.
     *
     * @return \Illuminate\View\View
     */
    public function news(): View
    {
        $posts = $this->publishedPosts()
            ->with('category')
            ->latest('published_at')
            ->paginate(6);

        $publishedFilter = fn ($q) => $q
            ->where('status', 'published')
            ->whereNotNull('published_at')
            ->where('published_at', '<=', now());

        $categories = PostCategory::query()
            ->withCount(['posts' => $publishedFilter])
            ->whereHas('posts', $publishedFilter)
            ->orderBy('name')
            ->get();

        return view('pages.news.index', compact('posts', 'categories'));
    }

    /**
     * Display details of a specific published news post.
     *
     * @param string $slug
     * @return \Illuminate\View\View
     */
    public function newsShow(string $slug): View
    {
        $post = $this->publishedPosts()
            ->with(['category', 'author', 'tags'])
            ->where('slug', $slug)
            ->firstOrFail();

        $related = $this->publishedPosts()
            ->with('category')
            ->where('id', '!=', $post->id)
            ->when($post->post_category_id, fn ($q) => $q->where('post_category_id', $post->post_category_id))
            ->latest('published_at')
            ->take(3)
            ->get();

        if ($related->count() < 3) {
            $related = $related->merge(
                $this->publishedPosts()
                    ->with('category')
                    ->where('id', '!=', $post->id)
                    ->whereNotIn('id', $related->pluck('id'))
                    ->latest('published_at')
                    ->take(3 - $related->count())
                    ->get()
            );
        }

        return view('pages.news.show', compact('post', 'related'));
    }

    /**
     * Display legal documents grouped by category.
     *
     * @return \Illuminate\View\View
     */
    public function documents(): View
    {
        $documents = Document::query()
            ->with('category')
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->get()
            ->groupBy(fn (Document $doc) => $doc->category?->name ?? 'Lainnya');

        return view('pages.documents', compact('documents'));
    }

    /**
     * Process a document download request.
     *
     * Increments the download counter and serves the file if it exists.
     *
     * @param \App\Models\Document $document
     * @return \Symfony\Component\HttpFoundation\StreamedResponse|\Illuminate\Http\RedirectResponse
     */
    public function documentDownload(Document $document): StreamedResponse|RedirectResponse
    {
        abort_unless($document->is_active, 404);

        $disk = Storage::disk('public');
        abort_unless($disk->exists($document->file_path), 404);

        $document->increment('download_count');

        return $disk->download($document->file_path);
    }

    /**
     * Display active job vacancies.
     *
     * Jobs still open are prioritized over those past their deadline.
     *
     * @return \Illuminate\View\View
     */
    public function careers(): View
    {
        $careers = Career::query()
            ->where('is_active', true)
            ->orderByRaw('CASE WHEN deadline IS NULL OR deadline >= ? THEN 0 ELSE 1 END', [now()->toDateString()])
            ->orderBy('deadline')
            ->get();

        return view('pages.careers', compact('careers'));
    }

    /**
     * Display the contact information page.
     *
     * @return \Illuminate\View\View
     */
    public function contact(): View
    {
        $settings = Setting::query()
            ->whereIn('group', ['contact', 'social', 'general'])
            ->pluck('value', 'key');

        return view('pages.contact', compact('settings'));
    }

    /**
     * Store a contact-form submission and flash a success message.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function contactSubmit(Request $request): RedirectResponse
    {
        // Honeypot: bots fill hidden fields. Silently accept without saving.
        if (filled($request->input('website'))) {
            return redirect()->route('contact')->with('contact_success', true);
        }

        $data = $request->validate([
            'name' => ['required', 'string', 'max:150'],
            'company' => ['nullable', 'string', 'max:150'],
            'email' => ['required', 'email', 'max:190'],
            'phone' => ['required', 'string', 'max:40'],
            'service_interest' => ['nullable', 'string', 'max:60'],
            'message' => ['required', 'string', 'max:5000'],
        ]);

        ContactMessage::create($data + ['ip_address' => $request->ip()]);

        return redirect()->route('contact')->with('contact_success', true);
    }
}
