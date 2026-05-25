<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Admin Masjid Al Ikhlas')</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Aref+Ruqaa:wght@400;700&family=Noto+Naskh+Arabic:wght@500;700&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Signika:wght@400;500;600;700&display=swap" rel="stylesheet">
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @else
        <style>{!! file_get_contents(resource_path('css/app.css')) !!}</style>
    @endif
</head>
<body class="admin-body">
    <div class="admin-shell">
        <aside class="admin-sidebar">
            <a class="admin-brand" href="{{ route('admin.dashboard') }}">
                <span class="brand-mark">ا</span>
                <strong>Admin Al Ikhlas</strong>
            </a>
            <nav>
                <a href="{{ route('admin.dashboard') }}">Dashboard</a>
                <a href="{{ route('admin.home.edit') }}">Home & QRIS</a>
                <a href="{{ route('admin.events.index') }}">Event</a>
                <a href="{{ route('admin.articles.index') }}">Artikel</a>
                <a href="{{ route('admin.institutions.index') }}">Lembaga</a>
                <a href="{{ route('admin.messages.index') }}">Pesan & Aduan</a>
                <a href="/" target="_blank">Lihat Website</a>
            </nav>
            <form method="POST" action="{{ route('admin.logout') }}">
                @csrf
                <button type="submit">Keluar</button>
            </form>
        </aside>

        <main class="admin-main">
            @if (session('status'))
                <div class="admin-alert">{{ session('status') }}</div>
            @endif

            @if ($errors->any())
                <div class="admin-alert admin-alert-error">{{ $errors->first() }}</div>
            @endif

            @yield('content')
        </main>
    </div>
    @unless (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        <script>{!! file_get_contents(resource_path('js/app.js')) !!}</script>
    @endunless
    @stack('scripts')
</body>
</html>
