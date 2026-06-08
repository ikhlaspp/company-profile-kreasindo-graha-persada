<?php

namespace Database\Seeders;

use App\Models\Post;
use App\Models\PostCategory;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class PostSeeder extends Seeder
{
    public function run(): void
    {
        $categories = collect([
            'Berita Perusahaan',
            'Teknologi',
            'Proyek',
            'Tips & Insight',
        ])->map(fn (string $name) => PostCategory::updateOrCreate(
            ['slug' => Str::slug($name)],
            ['name' => $name, 'description' => "Kategori {$name}"],
        ));

        $tags = collect([
            'IT', 'Interior', 'Konstruksi', 'Inovasi', 'Pemerintah', 'BUMN',
        ])->map(fn (string $name) => Tag::updateOrCreate(
            ['slug' => Str::slug($name)],
            ['name' => $name],
        ));

        $author = User::where('role', 'editor')->first() ?? User::first();

        for ($i = 1; $i <= 10; $i++) {
            $title = ucfirst(fake()->words(6, true))." #{$i}";
            $post = Post::updateOrCreate(
                ['slug' => Str::slug($title)],
                [
                    'post_category_id' => $categories->random()->id,
                    'user_id' => $author?->id,
                    'title' => $title,
                    'excerpt' => fake()->sentence(15),
                    'content' => fake()->paragraphs(6, true),
                    'status' => 'published',
                    'published_at' => fake()->dateTimeBetween('-1 year', 'now'),
                    'views_count' => fake()->numberBetween(0, 2000),
                ],
            );

            $post->tags()->sync($tags->random(rand(1, 3))->pluck('id')->all());
        }
    }
}
