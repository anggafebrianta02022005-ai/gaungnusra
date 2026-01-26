<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // 1. CEK TABEL NEWS: Cuma tambah category_id kalau belum punya
        if (Schema::hasTable('news')) {
            Schema::table('news', function (Blueprint $table) {
                if (!Schema::hasColumn('news', 'category_id')) {
                    $table->foreignId('category_id')
                          ->nullable()
                          ->constrained('categories')
                          ->nullOnDelete()
                          ->after('id');
                }
            });
        }

        // 2. CEK TABEL CATEGORIES: Cuma tambah is_active kalau belum punya
        if (Schema::hasTable('categories')) {
            Schema::table('categories', function (Blueprint $table) {
                if (!Schema::hasColumn('categories', 'is_active')) {
                    $table->boolean('is_active')->default(true)->after('slug');
                }
            });
        }
        
        // 3. TABEL ADS (IKLAN): Buat baru kalau belum ada
        if (!Schema::hasTable('ads')) {
            Schema::create('ads', function (Blueprint $table) {
                $table->id();
                $table->string('title');
                $table->string('image')->nullable();
                $table->string('url_link')->nullable(); // Link tujuan
                $table->string('position')->default('sidebar'); 
                $table->boolean('is_active')->default(true);
                $table->timestamps();
            });
        }
    }

    public function down(): void
    {
        // Aman untuk dikosongkan saat dev
    }
};