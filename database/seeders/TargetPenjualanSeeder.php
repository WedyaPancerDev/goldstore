<?php

namespace Database\Seeders;

use App\Models\TargetPenjualan;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TargetPenjualanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $transaksiPengeluarans = [
            [
                "user_id" => 4,
                "bulan" => "JAN",
                "total" => 0,
                "status" => "TIDAK TERPENUHI",
            ],
            [
                "user_id" => 4,
                "bulan" => "FEB",
                "total" => 0,
                "status" => "TIDAK TERPENUHI",
            ],
            [
                "user_id" => 4,
                "bulan" => "MAR",
                "total" => 0,
                "status" => "TIDAK TERPENUHI",
            ],
            [
                "user_id" => 4,
                "bulan" => "APR",
                "total" => 0,
                "status" => "TIDAK TERPENUHI",
            ],
            [
                "user_id" => 4,
                "bulan" => "MAY",
                "total" => 0,
                "status" => "TIDAK TERPENUHI",
            ],
            [
                "user_id" => 4,
                "bulan" => "JUN",
                "total" => 0,
                "status" => "TIDAK TERPENUHI",
            ],
            [
                "user_id" => 4,
                "bulan" => "JUL",
                "total" => 0,
                "status" => "TIDAK TERPENUHI",
            ],
            [
                "user_id" => 4,
                "bulan" => "AUG",
                "total" => 0,
                "status" => "TIDAK TERPENUHI",
            ],
            [
                "user_id" => 4,
                "bulan" => "SEP",
                "total" => 0,
                "status" => "TIDAK TERPENUHI",
            ],
            [
                "user_id" => 4,
                "bulan" => "OCT",
                "total" => 0,
                "status" => "TIDAK TERPENUHI",
            ],
            [
                "user_id" => 4,
                "bulan" => "NOV",
                "total" => 0,
                "status" => "TIDAK TERPENUHI",
            ],
            [
                "user_id" => 4,
                "bulan" => "DEC",
                "total" => 0,
                "status" => "TIDAK TERPENUHI",
            ],
        ];

        foreach ($transaksiPengeluarans as $transaksiPengeluaran) {
            TargetPenjualan::create($transaksiPengeluaran);
        }
    }
}
