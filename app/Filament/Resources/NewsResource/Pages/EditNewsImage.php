<?php

namespace App\Filament\Resources\NewsResource\Pages;

use App\Filament\Resources\NewsResource;
use App\Models\News;
use Filament\Resources\Pages\Page;
use Filament\Actions\Action;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Form;
use Filament\Notifications\Notification;

class EditNewsImage extends Page
{
    protected static string $resource = NewsResource::class;

    protected static string $view = 'filament.resources.news-resource.pages.edit-news-image';

    public ?array $data = [];
    public News $record;

    public function mount(News $record): void
    {
        $this->record = $record;
        $this->form->fill([
            'image' => $record->image,
            'thumbnail' => $record->thumbnail,
        ]);
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                FileUpload::make('image')
                    ->label('Potong Gambar Header (16:9)')
                    ->image()
                    ->imageEditor()
                    ->imageEditorMode(1)
                    ->imageEditorEmptyFillColor('#000000')
                    ->imageEditorAspectRatios(['16:9'])
                    ->panelLayout('integrated') // Canvas lega memakan satu halaman penuh
                    ->columnSpanFull(),
            ])
            ->statePath('data');
    }

    protected function getHeaderActions(): array
    {
        return [
            Action::make('save')
                ->label('Simpan & Kembali')
                ->color('success')
                ->action(function () {
                    $this->record->update($this->data);
                    
                    Notification::make()
                        ->title('Gambar berhasil disimpan')
                        ->success()
                        ->send();

                    return redirect($this->getResource()::getUrl('index'));
                }),
        ];
    }
}