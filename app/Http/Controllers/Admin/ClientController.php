<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\Concerns\InteractsWithResource;
use App\Http\Controllers\Controller;
use App\Models\Client;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class ClientController extends Controller
{
    use InteractsWithResource;

    public function index(Request $request): View
    {
        $items = Client::query()
            ->when($request->filled('q'), fn ($q) => $q->where('name', 'like', '%'.$request->string('q').'%'))
            ->when($request->filled('category'), fn ($q) => $q->where('category', $request->string('category')))
            ->orderBy('sort_order')
            ->paginate(15)
            ->withQueryString();

        return view('admin.clients.index', compact('items'));
    }

    public function create(): View
    {
        return view('admin.clients.form');
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->validateData($request);
        $data['slug'] = $this->uniqueSlug(Client::class, $data['name'], $request->input('slug'));
        $data['logo'] = $this->storeFile($request, 'logo', 'clients');

        Client::create($data);

        return redirect()->route('panel.clients.index')->with('success', 'Klien berhasil ditambahkan.');
    }

    public function edit(Client $client): View
    {
        return view('admin.clients.form', ['item' => $client]);
    }

    public function update(Request $request, Client $client): RedirectResponse
    {
        $data = $this->validateData($request);
        $data['slug'] = $this->uniqueSlug(Client::class, $data['name'], $request->input('slug'), $client->id);
        $data['logo'] = $this->storeFile($request, 'logo', 'clients', $client->logo);

        $client->update($data);

        return redirect()->route('panel.clients.index')->with('success', 'Klien berhasil diperbarui.');
    }

    public function destroy(Client $client): RedirectResponse
    {
        $client->delete();

        return redirect()->route('panel.clients.index')->with('success', 'Klien berhasil dihapus.');
    }

    /**
     * @return array<string, mixed>
     */
    private function validateData(Request $request): array
    {
        return $request->validate([
            'name' => ['required', 'string', 'max:150'],
            'slug' => ['nullable', 'string', 'max:170'],
            'category' => ['required', Rule::in(['militer', 'pemerintah', 'bumn', 'swasta'])],
            'website' => ['nullable', 'string', 'max:255'],
            'logo' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'is_active' => ['required', 'boolean'],
            'sort_order' => ['nullable', 'integer'],
        ]);
    }
}
