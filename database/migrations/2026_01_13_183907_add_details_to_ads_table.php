<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('ads', function (Blueprint $table) {
            // Cek agar tidak error jika kolom sudah ada
            if (!Schema::hasColumn('ads', 'type')) {
                $table->string('type')->default('image_only')->after('title'); // image_only atau with_link
                $table->string('link')->nullable()->after('image');
                $table->string('position')->default('sidebar_right')->after('link');
                $table->boolean('is_active')->default(true)->after('position');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('ads', function (Blueprint $table) {
            $table->dropColumn(['type', 'link', 'position', 'is_active']);
        });
    }
};