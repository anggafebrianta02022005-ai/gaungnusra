<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('categories', function (Blueprint $table) {
            // Ubah 'category_name' menjadi 'name' agar sesuai standar Laravel
            if (Schema::hasColumn('categories', 'category_name')) {
                $table->renameColumn('category_name', 'name');
            }
        });
    }

    public function down(): void
    {
        Schema::table('categories', function (Blueprint $table) {
            // Kembalikan nama jika rollback
            if (Schema::hasColumn('categories', 'name')) {
                $table->renameColumn('name', 'category_name');
            }
        });
    }
};