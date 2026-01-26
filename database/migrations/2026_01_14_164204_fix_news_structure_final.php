<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('news', function (Blueprint $table) {
            // 1. Buat kolom news_code jika belum ada
            if (!Schema::hasColumn('news', 'news_code')) {
                $table->string('news_code')->nullable()->after('id');
            }

            // 2. Buat kolom is_pinned jika belum ada
            if (!Schema::hasColumn('news', 'is_pinned')) {
                $table->boolean('is_pinned')->default(false)->after('image');
            }

            // 3. Buat kolom published_at jika belum ada
            if (!Schema::hasColumn('news', 'published_at')) {
                $table->timestamp('published_at')->nullable()->after('updated_at');
            }

            // 4. Buat kolom status jika belum ada
            if (!Schema::hasColumn('news', 'status')) {
                $table->string('status')->default('draft')->after('slug');
            }
        });
    }

    public function down(): void
    {
        // Tidak perlu drop agar aman
    }
};