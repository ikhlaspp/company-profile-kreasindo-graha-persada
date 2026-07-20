<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\Concerns\InteractsWithResource;
use App\Http\Controllers\Controller;
use App\Models\DocumentCategory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DocumentCategoryController extends Controller
{
    use InteractsWithResource;

    public function index(): View
    {
        $items = DocumentCategory::withCount('documents')->orderBy('name')->get();

        return view('admin.document-categories.index', compact('items'));
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'slug' => ['nullable', 'string', 'max:120'],
            'is_legal' => ['required', 'boolean'],
        ]);
        $data['slug'] = $this->uniqueSlug(DocumentCategory::class, $data['name'], $request->input('slug'));

        DocumentCategory::create($data);

        return redirect()->route('panel.document-categories.index')->with('success', 'Kategori berhasil ditambahkan.');
    }

    public function update(Request $request, DocumentCategory $documentCategory): RedirectResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'slug' => ['nullable', 'string', 'max:120'],
            'is_legal' => ['required', 'boolean'],
        ]);
        $data['slug'] = $this->uniqueSlug(DocumentCategory::class, $data['name'], $request->input('slug'), $documentCategory->id);

        $documentCategory->update($data);

        return redirect()->route('panel.document-categories.index')->with('success', 'Kategori berhasil diperbarui.');
    }

    public function destroy(DocumentCategory $documentCategory): RedirectResponse
    {
        $documentCategory->delete();

        return redirect()->route('panel.document-categories.index')->with('success', 'Kategori berhasil dihapus.');
    }
}
