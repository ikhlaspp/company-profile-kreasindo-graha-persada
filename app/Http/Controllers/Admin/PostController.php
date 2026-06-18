<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\Concerns\InteractsWithResource;
use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\PostCategory;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class PostController extends Controller
{
    use InteractsWithResource;

    public function index(Request $request): View
    {
        $items = Post::query()
            ->with(['category', 'author'])
            ->when($request->filled('q'), fn ($q) => $q->where('title', 'like', '%'.$request->string('q').'%'))
            ->when($request->filled('status'), fn ($q) => $q->where('status', $request->string('status')))
            ->latest('id')
            ->paginate(15)
            ->withQueryString();

        return view('admin.posts.index', compact('items'));
    }

    public function create(): View
    {
        return view('admin.posts.form', $this->formData());
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->validateData($request);
        $post = Post::create($this->mapData($request, $data));
        $this->syncTags($request, $post);

        return redirect()->route('panel.posts.index')->with('success', 'Berita berhasil disimpan.');
    }

    public function edit(Post $post): View
    {
        return view('admin.posts.form', ['item' => $post->load('tags')] + $this->formData());
    }

    public function update(Request $request, Post $post): RedirectResponse
    {
        $data = $this->validateData($request);
        $post->update($this->mapData($request, $data, $post));
        $this->syncTags($request, $post);

        return redirect()->route('panel.posts.index')->with('success', 'Berita berhasil diperbarui.');
    }

    public function destroy(Post $post): RedirectResponse
    {
        $post->delete();

        return redirect()->route('panel.posts.index')->with('success', 'Berita berhasil dihapus.');
    }

    /**
     * @return array<string, mixed>
     */
    private function formData(): array
    {
        return [
            'categories' => PostCategory::orderBy('name')->pluck('name', 'id')->all(),
            'authors' => User::orderBy('name')->pluck('name', 'id')->all(),
        ];
    }

    /**
     * @param  array<string, mixed>  $data
     * @return array<string, mixed>
     */
    private function mapData(Request $request, array $data, ?Post $post = null): array
    {
        return [
            'post_category_id' => $data['category_id'] ?? null,
            'user_id' => $data['author_id'] ?? null,
            'title' => $data['title'],
            'slug' => $this->uniqueSlug(Post::class, $data['title'], $request->input('slug'), $post?->id),
            'excerpt' => $data['excerpt'] ?? null,
            'content' => $data['content'] ?? null,
            'status' => $data['status'],
            'published_at' => $data['status'] === 'published'
                ? ($data['published_at'] ?? $post?->published_at ?? now())
                : ($data['published_at'] ?? null),
            'thumbnail' => $this->storeFile($request, 'thumbnail', 'posts', $post?->thumbnail),
        ];
    }

    private function syncTags(Request $request, Post $post): void
    {
        $names = collect($request->input('tags', []))
            ->filter()
            ->unique();

        $ids = $names->map(fn ($name) => Tag::firstOrCreate(
            ['slug' => Str::slug($name)],
            ['name' => $name],
        )->id);

        $post->tags()->sync($ids);
    }

    /**
     * @return array<string, mixed>
     */
    private function validateData(Request $request): array
    {
        return $request->validate([
            'category_id' => ['nullable', 'exists:post_categories,id'],
            'author_id' => ['nullable', 'exists:users,id'],
            'title' => ['required', 'string', 'max:200'],
            'slug' => ['nullable', 'string', 'max:220'],
            'excerpt' => ['nullable', 'string', 'max:500'],
            'content' => ['nullable', 'string'],
            'status' => ['required', Rule::in(['draft', 'published', 'archived'])],
            'published_at' => ['nullable', 'date'],
            'thumbnail' => ['nullable', 'image', 'max:5120'],
            'tags' => ['nullable', 'array'],
            'tags.*' => ['string', 'max:80'],
        ]);
    }
}
