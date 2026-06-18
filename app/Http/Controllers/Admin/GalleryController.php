<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\Concerns\InteractsWithResource;
use App\Http\Controllers\Controller;
use App\Models\Gallery;
use App\Models\GalleryPhoto;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class GalleryController extends Controller
{
    use InteractsWithResource;

    public function index(): View
    {
        $items = Gallery::withCount('photos')->orderBy('sort_order')->paginate(16);

        return view('admin.galleries.index', compact('items'));
    }

    public function create(): View
    {
        return view('admin.galleries.form');
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->validateData($request);
        $data['slug'] = $this->uniqueSlug(Gallery::class, $data['title'], $request->input('slug'));
        $data['cover_image'] = $this->storeFile($request, 'cover_image', 'galleries');

        $gallery = Gallery::create($data);

        return redirect()->route('panel.galleries.photos', $gallery)->with('success', 'Album dibuat. Tambahkan foto sekarang.');
    }

    public function edit(Gallery $gallery): View
    {
        return view('admin.galleries.form', ['item' => $gallery]);
    }

    public function update(Request $request, Gallery $gallery): RedirectResponse
    {
        $data = $this->validateData($request);
        $data['slug'] = $this->uniqueSlug(Gallery::class, $data['title'], $request->input('slug'), $gallery->id);
        $data['cover_image'] = $this->storeFile($request, 'cover_image', 'galleries', $gallery->cover_image);

        $gallery->update($data);

        return redirect()->route('panel.galleries.index')->with('success', 'Album berhasil diperbarui.');
    }

    public function destroy(Gallery $gallery): RedirectResponse
    {
        $gallery->delete();

        return redirect()->route('panel.galleries.index')->with('success', 'Album berhasil dihapus.');
    }

    public function photos(Gallery $gallery): View
    {
        $photos = $gallery->photos()->orderBy('sort_order')->get();

        return view('admin.galleries.photos', ['gallery' => $gallery, 'photos' => $photos]);
    }

    public function storePhotos(Request $request, Gallery $gallery): RedirectResponse
    {
        $request->validate([
            'images' => ['required', 'array'],
            'images.*' => ['image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ]);

        $start = $gallery->photos()->count();

        foreach ($request->file('images') as $i => $file) {
            $gallery->photos()->create([
                'file_path' => $file->store('galleries', 'public'),
                'sort_order' => $start + $i + 1,
            ]);
        }

        return redirect()->route('panel.galleries.photos', $gallery)->with('success', 'Foto berhasil diunggah.');
    }

    public function updatePhotos(Request $request, Gallery $gallery): RedirectResponse
    {
        $validated = $request->validate([
            'captions' => ['array'],
            'captions.*' => ['nullable', 'string', 'max:255'],
            'sort_orders' => ['array'],
            'sort_orders.*' => ['nullable', 'integer', 'min:0'],
        ]);

        $captions = $validated['captions'] ?? [];
        $orders = $validated['sort_orders'] ?? [];

        $gallery->photos()
            ->whereIn('id', array_keys($captions + $orders))
            ->get()
            ->each(fn (GalleryPhoto $photo) => $photo->update([
                'caption' => $captions[$photo->id] ?? $photo->caption,
                'sort_order' => $orders[$photo->id] ?? $photo->sort_order,
            ]));

        return redirect()->route('panel.galleries.photos', $gallery)->with('success', 'Keterangan & urutan foto diperbarui.');
    }

    public function destroyPhoto(Gallery $gallery, GalleryPhoto $photo): RedirectResponse
    {
        abort_unless($photo->gallery_id === $gallery->id, 404);
        $photo->delete();

        return redirect()->route('panel.galleries.photos', $gallery)->with('success', 'Foto berhasil dihapus.');
    }

    /**
     * @return array<string, mixed>
     */
    private function validateData(Request $request): array
    {
        return $request->validate([
            'title' => ['required', 'string', 'max:150'],
            'slug' => ['nullable', 'string', 'max:170'],
            'division' => ['required', Rule::in(['it', 'interior', 'sipil', 'event'])],
            'description' => ['nullable', 'string'],
            'cover_image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'is_active' => ['required', 'boolean'],
            'sort_order' => ['nullable', 'integer'],
        ]);
    }
}
