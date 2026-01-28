<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#F1F5F9">
    <title>{{ $company->name ?? 'Portal Berita' }}</title>
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
        body { background-color: #ffffff; }
        .line-clamp-2 { display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; }
        .line-clamp-3 { display: -webkit-box; -webkit-line-clamp: 3; -webkit-box-orient: vertical; overflow: hidden; }
        
        /* Hide Scrollbar but allow scroll */
        .no-scrollbar::-webkit-scrollbar { display: none; }
        .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }

        /* Search Styles */
        #search-results { display: none; }
        #search-results.active { display: block; }
    </style>
</head>
<body class="bg-white text-slate-800 flex flex-col min-h-screen" x-data="{ mobileMenu: false, searchOpen: false }">

    <header class="bg-white border-b border-gray-100 py-3 md:py-4 relative z-50">
        <div class="container mx-auto px-4 lg:px-8 flex justify-between items-center relative">
            
            {{-- LOGO: Menggunakan Absolute Center pada Mobile (left-1/2) dan Static pada Desktop --}}
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
            
            {{-- SEARCH (Desktop Only) --}}
            <div class="hidden md:block w-full max-w-md relative group ml-auto mr-4">
                <div class="relative transition-all duration-300 transform origin-left" :class="{ 'scale-105': searchOpen }">
                    <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-gray-400 group-focus-within:text-brand-red transition-colors"><i class="ph ph-magnifying-glass text-lg"></i></span>
                    <input type="text" id="search-input" autocomplete="off" @focus="searchOpen = true" @blur="setTimeout(() => searchOpen = false, 200)" placeholder="Cari berita..." class="w-full bg-brand-misty text-slate-800 border border-transparent rounded-full py-2.5 pl-10 pr-4 text-sm focus:bg-white focus:border-brand-red focus:ring-4 focus:ring-brand-red/10 focus:outline-none transition-all shadow-sm placeholder:text-gray-400">
                    <div id="search-results" class="absolute top-full left-0 w-full mt-2 bg-white rounded-xl shadow-xl border border-slate-100 overflow-hidden z-50"></div>
                </div>
            </div>

            {{-- TOMBOL MENU MOBILE (Pojok Kanan - ml-auto memaksanya ke kanan) --}}
            <button @click="mobileMenu = !mobileMenu" class="md:hidden ml-auto w-9 h-9 flex items-center justify-center rounded-full bg-brand-misty text-brand-dark hover:bg-brand-red hover:text-white transition-all active:scale-95 z-20">
                <i class="ph ph-list text-xl" x-show="!mobileMenu"></i>
                <i class="ph ph-x text-xl" x-show="mobileMenu" x-cloak></i>
            </button>
        </div>
    </header>
    {{-- ============================================================== --}}
    {{-- UPDATE 1 SELESAI --}}
    {{-- ============================================================== --}}

    <div x-show="searchOpen" class="px-4 py-3 bg-white border-b border-slate-100" x-transition>
        <div class="relative">
            <input type="text" id="search-input" placeholder="Cari berita..." class="w-full bg-brand-misty border-none rounded-lg py-2.5 px-4 text-sm focus:ring-2 focus:ring-brand-red outline-none">
            <div id="search-results" class="absolute top-full left-0 w-full mt-2 bg-white rounded-xl shadow-xl border border-slate-100 overflow-hidden z-50"></div>
        </div>
    </div>

    <div class="bg-white border-b border-slate-100 overflow-x-auto no-scrollbar">
        <div class="flex items-center px-4 h-12 gap-2 min-w-max">
            <a href="/" class="px-3 py-1.5 text-xs font-bold text-brand-red bg-brand-red/10 rounded-full border border-brand-red/20">Berita Utama</a>
            @foreach($categories as $category)
                <a href="{{ route('category.show', $category->slug) }}" class="px-3 py-1.5 text-xs font-medium text-slate-600 hover:text-brand-dark hover:bg-slate-50 rounded-full border border-transparent transition-all">
                    {{ $category->name }}
                </a>
            @endforeach
        </div>
    </div>

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
            <a href="/" class="block px-3 py-2.5 text-sm font-bold text-brand-red bg-red-50 rounded-lg">Home</a>
            @foreach($categories as $cat)
                <a href="{{ route('category.show', $cat->slug) }}" class="block px-3 py-2.5 text-sm font-medium text-slate-700 hover:bg-slate-50 rounded-lg">{{ $cat->name }}</a>
            @endforeach
        </div>
    </div>

    <div class="px-4 pt-4 pb-2">
        @if($headerAd)
            <a href="{{ $headerAd->link ?? '#' }}" class="block rounded-xl overflow-hidden shadow-sm border border-slate-100">
                <img src="{{ Storage::url($headerAd->image) }}" class="w-full h-auto object-cover max-h-[250px]">
            </a>
        @endif
    </div>

    <main class="flex-grow bg-white">
        
        <div class="px-4 py-4">
            <div class="flex items-center gap-2 mb-4">
                <div class="w-1 h-5 bg-brand-red rounded-full"></div>
                <h2 class="font-display font-bold text-lg text-brand-dark">Berita Terbaru</h2>
            </div>

            <div class="flex flex-col gap-4" id="news-container">
                @foreach($latestNews as $news)
                    <article class="flex gap-4 border-b border-slate-100 pb-4 last:border-0 last:pb-0">
                        <a href="{{ route('news.show', $news->slug) }}" class="w-28 h-20 shrink-0 rounded-lg overflow-hidden bg-slate-100 relative">
                             @if($news->pin_order)
                                <div class="absolute top-1 left-1 bg-brand-red text-white text-[8px] font-bold px-1.5 py-0.5 rounded shadow-sm">HEADLINE</div>
                            @endif
                            <img src="{{ Storage::url($news->thumbnail) }}" class="w-full h-full object-cover">
                        </a>
                        
                        <div class="flex-1 flex flex-col justify-between py-0.5">
                            <div>
                                <span class="text-[10px] font-bold text-brand-red uppercase tracking-wide mb-0.5 block">
                                    {{ $news->categories->first()->name ?? 'Umum' }}
                                </span>
                                <h3 class="text-sm font-bold text-slate-800 leading-snug line-clamp-2">
                                    <a href="{{ route('news.show', $news->slug) }}">{{ $news->title }}</a>
                                </h3>
                            </div>
                            <div class="flex items-center gap-2 mt-1">
                                <span class="text-[10px] text-slate-400">{{ $news->published_at->diffForHumans() }}</span>
                            </div>
                        </div>
                    </article>
                @endforeach
            </div>

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
                                <span class="text-[10px] text-slate-400"><i class="ph-fill ph-eye"></i> {{ number_format($sNews->views_count) }}</span>
                            </div>
                        </div>
                        
                        <div class="w-16 h-16 rounded-lg overflow-hidden shrink-0 bg-slate-100">
                            <img src="{{ Storage::url($sNews->thumbnail) }}" class="w-full h-full object-cover">
                        </div>
                    </a>
                @endforeach
            </div>
        </div>

        <div class="px-4 pb-8 pt-2">
            @if($sidebarAd)
                <div class="text-[10px] text-slate-400 text-center mb-1">SPONSORED</div>
                <a href="{{ $sidebarAd->link ?? '#' }}" class="block rounded-xl overflow-hidden shadow-sm border border-slate-100">
                    <img src="{{ Storage::url($sidebarAd->image) }}" class="w-full h-auto object-cover">
                </a>
            @endif
        </div>

    </main>

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
                </p>
                <div class="flex justify-center gap-3">
                    <a href="#" class="w-8 h-8 rounded-lg bg-white shadow-sm border border-slate-100 flex items-center justify-center text-slate-400 hover:bg-brand-red hover:text-white transition-all"><i class="ph-fill ph-instagram-logo text-lg"></i></a>
                    <a href="#" class="w-8 h-8 rounded-lg bg-white shadow-sm border border-slate-100 flex items-center justify-center text-slate-400 hover:bg-blue-600 hover:text-white transition-all"><i class="ph-fill ph-facebook-logo text-lg"></i></a>
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
                            
                        </ul>
                    </div>
                </div>
            </div>

            <div class="border-t border-slate-200 pt-6 text-center">
                <p class="text-[10px] text-slate-400 font-medium">
                    &copy; {{ date('Y') }} {{ $company->name ?? 'Gaung Nusra' }}. All rights reserved.
                </p>
                <div class="mt-1 text-[10px] text-slate-400">
                    Dibuat Oleh Udayana Digital Data
                </div>
            </div>

        </div>
    </footer>

    <script>
        $(document).ready(function() {
            // === LOAD MORE KHUSUS MOBILE ===
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

            // === SEARCH MOBILE ===
            var searchInput = $('#search-input');
            var searchResults = $('#search-results');
            var timeout = null;
            searchInput.on('keyup', function() {
                var query = $(this).val();
                clearTimeout(timeout);
                if (query.length < 2) { searchResults.html('').hide(); return; }
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
                                            <img src="${item.image}" class="w-8 h-8 rounded object-cover">
                                            <span class="truncate">${item.title}</span>
                                        </a>`;
                                });
                                html += '</div>';
                                searchResults.html(html).show();
                            } else {
                                searchResults.html('<div class="p-4 text-center text-xs text-slate-400">Tidak ditemukan.</div>').show();
                            }
                        }
                    });
                }, 300);
            });
        });
    </script>
</body>
</html>