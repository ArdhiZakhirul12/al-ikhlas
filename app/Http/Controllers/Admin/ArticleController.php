<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\Concerns\UploadsFiles;
use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Category;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class ArticleController extends Controller
{
    use UploadsFiles;

    public function index(): View
    {
        return view('admin.articles.index', [
            'articles' => Article::with('category')->latest()->paginate(12),
        ]);
    }

    public function create(): View
    {
        return view('admin.articles.form', [
            'article' => new Article(['is_published' => true, 'published_at' => now()]),
            'categories' => Category::where('type', 'article')->orderBy('name')->get(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        Article::create($this->validatedData($request));

        return redirect()->route('admin.articles.index')->with('status', 'Artikel berhasil dibuat.');
    }

    public function edit(Article $article): View
    {
        return view('admin.articles.form', [
            'article' => $article,
            'categories' => Category::where('type', 'article')->orderBy('name')->get(),
        ]);
    }

    public function update(Request $request, Article $article): RedirectResponse
    {
        $article->update($this->validatedData($request, $article));

        return redirect()->route('admin.articles.index')->with('status', 'Artikel berhasil diperbarui.');
    }

    public function destroy(Article $article): RedirectResponse
    {
        $article->delete();

        return back()->with('status', 'Artikel berhasil dihapus.');
    }

    private function validatedData(Request $request, ?Article $article = null): array
    {
        $validated = $request->validate([
            'category_id' => ['nullable', 'exists:categories,id'],
            'new_category' => ['nullable', 'string', 'max:80'],
            'title' => ['required', 'string', 'max:180'],
            'image' => ['nullable', 'image', 'max:4096'],
            'excerpt' => ['nullable', 'string', 'max:500'],
            'body' => ['nullable', 'string'],
            'published_at' => ['nullable', 'date'],
            'is_published' => ['nullable', 'boolean'],
        ]);

        if (! empty($validated['new_category'])) {
            $category = Category::firstOrCreate([
                'type' => 'article',
                'slug' => Str::slug($validated['new_category']),
            ], [
                'name' => $validated['new_category'],
            ]);
            $validated['category_id'] = $category->id;
        }

        $data = [
            'category_id' => $validated['category_id'] ?? null,
            'title' => $validated['title'],
            'slug' => $this->uniqueSlug($validated['title'], $article),
            'excerpt' => $validated['excerpt'] ?? null,
            'body' => $validated['body'] ?? null,
            'published_at' => $validated['published_at'] ?? null,
            'is_published' => (bool) ($validated['is_published'] ?? false),
        ];

        $data['image_path'] = $this->uploadPublicFile($request->file('image'), 'articles') ?: $article?->image_path;

        return $data;
    }

    private function uniqueSlug(string $title, ?Article $article = null): string
    {
        $base = Str::slug($title);
        $slug = $base;
        $counter = 2;

        while (Article::where('slug', $slug)->when($article, fn ($query) => $query->whereKeyNot($article->id))->exists()) {
            $slug = $base.'-'.$counter++;
        }

        return $slug;
    }
}
