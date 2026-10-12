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

Schema::create('pesanan', function (Blueprint $table) {
    $table->id('id_pesanan');
    $table->foreignId('id_pelanggan')->constrained('pelanggan', 'id_pelanggan')->onDelete('cascade');
    $table->foreignId('id_antrean')->nullable()->constrained('antrean', 'id_antrean')->onDelete('set null');
    $table->string('ukuran');
    $table->string('model');
    $table->string('bahan');
    $table->string('warna');
    $table->text('rincian');
    $table->string('status');
    $table->timestamps();
});

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pesanan');
    }
};
