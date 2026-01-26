<?php

namespace App\Filament\Widgets;

use App\Models\News;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class LatestNewsWidget extends BaseWidget
{
    // Urutan ke-3 (Sejajar dengan Category Chart)
    protected static ?int $sort = 3; 
    
    // UBAH DISINI: Ambil 1 kolom saja di layar Medium ke atas
    protected int | string | array $columnSpan = [
        'md' => 1,
        'xl' => 1,
    ]; 
    
    protected static ?string $heading = 'Monitor Berita Terbaru';

    public function table(Table $table): Table
    {
        return $table
            ->query(
                News::query()->latest()->limit(5)
            )
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->label('Judul')
                    ->limit(25) // Limit diperpendek biar muat di setengah layar
                    ->tooltip(fn ($state) => $state) // Hover untuk lihat judul penuh
                    ->weight('bold'),
                
                Tables\Columns\TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'published' => 'success',
                        'draft' => 'gray',
                        'review' => 'warning',
                        default => 'info',
                    }),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Tgl')
                    ->date('d M') // Format diperpendek biar rapi
                    ->color('gray')
                    ->size(Tables\Columns\TextColumn\TextColumnSize::ExtraSmall),
            ])
            ->paginated(false)
            ->searchable(false); // Search dimatikan agar tampilan header tabel lebih bersih
    }
}