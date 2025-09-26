<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\UnitAsal;

class UnitAsalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $units = [
            'OK ELEKTIF',
            'OK EMERGENCY',
            'KLINIK ANAK',
            'KLINIK BEDAH',
            'KLINIK BEDAH MULUT',
            'KLINIK BEDAH ONKOLOGI',
            'KLINIK KANDUNGAN',
            'KLINIK KULIT DAN KELAMIN',
            'KLINIK MATA',
            'KLINIK PARU',
            'KLINIK SORE PENYAKIT DALAM',
            'KLINIK THT',
            'ANGGREK',
            'ASTER',
            'BOUGENVIL',
            'DAHLIA',
            'EDELWEIS',
            'FLAMBOYAN',
            'ICU',
            'RR',
            'SAFIR',
            'SERUNI',
            'TERATAI',
            'TULIP',
        ];

        foreach ($units as $unit) {
            UnitAsal::updateOrCreate(
                ['nama' => $unit],
                ['nama' => $unit]
            );
        }
    }
}
