<?php

namespace App\Filament\Widgets;

use App\Models\News;
use Filament\Widgets\ChartWidget;

class NewsStatusChart extends ChartWidget
{
    protected static ?string $heading = 'Status Konten';
    
    // Urutan ke-2 (Sejajar dengan NewsChart)
    protected static ?int $sort = 2; 
    
    // AMBIL 1 KOLOM SAJA
    protected int | string | array $columnSpan = [
        'md' => 1,
        'xl' => 1,
    ];
    
    protected static ?string $maxHeight = '300px';

    protected function getData(): array
    {
        // Hitung jumlah berita berdasarkan status
        $published = News::where('status', 'published')->count();
        $draft = News::where('status', 'draft')->count();
        $review = News::where('status', 'review')->count(); // Jika ada status review

        return [
            'datasets' => [
                [
                    'label' => 'Jumlah',
                    'data' => [$published, $draft, $review],
                    'backgroundColor' => [
                        '#10B981', // Hijau (Published)
                        '#6B7280', // Abu-abu (Draft)
                        '#F59E0B', // Kuning (Review)
                    ],
                    'borderWidth' => 0,
                    'hoverOffset' => 5,
                ],
            ],
            'labels' => ['Tayang', 'Draft', 'Review'],
        ];
    }

    protected function getType(): string
    {
        return 'pie'; // Pie chart cocok untuk melihat porsi status
    }
    
    protected function getOptions(): array
    {
        return [
            'plugins' => [
                'legend' => [
                    'position' => 'right',
                    'labels' => ['usePointStyle' => true, 'boxWidth' => 8],
                ],
            ],
        ];
    }
}