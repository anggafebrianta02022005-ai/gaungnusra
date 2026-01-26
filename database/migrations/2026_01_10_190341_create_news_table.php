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
        Schema::create('news', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('sub_title')->nullable();
            $table->string('slug')->unique();
            $table->text('content'); // Isi berita
            $table->string('thumbnail')->nullable();
            
            // Kolom SEO (Poin 2.2 PRD) [cite: 19]
            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();
            $table->string('thumbnail_alt')->nullable();

            $table->string('journalist_code'); 
            $table->boolean('is_pinned')->default(false);
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('news');
    }
};
