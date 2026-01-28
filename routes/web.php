<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PageController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\EpaperController; // Tambahkan ini

// Route Search Berita
Route::get('/search/news', [HomeController::class, 'searchNews'])->name('search.news');

// Route Halaman Detail Berita
Route::get('/news/{slug}', [HomeController::class, 'show'])->name('news.show');

// Route Home
Route::get('/', [HomeController::class, 'index'])->name('home');

// Route Halaman Kategori
Route::get('/category/{slug}', [HomeController::class, 'category'])->name('category.show');

// Route Halaman Statis
Route::get('/tentang-kami', [PageController::class, 'about'])->name('pages.about');
Route::get('/pasang-iklan', [PageController::class, 'advertise'])->name('pages.advertise');

// --- FITUR KORAN CETAK (E-PAPER) ---

// 1. Route untuk Pengunjung (Download PDF)
Route::get('epaper/download/{epaper}', [EpaperController::class, 'download'])->name('epaper.download');

// 2. Route untuk Admin (Upload, Edit, Hapus)
// Catatan: Nanti sebaiknya ini dimasukkan ke dalam Middleware Auth (Login) biar aman
Route::resource('epapers', EpaperController::class);