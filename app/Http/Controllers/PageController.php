<?php

namespace App\Http\Controllers;

use App\Models\News;
use App\Models\Ad;
use App\Models\Category;
use App\Models\CompanyProfile;
use Illuminate\Http\Request;
use Jenssegers\Agent\Agent;

class PageController extends Controller
{
    public function about()
    {
        $agent = new Agent();
        
        // Cek view mobile
        if ($agent->isMobile() && view()->exists('mobile.pages.about')) {
            $view = 'mobile.pages.about';
        } else {
            $view = 'pages.about';
        }

        return view($view, $this->getSharedData());
    }

    public function advertise()
    {
        $agent = new Agent();
        
        if ($agent->isMobile() && view()->exists('mobile.pages.advertise')) {
            $view = 'mobile.pages.advertise';
        } else {
            $view = 'pages.advertise';
        }

        return view($view, $this->getSharedData());
    }

    /**
     * Fungsi Privasi untuk mengambil data yang sama (Menu, Iklan, Sidebar)
     */
    private function getSharedData()
    {
        return [
            // 1. DATA PERUSAHAAN
            'company' => CompanyProfile::first(),

            // 2. NAVIGASI
            'categories' => Category::where('is_active', true)->take(7)->get(),

            // 3. BERITA TRENDING (SIDEBAR)
            'sidebarNews' => News::where('status', 'published')
                            ->orderBy('views_count', 'desc') 
                            ->take(6)
                            ->get(),

            // 4. IKLAN HEADER (Atas)
            'headerAd' => Ad::where('position', 'header_top')
                            ->where('is_active', 1)
                            ->latest()
                            ->first(),

            // 5. [UPDATE] IKLAN SIDEBAR (5 Slot Vertikal)
            // Mengambil semua iklan sidebar aktif, urutkan slot, dan jadikan slot sebagai key array
            'sidebarAds' => Ad::where('position', 'sidebar_right')
                            ->where('is_active', true)
                            ->whereNotNull('slot_number')
                            ->orderBy('slot_number')
                            ->get()
                            ->keyBy('slot_number'),
        ];
    }
}