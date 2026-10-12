<?php

namespace Database\Factories;

use App\Models\Admin;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class AdminFactory extends Factory
{
    protected $model = Admin::class;

    public function definition(): array
    {
        return [
            'id_user' => User::factory()->create(['role' => 'admin'])->id_user,
            'nama' => fake()->name(),
            'no_telepon' => fake()->phoneNumber(),
        ];
    }
}
