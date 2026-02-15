<?php

namespace App\Filament\Resources\NewsResource\Pages;

use App\Filament\Resources\NewsResource;
use App\Models\News;
use Filament\Resources\Pages\Page;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Actions\Action;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Concerns\InteractsWithForms;

class EditNewsImage extends Page implements HasForms
{
    use InteractsWithForms;

    protected static string $resource = NewsResource::class;
    protected static string $view = 'filament.resources.news-resource.pages.edit-news-image';

    public ?array $data = [];
    public News $record;

    public function mount(News $record): void
    {
        $this->record = $record;
        
        // Pastikan data awal terisi agar jika tidak diedit salah satu, gambar lama tidak hilang
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
                    ->label('Potong Gambar Header')
                    ->image()
                    ->directory('news-main') // Pastikan direktori sama dengan di Resource utama
                    ->imageEditor()
                    ->imageEditorMode(1)
                    ->imageEditorAspectRatios(['16:9', '4:3', '1:1'])
                    ->panelLayout('integrated')
                    ->columnSpanFull(),
                
                FileUpload::make('thumbnail')
                    ->label('Potong Thumbnail')
                    ->image()
                    ->directory('news-thumbnails') // Pastikan direktori sama dengan di Resource utama
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
        // 1. Ambil data yang sudah divalidasi dari form
        $formData = $this->form->getState();

        // 2. Update record database
        $this->record->update($formData);

        // 3. Notifikasi sukses
        Notification::make()
            ->title('Gambar Berhasil Disimpan')
            ->success()
            ->send();

        // 4. Kembali ke halaman daftar
        return redirect($this->getResource()::getUrl('index'));
    }
}