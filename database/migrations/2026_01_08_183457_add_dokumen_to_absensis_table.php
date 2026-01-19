<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
{
    Schema::table('absensis', function (Blueprint $table) {
        // Menambahkan kolom dokumen setelah kolom keterangan
        $table->string('dokumen')->nullable()->after('keterangan');
    });
}

public function down(): void
{
    Schema::table('absensis', function (Blueprint $table) {
        $table->dropColumn('dokumen');
    });
}
};
