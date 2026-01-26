<?php

namespace App\Filament\Resources\CompanyProfileResource\Pages;

use App\Filament\Resources\CompanyProfileResource;
use App\Models\CompanyProfile;
use Filament\Resources\Pages\CreateRecord;
use Filament\Notifications\Notification;

class CreateCompanyProfile extends CreateRecord
{
    protected static string $resource = CompanyProfileResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    // ===> [LOGIKA 2] CEGAH AKSES PAKSA LEWAT URL <===
    // Dijalankan saat halaman mau dibuka (mount).
    // Jika data sudah ada, user ditendang balik ke halaman List.
    public function mount(): void
    {
        // Cek apakah sudah ada data profil?
        if (CompanyProfile::count() >= 1) {
            
            // 1. Kirim Peringatan
            Notification::make()
                ->warning()
                ->title('Akses Ditolak: Profil Sudah Ada!')
                ->body('Website hanya boleh memiliki 1 Profil Perusahaan. Silakan Edit profil yang ada, atau Hapus terlebih dahulu jika ingin membuat baru.')
                ->persistent() // Notifikasi tidak hilang otomatis (harus diclose user)
                ->send();

            // 2. Tendang balik ke halaman index (list)
            $this->redirect($this->getResource()::getUrl('index'));
            return;
        }

        parent::mount();
    }
}