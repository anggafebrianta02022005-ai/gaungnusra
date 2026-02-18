<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('ads', function (Blueprint $table) {
            // Menambahkan kolom slot_number, boleh kosong (nullable) karena iklan header tidak butuh slot
            $table->integer('slot_number')->nullable()->after('position');
        });
    }

    public function down(): void
    {
        Schema::table('ads', function (Blueprint $table) {
            $table->dropColumn('slot_number');
        });
    }
};