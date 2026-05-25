<?php

use App\Http\Controllers\Admin\AdminAuthController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\ArticleController;
use App\Http\Controllers\Admin\EventController;
use App\Http\Controllers\Admin\HomeContentController;
use App\Http\Controllers\Admin\InstitutionController;
use App\Http\Controllers\Admin\MessageAdminController;
use App\Http\Controllers\MosqueMessageController;
use App\Http\Controllers\PublicContentController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Schema;

Route::get('/', function () {
    $hasContentTables = Schema::hasTable('events')
        && Schema::hasTable('articles')
        && Schema::hasTable('institutions');

    return view('welcome', [
        'settings' => [
            'hero_eyebrow' => \App\Models\SiteSetting::get('hero_eyebrow', 'السلام عليكم ورحمة الله وبركاته'),
            'hero_title' => \App\Models\SiteSetting::get('hero_title', 'Masjid Al Ikhlas, ruang teduh untuk ibadah dan persaudaraan.'),
            'hero_text' => \App\Models\SiteSetting::get('hero_text', 'Tempat jamaah bertemu, belajar, berbagi, dan menguatkan hati. Website ini disiapkan agar informasi kegiatan masjid terasa hidup, mudah diperbarui admin, dan nyaman diakses semua warga.'),
            'hero_image' => \App\Models\SiteSetting::get('hero_image'),
            'infaq_qris_image' => \App\Models\SiteSetting::get('infaq_qris_image'),
            'contact_phone' => \App\Models\SiteSetting::get('contact_phone', '+62 812-3456-7890'),
            'contact_email' => \App\Models\SiteSetting::get('contact_email', 'info@masjidalikhlas.test'),
            'contact_address' => \App\Models\SiteSetting::get('contact_address', 'Jl. Masjid Al Ikhlas, Indonesia'),
        ],
        'homeEvents' => $hasContentTables ? \App\Models\Event::with('category')->where('is_published', true)->latest()->take(3)->get() : collect(),
        'homeArticles' => $hasContentTables ? \App\Models\Article::with('category')->where('is_published', true)->latest('published_at')->take(2)->get() : collect(),
        'homeInstitutions' => $hasContentTables ? \App\Models\Institution::where('is_active', true)->latest()->take(4)->get() : collect(),
    ]);
});

Route::view('/aduan', 'complaint')->name('complaints.create');
Route::post('/pesan/{type}', [MosqueMessageController::class, 'store'])->name('messages.store');

Route::get('/event', [PublicContentController::class, 'events'])->name('events.index');
Route::get('/event/{event:slug}', [PublicContentController::class, 'event'])->name('events.show');
Route::get('/artikel', [PublicContentController::class, 'articles'])->name('articles.index');
Route::get('/artikel/{article:slug}', [PublicContentController::class, 'article'])->name('articles.show');

Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/login', [AdminAuthController::class, 'login'])->name('login');
    Route::post('/login', [AdminAuthController::class, 'authenticate'])->name('authenticate');

    Route::middleware('admin')->group(function () {
        Route::post('/logout', [AdminAuthController::class, 'logout'])->name('logout');
        Route::get('/', AdminDashboardController::class)->name('dashboard');
        Route::get('/home', [HomeContentController::class, 'edit'])->name('home.edit');
        Route::put('/home', [HomeContentController::class, 'update'])->name('home.update');
        Route::resource('events', EventController::class)->except('show');
        Route::resource('articles', ArticleController::class)->except('show');
        Route::resource('institutions', InstitutionController::class)->except('show');
        Route::get('/messages', [MessageAdminController::class, 'index'])->name('messages.index');
        Route::patch('/messages/{message}', [MessageAdminController::class, 'update'])->name('messages.update');
        Route::delete('/messages/{message}', [MessageAdminController::class, 'destroy'])->name('messages.destroy');
    });
});
