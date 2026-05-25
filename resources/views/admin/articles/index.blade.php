@extends('admin.layout')

@section('title', 'Kelola Artikel')

@section('content')
    <div class="admin-list-head">
        <div class="admin-page-heading">
            <p class="eyebrow">Artikel</p>
            <h1>Kelola berita, tulisan, dan pengumuman.</h1>
        </div>
        <a class="primary-button" href="{{ route('admin.articles.create') }}">Tambah Artikel</a>
    </div>

    <div class="admin-table-wrap">
        <table class="admin-table">
            <thead>
                <tr>
                    <th>Judul</th>
                    <th>Kategori</th>
                    <th>Status</th>
                    <th>Tanggal</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($articles as $article)
                    <tr>
                        <td>{{ $article->title }}</td>
                        <td>{{ $article->category?->name ?? '-' }}</td>
                        <td>{{ $article->is_published ? 'Rilis' : 'Draft' }}</td>
                        <td>{{ optional($article->published_at)->format('d M Y') ?? '-' }}</td>
                        <td class="admin-actions">
                            <a href="{{ route('articles.show', $article) }}" target="_blank">Lihat</a>
                            <a href="{{ route('admin.articles.edit', $article) }}">Edit</a>
                            <form method="POST" action="{{ route('admin.articles.destroy', $article) }}">
                                @csrf
                                @method('DELETE')
                                <button type="submit">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="5">Belum ada artikel.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{ $articles->links() }}
@endsection
