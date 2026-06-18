<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\Concerns\InteractsWithResource;
use App\Http\Controllers\Controller;
use App\Models\Tag;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class TagController extends Controller
{
    use InteractsWithResource;

    public function index(): View
    {
        $items = Tag::withCount('posts')->orderBy('name')->get();

        return view('admin.tags.index', compact('items'));
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:80'],
        ]);
        $data['slug'] = $this->uniqueSlug(Tag::class, $data['name']);

        Tag::create($data);

        return redirect()->route('panel.tags.index')->with('success', 'Tag berhasil ditambahkan.');
    }

    public function destroy(Tag $tag): RedirectResponse
    {
        $tag->delete();

        return redirect()->route('panel.tags.index')->with('success', 'Tag berhasil dihapus.');
    }
}
