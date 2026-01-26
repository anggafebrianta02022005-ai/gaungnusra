@foreach($latestNews as $news)
    <article class="flex gap-4 border-b border-slate-100 pb-4 mb-4 last:border-0 last:pb-0 last:mb-0 animate-fade-in-up">
        
        <a href="{{ route('news.show', $news->slug) }}" class="w-28 h-20 shrink-0 rounded-lg overflow-hidden bg-slate-100 relative group">
            @if($news->pin_order)
                <div class="absolute top-1 left-1 bg-brand-red text-white text-[8px] font-bold px-1.5 py-0.5 rounded shadow-sm z-10">HEADLINE</div>
            @endif
            <img src="{{ Storage::url($news->thumbnail) }}" 
                 alt="{{ $news->title }}" 
                 loading="lazy" 
                 class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110">
        </a>
        
        <div class="flex-1 flex flex-col justify-between py-0.5">
            <div>
                <span class="text-[10px] font-bold text-brand-red uppercase tracking-wide mb-1 block">
                    {{ $news->categories->first()->name ?? 'Umum' }}
                </span>
                
                <h3 class="text-sm font-bold text-slate-800 leading-[1.4] line-clamp-2">
                    <a href="{{ route('news.show', $news->slug) }}">{{ $news->title }}</a>
                </h3>
            </div>
            
            <div class="flex items-center gap-2 mt-1.5">
                <span class="text-[10px] text-slate-400 flex items-center gap-1">
                    <i class="ph ph-clock"></i> {{ $news->published_at->diffForHumans() }}
                </span>
            </div>
        </div>

    </article>
@endforeach