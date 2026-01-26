@php
    // Mengambil data perusahaan langsung dari database
    $company = \App\Models\CompanyProfile::first();
@endphp

<div class="flex items-center gap-3">
    @if($company && $company->logo)
        <img src="{{ Storage::url($company->logo) }}" 
             alt="{{ $company->name }}" 
             class="h-10 w-auto object-contain">
    @endif

    <div class="font-bold text-xl tracking-tight leading-none text-gray-950 dark:text-white">
        Gaung<span class="text-[#D32F2F]">Nusra</span>
    </div>
</div>