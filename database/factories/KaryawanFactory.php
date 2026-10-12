<?php

namespace Database\Factories;

use App\Models\Karyawan;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class KaryawanFactory extends Factory
{
    protected $model = Karyawan::class;

    public function definition(): array
    {
        return [
            'id_user' => User::factory()->create(['role' => 'karyawan'])->id_user,
            'nama' => fake()->name(),
            'no_telepon' => fake()->phoneNumber(),
        ];
    }
}
