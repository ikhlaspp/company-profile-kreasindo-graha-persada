<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\Concerns\InteractsWithResource;
use App\Http\Controllers\Controller;
use App\Models\Service;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class ServiceController extends Controller
{
    use InteractsWithResource;

    public function index(Request $request): View
    {
        $items = Service::query()
            ->when($request->filled('q'), fn ($q) => $q->where('title', 'like', '%'.$request->string('q').'%'))
            ->when($request->filled('division'), fn ($q) => $q->where('division', $request->string('division')))
            ->when($request->filled('status'), fn ($q) => $q->where('is_active', $request->string('status')->value() === 'active'))
            ->orderBy('sort_order')
            ->paginate(15)
            ->withQueryString();

        return view('admin.services.index', compact('items'));
    }

    public function create(): View
    {
        return view('admin.services.form');
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->validateData($request);
        $data['slug'] = $this->uniqueSlug(Service::class, $data['title'], $request->input('slug'));
        $data['cover_image'] = $this->storeFile($request, 'cover_image', 'services');

        Service::create($data);

        return redirect()->route('panel.services.index')->with('success', 'Layanan berhasil ditambahkan.');
    }

    public function edit(Service $service): View
    {
        return view('admin.services.form', ['item' => $service]);
    }

    public function update(Request $request, Service $service): RedirectResponse
    {
        $data = $this->validateData($request);
        $data['slug'] = $this->uniqueSlug(Service::class, $data['title'], $request->input('slug'), $service->id);
        $data['cover_image'] = $this->storeFile($request, 'cover_image', 'services', $service->cover_image);

        $service->update($data);

        return redirect()->route('panel.services.index')->with('success', 'Layanan berhasil diperbarui.');
    }

    public function destroy(Service $service): RedirectResponse
    {
        $service->delete();

        return redirect()->route('panel.services.index')->with('success', 'Layanan berhasil dihapus.');
    }

    /**
     * @return array<string, mixed>
     */
    private function validateData(Request $request): array
    {
        return $request->validate([
            'division' => ['required', Rule::in(['it', 'interior', 'me'])],
            'title' => ['required', 'string', 'max:150'],
            'slug' => ['nullable', 'string', 'max:170'],
            'excerpt' => ['nullable', 'string', 'max:300'],
            'description' => ['nullable', 'string'],
            'icon' => ['nullable', 'string', 'max:255'],
            'cover_image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'is_active' => ['required', 'boolean'],
            'sort_order' => ['nullable', 'integer'],
        ]);
    }
}
