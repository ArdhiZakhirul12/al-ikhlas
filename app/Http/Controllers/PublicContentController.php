<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Event;
use Illuminate\View\View;

class PublicContentController extends Controller
{
    public function events(): View
    {
        return view('public.events.index', [
            'events' => Event::with('category')->where('is_published', true)->latest()->paginate(9),
        ]);
    }

    public function event(Event $event): View
    {
        abort_unless($event->is_published, 404);

        return view('public.events.show', compact('event'));
    }

    public function articles(): View
    {
        return view('public.articles.index', [
            'articles' => Article::with('category')->where('is_published', true)->latest('published_at')->paginate(9),
        ]);
    }

    public function article(Article $article): View
    {
        abort_unless($article->is_published, 404);

        return view('public.articles.show', compact('article'));
    }
}
