<div class="max-w-4xl mx-auto bg-white dark:bg-gray-900 min-h-screen p-6 md:p-10">
    
    {{-- === BAGIAN 1: HEADER BERITA === --}}
    <header class="mb-8 border-b pb-6 border-gray-200 dark:border-gray-700">
        {{-- Kategori (Badge Kecil) --}}
        <div class="flex flex-wrap gap-2 mb-4">
            @foreach($record->categories as $category)
                <span class="inline-flex items-center px-2.5 py-0.5 rounded text-xs font-bold uppercase tracking-wide bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200">
                    {{ $category->name }}
                </span>
            @endforeach
        </div>

        {{-- Judul Utama (Serif & Besar) --}}
        <h1 class="text-3xl md:text-4xl font-bold text-gray-900 dark:text-white leading-tight font-serif mb-3">
            {{ $record->title }}
        </h1>

        {{-- Sub-Judul (Lead) --}}
        @if($record->subtitle)
            <p class="text-lg md:text-xl text-gray-600 dark:text-gray-300 leading-relaxed font-light mb-4">
                {{ $record->subtitle }}
            </p>
        @endif

        {{-- Meta Data (Tanggal & Waktu) --}}
        <div class="flex items-center text-sm text-gray-500 dark:text-gray-400 font-medium">
            <span>Diposting: {{ $record->created_at->format('d M Y, H:i') }} WITA</span>
            <span class="mx-2">&bull;</span>
            <div class="flex items-center gap-1">
                <x-heroicon-m-eye class="w-4 h-4"/>
                <span>{{ $record->views_count }} views</span>
            </div>
        </div>
    </header>

    {{-- === BAGIAN 2: GAMBAR UTAMA === --}}
    @if($record->image)
        <figure class="mb-10">
            <div class="relative w-full aspect-video overflow-hidden rounded-lg shadow-sm">
                <img src="{{ asset('storage/' . $record->image) }}" 
                     class="w-full h-full object-cover"
                     alt="{{ $record->title }}">
            </div>
            {{-- Simulasi Caption (Opsional, karena tidak ada di DB, kita pakai title) --}}
            <figcaption class="mt-2 text-sm text-gray-500 italic dark:text-gray-400">
                (Caption): Ilustrasi {{ $record->title }}
            </figcaption>
        </figure>
    @endif

    {{-- === BAGIAN 3: ISI KONTEN (BODY) === --}}
    <article class="prose prose-lg prose-slate dark:prose-invert max-w-none text-gray-800 dark:text-gray-200 leading-relaxed mb-10 font-serif">
        {{-- Dropcap Effect untuk huruf pertama --}}
        <style>
            .prose p:first-of-type::first-letter {
                float: left;
                font-size: 3.5rem;
                line-height: 0.8;
                font-weight: bold;
                margin-right: 0.5rem;
                color: #2563eb; /* Blue-600 */
            }
        </style>
        
        {!! $record->content !!}
    </article>

    {{-- === BAGIAN 4: GALERI GAMBAR PENDUKUNG (Jika Ada) === --}}
    @if(!empty($record->support_images) || $record->article_image)
        <div class="mt-8 mb-8">
            <h3 class="text-lg font-bold border-l-4 border-blue-600 pl-3 mb-4 uppercase text-gray-700 dark:text-gray-300">
                Galeri Foto
            </h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                {{-- Gambar Artikel Lama (Jika masih dipakai) --}}
                @if($record->article_image)
                    <img src="{{ asset('storage/' . $record->article_image) }}" class="rounded-lg shadow w-full h-64 object-cover">
                @endif

                {{-- Support Images (JSON Array) --}}
                @if(!empty($record->support_images))
                    @foreach($record->support_images as $img)
                        <img src="{{ asset('storage/' . $img) }}" class="rounded-lg shadow w-full h-64 object-cover transition hover:scale-[1.02]">
                    @endforeach
                @endif
            </div>
        </div>
    @endif

    {{-- === BAGIAN 5: FOOTER (KODE JURNALIS) === --}}
    <footer class="mt-12 pt-6 border-t border-gray-200 dark:border-gray-700 flex justify-end">
        <div class="text-right">
            <p class="text-xs text-gray-400 uppercase tracking-widest mb-1">Jurnalis / Editor</p>
            <p class="text-sm font-bold text-blue-800 dark:text-blue-400 font-mono bg-blue-50 dark:bg-blue-900/30 px-3 py-1 rounded">
                KODE BERITA: [{{ $record->journalist_code }}]
            </p>
        </div>
    </footer>

</div>