<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CompanyProfileResource\Pages;
use App\Models\CompanyProfile;
use Filament\Forms;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class CompanyProfileResource extends Resource
{
    protected static ?string $model = CompanyProfile::class;

    protected static ?string $navigationIcon = 'heroicon-o-building-office-2';
    
    // [REVISI 1] Label Sidebar sudah benar 'Profil Perusahaan'
    protected static ?string $navigationLabel = 'Profil Perusahaan';
    
    protected static ?string $modelLabel = 'Profil Perusahaan';
    
    protected static ?string $navigationGroup = 'Pengaturan Situs';
    
    protected static ?int $navigationSort = 3;

    // ===> [SOLUSI UTAMA] PROTEKSI SIDEBAR <===
    // Menu ini hanya akan muncul jika User punya izin 'view_company_profile'
    // Admin biasa (ID 2) tidak punya izin ini, jadi menu akan HILANG.
    public static function canViewAny(): bool
    {
        return auth()->user()->can('view_company_profile');
    }

    // Logika tombol create (hanya muncul jika data masih 0)
    public static function canCreate(): bool
    {
        return CompanyProfile::count() === 0;
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Group::make()
                    ->schema([
                        Section::make('Identitas Perusahaan')
                            ->schema([
                                TextInput::make('name')
                                    ->label('Nama Perusahaan')
                                    ->required()
                                    ->maxLength(255)
                                    ->placeholder('Contoh: PT Media Gemilang'),

                                FileUpload::make('logo')
                                    ->label('Logo Perusahaan')
                                    ->image()
                                    ->directory('company-logo')
                                    ->imageEditor() // Biar bisa crop manual kalau mau (opsional)
                                    ->columnSpanFull() // Agar inputannya lebar
                                    ->required(),

                                RichEditor::make('description')
                                    ->label('Profil Lengkap & Sejarah')
                                    ->toolbarButtons([
                                        'attachFiles', 'blockquote', 'bold', 'bulletList', 'codeBlock',
                                        'h2', 'h3', 'italic', 'link', 'orderedList', 'redo',
                                        'strike', 'underline', 'undo',
                                    ])
                                    ->fileAttachmentsDirectory('company-attachments')
                                    ->columnSpanFull(),
                            ])->columns(2),

                        Section::make('Kontak & Alamat')
                            ->schema([
                                Textarea::make('address')
                                    ->label('Alamat Lengkap')
                                    ->rows(3)
                                    ->required()
                                    ->columnSpanFull(),

                                TextInput::make('email')
                                    ->email()
                                    ->label('Email Resmi')
                                    ->prefixIcon('heroicon-m-envelope'),

                                TextInput::make('phone')
                                    ->tel()
                                    ->label('Nomor Telepon')
                                    ->prefixIcon('heroicon-m-phone'),

                                TextInput::make('website')
                                    ->url()
                                    ->label('Website')
                                    ->prefix('https://')
                                    ->placeholder('www.domain.com'),
                            ])->columns(2),
                    ])->columnSpan(['lg' => 2]),

                Group::make()
                    ->schema([
                        Section::make('Sosial Media')
                            ->description('Link sosmed untuk ditampilkan di footer.')
                            ->schema([
                                TextInput::make('facebook')
                                    ->label('Facebook')
                                    ->prefix('facebook.com/'),
                                
                                TextInput::make('instagram')
                                    ->label('Instagram')
                                    ->prefix('instagram.com/'),
                            ]),
                    ])->columnSpan(['lg' => 1]),
            ])->columns(3);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('logo')
                    ->label('Logo')
                    ->square()
                    ->size(50),

                TextColumn::make('name')
                    ->label('Nama Perusahaan')
                    ->weight('bold'),

                TextColumn::make('email')
                    ->label('Email')
                    ->icon('heroicon-m-envelope')
                    ->copyable(),

                TextColumn::make('phone')
                    ->label('Telepon'),

                TextColumn::make('updated_at')
                    ->label('Terakhir Update')
                    ->dateTime('d M Y'),
            ])
            ->filters([])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCompanyProfiles::route('/'),
            'create' => Pages\CreateCompanyProfile::route('/create'),
            'edit' => Pages\EditCompanyProfile::route('/{record}/edit'),
        ];
    }
}