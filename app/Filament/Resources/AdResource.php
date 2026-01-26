<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AdResource\Pages;
use App\Models\Ad;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Get; // Import penting untuk baca nilai form
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TernaryFilter;

class AdResource extends Resource
{
    protected static ?string $model = Ad::class;

    protected static ?string $navigationIcon = 'heroicon-o-megaphone';
    
    protected static ?string $navigationGroup = 'Manajemen Konten';

    protected static ?string $navigationLabel = 'Iklan (Ads)';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Detail Iklan')
                    ->schema([
                        TextInput::make('title')
                            ->label('Judul / Nama Iklan')
                            ->required()
                            ->maxLength(255),

                        Select::make('type')
                            ->label('Jenis Tampilan')
                            ->options([
                                'image_only' => 'Hanya Gambar (Banner Info)',
                                'with_link' => 'Gambar Bisa Diklik (Link)',
                            ])
                            ->default('with_link')
                            ->live()
                            ->required(),

                        TextInput::make('link')
                            ->label('URL Tujuan')
                            ->placeholder('https://google.com')
                            ->url()
                            ->visible(fn (Get $get) => $get('type') === 'with_link')
                            ->required(fn (Get $get) => $get('type') === 'with_link'),

                        Select::make('position')
                            ->label('Posisi Penempatan')
                            ->options([
                                'header_top' => 'Header Atas',
                                'sidebar_right' => 'Sidebar Kanan',
                            ])
                            ->default('sidebar_right')
                            ->required()
                            ->live(), // Live agar toggle di bawah bisa validasi real-time

                        FileUpload::make('image')
                            ->label('Banner Iklan')
                            ->image()
                            ->directory('ads')
                            ->imageEditor() // <--- Aktifkan fitur crop manual
                            // Jangan kunci aspect ratio karena iklan beda-beda bentuknya
                            ->helperText('Rekomendasi Ukuran: Header (1200 x 300 px), Sidebar (300 x 600 px)')
                            ->columnSpanFull(),

                        // === [UPDATE REVISI 2] VALIDASI LIMIT IKLAN ===
                        Toggle::make('is_active')
                            ->label('Status Aktif')
                            ->default(true)
                            ->rules([
                                fn (Get $get, $record) => function (string $attribute, $value, \Closure $fail) use ($get, $record) {
                                    // Hanya cek jika user mencoba mengaktifkan (ON)
                                    if ($value) {
                                        $position = $get('position');
                                        
                                        // Cari iklan LAIN yang aktif di posisi yang sama
                                        $existingAds = Ad::where('position', $position)
                                            ->where('is_active', true)
                                            ->when($record, fn ($q) => $q->where('id', '!=', $record->id)) // Abaikan diri sendiri saat edit
                                            ->count();

                                        // Jika sudah ada 1, tolak!
                                        if ($existingAds >= 1) {
                                            $namaPosisi = match($position) {
                                                'header_top' => 'Header Atas',
                                                'sidebar_right' => 'Sidebar Kanan',
                                                default => $position
                                            };
                                            
                                            $fail("Gagal! Posisi '$namaPosisi' sudah penuh (Max 1 Iklan). Matikan iklan lain dulu.");
                                        }
                                    }
                                },
                            ]),
                    ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
        ->defaultSort('created_at', 'desc')
            ->columns([
                ImageColumn::make('image')
                    ->label('Preview'),
                
                TextColumn::make('title')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('type')
                    ->label('Jenis')
                    ->badge()
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'image_only' => 'Info',
                        'with_link' => 'Link',
                    })
                    ->color(fn (string $state): string => match ($state) {
                        'image_only' => 'gray',
                        'with_link' => 'success',
                    }),

                TextColumn::make('position')
                    ->label('Posisi')
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'header_top' => 'Header Atas',
                        'sidebar_right' => 'Sidebar Kanan',
                        default => $state,
                    })
                    ->sortable(),

                IconColumn::make('is_active')
                    ->label('Aktif')
                    ->boolean(),

                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('type')
                    ->label('Filter Jenis')
                    ->options([
                        'image_only' => 'Hanya Gambar',
                        'with_link' => 'Ada Link',
                    ]),

                SelectFilter::make('position')
                    ->label('Filter Posisi')
                    ->options([
                        'header_top' => 'Header Atas',
                        'sidebar_right' => 'Sidebar Kanan',
                    ]),

                TernaryFilter::make('is_active')
                    ->label('Status Aktif')
                    ->trueLabel('Hanya Aktif')
                    ->falseLabel('Hanya Non-Aktif'),
            ])
            ->actions([
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
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListAds::route('/'),
            'create' => Pages\CreateAd::route('/create'),
            'edit' => Pages\EditAd::route('/{record}/edit'),
        ];
    }
}