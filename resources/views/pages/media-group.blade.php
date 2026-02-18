<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#F1F5F9">
    <title>Media Group - {{ $company->name ?? 'Gaung Nusra' }}</title>
    
    {{-- SEO & Meta --}}
    <meta name="description" content="Jaringan Media Group Gaung Nusra. Partner informasi terpercaya di Nusa Tenggara dan Indonesia.">
    <link rel="icon" type="image/png" href="{{ asset('gaungnusra.png') }}?v=3">
    <link rel="canonical" href="{{ url()->current() }}">
    
    {{-- CSS & Fonts --}}
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;800&family=Plus+Jakarta+Sans:wght@500;700;800&display=swap" rel="stylesheet">
    
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: { sans: ['Inter', 'sans-serif'], display: ['"Plus Jakarta Sans"', 'sans-serif'] },
                    colors: { brand: { red: '#D32F2F', dark: '#1E3A8A', misty: '#F1F5F9' } }
                }
            }
        }
    </script>
    <style>[x-cloak]{display:none}.line-clamp-2{display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical;overflow:hidden}</style>
</head>

<body class="bg-white text-slate-800 flex flex-col min-h-screen" x-data="{ searchOpen: false, lightboxOpen: false, lightboxImage: '' }">

    {{-- HEADER (SAMA PERSIS DENGAN HOME DESKTOP) --}}
    <header class="bg-white border-b border-gray-100 py-4 sticky top-0 z-50">
        <div class="container mx-auto px-4 lg:px-8 flex justify-between items-center">
            <a href="/" class="flex items-center gap-3">
                @if($company && $company->logo) <img src="{{ Storage::url($company->logo) }}" class="h-12 w-auto object-contain"> @else <span class="font-display font-extrabold text-2xl text-brand-dark">GAUNG<span class="text-brand-red">NUSRA</span></span> @endif
            </a>
            
            <nav class="hidden md:flex items-center gap-6 font-medium text-sm text-slate-600">
                <a href="/" class="hover:text-brand-red">Home</a>
                @foreach($categories as $cat)
                    <a href="{{ route('category.show', $cat->slug) }}" class="hover:text-brand-red">{{ $cat->name }}</a>
                @endforeach
            </nav>

            <div class="flex items-center gap-3">
                <button @click="searchOpen = !searchOpen" class="w-10 h-10 rounded-full bg-slate-50 flex items-center justify-center hover:bg-slate-100"><i class="ph-bold ph-magnifying-glass"></i></button>
                <a href="{{ route('pages.advertise') }}" class="hidden md:inline-block px-5 py-2 bg-brand-red text-white text-xs font-bold rounded-full hover:bg-red-700 transition">Pasang Iklan</a>
            </div>
        </div>
    </header>

    {{-- SEARCH BAR --}}
    <div x-show="searchOpen" class="border-b border-gray-100 py-4 bg-white" x-transition>
        <div class="container mx-auto px-4 lg:px-8">
            <input type="text" id="desktop-search" class="w-full bg-slate-50 border-none rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-brand-red" placeholder="Ketik kata kunci berita...">
            <div id="desktop-results" class="mt-2 hidden bg-white shadow-lg rounded-xl border border-slate-100 p-2"></div>
        </div>
    </div>

    {{-- IKLAN HEADER --}}
    @if($headerAd && $headerAd->image)
    <div class="container mx-auto px-4 lg:px-8 py-6">
        @php $isPopup = empty($headerAd->link) || $headerAd->link === '#'; @endphp
        <a href="{{ $isPopup ? 'javascript:void(0)' : $headerAd->link }}" @if($isPopup) @click.prevent="lightboxOpen = true; lightboxImage = '{{ Storage::url($headerAd->image) }}'" @else target="_blank" @endif class="block rounded-2xl overflow-hidden shadow-sm hover:shadow-md transition">
            <div class="absolute top-0 right-0 bg-slate-100 text-slate-500 text-[10px] px-2 py-0.5 font-bold rounded-bl-lg z-10">SPONSORED</div>
            <img src="{{ Storage::url($headerAd->image) }}" class="w-full h-auto max-h-[250px] object-cover">
        </a>
    </div>
    @endif

    {{-- MAIN CONTENT (LAYOUT 8:4) --}}
    <main class="container mx-auto px-4 lg:px-8 py-6 flex-grow">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-10">
            
            {{-- KOLOM KIRI (KONTEN KHUSUS MEDIA GROUP) --}}
            <div class="lg:col-span-8">
                
                {{-- Judul Halaman --}}
                <div class="mb-10 text-center">
                    <span class="inline-block px-3 py-1 bg-brand-red/10 text-brand-red text-xs font-bold rounded-full mb-3">OFFICIAL PARTNER</span>
                    <h1 class="font-display font-extrabold text-3xl md:text-4xl text-brand-dark mb-4">Jaringan Media <span class="text-brand-red">Sumbawa</span></h1>
                    <p class="text-slate-500 max-w-2xl mx-auto">Bersinergi membangun ekosistem informasi yang sehat, akurat, dan terpercaya untuk masyarakat Nusa Tenggara.</p>
                </div>

                {{-- List Partner (Grid) --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-12">
                    
                    {{-- Partner 1 --}}
                    <div class="bg-white border border-slate-100 p-5 rounded-2xl shadow-sm hover:shadow-md transition-all flex items-center gap-4 group">
                        <div class="w-14 h-14 rounded-xl bg-blue-600 text-white flex items-center justify-center font-display font-bold text-xl shadow-lg shadow-blue-200">DS</div>
                        <div class="flex-1 overflow-hidden">
                            <h3 class="font-bold text-slate-800 text-lg truncate">Dinamika Sumbawa</h3>
                            <a href="https://dinamikasumbawa.com" target="_blank" class="text-sm text-slate-400 hover:text-blue-600 truncate block">dinamikasumbawa.com</a>
                        </div>
                        <a href="https://dinamikasumbawa.com" target="_blank" class="w-10 h-10 rounded-full bg-slate-50 flex items-center justify-center text-slate-400 group-hover:bg-blue-600 group-hover:text-white transition"><i class="ph-bold ph-arrow-right"></i></a>
                    </div>

                    {{-- Partner 2 --}}
                    <div class="bg-white border border-slate-100 p-5 rounded-2xl shadow-sm hover:shadow-md transition-all flex items-center gap-4 group">
                        <div class="w-14 h-14 rounded-xl bg-red-600 text-white flex items-center justify-center font-display font-bold text-xl shadow-lg shadow-red-200">LM</div>
                        <div class="flex-1 overflow-hidden">
                            <h3 class="font-bold text-slate-800 text-lg truncate">Laskar Merdeka</h3>
                            <a href="https://laskarmerdeka.com" target="_blank" class="text-sm text-slate-400 hover:text-red-600 truncate block">laskarmerdeka.com</a>
                        </div>
                        <a href="https://laskarmerdeka.com" target="_blank" class="w-10 h-10 rounded-full bg-slate-50 flex items-center justify-center text-slate-400 group-hover:bg-red-600 group-hover:text-white transition"><i class="ph-bold ph-arrow-right"></i></a>
                    </div>

                    {{-- Partner 3 --}}
                    <div class="bg-white border border-slate-100 p-5 rounded-2xl shadow-sm hover:shadow-md transition-all flex items-center gap-4 group">
                        <div class="w-14 h-14 rounded-xl bg-orange-500 text-white flex items-center justify-center font-display font-bold text-xl shadow-lg shadow-orange-200">ZS</div>
                        <div class="flex-1 overflow-hidden">
                            <h3 class="font-bold text-slate-800 text-lg truncate">Zona Sumbawa</h3>
                            <a href="https://zonasumbawa.com" target="_blank" class="text-sm text-slate-400 hover:text-orange-600 truncate block">zonasumbawa.com</a>
                        </div>
                        <a href="https://zonasumbawa.com" target="_blank" class="w-10 h-10 rounded-full bg-slate-50 flex items-center justify-center text-slate-400 group-hover:bg-orange-500 group-hover:text-white transition"><i class="ph-bold ph-arrow-right"></i></a>
                    </div>

                    {{-- Partner 4 --}}
                    <div class="bg-white border border-slate-100 p-5 rounded-2xl shadow-sm hover:shadow-md transition-all flex items-center gap-4 group">
                        <div class="w-14 h-14 rounded-xl bg-purple-600 text-white flex items-center justify-center font-display font-bold text-xl shadow-lg shadow-purple-200">AM</div>
                        <div class="flex-1 overflow-hidden">
                            <h3 class="font-bold text-slate-800 text-lg truncate">Amar Media</h3>
                            <a href="https://amarmedia.co.id" target="_blank" class="text-sm text-slate-400 hover:text-purple-600 truncate block">amarmedia.co.id</a>
                        </div>
                        <a href="https://amarmedia.co.id" target="_blank" class="w-10 h-10 rounded-full bg-slate-50 flex items-center justify-center text-slate-400 group-hover:bg-purple-600 group-hover:text-white transition"><i class="ph-bold ph-arrow-right"></i></a>
                    </div>

                </div>

                {{-- CTA Box --}}
                <div class="bg-brand-dark rounded-2xl p-8 text-center relative overflow-hidden shadow-lg">
                    <div class="absolute inset-0 bg-[url('https://www.transparenttextures.com/patterns/cubes.png')] opacity-10"></div>
                    <div class="relative z-10">
                        <h3 class="font-display font-bold text-2xl text-white mb-2">Media Anda Belum Terdaftar?</h3>
                        <p class="text-blue-100 mb-6">Bergabunglah dengan jaringan kami untuk jangkauan yang lebih luas.</p>
                        <a href="https://wa.me/{{ $company->phone ?? '' }}" target="_blank" class="inline-flex items-center gap-2 bg-white text-brand-dark hover:bg-slate-100 px-6 py-3 rounded-full font-bold transition shadow-md">
                            <i class="ph-fill ph-whatsapp-logo text-xl text-green-600"></i> Hubungi Redaksi
                        </a>
                    </div>
                </div>

            </div>

            {{-- KOLOM KANAN: SIDEBAR (SAMA PERSIS DENGAN HOME) --}}
            <aside class="lg:col-span-4 space-y-10 border-l border-slate-100 pl-0 lg:pl-10">
                
                {{-- TRENDING --}}
                <div class="bg-slate-50 rounded-2xl p-6 border border-slate-100">
                    <h3 class="font-bold text-lg text-brand-dark mb-6 flex items-center gap-2"><i class="ph-fill ph-trend-up text-brand-red"></i> Trending</h3>
                    <div class="flex flex-col gap-5">
                        @foreach($sidebarNews as $idx => $sNews)
                        <a href="{{ route('news.show', $sNews->slug) }}" class="flex gap-4 group">
                            <span class="text-3xl font-black text-slate-200 leading-none group-hover:text-brand-red/20 transition">{{ $idx + 1 }}</span>
                            <div>
                                <h4 class="text-sm font-bold text-slate-800 leading-snug group-hover:text-brand-red transition line-clamp-2">{{ $sNews->title }}</h4>
                            </div>
                        </a>
                        @endforeach
                    </div>
                </div>

                {{-- IKLAN 5 SLOT VERTIKAL (FIXED) --}}
                <div class="space-y-6">
                    @if(isset($sidebarAds))
                        @for ($i = 1; $i <= 5; $i++)
                            @if(isset($sidebarAds[$i]))
                                @php $ad = $sidebarAds[$i]; $isPopup = empty($ad->link) || $ad->link === '#'; @endphp
                                <div class="relative group">
                                    <a href="{{ $isPopup ? 'javascript:void(0)' : $ad->link }}" @if($isPopup) @click.prevent="lightboxOpen = true; lightboxImage = '{{ Storage::url($ad->image) }}'" @else target="_blank" @endif class="block rounded-xl overflow-hidden shadow-sm hover:shadow-md transition border border-slate-100">
                                        <span class="absolute top-0 right-0 bg-white/90 text-[9px] font-bold px-2 py-0.5 text-slate-500 rounded-bl-lg z-10">ADS #{{ $i }}</span>
                                        <img src="{{ Storage::url($ad->image) }}" class="w-full h-auto object-cover">
                                    </a>
                                </div>
                            @endif
                        @endfor
                    @endif
                </div>

            </aside>
        </div>
    </main>

    {{-- FOOTER (SAMA PERSIS DENGAN HOME) --}}
    <footer class="bg-brand-misty border-t border-slate-200 pt-12 pb-8 mt-12">
        <div class="container mx-auto px-4 lg:px-8 text-center">
            <p class="text-sm text-slate-500">&copy; {{ date('Y') }} {{ $company->name ?? 'Gaung Nusra' }}. All rights reserved.</p>
        </div>
    </footer>

    {{-- LIGHTBOX --}}
    <div x-show="lightboxOpen" class="fixed inset-0 z-[100] flex items-center justify-center bg-black/90 p-4" x-cloak>
        <button @click="lightboxOpen = false" class="absolute top-6 right-6 text-white p-2"><i class="ph-bold ph-x text-3xl"></i></button>
        <div class="relative max-w-5xl w-full flex justify-center" @click.away="lightboxOpen = false">
            <img :src="lightboxImage" class="max-w-full max-h-[90vh] object-contain rounded-lg shadow-2xl">
        </div>
    </div>

    {{-- SCRIPTS --}}
    <script>
        $(document).ready(function() {
            $('#desktop-search').on('keyup', function() {
                var q = $(this).val();
                if(q.length < 2) { $('#desktop-results').hide(); return; }
                $.get("{{ route('search.news') }}", {q:q}, function(d) {
                    var h = ''; 
                    if(d.length) { $.each(d, (k,v) => h+=`<a href="${v.url}" class="block px-3 py-2 text-sm hover:bg-slate-50 rounded">${v.title}</a>`); } 
                    else { h='<div class="p-2 text-xs text-slate-400">Tidak ditemukan.</div>'; }
                    $('#desktop-results').html(h).show();
                });
            });
        });
    </script>
</body>
</html>