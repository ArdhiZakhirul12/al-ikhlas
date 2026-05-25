@extends('admin.layout')

@section('title', 'Kelola Lembaga')

@section('content')
    <div class="admin-list-head">
        <div class="admin-page-heading">
            <p class="eyebrow">Lembaga</p>
            <h1>Kelola unit dan lembaga masjid.</h1>
        </div>
        <a class="primary-button" href="{{ route('admin.institutions.create') }}">Tambah Lembaga</a>
    </div>

    <div class="admin-table-wrap">
        <table class="admin-table">
            <thead>
                <tr>
                    <th>Nama</th>
                    <th>Ringkasan</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($institutions as $institution)
                    <tr>
                        <td>{{ $institution->name }}</td>
                        <td>{{ $institution->summary }}</td>
                        <td>{{ $institution->is_active ? 'Aktif' : 'Nonaktif' }}</td>
                        <td class="admin-actions">
                            <a href="{{ route('admin.institutions.edit', $institution) }}">Edit</a>
                            <form method="POST" action="{{ route('admin.institutions.destroy', $institution) }}">
                                @csrf
                                @method('DELETE')
                                <button type="submit">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="4">Belum ada lembaga.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection
