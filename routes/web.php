<?php
use App\Http\Controllers\PageController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController; // PENTING: Panggil Controller-nya
Route::get('/search/news', [HomeController::class, 'searchNews'])->name('search.news');
// Route untuk Halaman Detail Berita
Route::get('/news/{slug}', [App\Http\Controllers\HomeController::class, 'show'])->name('news.show');
Route::get('/', [HomeController::class, 'index'])->name('home');
// Route Halaman Kategori
Route::get('/category/{slug}', [App\Http\Controllers\HomeController::class, 'category'])->name('category.show');Route::get('/tentang-kami', [PageController::class, 'about'])->name('pages.about');
Route::get('/pasang-iklan', [PageController::class, 'advertise'])->name('pages.advertise');