<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\Concerns\InteractsWithResource;
use App\Http\Controllers\Controller;
use App\Models\Career;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class CareerController extends Controller
{
    use InteractsWithResource;

    public function index(Request $request): View
    {
        $items = Career::query()
            ->when($request->filled('q'), fn ($q) => $q->where('title', 'like', '%'.$request->string('q').'%'))
            ->latest('id')
            ->paginate(15)
            ->withQueryString();

        return view('admin.careers.index', compact('items'));
    }

    public function create(): View
    {
        return view('admin.careers.form');
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->validateData($request);
        $data['slug'] = $this->uniqueSlug(Career::class, $data['title'], $request->input('slug'));

        Career::create($data);

        return redirect()->route('panel.careers.index')->with('success', 'Lowongan berhasil ditambahkan.');
    }

    public function edit(Career $career): View
    {
        return view('admin.careers.form', ['item' => $career]);
    }

    public function update(Request $request, Career $career): RedirectResponse
    {
        $data = $this->validateData($request);
        $data['slug'] = $this->uniqueSlug(Career::class, $data['title'], $request->input('slug'), $career->id);

        $career->update($data);

        return redirect()->route('panel.careers.index')->with('success', 'Lowongan berhasil diperbarui.');
    }

    public function destroy(Career $career): RedirectResponse
    {
        $career->delete();

        return redirect()->route('panel.careers.index')->with('success', 'Lowongan berhasil dihapus.');
    }

    /**
     * @return array<string, mixed>
     */
    private function validateData(Request $request): array
    {
        return $request->validate([
            'division' => ['required', Rule::in(['it', 'interior', 'me', 'umum'])],
            'title' => ['required', 'string', 'max:150'],
            'slug' => ['nullable', 'string', 'max:170'],
            'description' => ['nullable', 'string'],
            'requirements' => ['nullable', 'string'],
            'employment_type' => ['required', Rule::in(['full_time', 'part_time', 'contract', 'internship'])],
            'location' => ['nullable', 'string', 'max:150'],
            'deadline' => ['nullable', 'date'],
            'is_active' => ['required', 'boolean'],
        ]);
    }
}
