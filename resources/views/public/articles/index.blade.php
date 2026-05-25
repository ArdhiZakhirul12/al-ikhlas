@extends('public.layout')

@section('title', 'Artikel Masjid Al Ikhlas')

@section('content')
    <main class="content-page">
        <section class="content-hero">
            <p class="eyebrow">Artikel</p>
            <h1>Berita, tulisan, dan kabar baik dari Masjid Al Ikhlas.</h1>
        </section>
        <section class="public-card-grid">
            @forelse ($articles as $article)
                <a class="public-event-card article-link-card" href="{{ route('articles.show', $article) }}">
                    <img src="{{ $article->image_path ? asset($article->image_path) : 'https://images.unsplash.com/photo-1609599006353-e629aaabfeae?auto=format&fit=crop&w=900&q=80' }}" alt="{{ $article->title }}">
                    <div>
                        <span>{{ $article->category?->name ?? 'Artikel' }}</span>
                        <h2>{{ $article->title }}</h2>
                        <p>{{ $article->excerpt }}</p>
                    </div>
                </a>
            @empty
                <div class="admin-empty">Belum ada artikel yang dirilis.</div>
            @endforelse
        </section>
        {{ $articles->links() }}
    </main>
@endsection
