<?php

namespace App\Filament\Resources;

use App\Filament\Resources\NewsResource\Pages;
use App\Models\News;
use Filament\Forms;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\DateTimePicker; // <--- UBAH INI (Dulu DatePicker)
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Form;
use Filament\Forms\Set;
use Filament\Forms\Get;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\Action;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Table;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Builder;

class NewsResource extends Resource
{
    protected static ?string $model = News::class;

    protected static ?string $navigationIcon = 'heroicon-o-newspaper';
    protected static ?string $navigationLabel = 'Berita';
    protected static ?string $pluralModelLabel = 'Daftar Berita';
    protected static ?string $navigationGroup = 'Manajemen Konten';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                // === KOLOM KIRI (KONTEN & MEDIA) ===
                Group::make()
                    ->schema([
                        Section::make('Detail Berita')
                            ->schema([
                                TextInput::make('news_code')
                                    ->label('Kode Berita')
                                    ->placeholder('Contoh: NEWS-001')
                                    ->required()
                                    ->unique(ignoreRecord: true)
                                    ->maxLength(50),

                                TextInput::make('title')
                                    ->label('Judul Utama')
                                    ->placeholder('Masukkan judul berita...')
                                    ->required()
                                    ->maxLength(255)
                                    ->live(onBlur: true)
                                    ->afterStateUpdated(fn (Set $set, ?string $state) => $set('slug', Str::slug($state))),

                                TextInput::make('slug')
                                    ->label('Permalink / Slug')
                                    ->disabled()
                                    ->dehydrated()
                                    ->unique(News::class, 'slug', ignoreRecord: true)
                                    ->prefix(env('APP_URL') . '/news/'),

                                Textarea::make('subtitle')
                                    ->label('Lead / Ringkasan')
                                    ->placeholder('Paragraf pembuka...')
                                    ->rows(2)
                                    ->maxLength(255)
                                    ->columnSpanFull(),
                                    
                                RichEditor::make('content')
                                    ->label('Isi Artikel')
                                    ->required()
                                    ->columnSpanFull()
                                    ->fileAttachmentsDirectory('news-content')
                                    ->toolbarButtons([
                                        'attachFiles', 'blockquote', 'bold', 'bulletList', 'codeBlock',
                                        'h2', 'h3', 'italic', 'link', 'orderedList', 'redo',
                                        'strike', 'underline', 'undo',
                                    ]),
                            ])
                            ->columns(2),

                        Section::make('Visual Utama')
                            ->description('Gambar akan otomatis dipotong (Auto-Crop) sesuai rasio.')
                            ->collapsible()
                            ->schema([
                                Group::make()->schema([
                                    FileUpload::make('image')
                                        ->label('Gambar Utama (Header)')
                                        ->helperText('Format Landscape 16:9')
                                        ->image()
                                        ->directory('news-main')
                                        ->required()
                                        ->imageResizeMode('cover') 
                                        ->imageCropAspectRatio('16:9') 
                                        ->imageResizeTargetWidth('1200')
                                        ->imageResizeTargetHeight('675')
                                        ->panelLayout('integrated'),
                                    
                                    FileUpload::make('thumbnail')
                                        ->label('Thumbnail Berita (Wajib 16:9)')
                                        ->image()
                                        ->directory('news-thumbnails')
                                        ->imageEditor()
                                        ->imageCropAspectRatio('16:9')
                                        ->imageResizeTargetWidth('1280')
                                        ->imageResizeTargetHeight('720')
                                        ->required()
                                        ->imageResizeMode('cover')
                                        ->imageCropAspectRatio('1:1')
                                        ->imageResizeTargetWidth('400')
                                        ->imageResizeTargetHeight('400')
                                        ->extraAttributes(['class' => 'w-1/2 mx-auto']), 
                                ])
                                ->columnSpanFull()
                                ->extraAttributes(['class' => 'flex flex-col items-center justify-center text-center gap-4']),
                            ]),
                    ])
                    ->columnSpan(['lg' => 2]),

                // === KOLOM KANAN (SIDEBAR SETTING) ===
                Group::make()
                    ->schema([
                        Section::make('Publikasi')
                            ->schema([
                                // 1. STATUS
                                Select::make('status')
                                    ->options([
                                        'draft' => 'Draft (Konsep)',
                                        'review' => 'Review (Tinjauan)',
                                        'published' => 'Tayang (Published)',
                                    ])
                                    ->default('draft')
                                    ->required()
                                    ->live() 
                                    ->native(false),

                                // 2. LOGIKA PIN BARU (Posisi 1, 2, 3)
                                Select::make('pin_order')
                                    ->label('Sematkan Berita (Pinned)')
                                    ->placeholder('Tidak disematkan')
                                    ->options([
                                        1 => 'Pin Posisi 1 (Utama)',
                                        2 => 'Pin Posisi 2',
                                        3 => 'Pin Posisi 3',
                                    ])
                                    ->disabled(fn (Get $get) => $get('status') !== 'published')
                                    ->afterStateUpdated(function ($state, Set $set, Get $get) {
                                        if ($get('status') !== 'published') {
                                            $set('pin_order', null);
                                        }
                                    })
                                    ->rules([
                                        fn (Get $get) => function (string $attribute, $value, \Closure $fail) use ($get) {
                                            if ($value && $get('status') !== 'published') {
                                                $fail('Berita harus berstatus PUBLISHED untuk bisa di-pin!');
                                            }
                                        },
                                    ])
                                    ->unique(ignoreRecord: true),

                                // === PERBAIKAN DISINI: DateTimePicker + Default Now() ===
                                DateTimePicker::make('published_at')
                                    ->label('Jadwal Tayang')
                                    ->seconds(false) // Detik disembunyikan biar rapi
                                    ->default(now()) // <--- INI KUNCINYA: Otomatis isi jam sekarang
                                    ->required()
                                    ->native(false),

                                Select::make('categories')
                                    ->label('Kategori')
                                    ->relationship('categories', 'name')
                                    ->multiple()
                                    ->preload()
                                    ->searchable()
                                    ->required(),
                            ]),

                        Section::make('Info Sistem')
                            ->schema([
                                Placeholder::make('created_at')
                                    ->label('Dibuat pada')
                                    ->content(fn (News $record): string => $record->created_at?->diffForHumans() ?? '-'),
                                Placeholder::make('updated_at')
                                    ->label('Terakhir diupdate')
                                    ->content(fn (News $record): string => $record->updated_at?->diffForHumans() ?? '-'),
                            ])
                            ->hidden(fn (?News $record) => $record === null),
                    ])
                    ->columnSpan(['lg' => 1]),
            ])
            ->columns(3);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->modifyQueryUsing(function (Builder $query) {
                return $query
                    ->orderByRaw('pin_order IS NULL asc')
                    ->orderBy('pin_order', 'asc')
                    ->orderBy('id', 'desc');
            })
            ->columns([
                ImageColumn::make('thumbnail')
                    ->label('Cover')
                    ->square()
                    ->size(50),

                TextColumn::make('news_code')
                    ->label('Kode')
                    ->searchable()
                    ->sortable()
                    ->color('gray')
                    ->copyable(),

                TextColumn::make('title')
                    ->label('Judul')
                    ->searchable()
                    ->weight('bold')
                    ->limit(40)
                    ->description(fn (News $record): string => 
                        Str::limit($record->subtitle ?? '-', 30)
                    ),

                TextColumn::make('pin_order')
                    ->label('Pin')
                    ->badge()
                    ->color(fn ($state) => match ($state) {
                        1 => 'danger',
                        2 => 'warning',
                        3 => 'info',
                        default => 'gray',
                    })
                    ->formatStateUsing(fn ($state) => $state ? "#$state" : '-')
                    ->alignCenter()
                    ->sortable(),

                TextColumn::make('categories.name')
                    ->label('Kategori')
                    ->badge()
                    ->color('info')
                    ->separator(','),

                TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'draft' => 'gray',
                        'published' => 'success',
                        'review' => 'warning',
                        default => 'gray',
                    }),

                TextColumn::make('views_count')
                    ->label('Views')
                    ->icon('heroicon-m-eye')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('published_at')
                    ->label('Tanggal')
                    ->dateTime('d M Y, H:i') // Update format tabel juga biar kelihatan jamnya
                    ->sortable(),
            ])
            ->filters([
                SelectFilter::make('categories')
                    ->relationship('categories', 'name')
                    ->multiple(),

                SelectFilter::make('status')
                    ->label('Status')
                    ->options([
                        'draft' => 'Draft',
                        'review' => 'Review',
                        'published' => 'Published',
                    ]),

                Filter::make('published_at')
                    ->form([
                        Forms\Components\DatePicker::make('published_from')->label('Dari Tanggal'),
                        Forms\Components\DatePicker::make('published_until')->label('Sampai Tanggal'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['published_from'],
                                fn (Builder $query, $date): Builder => $query->whereDate('published_at', '>=', $date),
                            )
                            ->when(
                                $data['published_until'],
                                fn (Builder $query, $date): Builder => $query->whereDate('published_at', '<=', $date),
                            );
                    }),
            ])
            ->actions([
                Action::make('preview')
                    ->label('Simulasi')
                    ->icon('heroicon-o-eye')
                    ->color('info')
                    ->modalContent(fn (News $record) => view('filament.resources.news-resource.pages.news-preview', ['record' => $record]))
                    ->modalSubmitAction(false)
                    ->modalCancelActionLabel('Tutup')
                    ->modalWidth('4xl'),

                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListNews::route('/'),
            'create' => Pages\CreateNews::route('/create'),
            'edit' => Pages\EditNews::route('/{record}/edit'),
        ];
    }
}