<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Masjid Al Ikhlas - Rumah Ibadah dan Ruang Umat</title>
    <meta name="description" content="Profil Masjid Al Ikhlas, pusat ibadah, pendidikan, kegiatan sosial, dan silaturahmi jamaah.">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Aref+Ruqaa:wght@400;700&family=Noto+Naskh+Arabic:wght@500;700&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Signika:wght@400;500;600;700&display=swap" rel="stylesheet">

    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @else
        <style>{!! file_get_contents(resource_path('css/app.css')) !!}</style>
    @endif
</head>
<body class="antialiased">
    <div class="site-shell">
        <header class="nav-wrap" data-animate>
            <a class="brand" href="#home" aria-label="Masjid Al Ikhlas">
                <span class="brand-mark">ا</span>
                <span>
                    <strong>Masjid Al Ikhlas</strong>
                    <small>Ngibadah, Ngaji, Guyub</small>
                </span>
            </a>
            <nav class="main-nav" aria-label="Navigasi utama">
                <a href="#home">Home</a>
                <a href="{{ route('events.index') }}">Event</a>
                <a href="{{ route('articles.index') }}">Artikel</a>
                <a href="#lembaga">Lembaga</a>
                <a href="#kontak">Kontak</a>
                <a href="/aduan">Aduan</a>
            </nav>
            <button class="nav-action" type="button" data-open-infaq>INFAQ</button>
        </header>

        <main id="home">
            @if (session('status'))
                <div class="flash-message" role="status">{{ session('status') }}</div>
            @endif

            @if ($errors->any())
                <div class="flash-message flash-error" role="alert">
                    {{ $errors->first() }}
                </div>
            @endif

            <section class="hero-section">
                <div class="hero-copy" data-animate>
                    <p class="eyebrow">{{ $settings['hero_eyebrow'] }}</p>
                    <h1>{{ $settings['hero_title'] }}</h1>
                    <p class="hero-lead">
                        {{ $settings['hero_text'] }}
                    </p>
                    <div class="hero-actions">
                        <a class="primary-button" href="#agenda">Lihat Kegiatan</a>
                        <a class="secondary-button" href="#street-view">Lihat Lokasi</a>
                    </div>
                </div>

                <div class="hero-visual" data-animate>
                    <img src="{{ $settings['hero_image'] ? asset($settings['hero_image']) : 'https://images.unsplash.com/photo-1519817650390-64a93db51149?auto=format&fit=crop&w=1200&q=85' }}" alt="Suasana Masjid Al Ikhlas">
                </div>
            </section>

            <section class="stats-band" aria-label="Ringkasan masjid" data-animate>
                <div>
                    <strong>5x</strong>
                    <span>Salat berjamaah setiap hari</span>
                </div>
                <div>
                    <strong>12+</strong>
                    <span>Program kajian dan sosial</span>
                </div>
                <div>
                    <strong>24 Jam</strong>
                    <span>Informasi jamaah tersambung</span>
                </div>
                <div>
                    <strong>Guyub</strong>
                    <span>Ruang silaturahmi warga</span>
                </div>
            </section>

            <section class="section-grid intro-section">
                <div class="section-heading" data-animate>
                    <p class="eyebrow">Profil Masjid</p>
                    <h2>Masjid yang ramah untuk ibadah, keluarga, pemuda, dan tetangga.</h2>
                </div>
                <div class="feature-grid">
                    <article class="feature-card" data-animate>
                        <span>01</span>
                        <h3>Ibadah Harian</h3>
                        <p>Informasi salat berjamaah, imam, muadzin, dan pengumuman rutin bisa ditampilkan dinamis dari admin.</p>
                    </article>
                    <article class="feature-card" data-animate>
                        <span>02</span>
                        <h3>Pendidikan</h3>
                        <p>TPA, tahsin, kajian keluarga, dan kelas remaja masjid mendapat ruang publikasi yang jelas.</p>
                    </article>
                    <article class="feature-card" data-animate>
                        <span>03</span>
                        <h3>Sosial Umat</h3>
                        <p>Program santunan, infak, gotong royong, dan layanan jamaah dapat ditampilkan dengan gaya modern.</p>
                    </article>
                </div>
            </section>

            <section id="agenda" class="agenda-section">
                <div class="section-heading center" data-animate>
                    <p class="eyebrow">Event Masjid</p>
                    <h2>Agenda yang menghidupkan hari-hari jamaah.</h2>
                </div>
                <div class="agenda-list">
                    @php
                        $fallbackEvents = collect([
                            (object) ['category' => (object) ['name' => 'Jumat'], 'title' => 'Kajian Ba’da Maghrib', 'excerpt' => 'Tema akhlak keluarga dan kehidupan bertetangga.', 'slug' => null],
                            (object) ['category' => (object) ['name' => 'Ahad'], 'title' => 'Subuh Berjamaah & Sarapan', 'excerpt' => 'Mengajak warga memulai pekan dengan ibadah dan silaturahmi.', 'slug' => null],
                            (object) ['category' => (object) ['name' => 'Rabu'], 'title' => 'TPA Al Ikhlas', 'excerpt' => 'Belajar Al-Qur’an untuk anak-anak dengan suasana hangat.', 'slug' => null],
                        ]);
                        $displayEvents = $homeEvents->isNotEmpty() ? $homeEvents : $fallbackEvents;
                    @endphp
                    @foreach ($displayEvents as $event)
                        <article class="agenda-card" data-animate>
                            <span>{{ $event->category?->name ?? 'Event' }}</span>
                            <h3>{{ $event->title }}</h3>
                            <p>{{ $event->excerpt }}</p>
                            @if ($event->slug)
                                <a href="{{ route('events.show', $event) }}">Detail Event</a>
                            @endif
                        </article>
                    @endforeach
                </div>
            </section>

            <section id="artikel" class="article-section">
                <div class="section-heading" data-animate>
                    <p class="eyebrow">Artikel Pilihan</p>
                    <h2>Ruang bacaan ringan untuk menambah ilmu dan meneduhkan hati.</h2>
                </div>
                <div class="article-grid">
                    @php
                        $fallbackArticles = collect([
                            (object) ['category' => (object) ['name' => 'Renungan'], 'title' => 'Menjaga Ikhlas dalam Amal yang Terlihat Orang', 'excerpt' => 'Naskah artikel nantinya bisa diganti admin untuk pengumuman, nasihat, atau cerita kegiatan.', 'slug' => null, 'image_path' => null],
                            (object) ['category' => (object) ['name' => 'Pendidikan'], 'title' => 'Membiasakan Anak Dekat dengan Masjid', 'excerpt' => 'Konten bisa dikembangkan menjadi blog masjid yang tertata dan mudah dicari.', 'slug' => null, 'image_path' => null],
                        ]);
                        $displayArticles = $homeArticles->isNotEmpty() ? $homeArticles : $fallbackArticles;
                    @endphp
                    @foreach ($displayArticles as $article)
                        <article class="article-card" data-animate>
                            <img src="{{ $article->image_path ? asset($article->image_path) : ($loop->first ? 'https://images.unsplash.com/photo-1609599006353-e629aaabfeae?auto=format&fit=crop&w=900&q=80' : 'https://images.unsplash.com/photo-1577896851231-70ef18881754?auto=format&fit=crop&w=900&q=80') }}" alt="{{ $article->title }}">
                            <div>
                                <span>{{ $article->category?->name ?? 'Artikel' }}</span>
                                <h3>{{ $article->title }}</h3>
                                <p>{{ $article->excerpt }}</p>
                                @if ($article->slug)
                                    <a href="{{ route('articles.show', $article) }}">Baca Artikel</a>
                                @endif
                            </div>
                        </article>
                    @endforeach
                </div>
            </section>

            <section id="lembaga" class="institution-section">
                <div class="section-heading center" data-animate>
                    <p class="eyebrow">Lembaga</p>
                    <h2>Satu masjid, banyak jalan kebaikan.</h2>
                </div>
                <div class="institution-grid">
                    @php
                        $fallbackInstitutions = collect([
                            (object) ['name' => 'Takmir Masjid', 'summary' => 'Deskripsi lembaga akan bisa diatur dari admin ketika modulnya dibuat.'],
                            (object) ['name' => 'Remaja Masjid', 'summary' => 'Deskripsi lembaga akan bisa diatur dari admin ketika modulnya dibuat.'],
                            (object) ['name' => 'TPA Al Ikhlas', 'summary' => 'Deskripsi lembaga akan bisa diatur dari admin ketika modulnya dibuat.'],
                            (object) ['name' => 'Lazis & Sosial', 'summary' => 'Deskripsi lembaga akan bisa diatur dari admin ketika modulnya dibuat.'],
                        ]);
                        $displayInstitutions = $homeInstitutions->isNotEmpty() ? $homeInstitutions : $fallbackInstitutions;
                    @endphp
                    @foreach ($displayInstitutions as $item)
                        <article class="institution-card" data-animate>
                            <span>✦</span>
                            <h3>{{ $item->name }}</h3>
                            <p>{{ $item->summary }}</p>
                        </article>
                    @endforeach
                </div>
            </section>

            <section id="street-view" class="map-section">
                <div class="map-copy" data-animate>
                    <p class="eyebrow">Lokasi Masjid</p>
                    <h2>Kunjungi Masjid Al Ikhlas melalui peta dan Street View.</h2>
                    <p>Tampilan jalan diarahkan ke koordinat dari tautan Google Maps masjid agar jamaah lebih mudah mengenali area sekitar sebelum berkunjung.</p>
                    <a class="secondary-button" href="https://maps.app.goo.gl/skM4M1QrAQQPSE2F6" target="_blank" rel="noreferrer">Buka di Google Maps</a>
                </div>
                <div class="map-embed-stack" data-animate>
                    <div class="map-frame street-frame">
                        <iframe
                            title="Street View sekitar Masjid Al Ikhlas"
                            src="https://www.google.com/maps?layer=c&cbll=-8.0026698,111.9097702&cbp=12,0,0,0,0&output=svembed"
                            loading="lazy"
                            referrerpolicy="no-referrer-when-downgrade">
                        </iframe>
                    </div>
                </div>
            </section>

            <section id="kontak" class="contact-section">
                <div class="contact-copy" data-animate>
                    <p class="eyebrow">Kontak</p>
                    <h2>Sampaikan pesan, kebutuhan, atau ajakan kerja sama.</h2>
                    <p>Form ini dibatasi agar tetap nyaman: satu orang hanya bisa mengirim 3 kali per hari dan perlu jeda 10 menit antar kiriman.</p>
                    <div class="contact-list">
                        <a href="tel:{{ $settings['contact_phone'] }}">{{ $settings['contact_phone'] }}</a>
                        <a href="mailto:{{ $settings['contact_email'] }}">{{ $settings['contact_email'] }}</a>
                        <span>{{ $settings['contact_address'] }}</span>
                    </div>
                </div>
                <form class="contact-form" method="POST" action="{{ route('messages.store', ['type' => 'contact']) }}" data-animate>
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
                        Subjek
                        <input name="subject" value="{{ old('subject') }}" required>
                    </label>
                    <label class="full-field">
                        Pesan
                        <textarea name="message" rows="5" required>{{ old('message') }}</textarea>
                    </label>
                    <button class="primary-button full-field" type="submit">Kirim Pesan</button>
                </form>
            </section>
        </main>

        <footer class="footer">
            <div class="footer-salam">
                <p>Salam hangat dari keluarga besar Masjid Al Ikhlas.</p>
                <strong>Semoga setiap langkah menuju masjid menjadi jalan pulang yang menenangkan.</strong>
            </div>
            <div class="footer-grid">
                <div>
                    <h2>Masjid Al Ikhlas</h2>
                    <p>Rumah ibadah, pusat belajar, dan ruang guyub jamaah.</p>
                </div>
                <div>
                    <h3>Kontak</h3>
                    <a href="tel:{{ $settings['contact_phone'] }}">{{ $settings['contact_phone'] }}</a>
                    <a href="mailto:{{ $settings['contact_email'] }}">{{ $settings['contact_email'] }}</a>
                </div>
                <div>
                    <h3>Sosial Media</h3>
                    <div class="social-links">
                        <a href="#" aria-label="Instagram">IG</a>
                        <a href="#" aria-label="YouTube">YT</a>
                        <a href="#" aria-label="Facebook">FB</a>
                        <a href="#" aria-label="WhatsApp">WA</a>
                    </div>
                </div>
            </div>
        </footer>
    </div>
    <div class="infaq-modal" data-infaq-modal hidden>
        <div class="infaq-backdrop" data-close-infaq></div>
        <div class="infaq-dialog" role="dialog" aria-modal="true" aria-label="QRIS Infaq Masjid Al Ikhlas">
            <button class="infaq-close" type="button" data-close-infaq>×</button>
            <p class="eyebrow">Infaq Masjid</p>
            <h2>Salurkan infaq terbaik Anda.</h2>
            @if ($settings['infaq_qris_image'])
                <img src="{{ asset($settings['infaq_qris_image']) }}" alt="QRIS infaq Masjid Al Ikhlas">
            @else
                <div class="qris-placeholder">QRIS belum diunggah dari admin.</div>
            @endif
        </div>
    </div>
    @unless (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        <script>{!! file_get_contents(resource_path('js/app.js')) !!}</script>
    @endunless
</body>
</html>
