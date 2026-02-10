<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#F1F5F9">
    <meta name="description" content="{{ $news->subtitle ?? Str::limit(strip_tags($news->content), 150) }}">
    <meta name="author" content="{{ $news->author->name ?? 'Redaksi' }}">
    <title>{{ $news->title }} - Gaung Nusra</title>
    
    {{-- CSS & FONTS --}}
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <link rel="icon" type="image/png" href="{{ asset('gaungnusra.png') }}?v=3">
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
    </style>
</head>
<body class="bg-white text-slate-800 flex flex-col min-h-screen" x-data="{ mobileMenu: false, searchOpen: false }">

    {{-- HEADER (SAMA PERSIS MOBILE) --}}
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

    {{-- NAVBAR KATEGORI (GAYA PILLS SEIRAS) --}}
    <div class="bg-white border-b border-slate-100 overflow-x-auto no-scrollbar sticky top-0 z-40">
        <div class="flex items-center px-4 h-12 gap-2 min-w-max">
            
            <a href="/" class="px-3 py-1.5 text-xs font-medium text-slate-600 hover:text-brand-dark hover:bg-slate-50 rounded-full border border-transparent transition-all">Berita Utama</a>
            
            @foreach($categories as $navCat)
                @php
                    // Logika Universal:
                    $isActive = false;
                    // 1. Cek jika di halaman kategori
                    if(request()->url() == route('category.show', $navCat->slug)) {
                        $isActive = true;
                    }
                    // 2. Cek jika baca berita (Cek route 'news.show' dulu)
                    elseif(request()->routeIs('news.show') && isset($news) && $news->categories->count() > 0 && $news->categories->first()->id == $navCat->id) {
                        $isActive = true;
                    }
                @endphp

                <a href="{{ route('category.show', $navCat->slug) }}" 
                   class="px-3 py-1.5 text-xs font-bold rounded-full border transition-all 
                   {{ $isActive ? 'text-brand-red bg-brand-red/10 border-brand-red/20' : 'text-slate-600 border-transparent hover:bg-slate-50' }}">
                    {{ $navCat->name }}
                </a>
            @endforeach
        </div>
    </div>

    {{-- SIDEBAR MOBILE MENU (SLIDE FROM RIGHT) --}}
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
                @php
                    $isActiveMobile = false;
                    if(request()->url() == route('category.show', $navCat->slug)) { $isActiveMobile = true; }
                    elseif(request()->routeIs('news.show') && isset($news) && $news->categories->count() > 0 && $news->categories->first()->id == $navCat->id) { $isActiveMobile = true; }
                @endphp
                <a href="{{ route('category.show', $navCat->slug) }}" 
                   class="block px-3 py-2.5 text-sm font-medium rounded-lg transition-colors 
                   {{ $isActiveMobile ? 'text-brand-red font-bold bg-red-50' : 'text-slate-700 hover:bg-slate-50' }}">
                    {{ $navCat->name }}
                </a>
            @endforeach
        </div>
    </div>

    {{-- KONTEN UTAMA (LAYOUT DETAIL BERITA) --}}
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

                {{-- SHARE BUTTONS --}}
                <div class="mt-10 pt-8 border-t border-slate-100 mb-10">
                    <div class="flex flex-col md:flex-row items-center justify-between gap-6">
                        <div class="flex items-center gap-2">
                            <span class="font-display font-bold text-slate-700">Bagikan:</span>
                        </div>
                       <div class="flex items-center gap-3">
    {{-- WhatsApp --}}
    <a href="https://api.whatsapp.com/send?text={{ urlencode($news->title . ' ' . request()->url()) }}" target="_blank" class="w-10 h-10 rounded-full bg-[#25D366]/10 text-[#25D366] flex items-center justify-center hover:bg-[#25D366] hover:text-white transition-all">
        <i class="ph-fill ph-whatsapp-logo text-xl"></i>
    </a>

    {{-- Facebook --}}
    <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(request()->url()) }}" target="_blank" class="w-10 h-10 rounded-full bg-[#1877F2]/10 text-[#1877F2] flex items-center justify-center hover:bg-[#1877F2] hover:text-white transition-all">
        <i class="ph-fill ph-facebook-logo text-xl"></i>
    </a>

    {{-- Instagram (Gaung Nusra) --}}
    <a href="https://www.instagram.com/gaungnusra?igsh=cDJqMmJ3Zm9pMmpt" target="_blank" class="w-10 h-10 rounded-full bg-[#E1306C]/10 text-[#E1306C] flex items-center justify-center hover:bg-[#E1306C] hover:text-white transition-all" title="Instagram Gaung Nusra">
        <i class="ph-fill ph-instagram-logo text-xl"></i>
    </a>

    {{-- Copy Link --}}
    <button onclick="copyToClipboard('Link')" class="w-10 h-10 rounded-full bg-slate-100 text-slate-600 flex items-center justify-center hover:bg-slate-800 hover:text-white transition-all" title="Salin Link">
        <i class="ph-bold ph-link text-xl"></i>
    </button>
</div>
                    </div>
                </div>

                {{-- BERITA TERKAIT --}}
                <div class="mt-12">
                    <h3 class="font-display font-bold text-lg text-brand-dark mb-4 flex items-center gap-2 border-l-4 border-brand-red pl-3">Berita Terkait</h3>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        @foreach($relatedNews as $rNews)
                        <a href="{{ route('news.show', $rNews->slug) }}" class="group block h-full">
                            <div class="rounded-lg overflow-hidden mb-3 aspect-video bg-slate-100 relative shadow-sm">
                                <img src="{{ Storage::url($rNews->thumbnail) }}" class="w-full h-full object-cover">
                            </div>
                            <h4 class="font-bold text-sm text-slate-800 leading-snug group-hover:text-brand-red transition-colors line-clamp-3">{{ $rNews->title }}</h4>
                        </a>
                        @endforeach
                    </div>
                </div>
            </article>

            {{-- SIDEBAR KANAN --}}
            <aside class="lg:col-span-4 space-y-8 pl-0 lg:pl-6 border-l border-transparent lg:border-slate-100">
                <div class="bg-white rounded-xl p-5 shadow-card border border-slate-100">
                    <h3 class="font-display font-bold text-base text-brand-dark mb-4 border-b border-slate-100 pb-2">Sedang Trending</h3>
                    <div class="space-y-5">
                        @foreach($sidebarNews as $index => $sNews)
                            <a href="{{ route('news.show', $sNews->slug) }}" class="group flex gap-3 items-start relative">
                                <span class="absolute -left-2 -top-2 w-5 h-5 flex items-center justify-center bg-white border border-slate-100 shadow-sm rounded-full text-[10px] font-bold {{ $index < 3 ? 'text-brand-red' : 'text-slate-400' }} z-10">#{{ $index + 1 }}</span>
                                <div class="w-20 h-20 img-wrapper rounded-lg flex-shrink-0 shadow-sm"><img src="{{ Storage::url($sNews->thumbnail) }}" class="w-full h-full object-cover"></div>
                                <div class="flex-1 py-0.5"><h4 class="font-display text-sm font-bold text-brand-dark leading-snug line-clamp-2 group-hover:text-brand-red transition-colors">{{ $sNews->title }}</h4></div>
                            </a>
                        @endforeach
                    </div>
                </div>
                
                @if($sidebarAd)
                <div>
                    <a href="{{ $sidebarAd->link ?? '#' }}" class="block rounded-xl overflow-hidden shadow-card"><img src="{{ Storage::url($sidebarAd->image) }}" class="w-full h-auto"></a>
                </div>
                @endif
            </aside>
        </div>
    </main>

    {{-- FOOTER (SAMA PERSIS MOBILE) --}}
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