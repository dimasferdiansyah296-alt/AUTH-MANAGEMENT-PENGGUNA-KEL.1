<?php

namespace Database\Factories;

use App\Models\Antrean;
use Illuminate\Database\Eloquent\Factories\Factory;

class AntreanFactory extends Factory
{
    protected $model = Antrean::class;

    private static int $counter = 1;

    public function definition(): array
    {
        return [
            'nomor_antrean' => 'A' . str_pad(self::$counter++, 3, '0', STR_PAD_LEFT),
            'tanggal' => fake()->dateTimeBetween('-1 month', '+1 month')->format('Y-m-d'),
            'status' => fake()->randomElement(['menunggu', 'diproses', 'selesai', 'batal']),
        ];
    }
}
