@extends('admin.layout')

@section('title', 'Dashboard Admin')

@section('content')
    <div class="admin-page-heading">
        <p class="eyebrow">Dashboard</p>
        <h1>Ruang kendali Masjid Al Ikhlas.</h1>
        <p>Semua konten utama website dapat diperbarui dari sini.</p>
    </div>

    <div class="admin-stat-grid">
        <a href="{{ route('admin.events.index') }}"><strong>{{ $eventCount }}</strong><span>Event</span></a>
        <a href="{{ route('admin.articles.index') }}"><strong>{{ $articleCount }}</strong><span>Artikel</span></a>
        <a href="{{ route('admin.institutions.index') }}"><strong>{{ $institutionCount }}</strong><span>Lembaga</span></a>
        <a href="{{ route('admin.messages.index') }}"><strong>{{ $newMessages }}</strong><span>Pesan Baru</span></a>
    </div>

    <div class="admin-quick-grid">
        <a class="admin-panel-link" href="{{ route('admin.home.edit') }}">Ubah hero home dan upload QRIS infaq</a>
        <a class="admin-panel-link" href="{{ route('admin.events.create') }}">Buat event dengan jadwal fleksibel</a>
        <a class="admin-panel-link" href="{{ route('admin.articles.create') }}">Tulis artikel atau berita baru</a>
        <a class="admin-panel-link" href="{{ route('admin.messages.index', ['type' => 'complaint']) }}">Lihat aduan jamaah</a>
    </div>
@endsection
