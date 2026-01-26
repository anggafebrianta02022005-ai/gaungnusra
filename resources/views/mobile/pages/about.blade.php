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
        .no-scrollbar::-webkit-scrollbar { display: none; }
        .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
        #search-results { display: none; }
        #search-results.active { display: block; }
    </style>
</head>
<body class="bg-white text-slate-800 flex flex-col min-h-screen" x-data="{ mobileMenu: false, searchOpen: false }">

    <header class="bg-white border-b border-gray-100 shadow-sm py-3 px-4 sticky top-0 z-50 flex justify-between items-center">
        <a href="/" class="flex items-center gap-2 group select-none shrink-0">
            @if($company && $company->logo)
                <img src="{{ Storage::url($company->logo) }}" alt="Logo" class="block h-8 w-auto object-contain">
            @else
                <div class="flex flex-col leading-none">
                    <span class="font-serif text-xl font-bold text-brand-red tracking-tight">Gaung</span>
                    <span class="font-display text-[10px] font-extrabold text-brand-dark tracking-widest uppercase -mt-0.5">NUSRA</span>
                </div>
            @endif
        </a>

        <div class="flex items-center gap-3">
            <button @click="searchOpen = !searchOpen" class="w-8 h-8 flex items-center justify-center rounded-full bg-slate-50 text-slate-600 hover:bg-slate-100">
                <i class="ph-bold ph-magnifying-glass text-lg"></i>
            </button>
            <button @click="mobileMenu = !mobileMenu" class="w-8 h-8 flex items-center justify-center rounded-full bg-brand-red text-white shadow-sm active:scale-95 transition-transform">
                <i class="ph-bold ph-list text-lg"></i>
            </button>
        </div>
    </header>

    <div x-show="searchOpen" class="px-4 py-3 bg-white border-b border-slate-100" x-transition style="display: none;">
        <div class="relative">
            <input type="text" id="search-input" placeholder="Cari berita..." class="w-full bg-brand-misty border-none rounded-lg py-2.5 px-4 text-sm focus:ring-2 focus:ring-brand-red outline-none">
            <div id="search-results" class="absolute top-full left-0 w-full mt-2 bg-white rounded-xl shadow-xl border border-slate-100 overflow-hidden z-50"></div>
        </div>
    </div>

    <div class="bg-white border-b border-slate-100 overflow-x-auto no-scrollbar">
        <div class="flex items-center px-4 h-12 gap-2 min-w-max">
            <a href="/" class="px-3 py-1.5 text-xs font-bold text-brand-red bg-brand-red/10 rounded-full border border-brand-red/20">Home</a>
            @foreach($categories as $category)
                <a href="{{ route('category.show', $category->slug) }}" class="px-3 py-1.5 text-xs font-medium text-slate-600 hover:text-brand-dark hover:bg-slate-50 rounded-full border border-transparent transition-all">
                    {{ $category->name }}
                </a>
            @endforeach
        </div>
    </div>

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

    <div class="px-4 pt-4 pb-2">
        @if($headerAd)
            <a href="{{ $headerAd->link ?? '#' }}" class="block rounded-xl overflow-hidden shadow-sm border border-slate-100">
                <img src="{{ Storage::url($headerAd->image) }}" class="w-full h-auto object-cover max-h-[250px]">
            </a>
        @endif
    </div>

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