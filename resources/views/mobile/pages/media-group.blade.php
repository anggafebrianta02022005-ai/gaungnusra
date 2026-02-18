<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#F1F5F9">
    <meta name="description" content="Jaringan Media Group Gaung Nusra. Partner informasi terpercaya di Nusa Tenggara dan Indonesia.">
    <title>Media Group - Gaung Nusra</title>
    
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
        .no-scrollbar::-webkit-scrollbar { display: none; }
        .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
        .search-results-container { display: none; }
        [x-cloak] { display: none !important; }
    </style>
</head>
<body class="bg-white text-slate-800 flex flex-col min-h-screen" x-data="{ mobileMenu: false, searchOpen: false }">

    {{-- HEADER (KONSISTEN) --}}
    <header class="bg-white border-b border-gray-100 py-3 md:py-4 relative z-50">
        <div class="container mx-auto px-4 lg:px-8 flex justify-between items-center relative min-h-[40px]">
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
            
            {{-- Search Desktop (Hidden on Mobile) --}}
            <div class="hidden md:block w-full max-w-md relative group ml-auto mr-4">
                <div class="relative transition-all duration-300">
                    <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-gray-400"><i class="ph ph-magnifying-glass text-lg"></i></span>
                    <input type="text" id="desktop-search-input" autocomplete="off" placeholder="Cari berita..." class="w-full bg-brand-misty text-slate-800 border border-transparent rounded-full py-2.5 pl-10 pr-4 text-sm focus:bg-white focus:border-brand-red focus:ring-4 focus:ring-brand-red/10 focus:outline-none transition-all shadow-sm">
                    <div id="desktop-search-results" class="search-results-container absolute top-full left-0 w-full mt-2 bg-white rounded-xl shadow-xl border border-slate-100 overflow-hidden z-50"></div>
                </div>
            </div>

            {{-- Tombol Mobile --}}
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

    {{-- NAVBAR KATEGORI (KONSISTEN) --}}
    <div class="bg-white border-b border-slate-100 overflow-x-auto no-scrollbar sticky top-0 z-40">
        <div class="flex items-center px-4 h-12 gap-2 min-w-max">
            <a href="/" class="px-3 py-1.5 text-xs font-medium text-slate-600 hover:text-brand-dark hover:bg-slate-50 rounded-full border border-transparent transition-all">Berita Utama</a>
            @foreach($categories as $navCat)
                <a href="{{ route('category.show', $navCat->slug) }}" class="px-3 py-1.5 text-xs font-bold rounded-full border border-transparent text-slate-600 hover:bg-slate-50 transition-all">
                    {{ $navCat->name }}
                </a>
            @endforeach
        </div>
    </div>

    {{-- SIDEBAR MOBILE MENU --}}
    <div x-show="mobileMenu" class="fixed inset-0 z-[60] bg-black/50 backdrop-blur-sm" @click="mobileMenu = false" x-transition.opacity style="display: none;"></div>
    <div x-show="mobileMenu" class="fixed top-0 right-0 h-full w-[80%] max-w-[300px] bg-white z-[70] shadow-2xl p-6 overflow-y-auto" 
         x-transition:enter="transition transform ease-out duration-300" x-transition:enter-start="translate-x-full" x-transition:enter-end="translate-x-0"
         x-transition:leave="transition transform ease-in duration-300" x-transition:leave-start="translate-x-0" x-transition:leave-end="translate-x-full" style="display: none;">
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

    {{-- KONTEN UTAMA: MEDIA GROUP --}}
    <main class="flex-grow bg-slate-50">
        
        {{-- Hero Section Simple --}}
        <div class="bg-white px-4 py-8 pb-10 text-center border-b border-slate-100 rounded-b-[2rem] shadow-sm">
            <span class="inline-block px-3 py-1 bg-brand-red/10 text-brand-red text-[10px] font-bold tracking-widest rounded-full mb-3 uppercase">Jaringan Kami</span>
            <h1 class="font-display font-extrabold text-3xl text-brand-dark mb-2">Media Group</h1>
            <p class="text-sm text-slate-500 leading-relaxed max-w-xs mx-auto">
                Sinergi informasi terpercaya dari berbagai platform di bawah naungan Gaung Nusra.
            </p>
        </div>

        {{-- Daftar Media (Grid 2 Kolom Mobile) --}}
        <div class="px-4 -mt-6 pb-12">
            <div class="grid grid-cols-2 gap-4">
                
                {{-- CARD 1: Gaung Nusra (Utama) --}}
                <div class="bg-white p-4 rounded-xl shadow-card border border-slate-100 flex flex-col items-center text-center group hover:-translate-y-1 transition-transform duration-300">
                    <div class="w-12 h-12 rounded-full bg-brand-misty flex items-center justify-center mb-3 text-brand-red">
                        <i class="ph-fill ph-globe-hemisphere-east text-2xl"></i>
                    </div>
                    <h3 class="font-bold text-sm text-brand-dark mb-1">Gaung Nusra</h3>
                    <p class="text-[10px] text-slate-400 mb-3">Portal Berita Utama</p>
                    <a href="/" class="w-full py-1.5 text-[10px] font-bold text-brand-red border border-brand-red/20 rounded-lg hover:bg-brand-red hover:text-white transition-colors">
                        Kunjungi
                    </a>
                </div>

                {{-- CARD 2: Gaung TV (Contoh) --}}
                <div class="bg-white p-4 rounded-xl shadow-card border border-slate-100 flex flex-col items-center text-center group hover:-translate-y-1 transition-transform duration-300">
                    <div class="w-12 h-12 rounded-full bg-blue-50 flex items-center justify-center mb-3 text-blue-600">
                        <i class="ph-fill ph-youtube-logo text-2xl"></i>
                    </div>
                    <h3 class="font-bold text-sm text-brand-dark mb-1">Gaung TV</h3>
                    <p class="text-[10px] text-slate-400 mb-3">Channel Youtube</p>
                    <a href="#" class="w-full py-1.5 text-[10px] font-bold text-blue-600 border border-blue-600/20 rounded-lg hover:bg-blue-600 hover:text-white transition-colors">
                        Tonton
                    </a>
                </div>

                {{-- CARD 3: E-Paper --}}
                <div class="bg-white p-4 rounded-xl shadow-card border border-slate-100 flex flex-col items-center text-center group hover:-translate-y-1 transition-transform duration-300">
                    <div class="w-12 h-12 rounded-full bg-green-50 flex items-center justify-center mb-3 text-green-600">
                        <i class="ph-fill ph-newspaper text-2xl"></i>
                    </div>
                    <h3 class="font-bold text-sm text-brand-dark mb-1">Koran Digital</h3>
                    <p class="text-[10px] text-slate-400 mb-3">E-Paper Harian</p>
                    <a href="{{ route('epaper.latest') }}" target="_blank" class="w-full py-1.5 text-[10px] font-bold text-green-600 border border-green-600/20 rounded-lg hover:bg-green-600 hover:text-white transition-colors">
                        Baca
                    </a>
                </div>

                {{-- CARD 4: Radio (Contoh) --}}
                <div class="bg-white p-4 rounded-xl shadow-card border border-slate-100 flex flex-col items-center text-center group hover:-translate-y-1 transition-transform duration-300">
                    <div class="w-12 h-12 rounded-full bg-purple-50 flex items-center justify-center mb-3 text-purple-600">
                        <i class="ph-fill ph-radio text-2xl"></i>
                    </div>
                    <h3 class="font-bold text-sm text-brand-dark mb-1">Radio Gaung</h3>
                    <p class="text-[10px] text-slate-400 mb-3">Streaming Audio</p>
                    <a href="#" class="w-full py-1.5 text-[10px] font-bold text-purple-600 border border-purple-600/20 rounded-lg hover:bg-purple-600 hover:text-white transition-colors">
                        Dengar
                    </a>
                </div>

                {{-- CARD 5: Social Media --}}
                <div class="bg-white p-4 rounded-xl shadow-card border border-slate-100 flex flex-col items-center text-center group hover:-translate-y-1 transition-transform duration-300 col-span-2">
                    <div class="flex gap-3 mb-3">
                        <div class="w-10 h-10 rounded-full bg-pink-50 flex items-center justify-center text-pink-600"><i class="ph-fill ph-instagram-logo text-xl"></i></div>
                        <div class="w-10 h-10 rounded-full bg-blue-50 flex items-center justify-center text-blue-600"><i class="ph-fill ph-facebook-logo text-xl"></i></div>
                        <div class="w-10 h-10 rounded-full bg-black/5 flex items-center justify-center text-black"><i class="ph-fill ph-tiktok-logo text-xl"></i></div>
                    </div>
                    <h3 class="font-bold text-sm text-brand-dark mb-1">Sosial Media</h3>
                    <p class="text-[10px] text-slate-400 mb-0">Ikuti update terbaru kami di platform favorit Anda.</p>
                </div>

            </div>

            {{-- CTA Box --}}
            <div class="mt-8 bg-brand-dark rounded-xl p-6 text-center relative overflow-hidden">
                {{-- Dekorasi Background --}}
                <div class="absolute top-0 right-0 -mr-6 -mt-6 w-24 h-24 bg-white/10 rounded-full blur-xl"></div>
                <div class="absolute bottom-0 left-0 -ml-6 -mb-6 w-24 h-24 bg-brand-red/20 rounded-full blur-xl"></div>
                
                <div class="relative z-10">
                    <h3 class="font-display font-bold text-lg text-white mb-2">Ingin Bermitra?</h3>
                    <p class="text-xs text-blue-100 mb-4 leading-relaxed">
                        Perluas jangkauan bisnis Anda dengan beriklan di jaringan media kami.
                    </p>
                    <a href="https://wa.me/{{ $company->phone ?? '' }}" target="_blank" class="inline-flex items-center gap-2 bg-white text-brand-dark px-5 py-2.5 rounded-lg text-xs font-bold shadow-lg active:scale-95 transition-transform">
                        <i class="ph-fill ph-whatsapp-logo text-lg text-green-500"></i> Hubungi Kami
                    </a>
                </div>
            </div>
        </div>

    </main>

    {{-- FOOTER (KONSISTEN) --}}
    <footer class="bg-white pt-10 pb-8 border-t border-slate-200">
        <div class="container mx-auto px-6">
            <div class="text-center mb-8">
                <div class="flex justify-center items-center gap-2 mb-3">
                    @if($company && $company->logo) <img src="{{ Storage::url($company->logo) }}" alt="Logo Footer" class="h-8 w-auto object-contain">
                    @else <h2 class="font-display font-extrabold text-xl text-brand-dark">GAUNG<span class="text-brand-red">NUSRA</span></h2> @endif
                </div>
                <div class="flex justify-center gap-3">
                    <a href="#" class="w-8 h-8 rounded-lg bg-slate-50 border border-slate-100 flex items-center justify-center text-slate-400 hover:bg-brand-red hover:text-white transition-all"><i class="ph-fill ph-instagram-logo text-lg"></i></a>
                    <a href="#" class="w-8 h-8 rounded-lg bg-slate-50 border border-slate-100 flex items-center justify-center text-slate-400 hover:bg-blue-600 hover:text-white transition-all"><i class="ph-fill ph-facebook-logo text-lg"></i></a>
                    <a href="#" class="w-8 h-8 rounded-lg bg-slate-50 border border-slate-100 flex items-center justify-center text-slate-400 hover:bg-black hover:text-white transition-all"><i class="ph-fill ph-x-logo text-lg"></i></a>
                </div>
            </div>
            <div class="grid grid-cols-2 gap-6 border-t border-slate-100 pt-6 mb-6">
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
            <div class="border-t border-slate-100 pt-6 text-center">
                <p class="text-[10px] text-slate-400 font-medium">&copy; {{ date('Y') }} {{ $company->name ?? 'Gaung Nusra' }}. All rights reserved.</p>
            </div>
        </div>
    </footer>

    {{-- SCRIPTS (SEARCH LOGIC SAJA, TIDAK PERLU LIGHTBOX DI HALAMAN INI) --}}
    <script>
        function initSearch(inputId, resultsId) {
            var input = $(inputId); var results = $(resultsId); var timeout = null;
            input.on('keyup', function() {
                var query = $(this).val(); clearTimeout(timeout);
                if (query.length < 2) { results.html('').hide(); return; }
                timeout = setTimeout(function() {
                    $.ajax({
                        url: "{{ route('search.news') }}", type: 'GET', data: { q: query },
                        success: function(data) {
                            var html = '';
                            if (data.length > 0) {
                                html += '<div class="py-2">';
                                $.each(data, function(index, item) {
                                    html += `<a href="${item.url}" class="block px-4 py-3 border-b border-slate-50 hover:bg-slate-50 text-sm font-bold text-slate-700 flex items-center gap-3"><div class="w-8 h-8 rounded bg-slate-100 overflow-hidden"><img src="${item.image}" class="w-full h-full object-cover"></div><span class="truncate">${item.title}</span></a>`;
                                });
                                html += '</div>'; results.html(html).show();
                            } else { results.html('<div class="p-4 text-center text-xs text-slate-400">Tidak ditemukan.</div>').show(); }
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