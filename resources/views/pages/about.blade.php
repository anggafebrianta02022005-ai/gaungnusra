@extends('layouts.frontend')

{{-- Ubah Title Browser --}}
@section('title', 'Tentang Kami - ' . ($company->name ?? 'Gaung Nusra'))

@section('content')

    {{-- 1. IKLAN HEADER (Jika Ada) --}}
    @if(isset($headerAd) && $headerAd->image)
    <div class="bg-white border-b border-slate-100 animate-fade-in-up">
        <div class="container mx-auto px-4 lg:px-8 py-6 flex flex-col items-center">
            <a href="{{ $headerAd->link ?? '#' }}" target="_blank" class="relative group block w-fit mx-auto rounded-2xl overflow-hidden hover:shadow-lg transition-all duration-500 hover:-translate-y-1">
                <div class="absolute top-0 right-0 bg-brand-misty text-slate-600 text-[10px] font-bold px-3 py-1 rounded-bl-xl backdrop-blur-sm z-20 border-l border-b border-white">SPONSORED</div>
                <img src="{{ Storage::url($headerAd->image) }}" alt="Iklan Header" class="block w-auto h-auto max-w-full max-h-[250px] md:max-h-[350px] object-contain rounded-xl shadow-card border border-slate-100">
            </a>
        </div>
    </div>
    @endif

    {{-- 2. KONTEN UTAMA --}}
    <main class="container mx-auto px-4 lg:px-8 py-10 flex-grow bg-white">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-12">
            
            {{-- KOLOM KIRI: TULISAN TENTANG KAMI --}}
            <div class="lg:col-span-8 animate-fade-in-up" style="animation-delay: 0.1s;">
                <div class="mb-8 pb-4 border-b border-slate-100">
                    <span class="text-xs font-bold text-brand-red uppercase tracking-widest">Profil</span>
                    <h1 class="font-display font-extrabold text-4xl text-brand-dark mt-2">Tentang {{ $company->name ?? 'Kami' }}</h1>
                </div>

                {{-- Deskripsi Perusahaan --}}
                <div class="prose prose-lg text-slate-600 max-w-none font-sans leading-relaxed mb-10">
                    @if($company && $company->description)
                        {!! $company->description !!}
                    @else
                        <p class="text-slate-400 italic bg-slate-50 p-4 rounded-lg border border-dashed border-slate-300">
                            Deskripsi profil belum diisi di Admin Panel.
                        </p>
                    @endif
                </div>

                {{-- Kotak Kontak --}}
                <h3 class="font-display font-bold text-2xl text-brand-dark mt-8 mb-6">Hubungi Kami</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 not-prose">
                    {{-- Email --}}
                    <div class="p-5 bg-white border border-slate-200 rounded-xl flex items-center gap-4 shadow-sm hover:shadow-md transition-shadow">
                        <div class="w-12 h-12 bg-blue-50 text-blue-600 rounded-full flex items-center justify-center text-2xl"><i class="ph-fill ph-envelope"></i></div>
                        <div class="overflow-hidden">
                            <span class="text-xs font-bold text-slate-400 uppercase">Email Redaksi</span>
                            <p class="font-bold text-brand-dark truncate">{{ $company->email ?? '-' }}</p>
                        </div>
                    </div>
                    
                    {{-- Telepon/WA --}}
                    <div class="p-5 bg-white border border-slate-200 rounded-xl flex items-center gap-4 shadow-sm hover:shadow-md transition-shadow">
                        <div class="w-12 h-12 bg-green-50 text-green-600 rounded-full flex items-center justify-center text-2xl"><i class="ph-fill ph-whatsapp-logo"></i></div>
                        <div>
                            <span class="text-xs font-bold text-slate-400 uppercase">WhatsApp / Telepon</span>
                            <p class="font-bold text-brand-dark">{{ $company->phone ?? '-' }}</p>
                        </div>
                    </div>
                    
                    {{-- Alamat --}}
                    <div class="p-5 bg-white border border-slate-200 rounded-xl flex items-center gap-4 shadow-sm hover:shadow-md transition-shadow md:col-span-2">
                        <div class="w-12 h-12 bg-red-50 text-brand-red rounded-full flex items-center justify-center text-2xl"><i class="ph-fill ph-map-pin"></i></div>
                        <div>
                            <span class="text-xs font-bold text-slate-400 uppercase">Alamat Kantor</span>
                            <p class="font-bold text-brand-dark">{{ $company->address ?? '-' }}</p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- KOLOM KANAN: SIDEBAR (Berita Trending & Iklan) --}}
            <aside class="lg:col-span-4 space-y-10 pl-0 lg:pl-6 border-l border-transparent lg:border-slate-100 animate-fade-in-up" style="animation-delay: 0.2s;">
                <div class="sticky top-24 space-y-8">
                    
                    {{-- WIDGET TRENDING --}}
                    <div class="bg-white rounded-2xl p-6 shadow-card border border-slate-100">
                        <div class="flex items-center justify-between mb-6 pb-4 border-b border-slate-50">
                            <h3 class="font-display font-bold text-lg text-brand-dark flex items-center gap-2">
                                <i class="ph-fill ph-trend-up text-brand-red"></i> Sedang Trending
                            </h3>
                        </div> 
                        <div class="space-y-6">
                            @if(isset($sidebarNews) && count($sidebarNews) > 0)
                                @foreach($sidebarNews as $index => $sNews)
                                    <a href="{{ route('news.show', $sNews->slug) }}" class="group flex gap-4 items-start relative">
                                        {{-- Nomor Urut --}}
                                        <span class="absolute -left-3 -top-3 w-7 h-7 flex items-center justify-center bg-white border border-slate-100 shadow-sm rounded-full text-xs font-bold {{ $index < 3 ? 'text-brand-red' : 'text-slate-400' }} z-10 font-display">#{{ $index + 1 }}</span>
                                        
                                        {{-- Gambar Kecil --}}
                                        <div class="w-24 h-24 img-wrapper rounded-xl flex-shrink-0 shadow-sm group-hover:shadow-md transition-all overflow-hidden">
                                            <img src="{{ Storage::url($sNews->thumbnail) }}" loading="lazy" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110">
                                        </div>
                                        
                                        {{-- Judul --}}
                                        <div class="flex-1 py-1">
                                            <h4 class="font-display text-sm font-bold text-brand-dark leading-snug line-clamp-3 group-hover:text-brand-red transition-colors duration-200 mb-2">{{ $sNews->title }}</h4>
                                            <div class="flex items-center gap-2 text-[10px] text-slate-400 font-medium">
                                                <i class="ph-fill ph-calendar-blank"></i> {{ $sNews->created_at->format('d M Y') }}
                                            </div>
                                        </div>
                                    </a>
                                @endforeach
                            @else
                                <p class="text-sm text-slate-400 italic">Belum ada berita trending.</p>
                            @endif
                        </div>
                    </div>

                    {{-- WIDGET IKLAN SIDEBAR --}}
                    <div>
                        @if(isset($sidebarAd) && $sidebarAd->image)
                            <a href="{{ $sidebarAd->link ?? '#' }}" target="_blank" class="block relative rounded-2xl overflow-hidden shadow-card group hover:shadow-lg transition-all duration-500 hover:-translate-y-1">
                                <span class="absolute top-3 right-3 bg-brand-misty text-[10px] font-bold px-2 py-0.5 rounded text-slate-500 z-10 tracking-widest border border-white">ADS</span>
                                <img src="{{ Storage::url($sidebarAd->image) }}" alt="Iklan Sidebar" loading="lazy" class="w-full h-full object-cover">
                            </a>
                        @endif
                    </div>

                </div>
            </aside>

        </div>
    </main>
@endsection