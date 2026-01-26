<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('ads', function (Blueprint $table) {
            // 1. Cek jika ada kolom 'image_url', ubah jadi 'image'
            if (Schema::hasColumn('ads', 'image_url')) {
                $table->renameColumn('image_url', 'image');
            }

            // 2. Jika belum ada 'image' (dan tadi tidak direname), buat baru
            if (!Schema::hasColumn('ads', 'image') && !Schema::hasColumn('ads', 'image_url')) {
                $table->string('image')->nullable()->after('title');
            }
        });

        // 3. Pastikan kolom 'image' bersifat NULLABLE (Boleh kosong)
        // Kita lakukan di alter terpisah untuk memastikan
        Schema::table('ads', function (Blueprint $table) {
            $table->string('image')->nullable()->change();
        });
    }

    public function down(): void
    {
        // Kembalikan ke asal (Opsional)
        Schema::table('ads', function (Blueprint $table) {
            if (Schema::hasColumn('ads', 'image')) {
                $table->renameColumn('image', 'image_url');
            }
        });
    }
};