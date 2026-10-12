<?php

namespace Database\Factories;

use App\Models\Laporan;
use Illuminate\Database\Eloquent\Factories\Factory;

class LaporanFactory extends Factory
{
    protected $model = Laporan::class;

    public function definition(): array
    {
        return [
            'periode' => fake()->randomElement(['Januari 2026', 'Februari 2026', 'Maret 2026', 'Q1 2026', 'Semester 1 2026']),
            'jumlah_pesanan' => fake()->numberBetween(10, 200),
            'jumlah_pembayaran' => fake()->randomFloat(2, 1000000, 100000000),
        ];
    }
}
