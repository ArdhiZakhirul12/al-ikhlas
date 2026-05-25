@extends('public.layout')

@section('title', $article->title.' - Artikel Masjid Al Ikhlas')

@section('content')
    <main class="detail-page">
        <article class="detail-article">
            <span class="detail-category">{{ $article->category?->name ?? 'Artikel' }}</span>
            <h1>{{ $article->title }}</h1>
            <p class="detail-excerpt">{{ $article->excerpt }}</p>
            <img class="detail-image" src="{{ $article->image_path ? asset($article->image_path) : 'https://images.unsplash.com/photo-1609599006353-e629aaabfeae?auto=format&fit=crop&w=1200&q=80' }}" alt="{{ $article->title }}">
            <div class="detail-body">{!! nl2br(e($article->body)) !!}</div>
        </article>
    </main>
@endsection
