@extends('admin.layout')

@section('title', 'Pesan & Aduan')

@section('content')
    <div class="admin-page-heading">
        <p class="eyebrow">Pesan & Aduan</p>
        <h1>Kelola pesan jamaah dan aduan.</h1>
    </div>

    <div class="admin-filter">
        <a href="{{ route('admin.messages.index') }}" @class(['active' => ! $type])>Semua</a>
        <a href="{{ route('admin.messages.index', ['type' => 'contact']) }}" @class(['active' => $type === 'contact'])>Kontak</a>
        <a href="{{ route('admin.messages.index', ['type' => 'complaint']) }}" @class(['active' => $type === 'complaint'])>Aduan</a>
    </div>

    <div class="message-list">
        @forelse ($messages as $message)
            <article class="message-card">
                <div>
                    <span>{{ $message->type === 'complaint' ? 'Aduan' : 'Kontak' }} • {{ $message->status }}</span>
                    <h2>{{ $message->subject }}</h2>
                    <p>{{ $message->message }}</p>
                    <small>{{ $message->name }} • {{ $message->email }} • {{ $message->phone ?: '-' }} • {{ $message->created_at->format('d M Y H:i') }}</small>
                </div>
                <div class="admin-actions">
                    <form method="POST" action="{{ route('admin.messages.update', $message) }}">
                        @csrf
                        @method('PATCH')
                        <select name="status" onchange="this.form.submit()">
                            @foreach (['baru', 'diproses', 'selesai'] as $status)
                                <option value="{{ $status }}" @selected($message->status === $status)>{{ ucfirst($status) }}</option>
                            @endforeach
                        </select>
                    </form>
                    <form method="POST" action="{{ route('admin.messages.destroy', $message) }}">
                        @csrf
                        @method('DELETE')
                        <button type="submit">Hapus</button>
                    </form>
                </div>
            </article>
        @empty
            <div class="admin-empty">Belum ada pesan.</div>
        @endforelse
    </div>

    {{ $messages->links() }}
@endsection
