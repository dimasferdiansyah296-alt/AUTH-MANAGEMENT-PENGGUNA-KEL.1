<?php

namespace Database\Factories;

use App\Models\Pembayaran;
use App\Models\Pesanan;
use Illuminate\Database\Eloquent\Factories\Factory;

class PembayaranFactory extends Factory
{
    protected $model = Pembayaran::class;

    public function definition(): array
    {
        return [
            'id_pesanan' => Pesanan::factory(),
            'jumlah' => fake()->randomFloat(2, 100000, 5000000),
            'bukti_pembayaran' => 'bukti_' . fake()->uuid() . '.png',
            'status' => fake()->randomElement(['pending', 'dibayar', 'lunas', 'ditolak']),
        ];
    }
}
