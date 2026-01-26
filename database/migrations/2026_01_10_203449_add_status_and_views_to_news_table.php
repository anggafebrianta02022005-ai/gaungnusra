<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * (Menambahkan kolom baru)
     */
    public function up(): void
    {
        Schema::table('news', function (Blueprint $table) {
            // 1. Kolom Status Tayang (Default: Aktif/True)
            $table->boolean('is_active')
                  ->default(true)
                  ->after('is_pinned'); // Ditaruh setelah kolom is_pinned
            
            // 2. Kolom Status Populer (Default: Tidak/False)
            $table->boolean('is_popular')
                  ->default(false)
                  ->after('is_active');
            
            // 3. Kolom Jumlah Views (Default: 0)
            $table->bigInteger('views_count')
                  ->default(0)
                  ->after('is_popular');
        });
    }

    /**
     * Reverse the migrations.
     * (Menghapus kolom jika di-rollback)
     */
    public function down(): void
    {
        Schema::table('news', function (Blueprint $table) {
            $table->dropColumn(['is_active', 'is_popular', 'views_count']);
        });
    }
};