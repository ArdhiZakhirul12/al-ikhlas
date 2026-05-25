@extends('admin.layout')

@section('title', $article->exists ? 'Edit Artikel' : 'Tambah Artikel')

@section('content')
    <div class="admin-page-heading">
        <p class="eyebrow">Artikel</p>
        <h1>{{ $article->exists ? 'Edit artikel' : 'Tulis artikel baru' }}.</h1>
        <p>Gunakan untuk berita masjid, pengumuman, cerita kegiatan, atau tulisan ringan jamaah.</p>
    </div>

    <form class="admin-form" method="POST" action="{{ $article->exists ? route('admin.articles.update', $article) : route('admin.articles.store') }}" enctype="multipart/form-data">
        @csrf
        @if ($article->exists)
            @method('PUT')
        @endif

        <label>
            Judul artikel
            <input name="title" value="{{ old('title', $article->title) }}" required>
        </label>
        <label>
            Kategori
            <select name="category_id">
                <option value="">Tanpa kategori</option>
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}" @selected(old('category_id', $article->category_id) == $category->id)>{{ $category->name }}</option>
                @endforeach
            </select>
        </label>
        <label>
            Kategori baru
            <input name="new_category" value="{{ old('new_category') }}" placeholder="Misal: Berita, Renungan, Pendidikan">
        </label>
        <label>
            Tanggal publikasi
            <input type="datetime-local" name="published_at" value="{{ old('published_at', optional($article->published_at)->format('Y-m-d\\TH:i')) }}">
        </label>
        <label>
            Gambar artikel
            <input type="file" name="image" accept="image/*">
        </label>
        <label class="admin-check">
            <input type="checkbox" name="is_published" value="1" @checked(old('is_published', $article->is_published))>
            Rilis di website
        </label>

        @if ($article->image_path)
            <figure class="admin-current-image full-field">
                <img src="{{ asset($article->image_path) }}" alt="Gambar artikel saat ini">
                <figcaption>Gambar aktif</figcaption>
            </figure>
        @endif

        <label class="full-field">
            Ringkasan
            <textarea name="excerpt" rows="3">{{ old('excerpt', $article->excerpt) }}</textarea>
        </label>
        <label class="full-field">
            Isi artikel
            <textarea name="body" rows="12">{{ old('body', $article->body) }}</textarea>
        </label>

        <button class="primary-button full-field" type="submit">Simpan Artikel</button>
    </form>
@endsection
