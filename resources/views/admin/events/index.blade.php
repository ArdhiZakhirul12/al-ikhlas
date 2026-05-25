@extends('admin.layout')

@section('title', 'Kelola Event')

@section('content')
    <div class="admin-list-head">
        <div class="admin-page-heading">
            <p class="eyebrow">Event</p>
            <h1>Kelola acara rutin dan kegiatan masjid.</h1>
        </div>
        <a class="primary-button" href="{{ route('admin.events.create') }}">Tambah Event</a>
    </div>

    <div class="admin-table-wrap">
        <table class="admin-table">
            <thead>
                <tr>
                    <th>Judul</th>
                    <th>Kategori</th>
                    <th>Status</th>
                    <th>Diperbarui</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($events as $event)
                    <tr>
                        <td>{{ $event->title }}</td>
                        <td>{{ $event->category?->name ?? '-' }}</td>
                        <td>{{ $event->is_published ? 'Rilis' : 'Draft' }}</td>
                        <td>{{ $event->updated_at->format('d M Y') }}</td>
                        <td class="admin-actions">
                            <a href="{{ route('events.show', $event) }}" target="_blank">Lihat</a>
                            <a href="{{ route('admin.events.edit', $event) }}">Edit</a>
                            <form method="POST" action="{{ route('admin.events.destroy', $event) }}">
                                @csrf
                                @method('DELETE')
                                <button type="submit">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="5">Belum ada event.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{ $events->links() }}
@endsection
