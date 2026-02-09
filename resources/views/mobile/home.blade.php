<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#F1F5F9">
    <title>Gaung Nusra - Media Online</title>
    
    {{-- CSS & FONTS --}}
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
    </style>
</head>
<body class="bg-white text-slate-800 flex flex-col min-h-screen" x-data="{ mobileMenu: false, searchOpen: false }">

    {{-- 1. HEADER (LOGO & ACTIONS) --}}
    <header class="bg-white border-b border-gray-100 py-3 relative z-50">
        <div class="container mx-auto px-4 flex justify-between items-center relative min-h-[40px]">
            
            {{-- LOGO --}}
            <a href="/" class="flex items-center gap-3 select-none shrink-0 z-10">
                @if($company && $company->logo)
                    <img src="{{ Storage::url($company->logo) }}" alt="{{ $company->name }}" class="block h-8 w-auto object-contain">
                @else
                    <div class="flex flex-col leading-none">
                        <span class="font-serif text-xl font-bold text-brand-red tracking-tight">Gaung</span>
                        <span class="font-display text-[10px] font-extrabold text-brand-dark tracking-widest uppercase -mt-0.5">NUSRA</span>
                    </div>
                @endif
            </a>
            
            {{-- TOMBOL AKSI MOBILE --}}
            <div class="flex items-center gap-2 ml-auto z-20">
                {{-- Tombol Search --}}
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

    {{-- 2. INPUT SEARCH MOBILE (Overlay Dropdown) --}}
    <div x-show="searchOpen" 
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0 -translate-y-2"
         x-transition:enter-end="opacity-100 translate-y-0"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100 translate-y-0"
         x-transition:leave-end="opacity-0 -translate-y-2"
         class="px-4 py-3 bg-white border-b border-slate-100 shadow-sm relative z-40" style="display: none;">
        
        <div class="relative">
            <span class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-brand-red"><i class="ph-bold ph-magnifying-glass"></i></span>
            <input x-ref="mobileSearchInput" type="text" id="mobile-search-input" placeholder="Ketik kata kunci berita..." class="w-full bg-brand-misty border-none rounded-lg py-2.5 pl-10 pr-4 text-sm focus:ring-2 focus:ring-brand-red outline-none shadow-inner">
            <div id="mobile-search-results" class="search-results-container absolute top-full left-0 w-full mt-2 bg-white rounded-xl shadow-xl border border-slate-100 overflow-hidden z-50"></div>
        </div>
    </div>

    {{-- 3. NAVBAR KATEGORI (UNIVERSAL LOGIC) --}}
    <nav class="sticky top-0 z-40 bg-white/95 backdrop-blur-md border-b border-gray-100 shadow-sm transition-all">
        <div class="px-4 py-2">
            <div class="flex items-center gap-2 h-10 overflow-x-auto no-scrollbar">
                
                {{-- Tombol Home --}}
                <a href="/" 
                   class="shrink-0 px-4 py-1.5 rounded-full text-xs font-bold border shadow-sm whitespace-nowrap transition-colors
                   {{ request()->is('/') ? 'bg-brand-red text-white border-brand-red' : 'bg-white text-slate-600 border-slate-200 hover:border-brand-red' }}">
                    Berita Utama
                </a>

                {{-- Loop Kategori --}}
                @foreach($categories as $navCategory)
                    @php
                        // Logika Navbar Universal (Sama dengan Desktop)
                        $isCategoryPage = request()->url() == route('category.show', $navCategory->slug);
                        $isNewsPage = request()->routeIs('news.show') && isset($news) && $news->categories->count() > 0 && $news->categories->first()->id == $navCategory->id;
                        $isActive = $isCategoryPage || $isNewsPage;
                    @endphp

                    <a href="{{ route('category.show', $navCategory->slug) }}" 
                       class="shrink-0 px-4 py-1.5 rounded-full text-xs font-medium border whitespace-nowrap active:scale-95 transition-transform
                       {{ $isActive ? 'bg-brand-red text-white border-brand-red' : 'bg-slate-50 text-slate-600 border-slate-100 hover:bg-slate-100' }}">
                        {{ $navCategory->name }}
                    </a>
                @endforeach

            </div>
        </div>
    </nav>

    {{-- 4. SIDEBAR MOBILE MENU (BURGER CONTENT) --}}
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
            <button @click="mobileMenu = false" class="w-8 h-8 rounded-full bg-slate-100 flex items-center justify-center text-slate-500"><i class="ph-bold ph-x"></i></button>
        </div>
        
        <div class="space-y-2">
            <a href="/" class="block px-3 py-2.5 text-sm font-bold rounded-lg {{ request()->is('/') ? 'text-brand-red bg-red-50' : 'text-slate-700 hover:bg-slate-50' }}">Berita Utama</a>
            
            @foreach($categories as $navCategory)
                @php
                    $isCategoryPage = request()->url() == route('category.show', $navCategory->slug);
                    $isNewsPage = request()->routeIs('news.show') && isset($news) && $news->categories->count() > 0 && $news->categories->first()->id == $navCategory->id;
                    $isActive = $isCategoryPage || $isNewsPage;
                @endphp
                <a href="{{ route('category.show', $navCategory->slug) }}" 
                   class="block px-3 py-2.5 text-sm font-medium rounded-lg transition-colors {{ $isActive ? 'text-brand-red font-bold bg-red-50' : 'text-slate-600 hover:bg-slate-50' }}">
                    {{ $navCategory->name }}
                </a>
            @endforeach
        </div>
    </div>

    {{-- IKLAN HEADER --}}
    <div class="px-4 pt-4 pb-2">
        @if($headerAd)
            <a href="{{ $headerAd->link ?? '#' }}" class="block rounded-xl overflow-hidden shadow-sm border border-slate-100">
                <img src="{{ Storage::url($headerAd->image) }}" class="w-full h-auto object-cover max-h-[250px]">
            </a>
        @endif
    </div>

    {{-- KONTEN UTAMA --}}
    <main class="flex-grow bg-white">
        
        <div class="px-4 py-4">
            <div class="flex items-center gap-2 mb-4">
                <div class="w-1 h-5 bg-brand-red rounded-full"></div>
                <h2 class="font-display font-bold text-lg text-brand-dark">Berita Terbaru</h2>
            </div>

            <div class="flex flex-col gap-4" id="news-container">
                @foreach($latestNews as $loopNews) {{-- Ubah nama variabel agar aman --}}
                    
                    {{-- 1. HEADLINE MOBILE (BERITA PERTAMA) --}}
                    @if($loop->first)
                        <a href="{{ route('news.show', $loopNews->slug) }}" class="group block relative bg-white rounded-2xl overflow-hidden shadow-card border border-slate-100 mb-2">
                            <div class="relative w-full aspect-video overflow-hidden bg-slate-100">
                                <img src="{{ Storage::url($loopNews->thumbnail) }}" alt="{{ $loopNews->title }}" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105">
                                @if($loopNews->pin_order)
                                    <div class="absolute top-3 left-3 bg-brand-red text-white text-[10px] font-bold px-2.5 py-1 rounded-full shadow-md z-10">HEADLINE</div>
                                @endif
                            </div>
                            <div class="p-4">
                                <span class="text-[10px] font-bold text-brand-red uppercase tracking-wide mb-1 block">{{ $loopNews->categories->first()->name ?? 'Berita' }}</span>
                                <h2 class="text-lg font-bold text-slate-900 leading-snug mb-2 line-clamp-3 group-hover:text-brand-red transition-colors">{{ $loopNews->title }}</h2>
                                <div class="flex items-center gap-3 text-xs text-slate-500">
                                    <span class="flex items-center gap-1"><i class="ph-fill ph-calendar-blank text-brand-red"></i> {{ $loopNews->published_at->format('d M Y') }}</span>
                                </div>
                            </div>
                        </a>

                    {{-- 2. BERITA LIST BIASA --}}
                    @else
                        <article class="flex gap-4 border-b border-slate-100 pb-4 last:border-0 last:pb-0">
                            <a href="{{ route('news.show', $loopNews->slug) }}" class="w-24 h-24 shrink-0 rounded-lg overflow-hidden bg-slate-100 relative">
                                <img src="{{ Storage::url($loopNews->thumbnail) }}" class="w-full h-full object-cover">
                            </a>
                            <div class="flex-1 flex flex-col justify-center py-0.5">
                                <div>
                                    <span class="text-[10px] font-bold text-brand-red uppercase tracking-wide mb-1 block">{{ $loopNews->categories->first()->name ?? 'Umum' }}</span>
                                    <h3 class="text-sm font-bold text-slate-800 leading-snug line-clamp-2 mb-1.5">
                                        <a href="{{ route('news.show', $loopNews->slug) }}">{{ $loopNews->title }}</a>
                                    </h3>
                                </div>
                                <div class="flex items-center gap-2 mt-1">
                                    <span class="text-[10px] text-slate-400">{{ $loopNews->published_at->diffForHumans() }}</span>
                                </div>
                            </div>
                        </article>
                    @endif

                @endforeach
            </div>

            {{-- TOMBOL LOAD MORE --}}
            @if($latestNews->hasMorePages())
                <div class="mt-6 text-center" id="load-more-wrapper">
                    <button id="btn-load-more" data-page="2" class="px-6 py-2.5 bg-white text-brand-red border border-brand-red/30 rounded-full text-xs font-bold shadow-sm w-full active:bg-brand-red active:text-white transition-colors flex items-center justify-center gap-2">
                        <span>Muat Lebih Banyak</span>
                        <i class="ph-bold ph-arrow-down"></i>
                    </button>
                    <div id="loading-indicator" class="hidden py-2"><span class="text-xs text-slate-400 animate-pulse">Memuat...</span></div>
                </div>
            @endif
        </div>

        <div class="h-2 bg-slate-100 border-y border-slate-200"></div>

        {{-- TRENDING --}}
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
                            <div class="flex items-center gap-2">
                                <span class="text-[10px] text-slate-400">{{ $sNews->published_at->diffForHumans() }}</span>
                            </div>
                        </div>
                        <div class="w-16 h-16 rounded-lg overflow-hidden shrink-0 bg-slate-100">
                            <img src="{{ Storage::url($sNews->thumbnail) }}" class="w-full h-full object-cover">
                        </div>
                    </a>
                @endforeach
            </div>
        </div>

        {{-- IKLAN BAWAH --}}
        <div class="px-4 pb-8 pt-2">
            @if($sidebarAd)
                <div class="text-[10px] text-slate-400 text-center mb-1">SPONSORED</div>
                <a href="{{ $sidebarAd->link ?? '#' }}" class="block rounded-xl overflow-hidden shadow-sm border border-slate-100">
                    <img src="{{ Storage::url($sidebarAd->image) }}" class="w-full h-auto object-cover">
                </a>
            @endif
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

    {{-- SCRIPTS (SEARCH & LOAD MORE) --}}
    <script>
        // Fungsi Pencarian
        function initSearch(inputId, resultsId) {
            var input = $(inputId);
            var results = $(resultsId);
            var timeout = null;

            input.on('keyup', function() {
                var query = $(this).val();
                clearTimeout(timeout);
                
                if (query.length < 2) { 
                    results.html('').removeClass('active').hide(); 
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
                                results.html(html).addClass('active').show();
                            } else {
                                results.html('<div class="p-4 text-center text-xs text-slate-400">Tidak ditemukan.</div>').addClass('active').show();
                            }
                        }
                    });
                }, 300);
            });
        }

        $(document).ready(function() {
            // Init Search
            initSearch('#mobile-search-input', '#mobile-search-results');

            // Load More Logic
            $('#btn-load-more').click(function() {
                var page = $(this).data('page');
                var btn = $(this);
                var loader = $('#loading-indicator');
                
                btn.addClass('hidden');
                loader.removeClass('hidden');

                $.ajax({
                    url: '/?page=' + page,
                    type: 'GET',
                    success: function(response) {
                        setTimeout(function() {
                            if(response.trim() != '') {
                                $('#news-container').append(response);
                                btn.data('page', page + 1);
                                btn.removeClass('hidden');
                                loader.addClass('hidden');
                            } else {
                                loader.addClass('hidden');
                                btn.parent().html('<span class="text-xs text-slate-400">Semua berita ditampilkan.</span>');
                            }
                        }, 500);
                    }
                });
            });
        });
    </script>
</body>
</html>