<?php

namespace Database\Seeders;

use App\Models\MasterBonus;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MasterBonusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $masterBonuss = [
            [
                "nama" => "bonus pengeluaran",
                "total" => 3000000,
            ],
            [
                "nama" => "bonus pengeluaran hari ini",
                "total" => 4000000,
            ],
        ];

        foreach ($masterBonuss as $masterBonus) {
            MasterBonus::create($masterBonus);
        }
    }
}
