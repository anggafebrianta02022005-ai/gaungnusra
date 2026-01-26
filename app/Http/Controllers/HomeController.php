<?php

namespace App\Http\Controllers;

use App\Models\Ad;
use App\Models\Category;
use App\Models\CompanyProfile;
use App\Models\News;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Jenssegers\Agent\Agent; // Pastikan library ini ada

class HomeController extends Controller
{
    public function index(Request $request)
    {
        // 1. DATA UTAMA
        $company = CompanyProfile::first(); 
        $categories = Category::where('is_active', true)->take(7)->get(); 

        // 2. IKLAN
        $headerAd = Ad::where('position', 'header_top')->where('is_active', true)->latest()->first();
        $sidebarAd = Ad::where('position', 'sidebar_right')->where('is_active', true)->inRandomOrder()->first();

        // 3. BERITA TERBARU (LOAD MORE)
        $latestNews = News::with(['categories', 'author'])
            ->where('status', 'published')
            ->orderByRaw('pin_order IS NULL asc')
            ->orderBy('pin_order', 'asc')
            ->orderBy('id', 'desc')
            ->paginate(5); 

        // ===> LOGIKA AJAX (LOAD MORE) YANG DIPERBAIKI <===
        if ($request->ajax()) {
            $agent = new Agent();
            
            // Jika HP, panggil partial khusus Mobile (yang layoutnya rapi/kecil)
            if ($agent->isMobile()) {
                return view('partials.mobile-news-list', compact('latestNews'))->render();
            }
            
            // Jika Desktop, panggil partial Desktop (yang layoutnya besar)
            return view('partials.news-list', compact('latestNews'))->render();
        }

        // 4. SIDEBAR (TRENDING)
        $sidebarNews = News::where('status', 'published')
            ->orderBy('views_count', 'desc')
            ->take(6) 
            ->get();

        // ===> LOGIKA DETEKSI HALAMAN UTAMA <===
        $agent = new Agent();

        if ($agent->isMobile()) {
            return view('mobile.home', compact(
                'company', 'categories', 'headerAd', 'sidebarAd', 'latestNews', 'sidebarNews'
            ));
        }

        return view('home', compact(
            'company', 'categories', 'headerAd', 'sidebarAd', 'latestNews', 'sidebarNews'
        ));
    }

    public function category(Request $request, $slug)
    {
        $category = Category::where('slug', $slug)->where('is_active', true)->firstOrFail();

        $news = $category->news()
            ->with(['author', 'categories'])
            ->where('status', 'published')
            ->orderByRaw('pin_order IS NULL asc')
            ->orderBy('pin_order', 'asc')
            ->orderBy('news.id', 'desc')
            ->paginate(10); 

        // ===> LOGIKA AJAX (LOAD MORE) KATEGORI YANG DIPERBAIKI <===
        if ($request->ajax()) {
            $agent = new Agent();
            
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

        // ===> LOGIKA DETEKSI HALAMAN KATEGORI <===
        $agent = new Agent();

        if ($agent->isMobile()) {
            return view('mobile.category.show', compact(
                'category', 'news', 'company', 'categories', 'headerAd', 'sidebarAd', 'sidebarNews'
            ));
        }

        return view('category.show', compact(
            'category', 'news', 'company', 'categories', 'headerAd', 'sidebarAd', 'sidebarNews'
        ));
    }

    public function show($slug)
    {
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
            ->take(3)
            ->get();

        // ===> LOGIKA DETEKSI HALAMAN DETAIL BERITA <===
        $agent = new Agent();

        if ($agent->isMobile()) {
            // Pastikan file 'resources/views/mobile/news/show.blade.php' sudah dibuat ya!
            // Jika belum, buat dulu (copy dari news/show.blade.php lalu sesuaikan layoutnya)
            // Untuk sementara saya arahkan ke file desktop jika file mobile belum ada, 
            // TAPI idealnya Mas Angga buat file mobile-nya.
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

    public function searchNews(Request $request)
    {
        $query = $request->get('q');
        
        if (!$query) {
            return response()->json([]);
        }

        $news = News::where('status', 'published')
            ->where('title', 'like', "%{$query}%") 
            ->take(5)
            ->get(['title', 'slug', 'thumbnail']); 

        $results = $news->map(function($item) {
            return [
                'title' => $item->title,
                'url' => route('news.show', $item->slug),
                'image' => Storage::url($item->thumbnail)
            ];
        });

        return response()->json($results);
    }
}