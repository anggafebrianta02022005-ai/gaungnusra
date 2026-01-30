<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#F1F5F9">
    <title>Kategori {{ $category->name }} - {{ $company->name ?? 'Portal Berita' }}</title>
    
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

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
        .img-wrapper { overflow: hidden; position: relative; background-color: #e2e8f0; }
        
        header.scrolled { 
            background-color: rgba(255, 255, 255, 0.9); 
            backdrop-filter: blur(12px); 
            box-shadow: 0 4px 20px -2px rgba(0, 0, 0, 0.05); 
            border-bottom-color: transparent; 
        }
        #search-results { display: none; }
        #search-results.active { display: block; }
    </style>
</head>
<body class="bg-white text-slate-800 flex flex-col min-h-screen" x-data="{ searchOpen: false }">

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

            <div class="hidden md:flex items-center gap-2 pl-6 border-l border-gray-300 h-6 animate-fade-in-up" style="animation-delay: 0.1s;">
                <a href="https://www.instagram.com/gaungnusra?igsh=cDJqMmJ3Zm9pMmpt" target="_blank" class="text-slate-400 hover:text-brand-red transition-colors">
                    <i class="ph-fill ph-instagram-logo text-lg"></i>
                </a>
                <a href="https://www.facebook.com/share/1DvqTnVEtY/?mibextid=wwXIfr" target="_blank" class="text-slate-400 hover:text-blue-600 transition-colors">
                    <i class="ph-fill ph-facebook-logo text-lg"></i>
                </a>
                <a href="https://www.threads.com/@gaungnusra?igshid=NTc4MTIwNjQ2YQ==" target="_blank" class="text-slate-400 hover:text-black transition-colors">
                    <i class="ph-fill ph-threads-logo text-lg"></i>
                </a>
                <a href="#" class="text-slate-400 hover:text-black transition-colors">
                    <i class="ph-fill ph-x-logo text-lg"></i>
                </a>
            </div>
        </div>
    </header>

    <nav class="sticky top-0 z-40 bg-brand-misty/90 backdrop-blur-xl border-b border-gray-200/50 shadow-sm transition-all animate-fade-in-up" style="animation-delay: 0.15s;">
        <div class="container mx-auto px-4 lg:px-8">
            <div class="flex items-center justify-between h-14">
                <div class="flex items-center gap-1 h-full overflow-x-auto no-scrollbar">
                    <a href="/" class="relative h-full flex items-center px-4 text-sm font-medium text-slate-600 hover:text-brand-dark transition-all duration-300 group"><i class="ph-fill ph-house mr-2"></i> Home</a>
                    @foreach($categories as $cat)
                        <a href="{{ route('category.show', $cat->slug) }}" class="relative h-full flex items-center px-4 text-sm font-medium {{ $category->id == $cat->id ? 'text-brand-red font-bold border-b-[3px] border-brand-red bg-white/50' : 'text-slate-600' }} hover:text-brand-dark transition-all duration-300 group">
                            {{ $cat->name }}
                            <span class="absolute bottom-0 left-1/2 -translate-x-1/2 w-0 h-[3px] bg-brand-red/20 rounded-t-full transition-all duration-300 group-hover:w-1/2 opacity-0 group-hover:opacity-100"></span>
                        </a>
                    @endforeach
                </div>
            </div>
        </div>
    </nav>

    <div class="bg-white border-b border-slate-100 animate-fade-in-up" style="animation-delay: 0.2s;">
        <div class="container mx-auto px-4 lg:px-8 py-6 flex flex-col items-center">
            @if($headerAd && $headerAd->image)
                <a href="{{ $headerAd->link ?? '#' }}" target="_blank" class="relative group block w-fit mx-auto rounded-2xl overflow-hidden hover:shadow-lg transition-all duration-500 hover:-translate-y-1">
                    <div class="absolute top-0 right-0 bg-brand-misty text-slate-600 text-[10px] font-bold px-3 py-1 rounded-bl-xl backdrop-blur-sm z-20 border-l border-b border-white">SPONSORED</div>
                    <img src="{{ Storage::url($headerAd->image) }}" 
                         alt="Iklan Header" 
                         class="block w-auto h-auto max-w-full max-h-[250px] md:max-h-[350px] object-contain rounded-xl shadow-card border border-slate-100">
                </a>
            @endif
        </div>
    </div>

    <main class="container mx-auto px-4 lg:px-8 py-10 flex-grow bg-white">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-12">
            
            <div class="lg:col-span-8 animate-fade-in-up" style="animation-delay: 0.3s;">
                <div class="mb-10 pb-6 border-b border-slate-100">
                    <span class="text-xs font-bold text-slate-400 uppercase tracking-widest">Kategori</span>
                    <h1 class="font-display font-extrabold text-3xl text-brand-dark mt-1">{{ $category->name }}</h1>
                </div>

                <div class="flex flex-col gap-8" id="news-container">
                    @if($news->count() > 0)
                        @foreach($news as $item)
                            <article class="group flex flex-col md:flex-row gap-6 border-b border-slate-100 pb-8 last:border-0">
                                <a href="{{ route('news.show', $item->slug) }}" class="w-full md:w-1/3 aspect-video md:aspect-[4/3] rounded-2xl overflow-hidden bg-slate-100 relative shrink-0 shadow-sm group-hover:shadow-md transition-all">
                                    <img src="{{ Storage::url($item->thumbnail) }}" alt="{{ $item->title }}" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105">
                                </a>
                                <div class="flex-1 flex flex-col justify-center">
                                    <div class="flex items-center gap-2 mb-2">
                                        <span class="text-xs text-slate-400 flex items-center gap-1"><i class="ph-bold ph-calendar-blank"></i> {{ $item->published_at->format('d M Y') }}</span>
                                    </div>
                                    <h3 class="font-display font-bold text-xl text-slate-800 leading-snug mb-3 group-hover:text-brand-red transition-colors">
                                        <a href="{{ route('news.show', $item->slug) }}">{{ $item->title }}</a>
                                    </h3>
                                    <p class="text-sm text-slate-500 line-clamp-2 mb-4 leading-relaxed">
                                        {{ $item->subtitle ?? Str::limit(strip_tags($item->content), 120) }}
                                    </p>
                                    <div class="flex items-center gap-2 text-xs text-slate-400">
                                        <span class="font-bold text-slate-600">{{ $item->author->name ?? 'Redaksi' }}</span>
                                        <span>•</span>
                                        <span><i class="ph-fill ph-eye"></i> {{ number_format($item->views_count) }} Views</span>
                                    </div>
                                </div>
                            </article>
                        @endforeach
                    @else
                        <div class="text-center py-20 bg-slate-50 rounded-2xl border border-dashed border-slate-200">
                            <i class="ph-duotone ph-newspaper text-4xl text-slate-300 mb-3"></i>
                            <p class="text-slate-500 font-medium">Belum ada berita di kategori ini.</p>
                        </div>
                    @endif
                </div>

                @if($news->hasMorePages())
                    <div class="mt-14 pb-8 flex flex-col items-center justify-center" id="load-more-wrapper">
                        <button id="btn-load-more" data-page="2" class="px-8 py-3 bg-white text-slate-600 font-display font-bold text-sm rounded-full border border-slate-200 shadow-sm hover:border-brand-red hover:text-brand-red transition-all flex items-center gap-2">
                            <span>Muat Lebih Banyak</span><i class="ph-bold ph-arrow-down"></i>
                        </button>
                    </div>
                @endif
            </div>

            <aside class="lg:col-span-4 space-y-10 pl-0 lg:pl-6 border-l border-transparent lg:border-slate-100 animate-fade-in-up" style="animation-delay: 0.4s;">
                <div class="sticky top-24 space-y-8">
                    <div class="bg-white rounded-2xl p-6 shadow-card border border-slate-100">
                        <div class="flex items-center justify-between mb-6 pb-4 border-b border-slate-50">
                            <h3 class="font-display font-bold text-lg text-brand-dark flex items-center gap-2">
                                <i class="ph-fill ph-trend-up text-brand-red"></i> Trending
                            </h3>
                        </div> 
                        <div class="space-y-6">
                            @foreach($sidebarNews as $index => $sNews)
                                <a href="{{ route('news.show', $sNews->slug) }}" class="group flex gap-4 items-start relative">
                                    <span class="absolute -left-3 -top-3 w-7 h-7 flex items-center justify-center bg-white border border-slate-100 shadow-sm rounded-full text-xs font-bold {{ $index < 3 ? 'text-brand-red' : 'text-slate-400' }} z-10 font-display">#{{ $index + 1 }}</span>
                                    <div class="w-24 h-24 img-wrapper rounded-xl flex-shrink-0 shadow-sm group-hover:shadow-md transition-all overflow-hidden">
                                        <img src="{{ Storage::url($sNews->thumbnail) }}" loading="lazy" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110">
                                    </div>
                                    <div class="flex-1 py-1">
                                        <h4 class="font-display text-sm font-bold text-brand-dark leading-snug line-clamp-3 group-hover:text-brand-red transition-colors duration-200 mb-2">{{ $sNews->title }}</h4>
                                        <div class="flex items-center gap-2 text-[10px] text-slate-400 font-medium">
                                            <i class="ph-fill ph-eye"></i> {{ number_format($sNews->views_count) }}
                                        </div>
                                    </div>
                                </a>
                            @endforeach
                        </div>
                    </div>

                    <div>
                        @if($sidebarAd && $sidebarAd->image)
                            <a href="{{ $sidebarAd->link ?? '#' }}" class="block relative rounded-2xl overflow-hidden shadow-card group hover:shadow-lg transition-all duration-500 hover:-translate-y-1">
                                <span class="absolute top-3 right-3 bg-brand-misty text-[10px] font-bold px-2 py-0.5 rounded text-slate-500 z-10 tracking-widest border border-white">ADS</span>
                                <img src="{{ Storage::url($sidebarAd->image) }}" alt="Iklan Sidebar" loading="lazy" class="w-full h-auto">
                            </a>
                        @else
                            <div class="bg-brand-misty h-[300px] w-full flex flex-col items-center justify-center text-slate-300 rounded-2xl text-center p-6 border border-slate-200 shadow-sm relative overflow-hidden group">
                                <i class="ph-duotone ph-image text-4xl mb-2 opacity-50"></i>
                                <span class="font-bold text-lg text-slate-400">Space Iklan</span>
                            </div>
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
                        <a href="#" class="text-slate-400 hover:text-black transition-colors">
                            <i class="ph-fill ph-x-logo text-lg"></i>
                        </a>
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

    <script>
        $(document).ready(function() {
            // Sticky Header Glass
            $(window).scroll(function() {
                var scroll = $(window).scrollTop();
                if (scroll >= 50) {
                    $('#main-header').addClass('scrolled');
                } else {
                    $('#main-header').removeClass('scrolled');
                }
            });

            // Load More Logic
            $('#btn-load-more').click(function() {
                var page = $(this).data('page');
                var btn = $(this);
                btn.html('<span>Memuat...</span>');
                
                var url = window.location.href.split('?')[0] + '?page=' + page; 

                $.ajax({
                    url: url,
                    type: 'GET',
                    success: function(response) {
                        if(response.trim() != '') {
                            $('#news-container').append(response);
                            btn.data('page', page + 1);
                            btn.html('<span>Muat Lebih Banyak</span><i class="ph-bold ph-arrow-down"></i>');
                        } else {
                            btn.parent().html('<span class="text-sm text-slate-400 italic">Semua berita ditampilkan.</span>');
                        }
                    }
                });
            });

            // Search
            var searchInput = $('#search-input');
            var searchResults = $('#search-results');
            var timeout = null;

            searchInput.on('keyup', function() {
                var query = $(this).val();
                clearTimeout(timeout);
                if (query.length < 2) { searchResults.html('').removeClass('active'); return; }
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
                                    html += `<a href="${item.url}" class="flex items-center gap-3 px-4 py-3 hover:bg-slate-50 transition-colors group">
                                            <div class="w-12 h-12 rounded-lg overflow-hidden shrink-0 bg-slate-100"><img src="${item.image}" class="w-full h-full object-cover"></div>
                                            <div class="flex-1 min-w-0"><h4 class="text-sm font-bold text-slate-700 truncate group-hover:text-brand-red">${item.title}</h4></div></a>`;
                                });
                                html += '</div>';
                                searchResults.html(html).addClass('active');
                            } else {
                                searchResults.html('<div class="p-4 text-center text-sm text-slate-400">Tidak ditemukan.</div>').addClass('active');
                            }
                        }
                    });
                }, 300);
            });
        });
    </script>
</body>
</html>