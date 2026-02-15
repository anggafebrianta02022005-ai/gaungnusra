<?php

namespace App\Filament\Resources\NewsResource\Pages;

use App\Filament\Resources\NewsResource;
use App\Models\News;
use Filament\Resources\Pages\Page;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Actions\Action;

class EditNewsImage extends Page
{
    protected static string $resource = NewsResource::class;
    protected static string $view = 'filament.resources.news-resource.pages.edit-news-image';

    public ?array $data = [];
    public News $record;

    public function mount(News $record): void
    {
        $this->record = $record;
        $this->form->fill($record->toArray());
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                FileUpload::make('image')
                    ->label('Potong Gambar Header')
                    ->image()
                    ->imageEditor()
                    ->imageEditorMode(1)
                    ->imageEditorAspectRatios(['16:9', '4:3', '1:1'])
                    ->panelLayout('integrated')
                    ->columnSpanFull(),
                
                FileUpload::make('thumbnail')
                    ->label('Potong Thumbnail')
                    ->image()
                    ->imageEditor()
                    ->imageEditorMode(1)
                    ->imageEditorAspectRatios(['16:9'])
                    ->panelLayout('integrated')
                    ->columnSpanFull(),
            ])
            ->statePath('data');
    }

    public function save()
    {
        $this->record->update($this->data);
        Notification::make()->title('Gambar Berhasil Disimpan')->success()->send();
        return redirect($this->getResource()::getUrl('index'));
    }
}