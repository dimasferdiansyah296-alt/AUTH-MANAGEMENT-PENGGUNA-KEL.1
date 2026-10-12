<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * Menambah kolom untuk kebutuhan form pemesanan pelanggan:
     *  - jenis_layanan : jenis jasa (Jahit Baju, Permak, Celana, dll.)
     *  - tgl_pesan     : tanggal pesanan dibuat
     *  - tgl_tenggat   : tanggal kebutuhan selesai
     *  - foto          : path foto acuan/desain (opsional)
     */
    public function up(): void
    {
        Schema::table('pesanan', function (Blueprint $table) {
            // nullable agar kompatibel dengan data lama; validasi di controller
            // memastikan pesanan BARU selalu mengisi kolom ini.
            $table->string('jenis_layanan')->nullable()->after('id_antrean');
            $table->date('tgl_pesan')->nullable()->after('jenis_layanan');
            $table->date('tgl_tenggat')->nullable()->after('tgl_pesan');
            $table->string('foto')->nullable()->after('tgl_tenggat');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pesanan', function (Blueprint $table) {
            $table->dropColumn(['jenis_layanan', 'tgl_pesan', 'tgl_tenggat', 'foto']);
        });
    }
};
