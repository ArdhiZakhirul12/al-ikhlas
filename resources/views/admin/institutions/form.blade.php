@extends('admin.layout')

@section('title', $institution->exists ? 'Edit Lembaga' : 'Tambah Lembaga')

@section('content')
    <div class="admin-page-heading">
        <p class="eyebrow">Lembaga</p>
        <h1>{{ $institution->exists ? 'Edit lembaga' : 'Tambah lembaga baru' }}.</h1>
    </div>

    <form class="admin-form" method="POST" action="{{ $institution->exists ? route('admin.institutions.update', $institution) : route('admin.institutions.store') }}" enctype="multipart/form-data">
        @csrf
        @if ($institution->exists)
            @method('PUT')
        @endif

        <label>
            Nama lembaga
            <input name="name" value="{{ old('name', $institution->name) }}" required>
        </label>
        <label>
            Gambar
            <input type="file" name="image" accept="image/*">
        </label>
        <label class="admin-check">
            <input type="checkbox" name="is_active" value="1" @checked(old('is_active', $institution->is_active))>
            Tampilkan di website
        </label>

        @if ($institution->image_path)
            <figure class="admin-current-image full-field">
                <img src="{{ asset($institution->image_path) }}" alt="Gambar lembaga saat ini">
                <figcaption>Gambar aktif</figcaption>
            </figure>
        @endif

        <label class="full-field">
            Ringkasan
            <textarea name="summary" rows="3">{{ old('summary', $institution->summary) }}</textarea>
        </label>
        <label class="full-field">
            Deskripsi
            <textarea name="description" rows="8">{{ old('description', $institution->description) }}</textarea>
        </label>

        <button class="primary-button full-field" type="submit">Simpan Lembaga</button>
    </form>
@endsection
