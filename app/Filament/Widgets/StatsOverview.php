<?php

namespace App\Filament\Widgets;

use App\Models\News;
use App\Models\Category;
use App\Models\Ad;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends BaseWidget
{
    // Urutan ke-1 (Paling Atas)
    protected static ?int $sort = 1; 
    
    // Agar widget ini memanjang penuh (tidak terpotong)
    protected int | string | array $columnSpan = 'full';

    protected function getStats(): array
    {
        return [
            Stat::make('Total Berita', News::count())
                ->description('Artikel telah terbit')
                ->descriptionIcon('heroicon-m-newspaper')
                ->chart([7, 3, 10, 5, 15, 8, 20]) // Grafik mini naik
                ->color('danger'), // Merah

            Stat::make('Kategori', Category::count())
                ->description('Topik tersedia')
                ->descriptionIcon('heroicon-m-tag')
                ->chart([2, 2, 3, 3, 4, 4, 5])
                ->color('info'), // Biru

            Stat::make('Iklan Aktif', Ad::where('is_active', 1)->count())
                ->description('Slot sedang tayang')
                ->descriptionIcon('heroicon-m-megaphone')
                ->chart([1, 2, 1, 2, 1, 2, 3])
                ->color('success'), // Hijau
                
            Stat::make('Total Pembaca', number_format(News::sum('views_count')))
                ->description('Views halaman')
                ->descriptionIcon('heroicon-m-eye')
                ->chart([100, 200, 150, 300, 250, 400, 500])
                ->color('warning'), // Kuning
        ];
    }
}