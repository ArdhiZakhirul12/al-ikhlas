@extends('admin.layout')

@section('title', 'Kelola Home & QRIS')

@section('content')
    <div class="admin-page-heading">
        <p class="eyebrow">Home & Infaq</p>
        <h1>Atur tampilan atas home dan QRIS infaq.</h1>
        <p>Gambar QRIS akan muncul dalam popup ketika tombol INFAQ di header website diklik.</p>
    </div>

    <form class="admin-form" method="POST" action="{{ route('admin.home.update') }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <label>
            Salam kecil di hero
            <input name="hero_eyebrow" value="{{ old('hero_eyebrow', $settings['hero_eyebrow']) }}">
        </label>
        <label>
            Judul hero
            <input name="hero_title" value="{{ old('hero_title', $settings['hero_title']) }}" required>
        </label>
        <label class="full-field">
            Teks hero
            <textarea name="hero_text" rows="4" required>{{ old('hero_text', $settings['hero_text']) }}</textarea>
        </label>
        <label>
            Gambar hero
            <input type="file" name="hero_image" accept="image/*">
        </label>
        <label>
            Gambar QRIS infaq
            <input type="file" name="infaq_qris_image" accept="image/*">
        </label>

        <div class="admin-preview-row full-field">
            @if ($settings['hero_image'])
                <figure>
                    <img src="{{ asset($settings['hero_image']) }}" alt="Gambar hero saat ini">
                    <figcaption>Gambar hero aktif</figcaption>
                </figure>
            @endif
            @if ($settings['infaq_qris_image'])
                <figure>
                    <img src="{{ asset($settings['infaq_qris_image']) }}" alt="QRIS infaq saat ini">
                    <figcaption>QRIS infaq aktif</figcaption>
                </figure>
            @endif
        </div>

        <label>
            Nomor kontak
            <input name="contact_phone" value="{{ old('contact_phone', $settings['contact_phone']) }}">
        </label>
        <label>
            Email kontak
            <input type="email" name="contact_email" value="{{ old('contact_email', $settings['contact_email']) }}">
        </label>
        <label class="full-field">
            Alamat
            <input name="contact_address" value="{{ old('contact_address', $settings['contact_address']) }}">
        </label>

        <button class="primary-button full-field" type="submit">Simpan Konten Home</button>
    </form>
@endsection
