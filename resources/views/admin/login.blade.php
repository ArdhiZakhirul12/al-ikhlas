<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login Admin - Masjid Al Ikhlas</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Aref+Ruqaa:wght@400;700&family=Plus+Jakarta+Sans:wght@400;600;700;800&family=Signika:wght@500;700&display=swap" rel="stylesheet">
    <style>{!! file_get_contents(resource_path('css/app.css')) !!}</style>
</head>
<body>
    <main class="admin-login-page">
        <form class="admin-login-card" method="POST" action="{{ route('admin.authenticate') }}">
            @csrf
            <p class="eyebrow">لوحة الإدارة</p>
            <h1>Masuk Admin</h1>
            <p>Kelola event, artikel, lembaga, konten home, QRIS infaq, pesan, dan aduan jamaah.</p>
            @if ($errors->any())
                <div class="admin-alert admin-alert-error">{{ $errors->first() }}</div>
            @endif
            <label>
                Password Admin
                <input type="password" name="password" required autofocus>
            </label>
            <button class="primary-button" type="submit">Masuk</button>
            <small>Password awal: admin12345. Ganti lewat ENV `ADMIN_PASSWORD` saat produksi.</small>
        </form>
    </main>
</body>
</html>
