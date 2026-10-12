<?php

namespace App\Models;

use Database\Factories\PesanFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable(['id_pesanan', 'pengirim', 'isi_pesan', 'waktu'])]
class Pesan extends Model
{
    use HasFactory;

    protected $table = 'pesan';

    protected $primaryKey = 'id_pesan';

    protected $casts = [
        'waktu' => 'datetime',
    ];

    protected static function newFactory(): PesanFactory
    {
        return PesanFactory::new();
    }

    public function pesanan(): BelongsTo
    {
        return $this->belongsTo(Pesanan::class, 'id_pesanan', 'id_pesanan');
    }
}
