<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AdResource\Pages;
use App\Models\Ad;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Get;
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

                        // Input Link fleksibel: Bisa URL atau # untuk popup
                        TextInput::make('link')
                            ->label('Link Tujuan (URL)')
                            ->placeholder('https://... atau # untuk Popup Gambar')
                            ->nullable(),

                        Select::make('position')
                            ->label('Posisi Penempatan')
                            ->options([
                                'header_top' => 'Header Atas',
                                'sidebar_right' => 'Sidebar Kanan (Mobile 5 Slot)',
                            ])
                            ->default('sidebar_right')
                            ->required()
                            ->live(), // Live agar input slot di bawah bisa muncul/hilang

                        // [BARU] Input Slot Number (Hanya muncul jika Sidebar dipilih)
                        Select::make('slot_number')
                            ->label('Pilih Slot Tayang')
                            ->options([
                                1 => 'Slot 1 (Paling Atas)',
                                2 => 'Slot 2',
                                3 => 'Slot 3',
                                4 => 'Slot 4',
                                5 => 'Slot 5 (Paling Bawah)',
                            ])
                            ->visible(fn (Get $get) => $get('position') === 'sidebar_right')
                            ->required(fn (Get $get) => $get('position') === 'sidebar_right')
                            ->native(false),

                        FileUpload::make('image')
                            ->label('Banner Iklan')
                            ->image()
                            ->directory('ads')
                            ->imageEditor()
                            ->helperText('Rekomendasi: Header (1200x300px), Sidebar (300x300px atau 300x600px)')
                            ->columnSpanFull()
                            ->required(),

                        // [UPDATE] Validasi Limit yang Lebih Cerdas (Support 5 Slot)
                        Toggle::make('is_active')
                            ->label('Status Aktif')
                            ->default(true)
                            ->rules([
                                fn (Get $get, $record) => function (string $attribute, $value, \Closure $fail) use ($get, $record) {
                                    if ($value) { // Cek hanya saat diaktifkan
                                        $position = $get('position');
                                        $slot = $get('slot_number');

                                        $query = Ad::where('position', $position)
                                            ->where('is_active', true)
                                            ->when($record, fn ($q) => $q->where('id', '!=', $record->id));

                                        // Jika Sidebar, cek berdasarkan Slot Number juga
                                        if ($position === 'sidebar_right') {
                                            $query->where('slot_number', $slot);
                                            $msg = "Slot Sidebar #{$slot} sudah terisi. Nonaktifkan iklan lain di slot ini dulu.";
                                        } else {
                                            // Jika Header, cek posisi saja (Max 1)
                                            $msg = "Posisi Header sudah terisi. Nonaktifkan iklan header yang lama dulu.";
                                        }

                                        if ($query->count() > 0) {
                                            $fail($msg);
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
                    ->label('Preview')
                    ->height(50),
                
                TextColumn::make('title')
                    ->searchable()
                    ->sortable()
                    ->limit(30),

                TextColumn::make('position')
                    ->label('Posisi')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'header_top' => 'info',
                        'sidebar_right' => 'warning',
                        default => 'gray',
                    })
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'header_top' => 'Header',
                        'sidebar_right' => 'Sidebar',
                        default => $state,
                    }),

                // [BARU] Kolom Slot agar admin tau ini iklan slot ke berapa
                TextColumn::make('slot_number')
                    ->label('Slot')
                    ->sortable()
                    ->alignCenter()
                    ->badge()
                    ->color('success')
                    ->formatStateUsing(fn ($state) => $state ? "#{$state}" : '-')
                    ->visible(fn () => true), // Selalu tampil

                TextColumn::make('link')
                    ->label('Tujuan')
                    ->limit(20)
                    ->icon(fn ($state) => $state === '#' ? 'heroicon-o-eye' : 'heroicon-o-link')
                    ->url(fn ($state) => $state === '#' ? null : $state, true),

                IconColumn::make('is_active')
                    ->label('Aktif')
                    ->boolean(),

                TextColumn::make('created_at')
                    ->dateTime('d M Y')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('position')
                    ->label('Filter Posisi')
                    ->options([
                        'header_top' => 'Header Atas',
                        'sidebar_right' => 'Sidebar Kanan',
                    ]),

                // Filter Slot Sidebar
                SelectFilter::make('slot_number')
                    ->label('Filter Slot')
                    ->options([
                        1 => 'Slot 1', 2 => 'Slot 2', 3 => 'Slot 3', 4 => 'Slot 4', 5 => 'Slot 5'
                    ]),

                TernaryFilter::make('is_active')
                    ->label('Status Aktif'),
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