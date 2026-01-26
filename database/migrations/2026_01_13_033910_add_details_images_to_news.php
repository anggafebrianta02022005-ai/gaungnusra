<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('news', function (Blueprint $table) {
            
            // 1. Cek Subtitle
            if (!Schema::hasColumn('news', 'subtitle')) {
                $table->string('subtitle')->nullable()->after('title');
            }

            // 2. Cek Thumbnail
            if (!Schema::hasColumn('news', 'thumbnail')) {
                // Kita asumsikan 'image' sudah ada sebagai patokan urutan
                // Jika 'image' tidak ada, dia akan default taruh paling belakang
                $table->string('thumbnail')->nullable()->after('image'); 
            }

            // 3. Cek Article Image
            if (!Schema::hasColumn('news', 'article_image')) {
                $table->string('article_image')->nullable()->after('thumbnail');
            }
        });
    }

    public function down(): void
    {
        Schema::table('news', function (Blueprint $table) {
            // Hapus kolom hanya jika ada
            if (Schema::hasColumn('news', 'subtitle')) $table->dropColumn('subtitle');
            if (Schema::hasColumn('news', 'thumbnail')) $table->dropColumn('thumbnail');
            if (Schema::hasColumn('news', 'article_image')) $table->dropColumn('article_image');
        });
    }
};