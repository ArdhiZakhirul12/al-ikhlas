<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Aduan Jamaah - Masjid Al Ikhlas</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Aref+Ruqaa:wght@400;700&family=Noto+Naskh+Arabic:wght@500;700&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Signika:wght@400;500;600;700&display=swap" rel="stylesheet">
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @else
        <style>{!! file_get_contents(resource_path('css/app.css')) !!}</style>
    @endif
</head>
<body>
    <main class="complaint-page">
        <a class="back-link" href="/">Kembali ke Home</a>

        @if (session('status'))
            <div class="flash-message" role="status">{{ session('status') }}</div>
        @endif

        @if ($errors->any())
            <div class="flash-message flash-error" role="alert">
                {{ $errors->first() }}
            </div>
        @endif

        <section class="complaint-shell">
            <div class="complaint-copy" data-animate>
                <p class="eyebrow">Aduan Jamaah</p>
                <h1>Ruang aman untuk menyampaikan keluhan, masukan, dan laporan.</h1>
                <p>
                    Setiap aduan akan masuk ke data masjid agar bisa ditindaklanjuti pengurus. Untuk mencegah spam, pengirim yang sama hanya dapat mengirim 3 kali per hari dengan jeda 10 menit.
                </p>
            </div>

            <form class="contact-form complaint-form" method="POST" action="{{ route('messages.store', ['type' => 'complaint']) }}" data-animate>
                @csrf
                <label>
                    Nama
                    <input name="name" value="{{ old('name') }}" autocomplete="name" required>
                </label>
                <label>
                    Email
                    <input type="email" name="email" value="{{ old('email') }}" autocomplete="email" required>
                </label>
                <label>
                    Nomor WhatsApp
                    <input name="phone" value="{{ old('phone') }}" autocomplete="tel">
                </label>
                <label>
                    Kategori
                    <select name="subject" required>
                        <option value="">Pilih kategori</option>
                        <option value="Fasilitas" @selected(old('subject') === 'Fasilitas')>Fasilitas</option>
                        <option value="Kegiatan" @selected(old('subject') === 'Kegiatan')>Kegiatan</option>
                        <option value="Layanan Jamaah" @selected(old('subject') === 'Layanan Jamaah')>Layanan Jamaah</option>
                        <option value="Lainnya" @selected(old('subject') === 'Lainnya')>Lainnya</option>
                    </select>
                </label>
                <label class="full-field">
                    Isi Aduan
                    <textarea name="message" rows="7" required>{{ old('message') }}</textarea>
                </label>
                <button class="primary-button full-field" type="submit">Kirim Aduan</button>
            </form>
        </section>
    </main>
    @unless (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        <script>{!! file_get_contents(resource_path('js/app.js')) !!}</script>
    @endunless
</body>
</html>
