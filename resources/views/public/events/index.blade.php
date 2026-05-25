@extends('public.layout')

@section('title', 'Event Masjid Al Ikhlas')

@section('content')
    <main class="content-page">
        <section class="content-hero">
            <p class="eyebrow">Event Masjid</p>
            <h1>Agenda rutin dan kegiatan yang menghidupkan jamaah.</h1>
        </section>
        <section class="public-card-grid">
            @forelse ($events as $event)
                <a class="public-event-card" href="{{ route('events.show', $event) }}">
                    <img src="{{ $event->image_path ? asset($event->image_path) : 'https://images.unsplash.com/photo-1564769625905-50e93615e769?auto=format&fit=crop&w=900&q=80' }}" alt="{{ $event->title }}">
                    <div>
                        <span>{{ $event->category?->name ?? 'Event' }}</span>
                        <h2>{{ $event->title }}</h2>
                        <p>{{ $event->excerpt }}</p>
                    </div>
                </a>
            @empty
                <div class="admin-empty">Belum ada event yang dirilis.</div>
            @endforelse
        </section>
        {{ $events->links() }}
    </main>
@endsection
