<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Panggil seeder UnitAsalSeeder
        $this->call([
            UnitAsalSeeder::class,
        ]);

        // Jika ingin menambahkan seeder lain, tambahkan di array ini
        // $this->call([
        //     UserSeeder::class,
        //     PasienSeeder::class,
        // ]);
    }
}
