<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#F1F5F9">
    {{-- Meta Data Khusus Detail Berita --}}
    <meta name="description" content="{{ $news->subtitle ?? Str::limit(strip_tags($news->content), 150) }}">
    <meta name="author" content="{{ $news->author->name ?? 'Redaksi' }}">
    <title>{{ $news->title }} - Gaung Nusra - Media Online</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <link rel="icon" type="image/png" href="{{ asset('gaungnusra.png') }}?v=3">
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
        body { -webkit-font-smoothing: antialiased; -moz-osx-font-smoothing: grayscale; background-color: #ffffff; }
        ::-webkit-scrollbar { width: 8px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: #CBD5E1; border-radius: 10px; border: 2px solid #fff; }
        .img-wrapper { overflow: hidden; position: relative; background-color: #e2e8f0; }
        
        /* === STYLE KONTEN BERITA === */
        .article-content { font-size: 1.05rem; line-height: 1.8; color: #334155; }
        .article-content p { margin-bottom: 1.5em; }
        .article-content h2, .article-content h3 { font-family: 'Plus Jakarta Sans', sans-serif; font-weight: 700; color: #1E3A8A; margin-top: 2em; margin-bottom: 0.75em; }
        .article-content ul { list-style-type: disc; margin-left: 1.5em; margin-bottom: 1.5em; }
        .article-content ol { list-style-type: decimal; margin-left: 1.5em; margin-bottom: 1.5em; }
        .article-content a { color: #D32F2F; text-decoration: underline; text-underline-offset: 2px; }
        
        /* === REVISI GAMBAR DI DALAM ARTIKEL === */
        .article-content img { 
            width: auto !important;       
            max-width: 85% !important;    
            height: auto !important;      
            border-radius: 8px;
            margin: 24px auto;            
            box-shadow: 0 4px 10px -1px rgba(0, 0, 0, 0.1); 
            display: block;               
        }

        .article-content figcaption {
            text-align: center; font-size: 0.85rem; color: #64748B; margin-top: -15px; margin-bottom: 30px; font-style: italic;
        }
        
        .search-results-container { display: none; }
        .no-scrollbar::-webkit-scrollbar { display: none; }
        .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
    </style>
</head>
<body class="bg-white text-slate-800 flex flex-col min-h-screen selection:bg-brand-misty selection:text-brand-dark" x-data="{ mobileMenu: false, searchOpen: false }">

    {{-- HEADER UTAMA --}}
    <header class="bg-white border-b border-gray-100 py-3 md:py-4 relative z-50">
        <div class="container mx-auto px-4 lg:px-8 flex justify-between items-center relative min-h-[40px]">
            
            {{-- 1. LOGO (Tengah di HP, Kiri di Desktop) --}}
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
            
            {{-- 2. SEARCH BAR (Khusus Desktop) --}}
            <div class="hidden md:block w-full max-w-md relative group ml-auto mr-4">
                <div class="relative transition-all duration-300 transform origin-left">
                    <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-gray-400 group-focus-within:text-brand-red transition-colors"><i class="ph ph-magnifying-glass text-lg"></i></span>
                    <input type="text" id="desktop-search-input" autocomplete="off" placeholder="Cari berita..." class="w-full bg-brand-misty text-slate-800 border border-transparent rounded-full py-2.5 pl-10 pr-4 text-sm focus:bg-white focus:border-brand-red focus:ring-4 focus:ring-brand-red/10 focus:outline-none transition-all shadow-sm placeholder:text-gray-400">
                    <div id="desktop-search-results" class="search-results-container absolute top-full left-0 w-full mt-2 bg-white rounded-xl shadow-xl border border-slate-100 overflow-hidden z-50"></div>
                </div>
            </div>

            {{-- 3. TOMBOL MENU & SEARCH (Khusus Mobile) --}}
            <div class="flex items-center gap-2 ml-auto md:hidden z-20">
                {{-- Tombol Search Mobile --}}
                <button 
                    @click="searchOpen = !searchOpen; if(searchOpen) $nextTick(() => $refs.mobileSearchInput.focus())" 
                    class="w-9 h-9 flex items-center justify-center rounded-full text-slate-600 hover:bg-slate-100 transition-all active:scale-95"
                    :class="{ 'bg-brand-red/10 text-brand-red': searchOpen }">
                    <i class="ph text-xl" :class="searchOpen ? 'ph-x' : 'ph-magnifying-glass'"></i>
                </button>

                {{-- Tombol Menu Burger --}}
                <button @click="mobileMenu = !mobileMenu" class="w-9 h-9 flex items-center justify-center rounded-full bg-brand-misty text-brand-dark hover:bg-brand-red hover:text-white transition-all active:scale-95">
                    <i class="ph ph-list text-xl" x-show="!mobileMenu"></i>
                    <i class="ph ph-x text-xl" x-show="mobileMenu" x-cloak></i>
                </button>
            </div>
        </div>
    </header>

    {{-- INPUT SEARCH MOBILE (Overlay Dropdown) --}}
    <div x-show="searchOpen" 
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0 -translate-y-2"
         x-transition:enter-end="opacity-100 translate-y-0"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100 translate-y-0"
         x-transition:leave-end="opacity-0 -translate-y-2"
         class="px-4 py-3 bg-white border-b border-slate-100 shadow-sm relative z-40 md:hidden" style="display: none;">
        
        <div class="relative">
            <span class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-brand-red"><i class="ph-bold ph-magnifying-glass"></i></span>
            <input x-ref="mobileSearchInput" type="text" id="mobile-search-input" placeholder="Ketik kata kunci berita..." class="w-full bg-brand-misty border-none rounded-lg py-2.5 pl-10 pr-4 text-sm focus:ring-2 focus:ring-brand-red outline-none shadow-inner">
            <div id="mobile-search-results" class="search-results-container absolute top-full left-0 w-full mt-2 bg-white rounded-xl shadow-xl border border-slate-100 overflow-hidden z-50"></div>
        </div>
    </div>

    {{-- NAVBAR KATEGORI --}}
    <nav class="sticky top-0 z-40 bg-brand-misty/90 backdrop-blur-xl border-b border-gray-200/50 shadow-sm transition-all hidden md:block">
        <div class="container mx-auto px-4 lg:px-8">
            <div class="flex items-center justify-between h-14">
                <div class="flex items-center gap-1 h-full overflow-x-auto no-scrollbar mask-gradient">
                    <a href="/" class="relative h-full flex items-center px-4 text-sm font-medium text-slate-600 hover:text-brand-dark transition-all duration-300 group"><i class="ph-fill ph-house mr-2"></i>Berita Utama</a>
                    @foreach($categories as $category)
                        {{-- Logika Aktif: Jika berita ini masuk dalam kategori tersebut, maka warnanya merah --}}
                        <a href="{{ route('category.show', $category->slug) }}" class="relative h-full flex items-center px-4 text-sm font-medium {{ $news->categories->contains($category->id) ? 'text-brand-red font-bold border-b-2 border-brand-red' : 'text-slate-600' }} hover:text-brand-dark transition-all duration-300 group">
                            {{ $category->name }}
                        </a>
                    @endforeach
                </div>
            </div>
        </div>
    </nav>

    {{-- SIDEBAR MOBILE MENU --}}
    <div x-show="mobileMenu" class="md:hidden fixed inset-0 z-[60] bg-black/50 backdrop-blur-sm" @click="mobileMenu = false" x-transition.opacity style="display: none;"></div>
    <div x-show="mobileMenu" x-transition.origin.top class="md:hidden fixed inset-x-0 top-[60px] bg-white border-b border-gray-200 shadow-xl z-[70] max-h-[80vh] overflow-y-auto" style="display: none;">
        <div class="p-4 space-y-1">
            <a href="/" class="block px-4 py-3 text-sm font-bold text-slate-700 rounded-lg hover:bg-brand-misty">Home</a>
            @foreach($categories as $category)
                <a href="{{ route('category.show', $category->slug) }}" class="block px-4 py-3 text-sm font-medium {{ $news->categories->contains($category->id) ? 'text-brand-red font-bold bg-red-50' : 'text-slate-600' }} rounded-lg hover:bg-brand-misty hover:text-brand-red">{{ $category->name }}</a>
            @endforeach
        </div>
    </div>

    {{-- IKLAN HEADER --}}
    <div class="bg-white border-b border-slate-100">
        <div class="container mx-auto px-4 lg:px-8 py-6 flex flex-col items-center">
            @if($headerAd)
                <a href="{{ $headerAd->link ?? '#' }}" target="_blank" class="relative group block w-full max-w-5xl rounded-xl overflow-hidden shadow-card transition-all duration-500 hover:-translate-y-1 ring-1 ring-black/5">
                    <div class="absolute top-0 right-0 bg-brand-misty text-slate-600 text-[8px] font-bold px-2 py-0.5 rounded-bl-lg backdrop-blur-sm z-20 border-l border-b border-white">ADS</div>
                    <img src="{{ Storage::url($headerAd->image) }}" alt="Iklan Header" class="w-full h-auto max-h-[150px] md:max-h-[250px] object-cover">
                </a>
            @endif
        </div>
    </div>

    {{-- KONTEN UTAMA --}}
    <main class="container mx-auto px-4 lg:px-8 py-6 md:py-10 flex-grow bg-white">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-12">
            
            {{-- KOLOM KIRI: ARTIKEL --}}
            <article class="lg:col-span-8">
                
                <div class="flex items-center gap-2 mb-3">
                    <span class="w-1 h-5 bg-brand-red rounded-full"></span>
                    <span class="text-brand-red font-bold text-xs md:text-sm tracking-wide uppercase">{{ $news->categories->first()->name ?? 'Berita' }}</span>
                </div>

                <h1 class="font-display font-extrabold text-2xl md:text-3xl lg:text-[40px] leading-tight text-brand-dark mb-4">
                    {{ $news->title }}
                </h1>

                @if($news->subtitle)
                    <p class="text-base md:text-lg text-slate-500 font-medium leading-relaxed mb-6 font-sans">
                        {{ $news->subtitle }}
                    </p>
                @endif

                <div class="flex flex-wrap items-center gap-x-4 gap-y-2 text-xs text-slate-500 mb-6 pb-6 border-b border-slate-100">
                    <div class="flex items-center gap-2">
                        <div class="w-7 h-7 md:w-8 md:h-8 rounded-full bg-brand-misty flex items-center justify-center font-bold text-brand-dark border border-slate-200">
                            {{ substr($news->author->name ?? 'R', 0, 1) }}
                        </div>
                        <span class="font-bold text-slate-700">{{ $news->author->name ?? 'Redaksi' }}</span>
                    </div>
                    <span class="text-slate-300 hidden md:inline">•</span>
                    <div class="flex items-center gap-1">
                        <i class="ph-fill ph-calendar-blank"></i>
                        <span>{{ $news->published_at->format('d M Y, H:i') }}</span>
                    </div>
                </div>

                <figure class="w-full rounded-xl overflow-hidden shadow-sm mb-8 bg-slate-100">
                    <img src="{{ Storage::url($news->image ?? $news->thumbnail) }}" alt="{{ $news->title }}" class="w-full h-auto object-cover">
                    <figcaption class="text-center text-[10px] md:text-xs text-slate-400 mt-2 italic px-4">Ilustrasi: {{ $news->title }}</figcaption>
                </figure>

                <div class="article-content font-sans">
                    @php
                        $fixedContent = str_replace(
                            ['http://localhost:8000', 'http://127.0.0.1:8000'], 
                            '', 
                            $news->content
                        );
                    @endphp
                    {!! $fixedContent !!}
                </div>

                {{-- SHARE BUTTONS --}}
                <div class="mt-10 pt-8 border-t border-slate-100 mb-10 animate-fade-in-up" style="animation-delay: 0.2s;">
                    <div class="flex flex-col md:flex-row items-center justify-between gap-6">
                        <div class="flex items-center gap-2">
                            <span class="w-1 h-6 bg-brand-red rounded-full"></span>
                            <span class="font-display font-bold text-slate-700 text-lg">Bagikan Berita Ini:</span>
                        </div>

                        <div class="flex items-center gap-3">
                            <a href="https://api.whatsapp.com/send?text={{ urlencode($news->title . ' ' . request()->fullUrl()) }}" target="_blank" 
                               class="w-10 h-10 md:w-12 md:h-12 rounded-full bg-[#25D366]/10 text-[#25D366] flex items-center justify-center hover:bg-[#25D366] hover:text-white transition-all duration-300 hover:scale-110 shadow-sm"
                               title="Bagikan ke WhatsApp">
                                <i class="ph-fill ph-whatsapp-logo text-xl md:text-2xl"></i>
                            </a>

                            <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(request()->fullUrl()) }}" target="_blank" 
                               class="w-10 h-10 md:w-12 md:h-12 rounded-full bg-[#1877F2]/10 text-[#1877F2] flex items-center justify-center hover:bg-[#1877F2] hover:text-white transition-all duration-300 hover:scale-110 shadow-sm"
                               title="Bagikan ke Facebook">
                                <i class="ph-fill ph-facebook-logo text-xl md:text-2xl"></i>
                            </a>

                            <button onclick="copyToClipboard('IG')" 
                               class="w-10 h-10 md:w-12 md:h-12 rounded-full bg-gradient-to-tr from-[#f09433] via-[#dc2743] to-[#bc1888] text-white opacity-90 flex items-center justify-center hover:opacity-100 transition-all duration-300 hover:scale-110 shadow-sm"
                               title="Post ke Instagram">
                                <i class="ph-fill ph-instagram-logo text-xl md:text-2xl"></i>
                            </button>

                            <button onclick="copyToClipboard('Link')" 
                               class="group relative w-10 h-10 md:w-12 md:h-12 rounded-full bg-slate-100 text-slate-600 flex items-center justify-center hover:bg-slate-800 hover:text-white transition-all duration-300 hover:scale-110 shadow-sm"
                               title="Salin Link">
                                <i class="ph-bold ph-link text-xl md:text-2xl"></i>
                            </button>
                        </div>
                    </div>
                </div>

                {{-- BERITA TERKAIT --}}
                <div class="mt-12">
                    <h3 class="font-display font-bold text-lg text-brand-dark mb-4 flex items-center gap-2 border-l-4 border-brand-red pl-3">
                        Berita Terkait
                    </h3>
                    
                    <div class="flex overflow-x-auto gap-4 pb-4 no-scrollbar -mx-4 px-4 md:mx-0 md:px-0">
                        @foreach($relatedNews as $rNews)
                        <a href="{{ route('news.show', $rNews->slug) }}" class="min-w-[260px] md:min-w-[220px] w-[260px] md:w-auto flex flex-col group bg-white border border-slate-100 p-3 rounded-xl hover:shadow-md hover:border-brand-red transition-all">
                            <div class="w-full aspect-video rounded-lg overflow-hidden bg-slate-100 relative mb-3">
                                <img src="{{ Storage::url($rNews->thumbnail) }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                            </div>
                            <h4 class="font-bold text-sm text-slate-700 leading-snug group-hover:text-brand-red transition-colors line-clamp-2">
                                {{ $rNews->title }}
                            </h4>
                            <span class="text-[10px] text-slate-400 mt-auto pt-2 block">{{ $rNews->published_at->format('d M Y') }}</span>
                        </a>
                        @endforeach
                    </div>
                </div>
            </article>

            {{-- SIDEBAR KANAN --}}
            <aside class="lg:col-span-4 space-y-8 pl-0 lg:pl-6 border-l border-transparent lg:border-slate-100">
                <div class="bg-white rounded-xl p-5 shadow-card border border-slate-100">
                    <h3 class="font-display font-bold text-base text-brand-dark mb-4 flex items-center gap-2 border-b border-slate-100 pb-2">
                        <i class="ph-fill ph-trend-up text-brand-red"></i> Sedang Trending
                    </h3>
                    <div class="space-y-5">
                        @foreach($sidebarNews as $index => $sNews)
                            <a href="{{ route('news.show', $sNews->slug) }}" class="group flex gap-3 items-start relative">
                                <span class="absolute -left-2 -top-2 w-5 h-5 flex items-center justify-center bg-white border border-slate-100 shadow-sm rounded-full text-[10px] font-bold {{ $index < 3 ? 'text-brand-red' : 'text-slate-400' }} z-10">#{{ $index + 1 }}</span>
                                <div class="w-20 h-20 img-wrapper rounded-lg flex-shrink-0 shadow-sm group-hover:shadow-md transition-all">
                                    <img src="{{ Storage::url($sNews->thumbnail) }}" loading="lazy" class="w-full h-full object-cover">
                                </div>
                                <div class="flex-1 py-0.5">
                                    <h4 class="font-display text-sm font-bold text-brand-dark leading-snug line-clamp-2 group-hover:text-brand-red transition-colors duration-200 mb-1">{{ $sNews->title }}</h4>
                                </div>
                            </a>
                        @endforeach
                    </div>
                </div>

                <div class="sticky top-24">
                    @if($sidebarAd)
                        <a href="{{ $sidebarAd->link ?? '#' }}" class="block relative rounded-xl overflow-hidden shadow-card group hover:shadow-misty-glow transition-all duration-500 hover:-translate-y-1">
                            <span class="absolute top-2 right-2 bg-brand-misty text-[8px] font-bold px-2 py-0.5 rounded text-slate-500 z-10 tracking-widest border border-white">ADS</span>
                            <img src="{{ Storage::url($sidebarAd->image) }}" alt="Iklan Sidebar" loading="lazy" class="w-full h-auto">
                        </a>
                    @else
                        <div class="bg-brand-misty h-[300px] w-full flex flex-col items-center justify-center text-slate-300 rounded-xl text-center p-6 border border-slate-200 shadow-sm">
                            <span class="font-bold text-sm text-slate-400">Space Iklan</span>
                        </div>
                    @endif
                </div>
            </aside>

        </div>
    </main>

    {{-- FOOTER --}}
    <footer class="bg-brand-misty pt-10 pb-8 border-t border-slate-200 mt-8">
        <div class="container mx-auto px-6">
            <div class="text-center mb-8">
                <div class="flex justify-center items-center gap-2 mb-3">
                    @if($company && $company->logo)
                        <img src="{{ Storage::url($company->logo) }}" alt="Logo Footer" class="h-8 w-auto object-contain">
                    @else
                        <h2 class="font-display font-extrabold text-xl text-brand-dark">GAUNG<span class="text-brand-red">NUSRA</span></h2>
                    @endif
                </div>
                
               <div class="flex justify-center gap-3">
                    <a href="https://www.instagram.com/gaungnusra?igsh=cDJqMmJ3Zm9pMmpt" target="_blank" class="w-8 h-8 rounded-lg bg-white shadow-sm border border-slate-100 flex items-center justify-center text-slate-400 hover:bg-brand-red hover:text-white transition-all"><i class="ph-fill ph-instagram-logo text-lg"></i></a>
                    <a href="https://www.facebook.com/share/1DvqTnVEtY/?mibextid=wwXIfr" target="_blank" class="w-8 h-8 rounded-lg bg-white shadow-sm border border-slate-100 flex items-center justify-center text-slate-400 hover:bg-blue-600 hover:text-white transition-all"><i class="ph-fill ph-facebook-logo text-lg"></i></a>
                    <a href="https://www.threads.com/@gaungnusra?igshid=NTc4MTIwNjQ2YQ==" target="_blank" class="w-8 h-8 rounded-lg bg-white shadow-sm border border-slate-100 flex items-center justify-center text-slate-400 hover:bg-black hover:text-white transition-all"><i class="ph-fill ph-threads-logo text-lg"></i></a>
                    <a href="#" class="w-8 h-8 rounded-lg bg-white shadow-sm border border-slate-100 flex items-center justify-center text-slate-400 hover:bg-black hover:text-white transition-all"><i class="ph-fill ph-x-logo text-lg"></i></a>
                </div>
            </div>

            <div class="grid grid-cols-2 gap-6 border-t border-slate-200 pt-6 mb-6">
                <div>
                    <h3 class="font-display font-bold text-brand-dark mb-3 text-xs tracking-wide uppercase">Kategori</h3>
                    <ul class="space-y-2 text-slate-500 text-xs font-medium">
                        @foreach($categories->take(5) as $cat)
                            <li><a href="{{ route('category.show', $cat->slug) }}" class="hover:text-brand-red transition-colors">{{ $cat->name }}</a></li>
                        @endforeach
                    </ul>
                </div>
                <div class="space-y-6">
                    <div>
                        <h3 class="font-display font-bold text-brand-dark mb-3 text-xs tracking-wide uppercase">Redaksi</h3>
                        <ul class="space-y-2 text-slate-500 text-xs font-medium">
                             <li><a href="{{ route('pages.about') }}" class="hover:text-brand-red transition-colors">Profil Redaksi</a></li>  
                        </ul>
                    </div>
                    <div>
                        <h3 class="font-display font-bold text-brand-dark mb-3 text-xs tracking-wide uppercase">Layanan</h3>
                        <ul class="space-y-2 text-slate-500 text-xs font-medium">
                            <li><a href="{{ route('pages.advertise') }}" class="hover:text-brand-red transition-colors">Pasang Iklan</a></li>
                            <li><a href="{{ route('epaper.latest') }}" target="_blank" class="hover:text-brand-red transition-colors">Koran Cetak</a></li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="border-t border-slate-200 pt-6 text-center">
                <p class="text-[10px] text-slate-400 font-medium">&copy; {{ date('Y') }} {{ $company->name ?? 'Gaung Nusra' }}. All rights reserved.</p>
                <div class="mt-1 text-[10px] text-slate-400">Dibuat Oleh Udayana Digital Data</div>
            </div>
        </div>
    </footer>

    {{-- SCRIPTS (UNIFIED SEARCH) --}}
    <script>
        // Fungsi Pencarian Cerdas untuk Menangani 2 Input Berbeda (Desktop & Mobile)
        function initSearch(inputId, resultsId) {
            var input = $(inputId);
            var results = $(resultsId);
            var timeout = null;

            input.on('keyup', function() {
                var query = $(this).val();
                clearTimeout(timeout);
                
                if (query.length < 2) { 
                    results.html('').hide(); 
                    return; 
                }
                
                timeout = setTimeout(function() {
                    $.ajax({
                        url: "{{ route('search.news') }}",
                        type: 'GET',
                        data: { q: query },
                        success: function(data) {
                            var html = '';
                            if (data.length > 0) {
                                html += '<div class="py-2">';
                                $.each(data, function(index, item) {
                                    html += `<a href="${item.url}" class="block px-4 py-3 border-b border-slate-50 hover:bg-slate-50 text-sm font-bold text-slate-700 flex items-center gap-3">
                                                <img src="${item.image}" class="w-8 h-8 rounded object-cover shrink-0 bg-slate-100">
                                                <span class="truncate">${item.title}</span>
                                            </a>`;
                                });
                                html += '</div>';
                                results.html(html).show();
                            } else {
                                results.html('<div class="p-4 text-center text-xs text-slate-400">Tidak ditemukan.</div>').show();
                            }
                        }
                    });
                }, 300);
            });

            // Sembunyikan hasil kalau klik di luar
            $(document).on('click', function(e) {
                if (!$(e.target).closest(inputId).length && !$(e.target).closest(resultsId).length) {
                    results.hide();
                }
            });
        }

        // Fungsi Copy Link
        function copyToClipboard(type) {
            var dummy = document.createElement('input'),
                text = window.location.href;
            
            document.body.appendChild(dummy);
            dummy.value = text;
            dummy.select();
            document.execCommand('copy');
            document.body.removeChild(dummy);

            if(type === 'IG') {
                alert('Link disalin! Paste di Story atau Post Instagram Anda.');
            } else {
                alert('Link berita berhasil disalin!');
            }
        }

        $(document).ready(function() {
            // Aktifkan Search Desktop
            initSearch('#desktop-search-input', '#desktop-search-results');

            // Aktifkan Search Mobile
            initSearch('#mobile-search-input', '#mobile-search-results');
        });
    </script>
</body>
</html>