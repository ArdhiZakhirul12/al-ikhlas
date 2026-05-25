<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\Concerns\UploadsFiles;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Event;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class EventController extends Controller
{
    use UploadsFiles;

    public function index(): View
    {
        return view('admin.events.index', [
            'events' => Event::with('category')->latest()->paginate(12),
        ]);
    }

    public function create(): View
    {
        return view('admin.events.form', [
            'event' => new Event(['is_published' => true]),
            'categories' => Category::where('type', 'event')->orderBy('name')->get(),
            'schedule' => [['Hari', 'Waktu', 'Kegiatan'], ['Jumat', '11.30 - selesai', 'Salat Jumat']],
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        Event::create($this->validatedData($request));

        return redirect()->route('admin.events.index')->with('status', 'Event berhasil dibuat.');
    }

    public function edit(Event $event): View
    {
        return view('admin.events.form', [
            'event' => $event,
            'categories' => Category::where('type', 'event')->orderBy('name')->get(),
            'schedule' => $event->schedule ?: [['Hari', 'Waktu', 'Kegiatan']],
        ]);
    }

    public function update(Request $request, Event $event): RedirectResponse
    {
        $event->update($this->validatedData($request, $event));

        return redirect()->route('admin.events.index')->with('status', 'Event berhasil diperbarui.');
    }

    public function destroy(Event $event): RedirectResponse
    {
        $event->delete();

        return back()->with('status', 'Event berhasil dihapus.');
    }

    private function validatedData(Request $request, ?Event $event = null): array
    {
        $validated = $request->validate([
            'category_id' => ['nullable', 'exists:categories,id'],
            'new_category' => ['nullable', 'string', 'max:80'],
            'title' => ['required', 'string', 'max:180'],
            'image' => ['nullable', 'image', 'max:4096'],
            'excerpt' => ['nullable', 'string', 'max:500'],
            'body' => ['nullable', 'string'],
            'schedule' => ['nullable', 'json'],
            'starts_at' => ['nullable', 'date'],
            'is_published' => ['nullable', 'boolean'],
        ]);

        if (! empty($validated['new_category'])) {
            $category = Category::firstOrCreate([
                'type' => 'event',
                'slug' => Str::slug($validated['new_category']),
            ], [
                'name' => $validated['new_category'],
            ]);
            $validated['category_id'] = $category->id;
        }

        $data = [
            'category_id' => $validated['category_id'] ?? null,
            'title' => $validated['title'],
            'slug' => $this->uniqueSlug($validated['title'], $event),
            'excerpt' => $validated['excerpt'] ?? null,
            'body' => $validated['body'] ?? null,
            'schedule' => json_decode($validated['schedule'] ?? '[]', true) ?: null,
            'starts_at' => $validated['starts_at'] ?? null,
            'is_published' => (bool) ($validated['is_published'] ?? false),
        ];

        $data['image_path'] = $this->uploadPublicFile($request->file('image'), 'events') ?: $event?->image_path;

        return $data;
    }

    private function uniqueSlug(string $title, ?Event $event = null): string
    {
        $base = Str::slug($title);
        $slug = $base;
        $counter = 2;

        while (Event::where('slug', $slug)->when($event, fn ($query) => $query->whereKeyNot($event->id))->exists()) {
            $slug = $base.'-'.$counter++;
        }

        return $slug;
    }
}
