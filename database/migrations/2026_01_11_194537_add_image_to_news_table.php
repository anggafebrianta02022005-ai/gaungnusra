<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('news', function (Blueprint $table) {
            // Menambahkan kolom image setelah content
            // Kita buat nullable() artinya boleh kosong (tidak wajib upload gambar)
            $table->string('image')->nullable()->after('content');
        });
    }

    public function down(): void
    {
        Schema::table('news', function (Blueprint $table) {
            $table->dropColumn('image');
        });
    }
};