@extends('public.layout')

@section('title', $event->title.' - Event Masjid Al Ikhlas')

@section('content')
    <main class="detail-page">
        <article class="detail-article">
            <span class="detail-category">{{ $event->category?->name ?? 'Event' }}</span>
            <h1>{{ $event->title }}</h1>
            <p class="detail-excerpt">{{ $event->excerpt }}</p>
            <img class="detail-image" src="{{ $event->image_path ? asset($event->image_path) : 'https://images.unsplash.com/photo-1564769625905-50e93615e769?auto=format&fit=crop&w=1200&q=80' }}" alt="{{ $event->title }}">
            @if ($event->schedule)
                <div class="public-schedule">
                    @foreach ($event->schedule as $row)
                        <div @class(['schedule-header' => $loop->first])>
                            @foreach ($row as $cell)
                                <span>{{ $cell }}</span>
                            @endforeach
                        </div>
                    @endforeach
                </div>
            @endif
            <div class="detail-body">{!! nl2br(e($event->body)) !!}</div>
        </article>
    </main>
@endsection
