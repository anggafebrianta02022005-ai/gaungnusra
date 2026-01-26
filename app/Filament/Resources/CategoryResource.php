<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CategoryResource\Pages;
use App\Models\Category;
use Filament\Forms;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle; // Tombol Saklar
use Filament\Forms\Form;
use Filament\Forms\Set;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn; // Saklar di Tabel
use Filament\Tables\Table;
use Illuminate\Support\Str;

class CategoryResource extends Resource
{
    protected static ?string $model = Category::class;

    protected static ?string $navigationIcon = 'heroicon-o-tag';
    protected static ?string $navigationLabel = 'Kategori';
    protected static ?string $pluralModelLabel = 'Kategori Berita';
    protected static ?string $navigationGroup = 'Manajemen Konten';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Card::make()->schema([
                    // Input Nama Kategori
                    TextInput::make('name')
                        ->label('Nama Kategori')
                        ->required()
                        ->maxLength(255)
                        ->live(onBlur: true) // Generate slug otomatis saat diketik
                        ->afterStateUpdated(fn (Set $set, ?string $state) => $set('slug', Str::slug($state))),

                    // Input Slug
                    TextInput::make('slug')
                        ->required()
                        ->readOnly() // Tidak bisa diedit manual (otomatis)
                        ->maxLength(255),

                    // Tombol Aktif (ON/OFF)
                    Toggle::make('is_active')
                        ->label('Aktifkan Kategori?')
                        ->default(true) // Default nyala
                        ->helperText('Jika dimatikan, kategori ini tidak akan muncul di website utama.'),
                ])->columns(1),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label('Nama Kategori')
                    ->searchable()
                    ->weight('bold')
                    ->sortable(),

                TextColumn::make('slug')
                    ->icon('heroicon-m-link'),

                // Toggle Langsung di Tabel (Bisa klik on/off tanpa masuk edit)
                ToggleColumn::make('is_active')
                    ->label('Status Aktif'),
                
                TextColumn::make('news_count')
                    ->counts('news') // Menghitung jumlah berita di kategori ini
                    ->label('Jumlah Berita')
                    ->badge(),

                TextColumn::make('created_at')
                    ->dateTime('d M Y')
                    ->label('Dibuat')
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCategories::route('/'),
            'create' => Pages\CreateCategory::route('/create'),
            'edit' => Pages\EditCategory::route('/{record}/edit'),
        ];
    }
}