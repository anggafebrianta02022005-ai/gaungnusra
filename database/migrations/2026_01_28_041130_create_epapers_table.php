<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('epapers', function (Blueprint $table) {
            $table->id();
            $table->string('title');        // Judul, misal: "Edisi Senin"
            $table->string('file');         // Lokasi file PDF (Tanpa Cover)
            $table->date('edition_date');   // Tanggal Terbit
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('epapers');
    }
};