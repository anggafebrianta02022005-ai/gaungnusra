<?php

namespace App\Filament\Widgets;

use App\Models\Category;
use Filament\Widgets\ChartWidget;

class CategoryChart extends ChartWidget
{
    protected static ?string $heading = 'Top Kategori';
    
    // Urutan SAMA dengan LatestNewsWidget agar sejajar
    protected static ?int $sort = 3; 
    
    // Ambil 1 kolom juga
    protected int | string | array $columnSpan = [
        'md' => 1,
        'xl' => 1,
    ];
    
    protected static ?string $maxHeight = '300px';

    protected function getData(): array
    {
        $categories = Category::withCount('news')
            ->orderByDesc('news_count')
            ->limit(5)
            ->get();

        return [
            'datasets' => [
                [
                    'label' => 'Artikel',
                    'data' => $categories->pluck('news_count'),
                    'backgroundColor' => [
                        '#D32F2F', '#1F2937', '#9CA3AF', '#F87171', '#E5E7EB',
                    ],
                    'borderWidth' => 0,
                    'hoverOffset' => 10,
                ],
            ],
            'labels' => $categories->pluck('name'),
        ];
    }

    protected function getType(): string
    {
        return 'doughnut';
    }
    
    protected function getOptions(): array
    {
        return [
            'cutout' => '70%',
            'plugins' => [
                'legend' => [
                    'position' => 'right',
                    'labels' => ['boxWidth' => 10],
                ],
            ],
        ];
    }
}