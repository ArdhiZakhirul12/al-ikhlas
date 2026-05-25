<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\Concerns\UploadsFiles;
use App\Http\Controllers\Controller;
use App\Models\SiteSetting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class HomeContentController extends Controller
{
    use UploadsFiles;

    public function edit(): View
    {
        return view('admin.home.edit', [
            'settings' => [
                'hero_eyebrow' => SiteSetting::get('hero_eyebrow', 'السلام عليكم ورحمة الله وبركاته'),
                'hero_title' => SiteSetting::get('hero_title', 'Masjid Al Ikhlas, ruang teduh untuk ibadah dan persaudaraan.'),
                'hero_text' => SiteSetting::get('hero_text', 'Tempat jamaah bertemu, belajar, berbagi, dan menguatkan hati.'),
                'hero_image' => SiteSetting::get('hero_image'),
                'infaq_qris_image' => SiteSetting::get('infaq_qris_image'),
                'contact_phone' => SiteSetting::get('contact_phone', '+62 812-3456-7890'),
                'contact_email' => SiteSetting::get('contact_email', 'info@masjidalikhlas.test'),
                'contact_address' => SiteSetting::get('contact_address', 'Jl. Masjid Al Ikhlas, Indonesia'),
            ],
        ]);
    }

    public function update(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'hero_eyebrow' => ['nullable', 'string', 'max:180'],
            'hero_title' => ['required', 'string', 'max:180'],
            'hero_text' => ['required', 'string', 'max:700'],
            'hero_image' => ['nullable', 'image', 'max:4096'],
            'infaq_qris_image' => ['nullable', 'image', 'max:4096'],
            'contact_phone' => ['nullable', 'string', 'max:80'],
            'contact_email' => ['nullable', 'email:rfc', 'max:160'],
            'contact_address' => ['nullable', 'string', 'max:220'],
        ]);

        foreach (['hero_eyebrow', 'hero_title', 'hero_text', 'contact_phone', 'contact_email', 'contact_address'] as $key) {
            SiteSetting::set($key, $validated[$key] ?? null);
        }

        if ($path = $this->uploadPublicFile($request->file('hero_image'), 'home')) {
            SiteSetting::set('hero_image', $path);
        }

        if ($path = $this->uploadPublicFile($request->file('infaq_qris_image'), 'infaq')) {
            SiteSetting::set('infaq_qris_image', $path);
        }

        return back()->with('status', 'Konten home berhasil diperbarui.');
    }
}
