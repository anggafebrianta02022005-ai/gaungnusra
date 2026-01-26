@foreach($latestNews as $news)
    <article class="flex flex-col md:flex-row gap-6 pb-8 mb-8 border-b border-slate-200 last:border-0 last:pb-0 group">
        
        <a href="{{ route('news.show', $news->slug) }}" class="w-full md:w-[260px] shrink-0 img-wrapper rounded-xl relative overflow-hidden bg-slate-100 block">
            @if($news->pin_order)
                <div class="absolute top-2 left-2 z-10 bg-brand-red text-white text-[10px] font-bold px-2.5 py-1 rounded-lg shadow-lg flex items-center gap-1">
                    <i class="ph-fill ph-push-pin"></i> HEADLINE
                </div>
            @endif
            
            <img src="{{ Storage::url($news->thumbnail) }}" 
                 alt="{{ $news->title }}" 
                 loading="lazy" 
                 class="img-zoom w-full h-full object-cover aspect-video">
        </a>
        
        <div class="flex-1 flex flex-col">
            <div class="flex items-center gap-2 mb-2.5">
                <span class="bg-brand-misty text-slate-600 border border-slate-200 text-[10px] font-bold px-2 py-0.5 rounded-full uppercase tracking-wider">
                    {{ $news->categories->first()->name ?? 'Umum' }}
                </span>
                <span class="text-slate-300 text-[10px]">•</span>
                
                <span class="text-slate-400 text-xs font-medium flex items-center gap-1">
                    <i class="ph ph-calendar-blank"></i> {{ $news->published_at->format('d M Y') }}
                </span>
            </div>

            <h3 class="font-display font-bold text-lg md:text-xl text-brand-dark leading-snug mb-3 group-hover:text-brand-red transition-colors duration-200">
                <a href="{{ route('news.show', $news->slug) }}">{{ $news->title }}</a>
            </h3>

            <p class="text-slate-500 text-sm leading-relaxed line-clamp-2 md:line-clamp-3 mb-4">
                {{ $news->subtitle ?? Str::limit(strip_tags($news->content), 120) }}
            </p>

            <div class="mt-auto flex items-center gap-3 pt-2">
                <div class="w-6 h-6 rounded-full bg-brand-misty flex items-center justify-center text-xs font-bold text-slate-500">
                    {{ substr($news->author->name ?? 'A', 0, 1) }}
                </div>
                <span class="text-xs font-medium text-slate-500">{{ $news->author->name ?? 'Redaksi' }}</span>
            </div>
        </div>

    </article>
@endforeach