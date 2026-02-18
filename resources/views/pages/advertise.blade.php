<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#F1F5F9">
    <title>Pasang Iklan - Gaung Nusra - Media Online</title>
    <link rel="icon" type="image/png" href="{{ asset('gaungnusra.png') }}?v=3">
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    {{-- SEO CANONICAL (UNIVERSAL) --}}
    @php
        // Default: Ambil URL bersih
        $canonicalUrl = url()->current();
        
        // Khusus Halaman 2, 3, dst (Pagination): Pakai URL lengkap (?page=2)
        if (request()->has('page') && request()->get('page') > 1) {
            $canonicalUrl = request()->fullUrl();
        }
    @endphp
    <link rel="canonical" href="{{ $canonicalUrl }}">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&family=Plus+Jakarta+Sans:wght@500;600;700;800&family=Playfair+Display:wght@700&display=swap" rel="stylesheet">
    
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                        display: ['"Plus Jakarta Sans"', 'sans-serif'],
                        serif: ['"Playfair Display"', 'serif'],
                    },
                    colors: {
                        brand: { red: '#D32F2F', dark: '#1E3A8A', misty: '#F1F5F9', gray: '#64748B', surface: '#FFFFFF' }
                    },
                    boxShadow: {
                        'soft': '0 4px 20px -2px rgba(0, 0, 0, 0.05)',
                        'card': '0 0 0 1px rgba(0,0,0,0.03), 0 2px 8px rgba(0,0,0,0.04)',
                        'misty-glow': '0 10px 40px -10px rgba(148, 163, 184, 0.4)', 
                    },
                    animation: {
                        'fade-in-up': 'fadeInUp 0.8s cubic-bezier(0.16, 1, 0.3, 1) forwards',
                    },
                    keyframes: {
                        fadeInUp: {
                            '0%': { opacity: '0', transform: 'translateY(20px)' },
                            '100%': { opacity: '1', transform: 'translateY(0)' },
                        }
                    }
                }
            }
        }
    </script>
    <style>
        body { -webkit-font-smoothing: antialiased; background-color: #ffffff; }
        ::-webkit-scrollbar { width: 10px; }
        ::-webkit-scrollbar-track { background: #f1f5f9; }
        ::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 5px; }
        header.scrolled { background-color: rgba(255, 255, 255, 0.9); backdrop-filter: blur(12px); box-shadow: 0 4px 20px -2px rgba(0, 0, 0, 0.05); border-bottom-color: transparent; }
        #search-results { display: none; } #search-results.active { display: block; }
        .no-scrollbar::-webkit-scrollbar { display: none; }
        .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
        [x-cloak] { display: none !important; }
    </style>
</head>
<body class="bg-white text-slate-800 flex flex-col min-h-screen" x-data="{ searchOpen: false, lightboxOpen: false, lightboxImage: '' }">

    <header id="main-header" class="bg-white border-b border-gray-100 py-4 relative z-50 transition-all duration-300">
        <div class="container mx-auto px-4 lg:px-8 flex justify-between items-center gap-4">
            <a href="/" class="flex items-center gap-3 group select-none shrink-0 animate-fade-in-up">
                @if($company && $company->logo)
                    <img src="{{ Storage::url($company->logo) }}" alt="{{ $company->name }}" class="block h-10 md:h-12 w-auto object-contain">
                @else
                    <div class="flex flex-col leading-none">
                        <span class="font-serif text-2xl font-bold text-brand-red tracking-tight">Gaung</span>
                        <span class="font-display text-sm font-extrabold text-brand-dark tracking-widest uppercase -mt-1">NUSRA</span>
                    </div>
                @endif
            </a>
            <div class="hidden md:block w-full max-w-md relative group animate-fade-in-up" style="animation-delay: 0.1s;">
                <div class="relative transition-all duration-300">
                    <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-gray-400 group-focus-within:text-brand-red transition-colors"><i class="ph ph-magnifying-glass text-lg"></i></span>
                    <input type="text" id="search-input" autocomplete="off" placeholder="Cari berita..." class="w-full bg-brand-misty text-slate-800 border border-transparent rounded-full py-2.5 pl-10 pr-4 text-sm focus:bg-white focus:border-brand-red focus:ring-4 focus:ring-brand-red/10 focus:outline-none transition-all shadow-sm placeholder:text-gray-400">
                    <div id="search-results" class="absolute top-full left-0 w-full mt-2 bg-white rounded-xl shadow-xl border border-slate-100 overflow-hidden z-50"></div>
                </div>
            </div>
        </div>
    </header>

<nav class="sticky top-0 z-40 bg-brand-misty/90 backdrop-blur-xl border-b border-gray-200/50 shadow-sm transition-all animate-fade-in-up" style="animation-delay: 0.15s;">
    <div class="container mx-auto px-4 lg:px-8">
        <div class="flex items-center justify-between h-14">
            
            <div id="menu-container" class="flex items-center gap-1 h-full overflow-x-auto no-scrollbar w-full md:w-auto pb-[2px]">
                
                {{-- 1. TOMBOL BERITA UTAMA --}}
                <a href="/" 
                   class="relative h-full flex items-center px-3 text-[13px] whitespace-nowrap shrink-0 transition-all duration-300
                   {{ request()->is('/') ? 'font-bold text-brand-red border-b-[3px] border-brand-red bg-white/50' : 'font-medium text-slate-600 hover:text-brand-dark' }}">
                    <i class="ph-fill ph-house mr-1.5 text-base"></i>Berita Utama
                </a>

                {{-- 2. LOOPING KATEGORI --}}
                @foreach($categories as $navCat)
                    @php
                        $isCategoryPage = request()->url() == route('category.show', $navCat->slug);
                        $isNewsPage = isset($news) && 
                                      $news->categories->count() > 0 && 
                                      $news->categories->first()->id == $navCat->id;
                        $isActive = $isCategoryPage || $isNewsPage;
                    @endphp

                    <a href="{{ route('category.show', $navCat->slug) }}" 
                       class="relative h-full flex items-center px-3 text-[13px] whitespace-nowrap shrink-0 transition-all duration-300 group
                       {{ $isActive ? 'font-bold text-brand-red border-b-[3px] border-brand-red bg-white/50' : 'font-medium text-slate-600 hover:text-brand-dark' }}">
                        
                        {{ $navCat->name }}

                        @if(!$isActive)
                            <span class="absolute bottom-0 left-1/2 -translate-x-1/2 w-0 h-[3px] bg-brand-red/20 rounded-t-full transition-all duration-300 group-hover:w-1/2 opacity-0 group-hover:opacity-100"></span>
                        @endif
                    </a>
                @endforeach
            </div>

            <div class="hidden md:flex items-center gap-3 pl-4 border-l border-gray-300 h-6 shrink-0">
                <a href="https://www.instagram.com/gaungnusra?igsh=cDJqMmJ3Zm9pMmpt" target="_blank" class="text-slate-400 hover:text-brand-red transition-colors"><i class="ph-fill ph-instagram-logo text-lg"></i></a>
                <a href="https://www.facebook.com/share/1DvqTnVEtY/?mibextid=wwXIfr" target="_blank" class="text-slate-400 hover:text-blue-600 transition-colors"><i class="ph-fill ph-facebook-logo text-lg"></i></a>
                <a href="https://www.threads.com/@gaungnusra?igshid=NTc4MTIwNjQ2YQ==" target="_blank" class="text-slate-400 hover:text-black transition-colors"><i class="ph-fill ph-threads-logo text-lg"></i></a>
            </div>

        </div>
    </div> 
</nav>

    <div class="bg-white border-b border-slate-100 animate-fade-in-up" style="animation-delay: 0.2s;">
        <div class="container mx-auto px-4 lg:px-8 py-6 flex flex-col items-center">
            @if($headerAd && $headerAd->image)
                @php $isPopupHead = empty($headerAd->link) || $headerAd->link === '#'; @endphp
                <a href="{{ $isPopupHead ? 'javascript:void(0)' : $headerAd->link }}" 
                   @if($isPopupHead) @click.prevent="lightboxOpen = true; lightboxImage = '{{ Storage::url($headerAd->image) }}'" @else target="_blank" @endif
                   class="relative group block w-fit mx-auto rounded-2xl overflow-hidden hover:shadow-lg transition-all duration-500 hover:-translate-y-1">
                    <div class="absolute top-0 right-0 bg-brand-misty text-slate-600 text-[10px] font-bold px-3 py-1 rounded-bl-xl backdrop-blur-sm z-20 border-l border-b border-white">SPONSORED</div>
                    <img src="{{ Storage::url($headerAd->image) }}" alt="Iklan Header" class="block w-auto h-auto max-w-full max-h-[250px] md:max-h-[350px] object-contain rounded-xl shadow-card border border-slate-100">
                </a>
            @endif
        </div>
    </div>

    <main class="container mx-auto px-4 lg:px-8 py-10 flex-grow bg-white">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-12">
            
            {{-- KOLOM KIRI --}}
            <div class="lg:col-span-8 animate-fade-in-up" style="animation-delay: 0.3s;">
                
                {{-- Hero Section --}}
                <div class="relative mb-12 py-8 rounded-3xl bg-slate-50 border border-slate-100 overflow-hidden text-center">
                    <div class="absolute top-0 left-0 w-32 h-32 bg-brand-red/5 rounded-full blur-3xl -ml-10 -mt-10"></div>
                    <div class="absolute bottom-0 right-0 w-32 h-32 bg-blue-500/5 rounded-full blur-3xl -mr-10 -mb-10"></div>
                    
                    <div class="relative z-10 px-6">
                        <span class="inline-flex items-center gap-1.5 px-3 py-1 bg-white border border-brand-red/20 text-brand-red text-xs font-bold tracking-widest rounded-full mb-4 uppercase shadow-sm">
                            <i class="ph-fill ph-megaphone"></i> Solusi Promosi
                        </span>
                        <h1 class="font-display font-extrabold text-4xl md:text-5xl text-brand-dark mb-4">
                            Pasang Iklan <span class="text-brand-red">Premium</span>
                        </h1>
                        <p class="text-slate-500 max-w-2xl mx-auto text-lg leading-relaxed">
                            Tingkatkan visibilitas bisnis Anda bersama <strong>{{ $company->name ?? 'Gaung Nusra' }}</strong>. Jangkau ribuan pembaca potensial setiap hari dengan strategi penempatan yang efektif.
                        </p>
                    </div>
                </div>

                {{-- Grid Layanan Iklan --}}
                <h3 class="font-display font-bold text-xl text-brand-dark mb-6 flex items-center gap-2 px-1">
                     Pilihan Slot Iklan
                </h3>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-12">
                    
                    {{-- Card 1: Header Ads --}}
                    <div class="group bg-white border border-slate-200 rounded-2xl p-6 hover:shadow-xl hover:border-blue-200 transition-all duration-300 hover:-translate-y-1 relative overflow-hidden">
                        <div class="absolute top-0 right-0 -mr-8 -mt-8 w-24 h-24 bg-blue-500/5 rounded-full blur-2xl group-hover:scale-150 transition-transform"></div>
                        
                        <div class="w-14 h-14 bg-blue-50 text-blue-600 rounded-xl flex items-center justify-center text-3xl mb-4 group-hover:bg-blue-600 group-hover:text-white transition-colors duration-300 shadow-sm">
                            <i class="ph-fill ph-browser"></i>
                        </div>
                        
                        <h4 class="font-display font-bold text-xl text-brand-dark mb-3 group-hover:text-blue-600 transition-colors">Iklan Header</h4>
                        <ul class="space-y-3 text-sm text-slate-600">
                            <li class="flex items-start gap-2">
                                <i class="ph-bold ph-check-circle text-blue-500 mt-0.5"></i>
                                <span>Posisi <strong>Paling Atas</strong> & Eksklusif.</span>
                            </li>
                            <li class="flex items-start gap-2">
                                <i class="ph-bold ph-check-circle text-blue-500 mt-0.5"></i>
                                <span>Dilihat pertama kali oleh pengunjung.</span>
                            </li>
                            <li class="flex items-start gap-2">
                                <i class="ph-bold ph-check-circle text-blue-500 mt-0.5"></i>
                                <span>Cocok untuk <strong>Brand Awareness</strong>.</span>
                            </li>
                        </ul>
                    </div>

                    {{-- Card 2: Sidebar Ads --}}
                    <div class="group bg-white border border-slate-200 rounded-2xl p-6 hover:shadow-xl hover:border-orange-200 transition-all duration-300 hover:-translate-y-1 relative overflow-hidden">
                        <div class="absolute top-0 right-0 -mr-8 -mt-8 w-24 h-24 bg-orange-500/5 rounded-full blur-2xl group-hover:scale-150 transition-transform"></div>
                        
                        <div class="w-14 h-14 bg-orange-50 text-orange-600 rounded-xl flex items-center justify-center text-3xl mb-4 group-hover:bg-orange-600 group-hover:text-white transition-colors duration-300 shadow-sm">
                            <i class="ph-fill ph-sidebar"></i>
                        </div>
                        
                        <h4 class="font-display font-bold text-xl text-brand-dark mb-3 group-hover:text-orange-600 transition-colors">Iklan Sidebar</h4>
                        <ul class="space-y-3 text-sm text-slate-600">
                            <li class="flex items-start gap-2">
                                <i class="ph-bold ph-check-circle text-orange-500 mt-0.5"></i>
                                <span>Tampil <strong>Sticky</strong> (Tetap) saat scroll.</span>
                            </li>
                            <li class="flex items-start gap-2">
                                <i class="ph-bold ph-check-circle text-orange-500 mt-0.5"></i>
                                <span>Muncul di samping setiap berita.</span>
                            </li>
                            <li class="flex items-start gap-2">
                                <i class="ph-bold ph-check-circle text-orange-500 mt-0.5"></i>
                                <span>Biaya lebih <strong>Efektif & Terjangkau</strong>.</span>
                            </li>
                        </ul>
                    </div>

                </div>

                {{-- CTA Box --}}
                <div class="bg-brand-dark rounded-3xl p-10 text-center relative overflow-hidden shadow-2xl group">
                    {{-- Background Animation --}}
                    <div class="absolute inset-0 bg-[url('https://www.transparenttextures.com/patterns/cubes.png')] opacity-10 group-hover:scale-105 transition-transform duration-1000"></div>
                    <div class="absolute top-0 right-0 -mr-16 -mt-16 w-64 h-64 bg-white/5 rounded-full blur-3xl group-hover:bg-white/10 transition-colors"></div>
                    <div class="absolute bottom-0 left-0 -ml-16 -mb-16 w-64 h-64 bg-brand-red/20 rounded-full blur-3xl group-hover:bg-brand-red/30 transition-colors"></div>

                    <div class="relative z-10">
                        <h3 class="font-display font-extrabold text-3xl text-white mb-3">Siap Mengembangkan Bisnis?</h3>
                        <p class="text-blue-100/90 mb-8 text-lg max-w-xl mx-auto">Konsultasikan kebutuhan promosi Anda dengan tim kami dan dapatkan penawaran terbaik hari ini.</p>
                        
                        <div class="flex flex-col sm:flex-row gap-4 justify-center">
                            <a href="https://wa.me/{{ $company->phone ?? '' }}?text=Halo%20Admin,%20saya%20tertarik%20pasang%20iklan." target="_blank" class="inline-flex items-center justify-center gap-2.5 bg-green-500 text-white px-8 py-3.5 rounded-xl font-bold shadow-lg hover:shadow-green-500/40 hover:bg-green-600 transition-all transform hover:-translate-y-1 group-active:scale-95">
                                <i class="ph-fill ph-whatsapp-logo text-xl"></i> Chat WhatsApp
                            </a>
                            <a href="mailto:{{ $company->email ?? '' }}" class="inline-flex items-center justify-center gap-2.5 bg-white text-brand-dark px-8 py-3.5 rounded-xl font-bold shadow-lg hover:bg-slate-50 transition-all transform hover:-translate-y-1 group-active:scale-95">
                                <i class="ph-fill ph-envelope-simple text-xl"></i> Kirim Email
                            </a>
                        </div>
                    </div>
                </div>

            </div>

            {{-- KOLOM KANAN: SIDEBAR --}}
            <aside class="lg:col-span-4 space-y-10 pl-0 lg:pl-6 border-l border-transparent lg:border-slate-100 animate-fade-in-up" style="animation-delay: 0.4s;">
                <div class="sticky top-24 space-y-8">
                    
                    {{-- TRENDING WIDGET --}}
                    <div class="bg-white rounded-2xl p-6 shadow-card border border-slate-100">
                        <div class="flex items-center justify-between mb-6 pb-4 border-b border-slate-50">
                            <h3 class="font-display font-bold text-lg text-brand-dark flex items-center gap-2">
                                <i class="ph-fill ph-trend-up text-brand-red"></i> Sedang Trending
                            </h3>
                        </div> 
                        <div class="space-y-6">
                            @foreach($sidebarNews as $index => $sNews)
                                <a href="{{ route('news.show', $sNews->slug) }}" class="group flex gap-4 items-start relative">
                                    {{-- Numbering --}}
                                    <span class="absolute -left-3 -top-3 w-7 h-7 flex items-center justify-center bg-white border border-slate-100 shadow-sm rounded-full text-xs font-bold {{ $index < 3 ? 'text-brand-red' : 'text-slate-400' }} z-10 font-display">#{{ $index + 1 }}</span>
                                    
                                    {{-- Image with Zoom --}}
                                    <div class="w-24 h-24 img-wrapper rounded-xl flex-shrink-0 shadow-sm group-hover:shadow-md transition-all overflow-hidden border border-slate-100">
                                        <img src="{{ Storage::url($sNews->thumbnail) }}" loading="lazy" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110">
                                    </div>
                                    
                                    {{-- Text --}}
                                    <div class="flex-1 py-1">
                                        <h4 class="font-display text-sm font-bold text-brand-dark leading-snug line-clamp-3 group-hover:text-brand-red transition-colors duration-200 mb-2">{{ $sNews->title }}</h4>
                                        <div class="flex items-center gap-2 text-[10px] text-slate-400 font-medium">
                                            <i class="ph-fill ph-calendar-blank"></i> {{ $sNews->created_at->format('d M Y') }}
                                        </div>
                                    </div>
                                </a>
                            @endforeach
                        </div>
                    </div>

                    {{-- 5 SLOT IKLAN SIDEBAR --}}
                    <div class="space-y-6">
                        <div class="flex items-center gap-2 mb-2 px-1">
                            <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Space Iklan (5 Slot)</span>
                        </div>

                        @if(isset($sidebarAds))
                            @for ($i = 1; $i <= 5; $i++)
                                @if(isset($sidebarAds[$i]))
                                    {{-- IKLAN AKTIF --}}
                                    @php $ad = $sidebarAds[$i]; $isPopup = empty($ad->link) || $ad->link === '#'; @endphp
                                    <a href="{{ $isPopup ? 'javascript:void(0)' : $ad->link }}" @if($isPopup) @click.prevent="lightboxOpen = true; lightboxImage = '{{ Storage::url($ad->image) }}'" @else target="_blank" @endif class="block relative rounded-xl overflow-hidden shadow-sm hover:shadow-md transition border border-slate-100 group">
                                        <span class="absolute top-0 right-0 bg-white/90 text-[9px] font-bold px-2 py-0.5 text-slate-500 rounded-bl-lg z-10 border-l border-b border-slate-100">ADS #{{ $i }}</span>
                                        <img src="{{ Storage::url($ad->image) }}" class="w-full h-auto object-cover group-hover:scale-105 transition-transform duration-500">
                                    </a>
                                @else
                                    {{-- SLOT KOSONG (Placeholder) --}}
                                    <div class="w-full h-24 rounded-xl border-2 border-dashed border-slate-200 bg-slate-50 flex flex-col items-center justify-center text-center opacity-60 hover:opacity-100 transition-opacity">
                                        <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wide">Slot #{{ $i }} Kosong</span>
                                    </div>
                                @endif
                            @endfor
                        @endif
                    </div>

                </div>
            </aside>
        </div>
    </main>

<footer class="bg-brand-misty border-t border-slate-200 pt-20 pb-10 mt-20 animate-fade-in-up" style="animation-delay: 0.5s;">
        <div class="container mx-auto px-4 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-12 mb-16">
                
                <div class="md:col-span-1">
                    <div class="flex items-center gap-2 mb-6">
                        @if($company && $company->logo)
                            <img src="{{ Storage::url($company->logo) }}" alt="Logo Footer" class="h-10 w-auto object-contain">
                        @else
                            <h2 class="font-display font-extrabold text-2xl text-brand-dark">GAUNG<span class="text-brand-red">NUSRA</span></h2>
                        @endif
                    </div>
                    <div class="flex gap-3">
                       <div class="flex space-x-4">
    <a href="https://www.instagram.com/gaungnusra?igsh=cDJqMmJ3Zm9pMmpt" target="_blank" class="text-slate-400 hover:text-brand-red transition-colors">
        <i class="ph-fill ph-instagram-logo text-lg"></i>
    </a>

    <a href="https://www.facebook.com/share/1DvqTnVEtY/?mibextid=wwXIfr" target="_blank" class="text-slate-400 hover:text-blue-600 transition-colors">
        <i class="ph-fill ph-facebook-logo text-lg"></i>
    </a>

    <a href="https://www.threads.com/@gaungnusra?igshid=NTc4MTIwNjQ2YQ==" target="_blank" class="text-slate-400 hover:text-black transition-colors">
        <i class="ph-fill ph-threads-logo text-lg"></i>
    </a>
</div>
                    </div>
                </div>

                <div>
                    <h3 class="font-display font-bold text-brand-dark mb-6 text-sm tracking-widest uppercase border-b-2 border-brand-red inline-block pb-1">Kategori</h3>
                    <ul class="space-y-4 text-slate-500 text-sm font-medium">
                        @foreach($categories->take(5) as $cat)
                            <li>
                                <a href="{{ route('category.show', $cat->slug) }}" class="hover:text-brand-red hover:pl-2 transition-all block">
                                    {{ $cat->name }}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>

                <div>
                    <h3 class="font-display font-bold text-brand-dark mb-6 text-sm tracking-widest uppercase border-b-2 border-brand-red inline-block pb-1">Tentang Kami</h3>
                    <ul class="space-y-4 text-slate-500 text-sm font-medium">
                        <li><a href="{{ route('pages.about') }}" class="hover:text-brand-red transition-colors">Profil Redaksi</a></li>  
                    </ul>
                </div>

               <div>
    <h3 class="font-display font-bold text-brand-dark mb-6 text-sm tracking-widest uppercase border-b-2 border-brand-red inline-block pb-1">Layanan</h3>
    <ul class="space-y-4 text-slate-500 text-sm font-medium">
    <li>
        <a href="{{ route('pages.advertise') }}" class="hover:text-brand-red transition-colors">
            Pasang Iklan
        </a>
    </li>
    <li>
        <a href="{{ route('epaper.latest') }}" target="_blank" class="hover:text-brand-red transition-colors flex items-center gap-2">
            <span>Koran Cetak (E-Paper)</span>
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
            </svg>
        </a>
    </li>
    <li>
        <a href="{{ route('pages.media-group') }}" class="hover:text-brand-red transition-colors">
            Media Group
        </a>
    </li>
</ul>
</div>
            </div>

            <div class="border-t border-slate-200 pt-8 flex flex-col md:flex-row items-center justify-between gap-4">
                <p class="text-sm text-slate-500 font-medium">&copy; {{ date('Y') }} {{ $company->name ?? 'Gaung Nusra' }}. All rights reserved.</p>
                <div class="flex items-center gap-1 text-xs text-slate-400">
                    <span>Dibuat Oleh Udayana Digital Data</span>
                </div>
            </div>
        </div>
    </footer>

    {{-- MODAL LIGHTBOX GLOBAL --}}
    <div x-show="lightboxOpen" 
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="fixed inset-0 z-[100] flex items-center justify-center bg-black/90 p-4" 
         x-cloak>
        
        <button @click="lightboxOpen = false" class="absolute top-6 right-6 text-white hover:text-brand-red transition-colors p-2 bg-black/50 rounded-full">
            <i class="ph-bold ph-x text-3xl"></i>
        </button>

        <div class="relative max-w-5xl w-full flex justify-center" @click.away="lightboxOpen = false">
            <img :src="lightboxImage" class="max-w-full max-h-[90vh] object-contain shadow-2xl rounded-lg">
        </div>
    </div>

    <script>
        $(document).ready(function() {
            $(window).scroll(function() {
                var scroll = $(window).scrollTop();
                if (scroll >= 50) { $('#main-header').addClass('scrolled'); } else { $('#main-header').removeClass('scrolled'); }
            });

            // Horizontal Menu Wheel Scroll
            const menuContainer = document.getElementById('menu-container');
            if(menuContainer){
                menuContainer.addEventListener('wheel', (evt) => {
                    if (menuContainer.scrollWidth > menuContainer.clientWidth) {
                        evt.preventDefault();
                        menuContainer.scrollLeft += evt.deltaY * 2; 
                    }
                });
            }

            var searchInput = $('#search-input');
            var searchResults = $('#search-results');
            var timeout = null;
            searchInput.on('keyup', function() {
                var query = $(this).val();
                clearTimeout(timeout);
                if (query.length < 2) { searchResults.html('').removeClass('active'); return; }
                timeout = setTimeout(function() {
                    // Logic AJAX search di sini
                }, 300);
            });
        });
    </script>
</body>
</html>