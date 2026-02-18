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
            // Jika request dari HP -> Panggil partial mobile
            if ($agent->isMobile()) {
                return view('partials.mobile-news-list', compact('latestNews'))->render();
            }
            // Jika request dari Desktop -> Panggil partial desktop
            return view('partials.news-list', compact('latestNews'))->render();
        }

        // 3. DATA UMUM (Header, Footer, Sidebar)
        $company = CompanyProfile::first();
        $categories = Category::where('is_active', true)->take(7)->get();
        $headerAd = Ad::where('position', 'header_top')->where('is_active', true)->latest()->first();
        $sidebarAd = Ad::where('position', 'sidebar_right')->where('is_active', true)->inRandomOrder()->first();

        // 4. TRENDING (SIDEBAR)
        $sidebarNews = News::where('status', 'published')
            ->orderBy('views_count', 'desc')
            ->take(6)
            ->get();

        // 5. RENDER VIEW (MOBILE / DESKTOP)
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

        // 1. QUERY BERITA PER KATEGORI
        $news = $category->news()
            ->with(['author', 'categories'])
            ->where('status', 'published')
            ->orderByRaw('pin_order IS NULL asc')
            ->orderBy('pin_order', 'asc')
            ->orderBy('news.id', 'desc')
            ->paginate(10);

        // 2. LOGIKA AJAX (LOAD MORE)
        if ($request->ajax()) {
            // Gunakan variable 'latestNews' agar kompatibel dengan partials yang sama
            if ($agent->isMobile()) {
                return view('partials.mobile-news-list', ['latestNews' => $news])->render();
            }
            return view('partials.news-list', ['latestNews' => $news])->render();
        }

        // 3. DATA PENDUKUNG
        $company = CompanyProfile::first();
        $categories = Category::where('is_active', true)->take(7)->get();
        $headerAd = Ad::where('position', 'header_top')->where('is_active', true)->latest()->first();
        $sidebarAd = Ad::where('position', 'sidebar_right')->where('is_active', true)->inRandomOrder()->first();

        $sidebarNews = News::where('status', 'published')
            ->orderBy('views_count', 'desc')
            ->take(6)
            ->get();

        // 4. RENDER VIEW
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

        // 1. AMBIL BERITA
        $news = News::where('slug', $slug)
            ->where('status', 'published')
            ->firstOrFail();

        // 2. COUNTER VIEWS
        $news->increment('views_count');

        // 3. DATA PENDUKUNG
        $company = CompanyProfile::first();
        $categories = Category::where('is_active', true)->take(7)->get();
        $headerAd = Ad::where('position', 'header_top')->where('is_active', true)->latest()->first();
        $sidebarAd = Ad::where('position', 'sidebar_right')->where('is_active', true)->inRandomOrder()->first();

        // 4. TRENDING
        $sidebarNews = News::where('status', 'published')
            ->orderBy('views_count', 'desc')
            ->take(6)
            ->get();

        // 5. BERITA TERKAIT (Relasi Kategori)
        $relatedNews = News::whereHas('categories', function($q) use ($news) {
                $q->whereIn('categories.id', $news->categories->pluck('id'));
            })
            ->where('id', '!=', $news->id)
            ->where('status', 'published')
            ->orderBy('id', 'desc')
            ->take(3)
            ->get();

        // 6. RENDER VIEW
        if ($agent->isMobile()) {
            // Pastikan file view mobile ada, jika tidak fallback ke desktop
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
     * Menampilkan Halaman Media Group (Halaman Baru)
     */
    public function mediaGroup()
    {
        $agent = new Agent();
        
        $company = CompanyProfile::first();
        $categories = Category::where('is_active', true)->take(7)->get();
        
        // Iklan tetap dimuat agar header/footer tidak error
        $headerAd = Ad::where('position', 'header_top')->where('is_active', true)->latest()->first();
        $sidebarAd = Ad::where('position', 'sidebar_right')->where('is_active', true)->inRandomOrder()->first();

        // Render khusus mobile jika user pakai HP
        if ($agent->isMobile()) {
            return view('mobile.pages.media-group', compact('company', 'categories', 'headerAd', 'sidebarAd'));
        }

        // Tampilan Desktop (Jika belum ada, bisa diarahkan ke view yang sama atau dibuatkan view khusus)
        return view('pages.media-group', compact('company', 'categories', 'headerAd', 'sidebarAd'));
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
            ->get(['title', 'slug', 'thumbnail']); // Optimasi: Ambil kolom yg perlu saja

        $results = $news->map(function($item) {
            return [
                'title' => $item->title,
                'url' => route('news.show', $item->slug),
                'image' => $item->thumbnail ? Storage::url($item->thumbnail) : asset('default-news.jpg') // Fallback image jika null
            ];
        });

        return response()->json($results);
    }
}