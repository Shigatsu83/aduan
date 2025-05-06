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
        Schema::table('admin_comments', function (Blueprint $table) {
            $table->enum('status_aduan', ['Sedang Diproses', 'Selesai'])->after('komentar');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('admin_comments', function (Blueprint $table) {
            $table->dropColumn('status_aduan');
        });
    }
};