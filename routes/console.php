<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule; // <--- 1. Tambahkan baris ini (PENTING)

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

// === 2. Tambahkan Jadwal Sitemap di Sini ===
Schedule::command('sitemap:generate')
        ->hourly()                 // Jalankan setiap jam (bisa diganti ->daily() kalau mau harian)
        ->withoutOverlapping();    // Mencegah perintah tumpuk jika server sedang lambat