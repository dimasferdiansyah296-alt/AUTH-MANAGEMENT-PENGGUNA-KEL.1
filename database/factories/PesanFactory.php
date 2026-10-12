<?php

namespace Database\Factories;

use App\Models\Pesan;
use App\Models\Pesanan;
use Illuminate\Database\Eloquent\Factories\Factory;

class PesanFactory extends Factory
{
    protected $model = Pesan::class;

    public function definition(): array
    {
        return [
            'id_pesanan' => Pesanan::factory(),
            'pengirim' => fake()->randomElement(['pelanggan', 'admin', 'karyawan']),
            'isi_pesan' => fake()->paragraph(),
            'waktu' => fake()->dateTimeBetween('-1 month', 'now'),
        ];
    }
}
