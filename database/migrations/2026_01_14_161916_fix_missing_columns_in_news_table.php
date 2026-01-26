<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('news', function (Blueprint $table) {
            
            // 1. Cek & Tambah news_code
            if (!Schema::hasColumn('news', 'news_code')) {
                $table->string('news_code')->nullable()->unique()->after('id');
            }

            // 2. Cek & Tambah is_pinned
            if (!Schema::hasColumn('news', 'is_pinned')) {
                $table->boolean('is_pinned')->default(false)->after('title');
            }

            // 3. Cek & Tambah status
            if (!Schema::hasColumn('news', 'status')) {
                $table->string('status')->default('draft')->after('slug'); 
            }

            // 4. Cek & Tambah published_at (INI YANG BIKIN ERROR TADI)
            if (!Schema::hasColumn('news', 'published_at')) {
                $table->timestamp('published_at')->nullable()->after('updated_at');
            }
        });
    }

    public function down(): void
    {
        // Kosongkan saja agar aman saat rollback
    }
};