<?php

namespace App\Filament\Resources\EpaperResource\Pages;

use App\Filament\Resources\EpaperResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListEpapers extends ListRecords
{
    protected static string $resource = EpaperResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
