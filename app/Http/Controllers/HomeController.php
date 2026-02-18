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
        
        // 4. IKLAN SIDEBAR (LOGIKA 5 SLOT)
        $sidebarAds = Ad::where('position', 'sidebar_right')
            ->where('is_active', true)
            ->whereNotNull('slot_number')
            ->orderBy('slot_number')
            ->get()
            ->keyBy('slot_number');

        // 5. TRENDING
        $sidebarNews = News::where('status', 'published')
            ->orderBy('views_count', 'desc')
            ->take(6)
            ->get();

        // 6. RENDER VIEW
        if ($agent->isMobile()) {
            return view('mobile.home', compact(
                'company', 'categories', 'headerAd', 'sidebarAds', 'latestNews', 'sidebarNews'
            ));
        }

        return view('home', compact(
            'company', 'categories', 'headerAd', 'sidebarAds', 'latestNews', 'sidebarNews'
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
        
        // IKLAN SIDEBAR 5 SLOT
        $sidebarAds = Ad::where('position', 'sidebar_right')
            ->where('is_active', true)
            ->whereNotNull('slot_number')
            ->orderBy('slot_number')
            ->get()
            ->keyBy('slot_number');

        $sidebarNews = News::where('status', 'published')
            ->orderBy('views_count', 'desc')
            ->take(6)
            ->get();

        if ($agent->isMobile()) {
            return view('mobile.category.show', compact(
                'category', 'news', 'company', 'categories', 'headerAd', 'sidebarAds', 'sidebarNews'
            ));
        }

        return view('category.show', compact(
            'category', 'news', 'company', 'categories', 'headerAd', 'sidebarAds', 'sidebarNews'
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
        
        // IKLAN SIDEBAR 5 SLOT
        $sidebarAds = Ad::where('position', 'sidebar_right')
            ->where('is_active', true)
            ->whereNotNull('slot_number')
            ->orderBy('slot_number')
            ->get()
            ->keyBy('slot_number');

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
                    'news', 'company', 'categories', 'headerAd', 'sidebarAds', 'sidebarNews', 'relatedNews'
                ));
            }
        }

        return view('news.show', compact(
            'news', 'company', 'categories', 'headerAd', 'sidebarAds', 'sidebarNews', 'relatedNews'
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
        
        // IKLAN SIDEBAR 5 SLOT
        $sidebarAds = Ad::where('position', 'sidebar_right')
            ->where('is_active', true)
            ->whereNotNull('slot_number')
            ->orderBy('slot_number')
            ->get()
            ->keyBy('slot_number');

        $sidebarNews = News::where('status', 'published')
            ->orderBy('views_count', 'desc')
            ->take(6)
            ->get();

        if ($agent->isMobile()) {
            return view('mobile.pages.media-group', compact(
                'company', 'categories', 'headerAd', 'sidebarAds', 'sidebarNews'
            ));
        }

        return view('pages.media-group', compact(
            'company', 'categories', 'headerAd', 'sidebarAds', 'sidebarNews'
        ));
    }

    /**
     * Menampilkan Halaman Tentang Kami (About)
     * UPDATE: Menambahkan logika 5 slot sidebarAds
     */
    public function about()
    {
        $agent = new Agent();
        
        $company = CompanyProfile::first();
        $categories = Category::where('is_active', true)->take(7)->get();
        $headerAd = Ad::where('position', 'header_top')->where('is_active', true)->latest()->first();
        
        // IKLAN SIDEBAR 5 SLOT (FIXED)
        $sidebarAds = Ad::where('position', 'sidebar_right')
            ->where('is_active', true)
            ->whereNotNull('slot_number')
            ->orderBy('slot_number')
            ->get()
            ->keyBy('slot_number');

        $sidebarNews = News::where('status', 'published')
            ->orderBy('views_count', 'desc')
            ->take(6)
            ->get();

        if ($agent->isMobile()) {
            // Pastikan mengirim 'sidebarAds' (Array 5 Slot)
            return view('mobile.pages.about', compact(
                'company', 'categories', 'headerAd', 'sidebarAds', 'sidebarNews'
            ));
        }

        return view('pages.about', compact(
            'company', 'categories', 'headerAd', 'sidebarAds', 'sidebarNews'
        ));
    }

    /**
     * Menampilkan Halaman Pasang Iklan (Advertise)
     * UPDATE: Menambahkan logika 5 slot sidebarAds
     */
    public function advertise()
    {
        $agent = new Agent();
        
        $company = CompanyProfile::first();
        $categories = Category::where('is_active', true)->take(7)->get();
        $headerAd = Ad::where('position', 'header_top')->where('is_active', true)->latest()->first();
        
        // IKLAN SIDEBAR 5 SLOT (FIXED)
        $sidebarAds = Ad::where('position', 'sidebar_right')
            ->where('is_active', true)
            ->whereNotNull('slot_number')
            ->orderBy('slot_number')
            ->get()
            ->keyBy('slot_number');

        $sidebarNews = News::where('status', 'published')
            ->orderBy('views_count', 'desc')
            ->take(6)
            ->get();

        if ($agent->isMobile()) {
            // Pastikan mengirim 'sidebarAds' (Array 5 Slot)
            return view('mobile.pages.advertise', compact(
                'company', 'categories', 'headerAd', 'sidebarAds', 'sidebarNews'
            ));
        }

        return view('pages.advertise', compact(
            'company', 'categories', 'headerAd', 'sidebarAds', 'sidebarNews'
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