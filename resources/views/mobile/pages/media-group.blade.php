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

{{-- UPDATE 1: Menambahkan State Lightbox di body --}}
<body class="bg-white text-slate-800 flex flex-col min-h-screen" 
      x-data="{ mobileMenu: false, searchOpen: false, lightboxOpen: false, lightboxImage: '' }">

    {{-- HEADER --}}
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
            
            {{-- Search Desktop --}}
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

    {{-- NAVBAR KATEGORI --}}
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

    {{-- UPDATE 2: IKLAN HEADER (DENGAN LOGIKA POPUP) --}}
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

    {{-- KONTEN UTAMA: MEDIA GROUP --}}
    <main class="flex-grow bg-slate-50 relative overflow-hidden">
        
        {{-- Dekorasi Latar Belakang --}}
        <div class="absolute top-0 left-0 w-full h-64 bg-gradient-to-b from-brand-red/5 to-transparent z-0"></div>
        <div class="absolute -top-10 -right-10 w-40 h-40 bg-brand-dark/5 rounded-full blur-3xl z-0"></div>

        <div class="relative z-10 px-4 py-8 pb-10">
            
            {{-- Header Title --}}
            <div class="text-center mb-8">
                <span class="inline-flex items-center gap-1.5 px-3 py-1 bg-white border border-brand-red/20 text-brand-red text-[10px] font-bold tracking-widest rounded-full mb-4 uppercase shadow-sm">
                    <i class="ph-fill ph-handshake"></i> Partner Resmi
                </span>
                <h1 class="font-display font-extrabold text-3xl text-brand-dark leading-tight mb-2">
                    Jaringan Media <br> <span class="text-brand-red">Sumbawa</span>
                </h1>
                <p class="text-sm text-slate-500 max-w-xs mx-auto leading-relaxed">
                    Sinergi media lokal terpercaya untuk menyuarakan aspirasi Sumbawa ke pentas nasional.
                </p>
            </div>

            {{-- List Media (Card Design Modern) --}}
            <div class="flex flex-col gap-4 max-w-md mx-auto">

                {{-- Partner 1: Dinamika Sumbawa --}}
                <div class="bg-white p-4 rounded-xl shadow-sm border border-slate-100 flex items-center gap-4 group hover:shadow-md hover:border-brand-red/30 transition-all duration-300">
                    <div class="w-14 h-14 shrink-0 rounded-xl bg-gradient-to-br from-blue-500 to-blue-600 text-white flex items-center justify-center font-display font-bold text-xl shadow-lg shadow-blue-500/20">DS</div>
                    <div class="flex-1 min-w-0">
                        <h3 class="font-display font-bold text-slate-800 text-base mb-0.5 truncate">Dinamika Sumbawa</h3>
                        <p class="text-[11px] text-slate-400 font-medium truncate">dinamikasumbawa.com</p>
                    </div>
                    <a href="https://dinamikasumbawa.com" target="_blank" class="w-10 h-10 rounded-full bg-slate-50 text-slate-400 flex items-center justify-center group-hover:bg-blue-50 group-hover:text-blue-600 transition-colors"><i class="ph-bold ph-arrow-right"></i></a>
                </div>

                {{-- Partner 2: Laskar Merdeka --}}
                <div class="bg-white p-4 rounded-xl shadow-sm border border-slate-100 flex items-center gap-4 group hover:shadow-md hover:border-brand-red/30 transition-all duration-300">
                    <div class="w-14 h-14 shrink-0 rounded-xl bg-gradient-to-br from-red-500 to-red-600 text-white flex items-center justify-center font-display font-bold text-xl shadow-lg shadow-red-500/20">LM</div>
                    <div class="flex-1 min-w-0">
                        <h3 class="font-display font-bold text-slate-800 text-base mb-0.5 truncate">Laskar Merdeka</h3>
                        <p class="text-[11px] text-slate-400 font-medium truncate">laskarmerdeka.com</p>
                    </div>
                    <a href="https://laskarmerdeka.com" target="_blank" class="w-10 h-10 rounded-full bg-slate-50 text-slate-400 flex items-center justify-center group-hover:bg-red-50 group-hover:text-red-600 transition-colors"><i class="ph-bold ph-arrow-right"></i></a>
                </div>

                {{-- Partner 3: Zona Sumbawa --}}
                <div class="bg-white p-4 rounded-xl shadow-sm border border-slate-100 flex items-center gap-4 group hover:shadow-md hover:border-brand-red/30 transition-all duration-300">
                    <div class="w-14 h-14 shrink-0 rounded-xl bg-gradient-to-br from-orange-400 to-orange-500 text-white flex items-center justify-center font-display font-bold text-xl shadow-lg shadow-orange-500/20">ZS</div>
                    <div class="flex-1 min-w-0">
                        <h3 class="font-display font-bold text-slate-800 text-base mb-0.5 truncate">Zona Sumbawa</h3>
                        <p class="text-[11px] text-slate-400 font-medium truncate">zonasumbawa.com</p>
                    </div>
                    <a href="https://zonasumbawa.com" target="_blank" class="w-10 h-10 rounded-full bg-slate-50 text-slate-400 flex items-center justify-center group-hover:bg-orange-50 group-hover:text-orange-500 transition-colors"><i class="ph-bold ph-arrow-right"></i></a>
                </div>

                {{-- Partner 4: Amar Media --}}
                <div class="bg-white p-4 rounded-xl shadow-sm border border-slate-100 flex items-center gap-4 group hover:shadow-md hover:border-brand-red/30 transition-all duration-300">
                    <div class="w-14 h-14 shrink-0 rounded-xl bg-gradient-to-br from-purple-500 to-purple-600 text-white flex items-center justify-center font-display font-bold text-xl shadow-lg shadow-purple-500/20">AM</div>
                    <div class="flex-1 min-w-0">
                        <h3 class="font-display font-bold text-slate-800 text-base mb-0.5 truncate">Amar Media</h3>
                        <p class="text-[11px] text-slate-400 font-medium truncate">amarmedia.co.id</p>
                    </div>
                    <a href="https://amarmedia.co.id" target="_blank" class="w-10 h-10 rounded-full bg-slate-50 text-slate-400 flex items-center justify-center group-hover:bg-purple-50 group-hover:text-purple-600 transition-colors"><i class="ph-bold ph-arrow-right"></i></a>
                </div>

            </div>

            {{-- CTA Box --}}
            <div class="mt-10 bg-brand-dark rounded-2xl p-6 text-center relative overflow-hidden shadow-lg">
                <div class="absolute inset-0 bg-[url('https://www.transparenttextures.com/patterns/cubes.png')] opacity-10"></div>
                <div class="absolute top-0 right-0 -mr-6 -mt-6 w-24 h-24 bg-white/10 rounded-full blur-xl"></div>
                <div class="relative z-10">
                    <span class="inline-block px-2 py-0.5 bg-white/10 text-white/80 text-[9px] font-bold rounded mb-3 border border-white/10">OPEN PARTNERSHIP</span>
                    <h3 class="font-display font-bold text-xl text-white mb-2">Media Anda Belum Terdaftar?</h3>
                    <p class="text-sm text-blue-100 mb-5 leading-relaxed px-2">Mari bergabung bersama jaringan media terbesar di Sumbawa untuk jangkauan yang lebih luas.</p>
                    <a href="https://wa.me/{{ $company->phone ?? '' }}" target="_blank" class="inline-flex items-center gap-2 bg-white text-brand-dark px-6 py-3 rounded-xl text-sm font-bold shadow-xl active:scale-95 transition-transform hover:bg-slate-100">
                        <i class="ph-fill ph-whatsapp-logo text-xl text-green-500"></i> Hubungi Redaksi
                    </a>
                </div>
            </div>

        </div>

        {{-- UPDATE 3: SECTION TRENDING & IKLAN BAWAH --}}
        {{-- Kita bungkus dengan background putih agar terpisah dari konten Media Group yg abu-abu --}}
        <div class="bg-white rounded-t-[2rem] pt-8 shadow-[0_-10px_40px_-15px_rgba(0,0,0,0.05)] relative z-20">
            
            {{-- BERITA TRENDING --}}
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

            {{-- UPDATE 4: IKLAN SIDEBAR (LOGIKA POPUP) --}}
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
    <footer class="bg-brand-misty pt-10 pb-8 border-t border-slate-200">
        <div class="container mx-auto px-6">
            <div class="text-center mb-8">
                <div class="flex justify-center items-center gap-2 mb-3">
                    @if($company && $company->logo) <img src="{{ Storage::url($company->logo) }}" alt="Logo Footer" class="h-8 w-auto object-contain">
                    @else <h2 class="font-display font-extrabold text-xl text-brand-dark">GAUNG<span class="text-brand-red">NUSRA</span></h2> @endif
                </div>
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
                            <li><a href="{{ route('pages.media-group') }}" class="hover:text-brand-red transition-colors">Media Group</a></li>
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

    {{-- UPDATE 5: MODAL LIGHTBOX (WAJIB DI BAWAH) --}}
    <div x-show="lightboxOpen" 
         x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
         class="fixed inset-0 z-[100] flex items-center justify-center bg-black/90 p-4" x-cloak>
        <button @click="lightboxOpen = false" class="absolute top-6 right-6 text-white hover:text-brand-red transition-colors p-2 bg-black/50 rounded-full"><i class="ph-bold ph-x text-3xl"></i></button>
        <div class="relative max-w-5xl w-full flex justify-center" @click.away="lightboxOpen = false">
            <img :src="lightboxImage" class="max-w-full max-h-[90vh] object-contain shadow-2xl rounded-lg">
        </div>
    </div>

    {{-- SCRIPTS (Search Logic Only) --}}
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