@extends('admin.layout')

@section('title', $event->exists ? 'Edit Event' : 'Tambah Event')

@section('content')
    <div class="admin-page-heading">
        <p class="eyebrow">Event</p>
        <h1>{{ $event->exists ? 'Edit event' : 'Tambah event baru' }}.</h1>
        <p>Jadwal bisa dibuat seperti tabel bebas: tambah baris dan kolom sesuai kebutuhan acara.</p>
    </div>

    <form class="admin-form" method="POST" action="{{ $event->exists ? route('admin.events.update', $event) : route('admin.events.store') }}" enctype="multipart/form-data">
        @csrf
        @if ($event->exists)
            @method('PUT')
        @endif

        <label>
            Judul event
            <input name="title" value="{{ old('title', $event->title) }}" required>
        </label>
        <label>
            Kategori
            <select name="category_id">
                <option value="">Tanpa kategori</option>
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}" @selected(old('category_id', $event->category_id) == $category->id)>{{ $category->name }}</option>
                @endforeach
            </select>
        </label>
        <label>
            Kategori baru
            <input name="new_category" value="{{ old('new_category') }}" placeholder="Misal: Jumatan, Kajian, Remaja">
        </label>
        <label>
            Tanggal mulai
            <input type="datetime-local" name="starts_at" value="{{ old('starts_at', optional($event->starts_at)->format('Y-m-d\\TH:i')) }}">
        </label>
        <label>
            Gambar event
            <input type="file" name="image" accept="image/*">
        </label>
        <label class="admin-check">
            <input type="checkbox" name="is_published" value="1" @checked(old('is_published', $event->is_published))>
            Rilis di website
        </label>

        @if ($event->image_path)
            <figure class="admin-current-image full-field">
                <img src="{{ asset($event->image_path) }}" alt="Gambar event saat ini">
                <figcaption>Gambar aktif</figcaption>
            </figure>
        @endif

        <label class="full-field">
            Ringkasan
            <textarea name="excerpt" rows="3">{{ old('excerpt', $event->excerpt) }}</textarea>
        </label>
        <label class="full-field">
            Isi teks event
            <textarea name="body" rows="8">{{ old('body', $event->body) }}</textarea>
        </label>

        <div class="schedule-editor full-field" data-schedule-editor>
            <div class="schedule-toolbar">
                <strong>Tabel jadwal</strong>
                <button type="button" data-add-row>Tambah Baris</button>
                <button type="button" data-add-col>Tambah Kolom</button>
                <button type="button" data-remove-row>Hapus Baris</button>
                <button type="button" data-remove-col>Hapus Kolom</button>
            </div>
            <div class="schedule-grid" data-schedule-grid></div>
            <input type="hidden" name="schedule" data-schedule-input value='@json(old('schedule') ? json_decode(old('schedule'), true) : $schedule)'>
        </div>

        <button class="primary-button full-field" type="submit">Simpan Event</button>
    </form>
@endsection
