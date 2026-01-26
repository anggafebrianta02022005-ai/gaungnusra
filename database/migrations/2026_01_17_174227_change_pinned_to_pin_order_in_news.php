<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('news', function (Blueprint $table) {
            // Hapus kolom is_pinned lama
            if (Schema::hasColumn('news', 'is_pinned')) {
                $table->dropColumn('is_pinned');
            }
            // Tambah kolom pin_order (Bisa NULL, 1, 2, atau 3)
            if (!Schema::hasColumn('news', 'pin_order')) {
                $table->integer('pin_order')->nullable()->unique()->after('status');
            }
        });
    }

    public function down(): void
    {
        Schema::table('news', function (Blueprint $table) {
            $table->dropColumn('pin_order');
            $table->boolean('is_pinned')->default(false);
        });
    }
};