<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Masjid Al Ikhlas')</title>
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
    <header class="nav-wrap public-subnav">
        <a class="brand" href="/">
            <span class="brand-mark">ا</span>
            <span><strong>Masjid Al Ikhlas</strong><small>Ngibadah, Ngaji, Guyub</small></span>
        </a>
        <nav class="main-nav">
            <a href="/">Home</a>
            <a href="{{ route('events.index') }}">Event</a>
            <a href="{{ route('articles.index') }}">Artikel</a>
            <a href="/aduan">Aduan</a>
        </nav>
    </header>
    @yield('content')
    @unless (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        <script>{!! file_get_contents(resource_path('js/app.js')) !!}</script>
    @endunless
</body>
</html>
