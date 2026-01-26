<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Hash;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';
    protected static ?string $navigationLabel = 'Manajemen Pengguna';
    protected static ?string $pluralModelLabel = 'Daftar Pengguna';
    protected static ?string $navigationGroup = 'Pengaturan Akses';

    // ==================================================================
    //  LOGIKA MENYEMBUNYIKAN MENU (Agar Admin Biasa tidak lihat)
    // ==================================================================
    public static function shouldRegisterNavigation(): bool
    {
        // Hanya tampil jika user punya izin 'view_any_user'
        return auth()->check() && auth()->user()->can('view_any_user');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Card::make()->schema([
                    TextInput::make('name')
                        ->label('Nama Lengkap')
                        ->required()
                        ->maxLength(255),

                    // ===> INI TAMBAHAN INPUT USERNAME <===
                    TextInput::make('username')
                        ->label('Username')
                        ->required() // Wajib isi
                        ->unique(ignoreRecord: true) // Tidak boleh kembar
                        ->maxLength(255)
                        ->helperText('Gunakan huruf kecil tanpa spasi. Cth: angga123'),
                    // =====================================
                    
                    TextInput::make('email')
                        ->label('Email')
                        ->email()
                        ->required()
                        ->maxLength(255),
                    
                    TextInput::make('password')
                        ->label('Password')
                        ->password()
                        ->dehydrateStateUsing(fn ($state) => Hash::make($state))
                        ->dehydrated(fn ($state) => filled($state))
                        ->required(fn (string $context): bool => $context === 'create'),
                    
                    // Input Jabatan (Role)
                    Select::make('roles')
                        ->label('Jabatan')
                        ->relationship('roles', 'name')
                        ->multiple()
                        ->preload()
                        ->searchable(),
                ])->columns(1),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label('Nama')
                    ->searchable()
                    ->sortable(),

                // Tampilkan Username di Tabel juga biar rapi
                TextColumn::make('username')
                    ->label('Username')
                    ->searchable()
                    ->icon('heroicon-m-at-symbol')
                    ->color('gray'),
                    
                TextColumn::make('email')
                    ->label('Email')
                    ->searchable(),
                
                TextColumn::make('roles.name')
                    ->label('Jabatan')
                    ->badge()
                    ->color(fn ($state) => match ($state) {
                        'SuperAdminGaungRedaksi' => 'danger',
                        'super_admin' => 'danger',
                        'Admin' => 'success',
                        default => 'primary',
                    })
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}