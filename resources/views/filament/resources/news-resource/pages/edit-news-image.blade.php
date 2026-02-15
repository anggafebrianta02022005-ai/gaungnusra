<x-filament-panels::page>
    <div class="bg-white p-6 shadow sm:rounded-xl">
        <form wire:submit="save" class="space-y-6">
            {{ $this->form }}
            
            <div class="flex items-center gap-3 justify-end mt-6 border-t pt-6">
                <x-filament::button type="submit" color="success">
                    Simpan Perubahan
                </x-filament::button>
                
                <x-filament::button :href="static::getResource()::getUrl('index')" tag="a" color="gray">
                    Batal
                </x-filament::button>
            </div>
        </form>
    </div>
</x-filament-panels::page>