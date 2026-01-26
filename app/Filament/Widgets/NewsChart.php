<?php

namespace App\Filament\Widgets;

use App\Models\News;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Carbon;

class NewsChart extends ChartWidget
{
    protected static ?string $heading = 'Tren Produktivitas (7 Hari)';
    
    // Urutan ke-2 (Baris Kedua)
    protected static ?int $sort = 2; 
    
    // AMBIL 1 KOLOM SAJA
    protected int | string | array $columnSpan = [
        'md' => 1,
        'xl' => 1,
    ];
    
    protected static ?string $maxHeight = '300px';

    protected function getData(): array
    {
        $data = collect(range(0, 6))->map(function ($days) {
            $date = Carbon::now()->subDays($days)->format('Y-m-d');
            return [
                'date' => Carbon::now()->subDays($days)->format('d M'),
                'count' => News::whereDate('created_at', $date)->count(),
            ];
        })->reverse();

        return [
            'datasets' => [
                [
                    'label' => 'Artikel Dibuat',
                    'data' => $data->pluck('count'),
                    'fill' => true,
                    'backgroundColor' => 'rgba(211, 47, 47, 0.1)', // Merah Transparan
                    'borderColor' => '#D32F2F',
                    'tension' => 0.4,
                    'pointBackgroundColor' => '#fff',
                    'pointBorderColor' => '#D32F2F',
                    'pointBorderWidth' => 2,
                ],
            ],
            'labels' => $data->pluck('date'),
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
    
    protected function getOptions(): array
    {
        return [
            'plugins' => ['legend' => ['display' => false]], // Sembunyikan legenda
            'scales' => [
                'y' => ['grid' => ['display' => false], 'ticks' => ['stepSize' => 1]],
                'x' => ['grid' => ['display' => false]],
            ],
        ];
    }
}