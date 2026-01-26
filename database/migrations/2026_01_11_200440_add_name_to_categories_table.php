<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('categories', function (Blueprint $table) {
            // Tambahkan kolom 'name' jika belum ada
            if (!Schema::hasColumn('categories', 'name')) {
                $table->string('name')->after('id');
            }
            
            // Tambahkan kolom 'slug' juga sekalian (untuk URL)
            if (!Schema::hasColumn('categories', 'slug')) {
                $table->string('slug')->after('name');
            }
        });
    }

    public function down(): void
    {
        Schema::table('categories', function (Blueprint $table) {
            $table->dropColumn(['name', 'slug']);
        });
    }
};