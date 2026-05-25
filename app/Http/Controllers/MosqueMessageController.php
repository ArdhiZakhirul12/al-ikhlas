<?php

namespace App\Http\Controllers;

use App\Models\MosqueMessage;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class MosqueMessageController extends Controller
{
    public function store(Request $request, string $type): RedirectResponse
    {
        abort_unless(in_array($type, ['contact', 'complaint'], true), 404);

        $subjectRules = ['required', 'string', 'max:160'];
        if ($type === 'complaint') {
            $subjectRules[] = Rule::in(['Fasilitas', 'Kegiatan', 'Layanan Jamaah', 'Lainnya']);
        }

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:120'],
            'email' => ['required', 'email:rfc', 'max:160'],
            'phone' => ['nullable', 'string', 'max:40'],
            'subject' => $subjectRules,
            'message' => ['required', 'string', 'min:10', 'max:3000'],
        ]);

        $identity = $this->identityKey($request, $type, $validated['email']);
        $historyKey = "{$identity}:history";
        $lastSentKey = "{$identity}:last_sent";
        $now = now();

        $lastSentAt = Cache::get($lastSentKey);
        if ($lastSentAt && $now->diffInSeconds(Carbon::parse($lastSentAt)) < 600) {
            $minutes = (int) ceil((600 - $now->diffInSeconds(Carbon::parse($lastSentAt))) / 60);
            throw ValidationException::withMessages([
                'message' => "Mohon tunggu sekitar {$minutes} menit sebelum mengirim lagi.",
            ]);
        }

        $history = collect(Cache::get($historyKey, []))
            ->filter(fn (string $sentAt): bool => $now->diffInHours(Carbon::parse($sentAt)) < 24)
            ->values()
            ->all();

        if (count($history) >= 3) {
            throw ValidationException::withMessages([
                'message' => 'Batas 3 kiriman dalam 24 jam untuk pengirim ini sudah tercapai.',
            ]);
        }

        MosqueMessage::create([
            ...$validated,
            'type' => $type,
            'ip_address' => $request->ip(),
            'user_agent' => Str::limit((string) $request->userAgent(), 500, ''),
        ]);

        $history[] = $now->toIso8601String();
        Cache::put($historyKey, $history, now()->addDay());
        Cache::put($lastSentKey, $now->toIso8601String(), now()->addMinutes(10));

        return back()->with('status', $type === 'complaint'
            ? 'Aduan berhasil dikirim. Terima kasih, insyaallah akan ditindaklanjuti pengurus.'
            : 'Pesan berhasil dikirim. Terima kasih sudah menghubungi Masjid Al Ikhlas.');
    }

    private function identityKey(Request $request, string $type, string $email): string
    {
        return 'mosque-message:'.hash('sha256', implode('|', [
            $type,
            Str::lower(trim($email)),
            $request->ip(),
        ]));
    }
}
