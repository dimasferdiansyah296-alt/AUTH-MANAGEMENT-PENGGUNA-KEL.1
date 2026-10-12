<?php

namespace Database\Factories;

use App\Models\Antrean;
use App\Models\Pelanggan;
use App\Models\Pesanan;
use Illuminate\Database\Eloquent\Factories\Factory;

class PesananFactory extends Factory
{
    protected $model = Pesanan::class;

    public function definition(): array
    {
        return [
            'id_pelanggan' => Pelanggan::factory(),
            'id_antrean' => fake()->boolean(70) ? Antrean::factory() : null,
            'ukuran' => fake()->randomElement(['S', 'M', 'L', 'XL', 'XXL']),
            'model' => fake()->randomElement(['Kemeja', 'Celana', 'Gaun', 'Jaket', 'Rok', 'Seragam']),
            'bahan' => fake()->randomElement(['Katun', 'Sutra', 'Denim', 'Wol', 'Flanel', 'Linen']),
            'warna' => fake()->safeColorName(),
            'rincian' => fake()->paragraph(2),
            'status' => fake()->randomElement(['baru', 'diproses', 'dijahit', 'selesai', 'diambil']),
        ];
    }
}
