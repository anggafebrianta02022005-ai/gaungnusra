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
        $view = $agent->isMobile() ? 'mobile.pages.about' : 'pages.about';

        return view($view, $this->getSharedData());
    }

    public function advertise()
    {
        $agent = new Agent();
        $view = $agent->isMobile() ? 'mobile.pages.advertise' : 'pages.advertise';

        return view($view, $this->getSharedData());
    }

    private function getSharedData()
    {
        return [
            'company' => CompanyProfile::first(),
            'categories' => Category::all(),
            
            // Berita Trending (Sidebar)
            'sidebarNews' => News::where('status', 'published')
                                ->latest()
                                ->take(5)
                                ->get(),
            
            // --- PERBAIKAN DI SINI (SESUAI DATABASE) ---
            
            // 1. Ganti 'sidebar' jadi 'sidebar_right'
            // 2. Tambahkan pengecekan 'is_active' = 1
            'sidebarAd' => Ad::where('position', 'sidebar_right')
                             ->where('is_active', 1)
                             ->latest()
                             ->first(),
            
            // 1. Ganti 'header' jadi 'header_top'
            // 2. Tambahkan pengecekan 'is_active' = 1
            'headerAd' => Ad::where('position', 'header_top')
                            ->where('is_active', 1)
                            ->latest()
                            ->first(),
        ];
    }
}