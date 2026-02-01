<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#F1F5F9">
    <title>Tentang Kami - {{ $company->name ?? 'Portal Berita' }}</title>
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
        
        /* Hide Scrollbar */
        .no-scrollbar::-webkit-scrollbar { display: none; }
        .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
        
        /* Search Styles */
        .search-results-container { display: none; }
    </style>
</head>
<body class="bg-white text-slate-800 flex flex-col min-h-screen" x-data="{ mobileMenu: false, searchOpen: false }">

    {{-- HEADER --}}
    <header class="bg-white border-b border-gray-100 py-3 md:py-4 relative z-50">
        <div class="container mx-auto px-4 lg:px-8 flex justify-between items-center relative min-h-[40px]">
            
            {{-- 1. LOGO --}}
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
            
            {{-- 2. SEARCH BAR (DESKTOP) --}}
            <div class="hidden md:block w-full max-w-md relative group ml-auto mr-4">
                <div class="relative transition-all duration-300 transform origin-left">
                    <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-gray-400 group-focus-within:text-brand-red transition-colors"><i class="ph ph-magnifying-glass text-lg"></i></span>
                    <input type="text" id="desktop-search-input" autocomplete="off" placeholder="Cari berita..." class="w-full bg-brand-misty text-slate-800 border border-transparent rounded-full py-2.5 pl-10 pr-4 text-sm focus:bg-white focus:border-brand-red focus:ring-4 focus:ring-brand-red/10 focus:outline-none transition-all shadow-sm placeholder:text-gray-400">
                    <div id="desktop-search-results" class="search-results-container absolute top-full left-0 w-full mt-2 bg-white rounded-xl shadow-xl border border-slate-100 overflow-hidden z-50"></div>
                </div>
            </div>

            {{-- 3. TOMBOL AKSI MOBILE (Search & Menu) --}}
            <div class="flex items-center gap-2 ml-auto md:hidden z-20">
                {{-- Tombol Search Mobile --}}
                <button 
                    @click="searchOpen = !searchOpen; if(searchOpen) $nextTick(() => $refs.mobileSearchInput.focus())" 
                    class="w-9 h-9 flex items-center justify-center rounded-full text-slate-600 hover:bg-slate-100 transition-all active:scale-95"
                    :class="{ 'bg-brand-red/10 text-brand-red': searchOpen }">
                    <i class="ph text-xl" :class="searchOpen ? 'ph-x' : 'ph-magnifying-glass'"></i>
                </button>

                {{-- Tombol Menu --}}
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
    <div class="bg-white border-b border-slate-100 overflow-x-auto no-scrollbar">
        <div class="flex items-center px-4 h-12 gap-2 min-w-max">
            <a href="/" class="px-3 py-1.5 text-xs font-medium text-slate-600 hover:text-brand-dark hover:bg-slate-50 rounded-full border border-transparent transition-all">Berita Utama</a>
            @foreach($categories as $cat)
                <a href="{{ route('category.show', $cat->slug) }}" class="px-3 py-1.5 text-xs font-bold rounded-full border transition-all text-slate-600 border-transparent hover:bg-slate-50">
                    {{ $cat->name }}
                </a>
            @endforeach
        </div>
    </div>

    {{-- SIDEBAR MOBILE MENU --}}
    <div x-show="mobileMenu" class="fixed inset-0 z-[60] bg-black/50 backdrop-blur-sm" @click="mobileMenu = false" x-transition.opacity style="display: none;"></div>
    <div x-show="mobileMenu" class="fixed top-0 right-0 h-full w-[80%] max-w-[300px] bg-white z-[70] shadow-2xl p-6 overflow-y-auto" 
         x-transition:enter="transition transform ease-out duration-300" x-transition:enter-start="translate-x-full" x-transition:enter-end="translate-x-0" x-transition:leave="transition transform ease-in duration-300" x-transition:leave-start="translate-x-0" x-transition:leave-end="translate-x-full" style="display: none;">
        
        <div class="flex justify-between items-center mb-8 border-b border-slate-100 pb-4">
            <h3 class="font-display font-bold text-lg text-brand-dark">Menu</h3>
            <button @click="mobileMenu = false" class="w-8 h-8 rounded-full bg-slate-100 flex items-center justify-center text-slate-500"><i class="ph-bold ph-x"></i></button>
        </div>
        <div class="space-y-2">
            <a href="/" class="block px-3 py-2.5 text-sm font-bold text-brand-red bg-red-50 rounded-lg">Home</a>
            @foreach($categories as $cat)
                <a href="{{ route('category.show', $cat->slug) }}" class="block px-3 py-2.5 text-sm font-medium text-slate-700 hover:bg-slate-50 rounded-lg">{{ $cat->name }}</a>
            @endforeach
            <a href="{{ route('pages.advertise') }}" class="block px-3 py-2.5 text-sm font-medium text-slate-700 hover:bg-slate-50 rounded-lg">Pasang Iklan</a>
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
            <div class="mb-6 pb-2 border-b border-slate-100">
                <span class="text-[10px] font-bold text-brand-red uppercase tracking-widest">Profil Redaksi</span>
                <h1 class="font-display font-extrabold text-2xl text-brand-dark mt-1">Tentang Kami</h1>
            </div>
            
            <div class="prose prose-sm text-slate-600 font-sans leading-relaxed mb-8">
                @if($company && $company->description)
                    {!! $company->description !!}
                @else
                    <div class="p-4 bg-slate-50 rounded-xl border border-dashed border-slate-200 text-center">
                        <p class="text-slate-400 italic text-xs">Informasi profil belum tersedia.</p>
                    </div>
                @endif
            </div>

            <div class="space-y-4">
                <h3 class="font-display font-bold text-lg text-brand-dark mb-2 flex items-center gap-2">
                    <i class="ph-fill ph-address-book text-brand-red"></i> Kontak
                </h3>
                
                <a href="mailto:{{ $company->email ?? '' }}" class="flex items-center gap-4 p-4 bg-white border border-slate-200 rounded-xl shadow-sm hover:border-brand-red transition-colors">
                    <div class="w-10 h-10 bg-blue-50 text-blue-600 rounded-full flex items-center justify-center text-xl shrink-0"><i class="ph-fill ph-envelope"></i></div>
                    <div class="overflow-hidden">
                        <span class="text-[10px] uppercase font-bold text-slate-400 block mb-0.5">Email</span>
                        <span class="font-bold text-sm text-brand-dark truncate block">{{ $company->email ?? '-' }}</span>
                    </div>
                </a>

                <a href="https://wa.me/{{ $company->phone ?? '' }}" class="flex items-center gap-4 p-4 bg-white border border-slate-200 rounded-xl shadow-sm hover:border-green-500 transition-colors">
                    <div class="w-10 h-10 bg-green-50 text-green-600 rounded-full flex items-center justify-center text-xl shrink-0"><i class="ph-fill ph-whatsapp-logo"></i></div>
                    <div>
                        <span class="text-[10px] uppercase font-bold text-slate-400 block mb-0.5">WhatsApp</span>
                        <span class="font-bold text-sm text-brand-dark">{{ $company->phone ?? '-' }}</span>
                    </div>
                </a>

                <div class="flex items-start gap-4 p-4 bg-white border border-slate-200 rounded-xl shadow-sm">
                    <div class="w-10 h-10 bg-red-50 text-brand-red rounded-full flex items-center justify-center text-xl shrink-0 mt-1"><i class="ph-fill ph-map-pin"></i></div>
                    <div>
                        <span class="text-[10px] uppercase font-bold text-slate-400 block mb-0.5">Alamat</span>
                        <span class="font-bold text-sm text-brand-dark leading-snug">{{ $company->address ?? '-' }}</span>
                    </div>
                </div>
            </div>
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
                                <span class="text-[10px] text-slate-400"><i class="ph-fill ph-calendar-blank"></i> {{ $sNews->created_at->format('d M Y') }}</span>
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
        // Fungsi Pencarian Cerdas
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

            // Sembunyikan hasil saat klik di luar
            $(document).on('click', function(e) {
                if (!$(e.target).closest(inputId).length && !$(e.target).closest(resultsId).length) {
                    results.hide();
                }
            });
        }

        $(document).ready(function() {
            // Aktifkan Search Desktop & Mobile
            initSearch('#desktop-search-input', '#desktop-search-results');
            initSearch('#mobile-search-input', '#mobile-search-results');
        });
    </script>
</body>
</html>