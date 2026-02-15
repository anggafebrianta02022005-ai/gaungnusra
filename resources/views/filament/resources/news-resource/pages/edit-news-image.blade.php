<x-filament-panels::page>
    <form wire:submit="save">
        {{ $this->form }}
        
        <div class="mt-6 flex justify-end gap-3">
            <x-filament::button type="submit" color="success">
                Simpan & Kembali ke Daftar
            </x-filament::button>
            
            <x-filament::button :href="static::getResource()::getUrl('index')" tag="a" color="gray">
                Batal
            </x-filament::button>
        </div>
    </form>
</x-filament-panels::page>