<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PageController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\EpaperController;
use App\Http\Controllers\SitemapController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// === ROUTE PENCARIAN (AJAX) ===
Route::get('/search/news', [HomeController::class, 'searchNews'])->name('search.news');

// === ROUTE HALAMAN UTAMA ===
Route::get('/', [HomeController::class, 'index'])->name('home');

// === ROUTE KATEGORI BERITA ===
Route::get('/category/{slug}', [HomeController::class, 'category'])->name('category.show');

// === ROUTE DETAIL BERITA ===
// Pastikan ini ditaruh agak bawah agar tidak bentrok dengan halaman statis lain
Route::get('/news/{slug}', [HomeController::class, 'show'])->name('news.show');

// === ROUTE HALAMAN STATIS ===
Route::get('/tentang-kami', [PageController::class, 'about'])->name('pages.about');
Route::get('/pasang-iklan', [PageController::class, 'advertise'])->name('pages.advertise');
Route::get('/media-group', [HomeController::class, 'mediaGroup'])->name('pages.media-group');

// === ROUTE SITEMAP (SEO) ===
Route::get('/sitemap.xml', [SitemapController::class, 'index']);

// === FITUR KORAN CETAK (E-PAPER) ===
// 1. Download E-Paper Terbaru
Route::get('/epaper/terbaru', [EpaperController::class, 'downloadLatest'])->name('epaper.latest');

// 2. Download Spesifik
Route::get('epaper/download/{epaper}', [EpaperController::class, 'download'])->name('epaper.download');

// 3. Resource Admin (Sebaiknya dilindungi Middleware Auth nanti)
Route::resource('epapers', EpaperController::class);