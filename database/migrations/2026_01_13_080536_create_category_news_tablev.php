<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Tabel Pivot (Penghubung)
        Schema::create('category_news', function (Blueprint $table) {
            $table->id();
            $table->foreignId('news_id')->constrained()->cascadeOnDelete();
            $table->foreignId('category_id')->constrained()->cascadeOnDelete();
            // Tidak perlu timestamps untuk pivot sederhana
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('category_news');
    }
};