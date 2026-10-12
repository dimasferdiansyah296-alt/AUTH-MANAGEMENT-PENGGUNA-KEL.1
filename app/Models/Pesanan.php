<?php

namespace App\Models;

use Database\Factories\PesananFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Storage;

#[Fillable([
    'id_pelanggan', 'id_antrean', 'jenis_layanan', 'tgl_pesan', 'tgl_tenggat',
    'ukuran', 'model', 'bahan', 'warna', 'rincian', 'foto', 'status',
])]
class Pesanan extends Model
{
    use HasFactory;

    protected $table = 'pesanan';

    protected $primaryKey = 'id_pesanan';

    protected function casts(): array
    {
        return [
            'tgl_pesan'   => 'date',
            'tgl_tenggat' => 'date',
        ];
    }

    protected static function newFactory(): PesananFactory
    {
        return PesananFactory::new();
    }

    /**
     * URL penuh untuk menampilkan foto acuan di browser.
     * Mengembalikan null jika tidak ada foto.
     */
    public function getFotoUrlAttribute(): ?string
    {
        if (! $this->foto) {
            return null;
        }

        return Storage::disk('public')->url($this->foto);
    }

    public function pelanggan(): BelongsTo
    {
        return $this->belongsTo(Pelanggan::class, 'id_pelanggan', 'id_pelanggan');
    }

    public function antrean(): BelongsTo
    {
        return $this->belongsTo(Antrean::class, 'id_antrean', 'id_antrean');
    }

    public function pembayaran(): HasMany
    {
        return $this->hasMany(Pembayaran::class, 'id_pesanan', 'id_pesanan');
    }

    public function pesan(): HasMany
    {
        return $this->hasMany(Pesan::class, 'id_pesanan', 'id_pesanan');
    }
}
