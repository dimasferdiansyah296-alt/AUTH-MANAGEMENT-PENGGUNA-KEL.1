<?php

namespace Database\Factories;

use App\Models\Pelanggan;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class PelangganFactory extends Factory
{
    protected $model = Pelanggan::class;

    public function definition(): array
    {
        return [
            'id_user' => User::factory()->create(['role' => 'pelanggan'])->id_user,
            'no_telepon' => fake()->phoneNumber(),
            'alamat' => fake()->address(),
        ];
    }
}
