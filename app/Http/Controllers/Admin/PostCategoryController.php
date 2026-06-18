<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\Concerns\InteractsWithResource;
use App\Http\Controllers\Controller;
use App\Models\PostCategory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PostCategoryController extends Controller
{
    use InteractsWithResource;

    public function index(): View
    {
        $items = PostCategory::withCount('posts')->orderBy('name')->get();

        return view('admin.post-categories.index', compact('items'));
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'slug' => ['nullable', 'string', 'max:120'],
            'description' => ['nullable', 'string', 'max:255'],
        ]);
        $data['slug'] = $this->uniqueSlug(PostCategory::class, $data['name'], $request->input('slug'));

        PostCategory::create($data);

        return redirect()->route('panel.post-categories.index')->with('success', 'Kategori berhasil ditambahkan.');
    }

    public function update(Request $request, PostCategory $postCategory): RedirectResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'slug' => ['nullable', 'string', 'max:120'],
            'description' => ['nullable', 'string', 'max:255'],
        ]);
        $data['slug'] = $this->uniqueSlug(PostCategory::class, $data['name'], $request->input('slug'), $postCategory->id);

        $postCategory->update($data);

        return redirect()->route('panel.post-categories.index')->with('success', 'Kategori berhasil diperbarui.');
    }

    public function destroy(PostCategory $postCategory): RedirectResponse
    {
        $postCategory->delete();

        return redirect()->route('panel.post-categories.index')->with('success', 'Kategori berhasil dihapus.');
    }
}
