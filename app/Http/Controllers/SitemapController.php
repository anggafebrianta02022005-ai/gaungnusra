<?php

namespace App\Http\Controllers;

use App\Models\News;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class SitemapController extends Controller
{
    public function index()
    {
        // 1. Ambil Berita yang SUDAH TAYANG (Published), urutkan dari yang terbaru
        $news = News::where('status', 'published')
                    ->latest()
                    ->get();

        // 2. Ambil Kategori aktif
        $categories = Category::where('is_active', true)->get();

        // 3. Render ke View khusus XML
        return response()->view('sitemap', [
            'news' => $news,
            'categories' => $categories,
        ])->header('Content-Type', 'text/xml'); // PENTING: Header ini bikin browser tahu ini XML
    }
}