<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\Concerns\InteractsWithResource;
use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\Project;
use App\Models\Service;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class ProjectController extends Controller
{
    use InteractsWithResource;

    public function index(Request $request): View
    {
        $items = Project::query()
            ->with('client')
            ->when($request->filled('q'), fn ($q) => $q->where('title', 'like', '%'.$request->string('q').'%'))
            ->when($request->filled('division'), fn ($q) => $q->where('division', $request->string('division')))
            ->when($request->filled('year'), fn ($q) => $q->where('year', $request->integer('year')))
            ->when($request->filled('featured'), fn ($q) => $q->where('is_featured', $request->string('featured')->value() === '1'))
            ->orderBy('sort_order')
            ->latest('id')
            ->paginate(15)
            ->withQueryString();

        $years = Project::query()
            ->whereNotNull('year')
            ->distinct()
            ->orderByDesc('year')
            ->pluck('year');

        return view('admin.projects.index', compact('items', 'years'));
    }

    public function create(): View
    {
        return view('admin.projects.form', $this->formData());
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->validateData($request);
        unset($data['images']);
        $data['slug'] = $this->uniqueSlug(Project::class, $data['title'], $request->input('slug'));

        $project = Project::create($data);
        $this->syncImages($request, $project);

        return redirect()->route('panel.projects.index')->with('success', 'Proyek berhasil ditambahkan.');
    }

    public function edit(Project $project): View
    {
        return view('admin.projects.form', ['item' => $project->load('images')] + $this->formData());
    }

    public function update(Request $request, Project $project): RedirectResponse
    {
        $data = $this->validateData($request);
        unset($data['images']);
        $data['slug'] = $this->uniqueSlug(Project::class, $data['title'], $request->input('slug'), $project->id);

        $project->update($data);
        $this->syncImages($request, $project);

        return redirect()->route('panel.projects.index')->with('success', 'Proyek berhasil diperbarui.');
    }

    public function destroy(Project $project): RedirectResponse
    {
        $project->delete();

        return redirect()->route('panel.projects.index')->with('success', 'Proyek berhasil dihapus.');
    }

    /**
     * @return array<string, mixed>
     */
    private function formData(): array
    {
        return [
            'clients' => Client::orderBy('name')->pluck('name', 'id')->all(),
            'services' => Service::orderBy('title')->pluck('title', 'id')->all(),
            'divisions' => ['it' => 'IT', 'interior' => 'Interior', 'sipil' => 'Sipil'],
        ];
    }

    private function syncImages(Request $request, Project $project): void
    {
        if (! $request->hasFile('images')) {
            return;
        }

        $coverIndex = (int) $request->input('cover_index', 0);
        $start = $project->images()->count();

        foreach ($request->file('images') as $i => $file) {
            $project->images()->create([
                'file_path' => $file->store('projects', 'public'),
                'is_cover' => $i === $coverIndex && $start === 0,
                'sort_order' => $start + $i + 1,
            ]);
        }

        // Pastikan selalu ada tepat satu cover (fallback ke foto pertama).
        if ($project->images()->where('is_cover', true)->doesntExist()) {
            $project->images()->oldest('sort_order')->first()?->update(['is_cover' => true]);
        }
    }

    /**
     * @return array<string, mixed>
     */
    private function validateData(Request $request): array
    {
        return $request->validate([
            'client_id' => ['nullable', 'exists:clients,id'],
            'service_id' => ['nullable', 'exists:services,id'],
            'division' => ['required', Rule::in(['it', 'interior', 'sipil'])],
            'title' => ['required', 'string', 'max:200'],
            'slug' => ['nullable', 'string', 'max:220'],
            'description' => ['nullable', 'string'],
            'contract_value' => ['nullable', 'integer', 'min:0'],
            'location' => ['nullable', 'string', 'max:150'],
            'year' => ['nullable', 'integer', 'min:1900', 'max:2100'],
            'completed_at' => ['nullable', 'date'],
            'is_featured' => ['required', 'boolean'],
            'is_active' => ['required', 'boolean'],
            'sort_order' => ['nullable', 'integer'],
            'images' => ['nullable', 'array'],
            'images.*' => ['image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ]);
    }
}
