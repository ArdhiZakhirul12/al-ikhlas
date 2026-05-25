<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MosqueMessage;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class MessageAdminController extends Controller
{
    public function index(Request $request): View
    {
        $type = $request->query('type');

        return view('admin.messages.index', [
            'type' => $type,
            'messages' => MosqueMessage::when($type, fn ($query) => $query->where('type', $type))
                ->latest()
                ->paginate(15),
        ]);
    }

    public function update(Request $request, MosqueMessage $message): RedirectResponse
    {
        $validated = $request->validate([
            'status' => ['required', 'in:baru,diproses,selesai'],
        ]);

        $message->update($validated);

        return back()->with('status', 'Status pesan berhasil diperbarui.');
    }

    public function destroy(MosqueMessage $message): RedirectResponse
    {
        $message->delete();

        return back()->with('status', 'Pesan berhasil dihapus.');
    }
}
