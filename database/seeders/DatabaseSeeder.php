<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\Antrean;
use App\Models\Karyawan;
use App\Models\Laporan;
use App\Models\Pelanggan;
use App\Models\Pembayaran;
use App\Models\Pesan;
use App\Models\Pesanan;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        User::factory()->create([
            'nama' => 'Test User',
            'email' => 'test@example.com',
            'role' => 'admin',
        ]);

        $pelanggan = Pelanggan::factory(5)->create();
        $karyawan = Karyawan::factory(3)->create();
        $admin = Admin::factory(2)->create();
        $antrean = Antrean::factory(8)->create();

        $pesanan = Pesanan::factory(10)->create([
            'id_pelanggan' => fn () => $pelanggan->random()->id_pelanggan,
            'id_antrean' => fn () => fake()->boolean(70) ? $antrean->random()->id_antrean : null,
        ]);

        Pembayaran::factory(10)->create([
            'id_pesanan' => fn () => $pesanan->random()->id_pesanan,
        ]);

        Pesan::factory(15)->create([
            'id_pesanan' => fn () => $pesanan->random()->id_pesanan,
        ]);

        Laporan::factory(4)->create();
    }
}
