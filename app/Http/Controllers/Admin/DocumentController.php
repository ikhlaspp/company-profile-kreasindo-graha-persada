<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\Concerns\InteractsWithResource;
use App\Http\Controllers\Controller;
use App\Models\Document;
use App\Models\DocumentCategory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class DocumentController extends Controller
{
    use InteractsWithResource;

    public function index(Request $request): View
    {
        $items = Document::query()
            ->with('category')
            ->when($request->filled('q'), fn ($q) => $q->where('title', 'like', '%'.$request->string('q').'%'))
            ->when($request->filled('category'), fn ($q) => $q->where('document_category_id', $request->string('category')))
            ->orderBy('sort_order')
            ->latest('id')
            ->paginate(15)
            ->withQueryString();

        return view('admin.documents.index', compact('items'));
    }

    public function create(): View
    {
        return view('admin.documents.form', $this->formData());
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->validateData($request, fileRequired: true);

        $file = $request->file('file');
        Document::create([
            'document_category_id' => $data['category_id'] ?? null,
            'title' => $data['title'],
            'file_path' => $file->store('documents', 'public'),
            'file_size_kb' => (int) ceil($file->getSize() / 1024),
            'mime_type' => $file->getClientMimeType(),
            'year' => $data['year'] ?? null,
            'is_active' => $data['is_active'],
            'sort_order' => $data['sort_order'] ?? 0,
        ]);

        return redirect()->route('panel.documents.index')->with('success', 'Dokumen berhasil ditambahkan.');
    }

    public function edit(Document $document): View
    {
        return view('admin.documents.form', ['item' => $document] + $this->formData());
    }

    public function update(Request $request, Document $document): RedirectResponse
    {
        $data = $this->validateData($request, fileRequired: false);

        $payload = [
            'document_category_id' => $data['category_id'] ?? null,
            'title' => $data['title'],
            'year' => $data['year'] ?? null,
            'is_active' => $data['is_active'],
            'sort_order' => $data['sort_order'] ?? 0,
        ];

        if ($request->hasFile('file')) {
            if ($document->file_path) {
                Storage::disk('public')->delete($document->file_path);
            }
            $file = $request->file('file');
            $payload['file_path'] = $file->store('documents', 'public');
            $payload['file_size_kb'] = (int) ceil($file->getSize() / 1024);
            $payload['mime_type'] = $file->getClientMimeType();
        }

        $document->update($payload);

        return redirect()->route('panel.documents.index')->with('success', 'Dokumen berhasil diperbarui.');
    }

    public function destroy(Document $document): RedirectResponse
    {
        if ($document->file_path) {
            Storage::disk('public')->delete($document->file_path);
        }
        $document->delete();

        return redirect()->route('panel.documents.index')->with('success', 'Dokumen berhasil dihapus.');
    }

    /**
     * @return array<string, mixed>
     */
    private function formData(): array
    {
        return [
            'categories' => DocumentCategory::orderBy('name')->pluck('name', 'id')->all(),
        ];
    }

    /**
     * @return array<string, mixed>
     */
    private function validateData(Request $request, bool $fileRequired): array
    {
        return $request->validate([
            'category_id' => ['nullable', 'exists:document_categories,id'],
            'title' => ['required', 'string', 'max:200'],
            'year' => ['nullable', 'integer', 'min:1900', 'max:2100'],
            'sort_order' => ['nullable', 'integer'],
            'is_active' => ['required', 'boolean'],
            'file' => [$fileRequired ? 'required' : 'nullable', 'file', 'mimes:pdf', 'max:10240'],
        ]);
    }
}
