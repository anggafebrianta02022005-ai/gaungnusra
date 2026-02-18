<?php

namespace App\Http\Controllers;

use App\Models\Ad;
use App\Models\Category;
use App\Models\CompanyProfile;
use App\Models\News;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Jenssegers\Agent\Agent;

class HomeController extends Controller
{
    /**
     * Menampilkan Halaman Utama (Home)
     */
    public function index(Request $request)
    {
        $agent = new Agent();

        // 1. QUERY BERITA (LOAD MORE)
        $latestNews = News::with(['categories', 'author'])
            ->where('status', 'published')
            ->orderByRaw('pin_order IS NULL asc')
            ->orderBy('pin_order', 'asc')
            ->orderBy('id', 'desc')
            ->paginate(5);

        // 2. LOGIKA AJAX (LOAD MORE)
        if ($request->ajax()) {
            if ($agent->isMobile()) {
                return view('partials.mobile-news-list', compact('latestNews'))->render();
            }
            return view('partials.news-list', compact('latestNews'))->render();
        }

        // 3. DATA UMUM
        $company = CompanyProfile::first();
        $categories = Category::where('is_active', true)->take(7)->get();
        $headerAd = Ad::where('position', 'header_top')->where('is_active', true)->latest()->first();
        
        // Mengambil Iklan Sidebar (Logic 5 Slot untuk Mobile, atau Random untuk Desktop)
        // Jika Anda sudah migrasi 5 slot, pakai logika keyBy('slot_number') di sini.
        // Untuk saat ini saya pakai random dulu sesuai kode awal agar tidak error.
        $sidebarAd = Ad::where('position', 'sidebar_right')->where('is_active', true)->inRandomOrder()->first();

        // 4. TRENDING
        $sidebarNews = News::where('status', 'published')
            ->orderBy('views_count', 'desc')
            ->take(6)
            ->get();

        // 5. RENDER VIEW
        if ($agent->isMobile()) {
            return view('mobile.home', compact(
                'company', 'categories', 'headerAd', 'sidebarAd', 'latestNews', 'sidebarNews'
            ));
        }

        return view('home', compact(
            'company', 'categories', 'headerAd', 'sidebarAd', 'latestNews', 'sidebarNews'
        ));
    }

    /**
     * Menampilkan Halaman Kategori
     */
    public function category(Request $request, $slug)
    {
        $agent = new Agent();
        $category = Category::where('slug', $slug)->where('is_active', true)->firstOrFail();

        $news = $category->news()
            ->with(['author', 'categories'])
            ->where('status', 'published')
            ->orderByRaw('pin_order IS NULL asc')
            ->orderBy('pin_order', 'asc')
            ->orderBy('news.id', 'desc')
            ->paginate(10);

        if ($request->ajax()) {
            if ($agent->isMobile()) {
                return view('partials.mobile-news-list', ['latestNews' => $news])->render();
            }
            return view('partials.news-list', ['latestNews' => $news])->render();
        }

        $company = CompanyProfile::first();
        $categories = Category::where('is_active', true)->take(7)->get();
        $headerAd = Ad::where('position', 'header_top')->where('is_active', true)->latest()->first();
        $sidebarAd = Ad::where('position', 'sidebar_right')->where('is_active', true)->inRandomOrder()->first();

        $sidebarNews = News::where('status', 'published')
            ->orderBy('views_count', 'desc')
            ->take(6)
            ->get();

        if ($agent->isMobile()) {
            return view('mobile.category.show', compact(
                'category', 'news', 'company', 'categories', 'headerAd', 'sidebarAd', 'sidebarNews'
            ));
        }

        return view('category.show', compact(
            'category', 'news', 'company', 'categories', 'headerAd', 'sidebarAd', 'sidebarNews'
        ));
    }

    /**
     * Menampilkan Halaman Detail Berita
     */
    public function show($slug)
    {
        $agent = new Agent();

        $news = News::where('slug', $slug)
            ->where('status', 'published')
            ->firstOrFail();

        $news->increment('views_count');

        $company = CompanyProfile::first();
        $categories = Category::where('is_active', true)->take(7)->get();
        $headerAd = Ad::where('position', 'header_top')->where('is_active', true)->latest()->first();
        $sidebarAd = Ad::where('position', 'sidebar_right')->where('is_active', true)->inRandomOrder()->first();

        $sidebarNews = News::where('status', 'published')
            ->orderBy('views_count', 'desc')
            ->take(6)
            ->get();

        $relatedNews = News::whereHas('categories', function($q) use ($news) {
                $q->whereIn('categories.id', $news->categories->pluck('id'));
            })
            ->where('id', '!=', $news->id)
            ->where('status', 'published')
            ->orderBy('id', 'desc')
            ->take(3)
            ->get();

        if ($agent->isMobile()) {
            if (view()->exists('mobile.news.show')) {
                return view('mobile.news.show', compact(
                    'news', 'company', 'categories', 'headerAd', 'sidebarAd', 'sidebarNews', 'relatedNews'
                ));
            }
        }

        return view('news.show', compact(
            'news', 'company', 'categories', 'headerAd', 'sidebarAd', 'sidebarNews', 'relatedNews'
        ));
    }

    /**
     * Menampilkan Halaman Media Group
     */
    public function mediaGroup()
    {
        $agent = new Agent();
        
        $company = CompanyProfile::first();
        $categories = Category::where('is_active', true)->take(7)->get();
        
        $headerAd = Ad::where('position', 'header_top')->where('is_active', true)->latest()->first();
        $sidebarAd = Ad::where('position', 'sidebar_right')->where('is_active', true)->inRandomOrder()->first();

        $sidebarNews = News::where('status', 'published')
            ->orderBy('views_count', 'desc')
            ->take(6)
            ->get();

        if ($agent->isMobile()) {
            return view('mobile.pages.media-group', compact(
                'company', 'categories', 'headerAd', 'sidebarAd', 'sidebarNews'
            ));
        }

        return view('pages.media-group', compact(
            'company', 'categories', 'headerAd', 'sidebarAd', 'sidebarNews'
        ));
    }

    /**
     * [BARU] Menampilkan Halaman Pasang Iklan
     */
    public function advertise()
    {
        $agent = new Agent();
        
        $company = CompanyProfile::first();
        $categories = Category::where('is_active', true)->take(7)->get();
        
        $headerAd = Ad::where('position', 'header_top')->where('is_active', true)->latest()->first();
        $sidebarAd = Ad::where('position', 'sidebar_right')->where('is_active', true)->inRandomOrder()->first();

        $sidebarNews = News::where('status', 'published')
            ->orderBy('views_count', 'desc')
            ->take(6)
            ->get();

        // Jika Mobile, arahkan ke file view mobile yang baru kita buat
        if ($agent->isMobile()) {
            // Pastikan Anda menyimpan file tadi di: resources/views/mobile/pages/advertise.blade.php
            return view('mobile.pages.advertise', compact(
                'company', 'categories', 'headerAd', 'sidebarAd', 'sidebarNews'
            ));
        }

        // Jika Desktop (Fallback ke halaman page biasa jika belum ada view khusus)
        return view('pages.advertise', compact(
            'company', 'categories', 'headerAd', 'sidebarAd', 'sidebarNews'
        ));
    }

    /**
     * API Pencarian Berita (AJAX)
     */
    public function searchNews(Request $request)
    {
        $query = $request->get('q');
        
        if (!$query || strlen($query) < 2) {
            return response()->json([]);
        }

        $news = News::where('status', 'published')
            ->where('title', 'like', "%{$query}%")
            ->orderBy('id', 'desc')
            ->take(5)
            ->get(['title', 'slug', 'thumbnail']);

        $results = $news->map(function($item) {
            return [
                'title' => $item->title,
                'url' => route('news.show', $item->slug),
                'image' => $item->thumbnail ? Storage::url($item->thumbnail) : asset('default-news.jpg')
            ];
        });

        return response()->json($results);
    }
}