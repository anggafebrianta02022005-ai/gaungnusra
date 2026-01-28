<?php

namespace App\Filament\Resources;

use App\Filament\Resources\EpaperResource\Pages;
use App\Models\Epaper;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class EpaperResource extends Resource
{
    protected static ?string $model = Epaper::class;

    // Ganti icon menu di sidebar admin (pilih icon koran)
    protected static ?string $navigationIcon = 'heroicon-o-newspaper';
    
    // Nama Menu di Sidebar
    protected static ?string $navigationLabel = 'Koran Cetak (E-Paper)';
    protected static ?string $modelLabel = 'E-Paper';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Card::make()
                    ->schema([
                        // Input Judul
                        Forms\Components\TextInput::make('title')
                            ->label('Judul Edisi')
                            ->placeholder('Contoh: Edisi Senin, 28 Jan 2026')
                            ->required()
                            ->maxLength(255),

                        // Input Tanggal
                        Forms\Components\DatePicker::make('edition_date')
                            ->label('Tanggal Terbit')
                            ->required(),

                        // Input Upload PDF
                        Forms\Components\FileUpload::make('file')
                            ->label('File Koran (PDF)')
                            ->directory('epapers') // Masuk ke folder public/epapers
                            ->acceptedFileTypes(['application/pdf']) // Hanya boleh PDF
                            ->maxSize(10240) // Maksimal 10MB
                            ->required()
                            ->columnSpanFull(), // Biar lebar full
                        
                        // Tombol Aktif/Nonaktif
                        Forms\Components\Toggle::make('is_active')
                            ->label('Tampilkan di Website?')
                            ->default(true),
                    ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('edition_date')
                    ->label('Tanggal')
                    ->date('d M Y')
                    ->sortable(),
                
                Tables\Columns\TextColumn::make('title')
                    ->label('Judul')
                    ->searchable(),

                Tables\Columns\IconColumn::make('is_active')
                    ->label('Aktif')
                    ->boolean(),

                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('edition_date', 'desc') // Urutkan dari yang terbaru
            ->filters([
                //
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
            'index' => Pages\ListEpapers::route('/'),
            'create' => Pages\CreateEpaper::route('/create'),
            'edit' => Pages\EditEpaper::route('/{record}/edit'),
        ];
    }
}