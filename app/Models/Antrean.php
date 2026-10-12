<?php

namespace App\Models;

use Database\Factories\AntreanFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable(['nomor_antrean', 'tanggal', 'status'])]
class Antrean extends Model
{
    use HasFactory;

    protected $table = 'antrean';

    protected $primaryKey = 'id_antrean';

    protected $casts = [
        'tanggal' => 'date',
    ];

    protected static function newFactory(): AntreanFactory
    {
        return AntreanFactory::new();
    }

    public function pesanan(): HasMany
    {
        return $this->hasMany(Pesanan::class, 'id_antrean', 'id_antrean');
    }
}
