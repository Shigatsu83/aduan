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
        Schema::table('aduans', function (Blueprint $table) {
            // Hapus kolom jenis yang lama
            $table->dropColumn('jenis');
        });

        Schema::table('aduans', function (Blueprint $table) {
            // Buat kolom jenis baru dengan tipe enum
            $table->enum('jenis', [
                'Infrastruktur',
                'Lingkungan',
                'Pelayanan Publik',
                'Keamanan',
                'Lainnya'
            ])->after('isi');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('aduans', function (Blueprint $table) {
            // Hapus kolom jenis enum
            $table->dropColumn('jenis');
        });

        Schema::table('aduans', function (Blueprint $table) {
            // Kembalikan ke kolom string biasa
            $table->string('jenis')->after('isi');
        });
    }
};