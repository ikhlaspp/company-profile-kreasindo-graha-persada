<?php

namespace App\Http\Controllers;

use App\Models\Career;
use App\Models\Client;
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
        $stats = [
            ['value' => Project::where('is_active', true)->count(), 'suffix' => '+', 'label' => 'Proyek Selesai'],
            ['value' => Client::where('is_active', true)->count(), 'suffix' => '+', 'label' => 'Klien Aktif'],
            ['value' => 2016, 'suffix' => '', 'label' => 'Sejak Tahun'],
            ['value' => 2, 'suffix' => '', 'label' => 'Divisi Utama'],
        ];

        $featured = Project::query()
            ->with(['client', 'images'])
            ->where('is_active', true)
            ->where('is_featured', true)
            ->orderBy('sort_order')
            ->latest('id')
            ->take(3)
            ->get()
            ->map(function (Project $project) {
                $cover = $project->images->firstWhere('is_cover', true) ?? $project->images->first();

                return [
                    'title' => $project->title,
                    'division' => $project->division,
                    'year' => $project->year,
                    'client' => $project->client?->name ?? '—',
                    'cover' => $cover ? asset('storage/'.$cover->file_path) : '',
                    'slug' => $project->slug,
                ];
            })
            ->all();

        $divisions = [
            [
                'title' => 'Divisi IT',
                'desc' => 'Solusi teknologi komprehensif mulai dari pengembangan perangkat lunak, infrastruktur jaringan, hingga keamanan sistem untuk instansi Anda.',
                'slug' => 'it',
                'icon' => '<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>',
            ],
            [
                'title' => 'Divisi Interior',
                'desc' => 'Layanan desain dan konstruksi interior profesional yang mengutamakan estetika, fungsionalitas, dan kenyamanan ruang kerja Anda.',
                'slug' => 'interior',
                'icon' => '<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>',
            ],
        ];

        $clients = Client::query()
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->take(8)
            ->get()
            ->map(fn (Client $client) => [
                'name' => $client->name,
                'logo' => $client->logo ? asset('storage/'.$client->logo) : '',
            ])
            ->all();

        $org = Setting::query()
            ->whereIn('group', ['general', 'contact', 'social'])
            ->pluck('value', 'key');

        return view('pages.home', compact('stats', 'featured', 'divisions', 'clients', 'org'));
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
     *
     * @return \Illuminate\View\View
     */
    public function about(): View
    {
        $settings = Setting::whereIn('group', ['general', 'company'])->pluck('value', 'key');

        $mission = collect(explode("\n", $settings['company_mission'] ?? ''))
            ->map(fn (string $m) => trim($m))
            ->filter()
            ->values()
            ->all();

        $company = [
            'name' => $settings['site_name'] ?? 'PT. Kreasindo Graha Persada',
            'history' => $settings['company_history'] ?? 'Berdiri sejak tahun 2016, PT. Kreasindo Graha Persada telah berkembang menjadi perusahaan konsultan dan kontraktor yang dipercaya oleh berbagai instansi pemerintah, militer, dan swasta. Kami memulai perjalanan ini dengan semangat untuk memberikan solusi yang tepat guna dan bernilai tinggi bagi setiap klien kami.',
            'vision' => $settings['company_vision'] ?? 'Menjadi perusahaan penyedia jasa IT dan Interior terdepan yang inovatif, profesional, dan memberikan dampak positif secara berkelanjutan.',
            'mission' => $mission !== [] ? $mission : [
                'Memberikan layanan berkualitas tinggi yang memenuhi standar industri.',
                'Membangun hubungan jangka panjang yang saling menguntungkan dengan klien dan mitra.',
                'Mendorong inovasi dalam setiap solusi teknologi dan desain yang ditawarkan.',
                'Menjaga profesionalisme dan integritas dalam setiap proses bisnis.',
            ],
        ];

        $directors = [
            ['name' => 'Budi Santoso', 'position' => 'Direktur Utama', 'photo' => ''],
            ['name' => 'Andi Wijaya', 'position' => 'Direktur IT', 'photo' => ''],
            ['name' => 'Siti Aminah', 'position' => 'Direktur Operasional', 'photo' => ''],
        ];

        $legalities = [
            ['code' => 'SBU', 'label' => 'Sertifikat Badan Usaha'],
            ['code' => 'SIUP', 'label' => 'Surat Izin Usaha Perdagangan'],
            ['code' => 'SIUJK', 'label' => 'Surat Izin Usaha Jasa Konstruksi'],
            ['code' => 'NIB', 'label' => 'Nomor Induk Berusaha'],
        ];

        return view('pages.about', compact('company', 'directors', 'legalities'));
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
}
