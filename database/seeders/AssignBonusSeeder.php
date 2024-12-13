<?php

namespace Database\Seeders;

use App\Models\AssignBonus;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AssignBonusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $assignBonuses = [
            [
                "transaksi_pengeluaran_id" => 1,
                "user_id" => 4,
                "bonus_id" => 1,
            ],

        ];

        foreach ($assignBonuses as $assignBonus) {
            AssignBonus::create($assignBonus);
        }
    }
}
