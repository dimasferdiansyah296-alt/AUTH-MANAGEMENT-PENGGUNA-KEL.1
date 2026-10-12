<?php

namespace App\Models;

use Database\Factories\LaporanFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['periode', 'jumlah_pesanan', 'jumlah_pembayaran'])]
class Laporan extends Model
{
    use HasFactory;

    protected $table = 'laporan';

    protected $primaryKey = 'id_laporan';

    protected $casts = [
        'jumlah_pesanan' => 'integer',
        'jumlah_pembayaran' => 'decimal:2',
    ];

    protected static function newFactory(): LaporanFactory
    {
        return LaporanFactory::new();
    }
}
