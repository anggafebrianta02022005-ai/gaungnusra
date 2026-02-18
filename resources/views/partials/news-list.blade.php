@foreach($latestNews as $news)
    <article class="group flex flex-col md:flex-row gap-6 border-b border-slate-100 pb-8 last:border-0 animate-fade-in-up">
        
        {{-- CONTAINER GAMBAR: Ditambahkan rounded-xl untuk garis tepi lengkung --}}
        <a href="{{ route('news.show', $news->slug) }}" 
           class="w-full md:w-1/3 aspect-video shrink-0 rounded-xl overflow-hidden bg-slate-100 relative shadow-sm group-hover:shadow-md transition-all">
            
            @if($news->pin_order)
                <div class="absolute top-2 left-2 bg-brand-red text-white text-[10px] font-bold px-2 py-1 rounded shadow-sm z-10">HEADLINE</div>
            @endif
            
            {{-- GAMBAR: Ditambahkan animasi zoom (scale-105) saat hover --}}
            <img src="{{ Storage::url($news->thumbnail) }}" 
                 alt="{{ $news->title }}" 
                 loading="lazy" 
                 class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105">
        </a>
        
        <div class="flex-1 flex flex-col justify-center">
            <div class="flex items-center gap-2 mb-2">
                <span class="text-xs font-bold text-brand-red uppercase tracking-wide bg-red-50 px-2 py-0.5 rounded-full">
                    {{ $news->categories->first()->name ?? 'Umum' }}
                </span>
                <span class="text-xs text-slate-400 flex items-center gap-1">
                    <i class="ph-bold ph-calendar-blank"></i> {{ $news->published_at->format('d M Y') }}
                </span>
            </div>

            <h3 class="font-display font-bold text-xl md:text-2xl text-slate-800 leading-snug mb-3 group-hover:text-brand-red transition-colors">
                <a href="{{ route('news.show', $news->slug) }}">{{ $news->title }}</a>
            </h3>

            <p class="text-sm text-slate-500 line-clamp-2 mb-4 leading-relaxed">
                {{ $news->subtitle ?? Str::limit(strip_tags($news->content), 120) }}
            </p>

            <div class="flex items-center gap-2 text-xs text-slate-400">
                <span class="font-bold text-slate-600">{{ $news->author->name ?? 'Redaksi' }}</span>
            </div>
        </div>

    </article>
@endforeach