<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#F1F5F9">
    
    {{-- META DATA UTAMA --}}
    <meta name="description" content="{{ $news->subtitle ?? Str::limit(strip_tags($news->content), 150) }}">
    <meta name="author" content="{{ $news->author->name ?? 'Redaksi' }}">
    <title>{{ $news->title }} - Gaung Nusra</title>

    {{-- IMPLEMENTASI 1: META TAGS SHARE (Open Graph & Twitter) --}}
    <meta property="og:type" content="article">
    <meta property="og:title" content="{{ $news->title }}">
    <meta property="og:description" content="{{ $news->subtitle ?? Str::limit(strip_tags($news->content), 120) }}">
    <meta property="og:url" content="{{ request()->url() }}">
    <meta property="og:site_name" content="Gaung Nusra">
    
    {{-- Gambar Utama Berita untuk Preview WA/FB --}}
    <meta property="og:image" content="{{ asset(Storage::url($news->image ?? $news->thumbnail)) }}">
    <meta property="og:image:width" content="1200">
    <meta property="og:image:height" content="630">
    
    {{-- Twitter Cards --}}
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="{{ $news->title }}">
    <meta name="twitter:image" content="{{ asset(Storage::url($news->image ?? $news->thumbnail)) }}">

    {{-- CSS & FONTS --}}
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <link rel="icon" type="image/png" href="{{ asset('gaungnusra.png') }}?v=3">
    
    {{-- SEO CANONICAL --}}
    @php
        $canonicalUrl = url()->current();
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
                    }
                }
            }
        }
    </script>
    <style>
        body { background-color: #ffffff; -webkit-font-smoothing: antialiased; }
        .line-clamp-2 { display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; }
        
        /* Hide Scrollbar */
        .no-scrollbar::-webkit-scrollbar { display: none; }
        .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }

        /* Search Styles */
        .search-results-container { display: none; }
        .search-results-container.active { display: block; }

        /* ARTIKEL STYLES */
        .article-content { font-size: 1.05rem; line-height: 1.8; color: #334155; }
        .article-content p { margin-bottom: 1.5em; }
        .article-content h2, .article-content h3 { font-family: 'Plus Jakarta Sans', sans-serif; font-weight: 700; color: #1E3A8A; margin-top: 2em; margin-bottom: 0.75em; }
        .article-content ul { list-style-type: disc; margin-left: 1.5em; margin-bottom: 1.5em; }
        .article-content img { width: auto !important; max-width: 100% !important; height: auto !important; border-radius: 8px; margin: 24px auto; }
        
        [x-cloak] { display: none !important; }
    </style>
</head>

{{-- Tambahkan lightboxOpen di x-data body --}}
<body class="bg-white text-slate-800 flex flex-col min-h-screen" 
      x-data="{ mobileMenu: false, searchOpen: false, lightboxOpen: false, lightboxImage: '' }">

    {{-- HEADER --}}
    <header class="bg-white border-b border-gray-100 py-3 md:py-4 relative z-50">
        <div class="container mx-auto px-4 lg:px-8 flex justify-between items-center relative min-h-[40px]">
            
            {{-- LOGO --}}
            <a href="/" class="absolute left-1/2 -translate-x-1/2 md:static md:translate-x-0 flex items-center gap-3 group select-none shrink-0 z-10">
                @if($company && $company->logo)
                    <img src="{{ Storage::url($company->logo) }}" alt="{{ $company->name }}" class="block h-8 md:h-12 w-auto object-contain">
                @else
                    <div class="flex flex-col leading-none text-center md:text-left">
                        <span class="font-serif text-xl md:text-2xl font-bold text-brand-red tracking-tight">Gaung</span>
                        <span class="font-display text-[10px] md:text-sm font-extrabold text-brand-dark tracking-widest uppercase -mt-0.5 md:-mt-1">NUSRA</span>
                    </div>
                @endif
            </a>
            
            {{-- SEARCH DESKTOP --}}
            <div class="hidden md:block w-full max-w-md relative group ml-auto mr-4">
                <div class="relative transition-all duration-300">
                    <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-gray-400"><i class="ph ph-magnifying-glass text-lg"></i></span>
                    <input type="text" id="desktop-search-input" autocomplete="off" placeholder="Cari berita..." class="w-full bg-brand-misty text-slate-800 border border-transparent rounded-full py-2.5 pl-10 pr-4 text-sm focus:bg-white focus:border-brand-red focus:ring-4 focus:ring-brand-red/10 focus:outline-none transition-all shadow-sm placeholder:text-gray-400">
                    <div id="desktop-search-results" class="search-results-container absolute top-full left-0 w-full mt-2 bg-white rounded-xl shadow-xl border border-slate-100 overflow-hidden z-50"></div>
                </div>
            </div>

            {{-- TOMBOL AKSI MOBILE --}}
            <div class="flex items-center gap-2 ml-auto md:hidden z-20">
                <button @click="searchOpen = !searchOpen; if(searchOpen) $nextTick(() => $refs.mobileSearchInput.focus())" class="w-9 h-9 flex items-center justify-center rounded-full text-slate-600 hover:bg-slate-100 transition-all active:scale-95" :class="{ 'bg-brand-red/10 text-brand-red': searchOpen }">
                    <i class="ph text-xl" :class="searchOpen ? 'ph-x' : 'ph-magnifying-glass'"></i>
                </button>
                <button @click="mobileMenu = !mobileMenu" class="w-9 h-9 flex items-center justify-center rounded-full bg-brand-misty text-brand-dark hover:bg-brand-red hover:text-white transition-all active:scale-95">
                    <i class="ph ph-list text-xl" x-show="!mobileMenu"></i>
                    <i class="ph ph-x text-xl" x-show="mobileMenu" x-cloak></i>
                </button>
            </div>
        </div>
    </header>

    {{-- INPUT SEARCH MOBILE --}}
    <div x-show="searchOpen" x-transition class="px-4 py-3 bg-white border-b border-slate-100 shadow-sm relative z-40 md:hidden" style="display: none;">
        <div class="relative">
            <span class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-brand-red"><i class="ph-bold ph-magnifying-glass"></i></span>
            <input x-ref="mobileSearchInput" type="text" id="mobile-search-input" placeholder="Ketik kata kunci berita..." class="w-full bg-brand-misty border-none rounded-lg py-2.5 pl-10 pr-4 text-sm focus:ring-2 focus:ring-brand-red outline-none shadow-inner">
            <div id="mobile-search-results" class="search-results-container absolute top-full left-0 w-full mt-2 bg-white rounded-xl shadow-xl border border-slate-100 overflow-hidden z-50"></div>
        </div>
    </div>

    {{-- NAVBAR KATEGORI --}}
    <div class="bg-white border-b border-slate-100 overflow-x-auto no-scrollbar sticky top-0 z-40">
        <div class="flex items-center px-4 h-12 gap-2 min-w-max">
            <a href="/" class="px-3 py-1.5 text-xs font-medium text-slate-600 hover:text-brand-dark hover:bg-slate-50 rounded-full border border-transparent transition-all">Berita Utama</a>
            @foreach($categories as $navCat)
                @php
                    $isActive = false;
                    if(request()->url() == route('category.show', $navCat->slug)) { $isActive = true; }
                    elseif(request()->routeIs('news.show') && isset($news) && $news->categories->count() > 0 && $news->categories->first()->id == $navCat->id) { $isActive = true; }
                @endphp
                <a href="{{ route('category.show', $navCat->slug) }}" 
                   class="px-3 py-1.5 text-xs font-bold rounded-full border transition-all 
                   {{ $isActive ? 'text-brand-red bg-brand-red/10 border-brand-red/20' : 'text-slate-600 border-transparent hover:bg-slate-50' }}">
                    {{ $navCat->name }}
                </a>
            @endforeach
        </div>
    </div>

    {{-- SIDEBAR MOBILE MENU --}}
    <div x-show="mobileMenu" class="fixed inset-0 z-[60] bg-black/50 backdrop-blur-sm" @click="mobileMenu = false" x-transition.opacity style="display: none;"></div>
    <div x-show="mobileMenu" class="fixed top-0 right-0 h-full w-[80%] max-w-[300px] bg-white z-[70] shadow-2xl p-6 overflow-y-auto" 
         x-transition:enter="transition transform ease-out duration-300"
         x-transition:enter-start="translate-x-full"
         x-transition:enter-end="translate-x-0"
         x-transition:leave="transition transform ease-in duration-300"
         x-transition:leave-start="translate-x-0"
         x-transition:leave-end="translate-x-full" style="display: none;">
        
        <div class="flex justify-between items-center mb-8 border-b border-slate-100 pb-4">
            <h3 class="font-display font-bold text-lg text-brand-dark">Menu</h3>
            <button @click="mobileMenu = false" class="w-8 h-8 rounded-full bg-slate-100 flex items-center justify-center text-slate-500 active:scale-95"><i class="ph-bold ph-x"></i></button>
        </div>
        
        <div class="space-y-2">
            <a href="/" class="block px-3 py-2.5 text-sm font-medium text-slate-700 hover:bg-slate-50 rounded-lg">Home</a>
            @foreach($categories as $navCat)
                <a href="{{ route('category.show', $navCat->slug) }}" class="block px-3 py-2.5 text-sm font-medium rounded-lg transition-colors text-slate-700 hover:bg-slate-50">{{ $navCat->name }}</a>
            @endforeach
        </div>
    </div>

    {{-- IMPLEMENTASI 2: IKLAN HEADER (LOGIKA POPUP + LINK) --}}
    <div class="px-4 pt-4 pb-2">
        @if($headerAd && $headerAd->image)
            @php 
                $isPopupHeader = empty($headerAd->link) || $headerAd->link === '#'; 
            @endphp

            <a href="{{ $isPopupHeader ? 'javascript:void(0)' : $headerAd->link }}" 
               @if($isPopupHeader) 
                    @click.prevent="lightboxOpen = true; lightboxImage = '{{ Storage::url($headerAd->image) }}'" 
               @else 
                    target="_blank" 
               @endif
               class="block relative rounded-xl overflow-hidden shadow-sm border border-slate-100 group transition-transform active:scale-95">
               
               <div class="absolute top-0 right-0 bg-brand-misty text-slate-600 text-[8px] font-bold px-2 py-0.5 rounded-bl-lg z-10 border-l border-b border-white">SPONSORED</div>
               <img src="{{ Storage::url($headerAd->image) }}" class="w-full h-auto object-cover max-h-[250px]">
            </a>
        @endif
    </div>

    {{-- KONTEN UTAMA --}}
    <main class="container mx-auto px-4 lg:px-8 py-6 md:py-10 flex-grow bg-white">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-12">
            
            {{-- KOLOM KIRI: BERITA --}}
            <article class="lg:col-span-8 animate-fade-in-up">
                <div class="flex items-center gap-3 mb-4">
                    <span class="w-1.5 h-6 bg-brand-red rounded-full shrink-0"></span>
                    <span class="text-brand-red font-bold text-sm tracking-wide uppercase">{{ $news->categories->first()->name ?? 'Berita' }}</span>
                </div>

                <h1 class="font-display font-extrabold text-2xl md:text-3xl lg:text-[40px] leading-tight text-brand-dark mb-4">{{ $news->title }}</h1>

                @if($news->subtitle)
                    <p class="text-lg text-slate-500 font-medium leading-relaxed mb-6 font-sans">{{ $news->subtitle }}</p>
                @endif

                <div class="flex items-center gap-6 text-sm text-slate-500 mb-8 pb-6 border-b border-slate-100">
                    <div class="flex items-center gap-2">
                        <div class="w-8 h-8 rounded-full bg-brand-misty flex items-center justify-center font-bold text-brand-dark border border-slate-200">{{ substr($news->author->name ?? 'R', 0, 1) }}</div>
                        <span class="font-bold text-slate-700">{{ $news->author->name ?? 'Redaksi' }}</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <i class="ph-fill ph-calendar-blank"></i>
                        <span>{{ $news->published_at->format('d M Y, H:i') }} WITA</span>
                    </div>
                </div>

                <figure class="w-full rounded-xl overflow-hidden shadow-sm mb-8 bg-slate-100">
                    <img src="{{ Storage::url($news->image ?? $news->thumbnail) }}" alt="{{ $news->title }}" class="w-full h-auto object-cover">
                    <figcaption class="text-center text-[10px] md:text-xs text-slate-400 mt-2 italic px-4">{{ $news->image_caption ?? 'Ilustrasi: ' . $news->title }}</figcaption>
                </figure>

                <div class="article-content font-sans">
                    {!! $news->content !!}
                </div>

                {{-- SHARE BUTTONS (KEMBALI KE TAMPILAN STANDARD RAPI) --}}
<div class="mt-10 pt-8 border-t border-slate-200 mb-10">
    <div class="flex flex-col md:flex-row items-center justify-between gap-6">
        
        {{-- Label --}}
        <div class="flex items-center gap-2">
            <span class="w-1 h-6 bg-brand-red rounded-full"></span>
            <span class="font-display font-bold text-slate-700 text-lg">Bagikan Berita Ini:</span>
        </div>

        {{-- Tombol Baris Horizontal --}}
        <div class="flex items-center gap-3">
            {{-- WhatsApp --}}
            <a href="https://api.whatsapp.com/send?text={{ urlencode($news->title . ' ' . request()->url()) }}" 
               target="_blank" 
               class="w-12 h-12 rounded-full bg-[#25D366]/10 text-[#25D366] flex items-center justify-center hover:bg-[#25D366] hover:text-white transition-all shadow-sm">
                <i class="ph-fill ph-whatsapp-logo text-2xl"></i>
            </a>
            
            {{-- Facebook --}}
            <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(request()->url()) }}" 
               target="_blank" 
               class="w-12 h-12 rounded-full bg-[#1877F2]/10 text-[#1877F2] flex items-center justify-center hover:bg-[#1877F2] hover:text-white transition-all shadow-sm">
                <i class="ph-fill ph-facebook-logo text-2xl"></i>
            </a>

            {{-- Instagram (Direct ke Profile/App) --}}
            <a href="https://www.instagram.com/" 
               target="_blank" 
               class="w-12 h-12 rounded-full bg-gradient-to-tr from-[#f09433] via-[#dc2743] to-[#bc1888] text-white opacity-90 flex items-center justify-center hover:opacity-100 hover:scale-110 transition-all shadow-sm">
                <i class="ph-fill ph-instagram-logo text-2xl"></i>
            </a>

            {{-- Copy Link --}}
            <button onclick="copyToClipboard('Link')" 
                    class="w-12 h-12 rounded-full bg-slate-100 text-slate-600 flex items-center justify-center hover:bg-slate-800 hover:text-white transition-all shadow-sm"
                    title="Salin Link">
                <i class="ph-bold ph-link text-2xl"></i>
            </button>
        </div>

    </div>
</div>

                {{-- BERITA TERKAIT --}}
                <div class="mt-10 md:mt-14 border-t border-slate-100 pt-8">
                    <div class="flex items-center justify-between mb-5 px-0">
                        <h3 class="font-display font-bold text-lg text-brand-dark flex items-center gap-2 border-l-4 border-brand-red pl-3">
                            Berita Terkait
                        </h3>
                    </div>
                    <div class="flex md:grid md:grid-cols-3 gap-5 overflow-x-auto md:overflow-visible pb-6 -mx-4 px-4 md:mx-0 md:px-0 snap-x snap-mandatory no-scrollbar">
                        @foreach($relatedNews as $rNews)
                        <a href="{{ route('news.show', $rNews->slug) }}" class="group block relative flex-shrink-0 w-[260px] md:w-auto snap-center md:snap-align-none transition-transform active:scale-95 md:active:scale-100">
                            <div class="rounded-xl overflow-hidden mb-3 aspect-video bg-slate-100 relative shadow-card border border-slate-100 group-hover:shadow-md transition-all">
                                @if($rNews->categories->count() > 0)
                                    <span class="absolute top-2 left-2 bg-brand-red/90 backdrop-blur-sm text-white text-[9px] font-bold px-2 py-0.5 rounded shadow-sm z-10">{{ $rNews->categories->first()->name }}</span>
                                @endif
                                <img src="{{ Storage::url($rNews->thumbnail) }}" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
                            </div>
                            <div class="px-1">
                                <div class="flex items-center gap-2 text-[10px] text-slate-400 mb-1.5 font-medium">
                                    <i class="ph-fill ph-calendar-blank"></i>
                                    <span>{{ $rNews->created_at->format('d M Y') }}</span>
                                </div>
                                <h4 class="font-display font-bold text-sm text-slate-800 leading-snug group-hover:text-brand-red transition-colors line-clamp-2">{{ $rNews->title }}</h4>
                            </div>
                        </a>
                        @endforeach
                    </div>
                </div>
            </article>

            {{-- SIDEBAR KANAN --}}
            <div class="px-4 py-6 bg-white">
                <div class="flex items-center gap-2 mb-5">
                    <i class="ph-fill ph-trend-up text-brand-red text-xl"></i>
                    <h2 class="font-display font-bold text-lg text-brand-dark">Sedang Trending</h2>
                </div>
                <div class="flex flex-col gap-4">
                    @foreach($sidebarNews as $index => $sNews)
                        <a href="{{ route('news.show', $sNews->slug) }}" class="flex gap-4 items-center group">
                            <span class="text-2xl font-black text-slate-200 w-6 text-center group-hover:text-brand-red/50 transition-colors">{{ $index + 1 }}</span>
                            <div class="flex-1">
                                <h4 class="text-sm font-bold text-slate-800 leading-snug line-clamp-2 mb-1 group-hover:text-brand-red transition-colors">{{ $sNews->title }}</h4>
                            </div>
                            <div class="w-16 h-16 rounded-lg overflow-hidden shrink-0 bg-slate-100">
                                <img src="{{ Storage::url($sNews->thumbnail) }}" class="w-full h-full object-cover">
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>

            {{-- IMPLEMENTASI 2: IKLAN SIDEBAR (LOGIKA POPUP) --}}
            <div class="px-4 pb-8 pt-2">
                @if($sidebarAd && $sidebarAd->image)
                    @php 
                        $isPopupSidebar = empty($sidebarAd->link) || $sidebarAd->link === '#'; 
                    @endphp

                    <a href="{{ $isPopupSidebar ? 'javascript:void(0)' : $sidebarAd->link }}" 
                       @if($isPopupSidebar) 
                            @click.prevent="lightboxOpen = true; lightboxImage = '{{ Storage::url($sidebarAd->image) }}'" 
                       @else 
                            target="_blank" 
                       @endif
                       class="block relative rounded-xl overflow-hidden shadow-sm border border-slate-100 group transition-transform active:scale-95">
                       
                       <span class="absolute top-0 right-0 bg-brand-misty text-slate-600 text-[8px] font-bold px-2 py-0.5 rounded-bl-lg z-10 border-l border-b border-white">ADS</span>
                       <img src="{{ Storage::url($sidebarAd->image) }}" class="w-full h-auto object-cover">
                    </a>
                @endif
            </div>
        </div>
    </main>

    {{-- FOOTER --}}
    <footer class="bg-brand-misty pt-10 pb-8 border-t border-slate-200 mt-8">
        <div class="container mx-auto px-6">
            <div class="text-center mb-8">
                <div class="flex justify-center items-center gap-2 mb-3">
                    @if($company && $company->logo) <img src="{{ Storage::url($company->logo) }}" alt="Logo Footer" class="h-8 w-auto object-contain">
                    @else <h2 class="font-display font-extrabold text-xl text-brand-dark">GAUNG<span class="text-brand-red">NUSRA</span></h2> @endif
                </div>
                <div class="flex justify-center gap-3">
                    <a href="https://www.instagram.com/gaungnusra" target="_blank" class="w-8 h-8 rounded-lg bg-white shadow-sm border border-slate-100 flex items-center justify-center text-slate-400 hover:bg-brand-red hover:text-white transition-all"><i class="ph-fill ph-instagram-logo text-lg"></i></a>
                    <a href="https://www.facebook.com/gaungnusra" target="_blank" class="w-8 h-8 rounded-lg bg-white shadow-sm border border-slate-100 flex items-center justify-center text-slate-400 hover:bg-blue-600 hover:text-white transition-all"><i class="ph-fill ph-facebook-logo text-lg"></i></a>
                    <a href="#" class="w-8 h-8 rounded-lg bg-white shadow-sm border border-slate-100 flex items-center justify-center text-slate-400 hover:bg-black hover:text-white transition-all"><i class="ph-fill ph-x-logo text-lg"></i></a>
                </div>
            </div>
            <div class="grid grid-cols-2 gap-6 border-t border-slate-200 pt-6 mb-6">
                <div>
                    <h3 class="font-display font-bold text-brand-dark mb-3 text-xs tracking-wide uppercase">Kategori</h3>
                    <ul class="space-y-2 text-slate-500 text-xs font-medium">
                        @foreach($categories->take(5) as $cat) <li><a href="{{ route('category.show', $cat->slug) }}" class="hover:text-brand-red transition-colors">{{ $cat->name }}</a></li> @endforeach
                    </ul>
                </div>
                <div class="space-y-6">
                    <div>
                        <h3 class="font-display font-bold text-brand-dark mb-3 text-xs tracking-wide uppercase">Redaksi</h3>
                        <ul class="space-y-2 text-slate-500 text-xs font-medium"><li><a href="{{ route('pages.about') }}" class="hover:text-brand-red transition-colors">Profil Redaksi</a></li></ul>
                    </div>
                    <div>
                        <h3 class="font-display font-bold text-brand-dark mb-3 text-xs tracking-wide uppercase">Layanan</h3>
                        <ul class="space-y-2 text-slate-500 text-xs font-medium">
                        <li>
                            <a href="{{ route('pages.advertise') }}" class="hover:text-brand-red transition-colors">
                                Pasang Iklan
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('epaper.latest') }}" target="_blank" class="hover:text-brand-red transition-colors">
                                Koran Cetak
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
            </div>
            <div class="border-t border-slate-200 pt-6 text-center">
                <p class="text-[10px] text-slate-400 font-medium">&copy; {{ date('Y') }} {{ $company->name ?? 'Gaung Nusra' }}. All rights reserved.</p>
            </div>
        </div>
    </footer>

    {{-- IMPLEMENTASI 4: MODAL LIGHTBOX --}}
    <div x-show="lightboxOpen" 
         x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
         class="fixed inset-0 z-[100] flex items-center justify-center bg-black/90 p-4" x-cloak>
        <button @click="lightboxOpen = false" class="absolute top-6 right-6 text-white hover:text-brand-red transition-colors p-2 bg-black/50 rounded-full"><i class="ph-bold ph-x text-3xl"></i></button>
        <div class="relative max-w-5xl w-full flex justify-center" @click.away="lightboxOpen = false">
            <img :src="lightboxImage" class="max-w-full max-h-[90vh] object-contain shadow-2xl rounded-lg">
        </div>
    </div>

    {{-- SCRIPTS --}}
    <script>
        function copyToClipboard(text) {
            if(text === 'Link') text = window.location.href;
            var dummy = document.createElement('input'); document.body.appendChild(dummy); dummy.value = text; dummy.select(); document.execCommand('copy'); document.body.removeChild(dummy);
            alert('Link berhasil disalin!');
        }

        function initSearch(inputId, resultsId) {
            var input = $(inputId); var results = $(resultsId); var timeout = null;
            input.on('keyup', function() {
                var query = $(this).val(); clearTimeout(timeout);
                if (query.length < 2) { results.html('').removeClass('active').hide(); return; }
                timeout = setTimeout(function() {
                    $.ajax({
                        url: "{{ route('search.news') }}", type: 'GET', data: { q: query },
                        success: function(data) {
                            var html = '';
                            if (data.length > 0) {
                                html += '<div class="py-2">';
                                $.each(data, function(index, item) {
                                    html += `<a href="${item.url}" class="flex items-center gap-3 px-4 py-3 hover:bg-slate-50 transition-colors group">
                                                <div class="w-8 h-8 rounded bg-slate-100 overflow-hidden"><img src="${item.image}" class="w-full h-full object-cover"></div>
                                                <div class="flex-1 min-w-0"><h4 class="text-sm font-bold text-slate-700 truncate group-hover:text-brand-red">${item.title}</h4></div></a>`;
                                });
                                html += '</div>'; results.html(html).addClass('active').show();
                            } else { results.html('<div class="p-4 text-center text-xs text-slate-400">Tidak ditemukan.</div>').addClass('active').show(); }
                        }
                    });
                }, 300);
            });
            $(document).on('click', function(e) { if (!$(e.target).closest(inputId).length && !$(e.target).closest(resultsId).length) { results.hide(); } });
        }

        $(document).ready(function() {
            initSearch('#desktop-search-input', '#desktop-search-results');
            initSearch('#mobile-search-input', '#mobile-search-results');
        });
    </script>
</body>
</html>