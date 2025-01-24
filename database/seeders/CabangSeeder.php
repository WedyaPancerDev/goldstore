<?php

namespace Database\Seeders;

use App\Models\Cabang;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class CabangSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $cabangs = [
            [
                "nama_cabang" => "Denpasar"
            ],
            [
                "nama_cabang" => "Tabanan"
            ],
            [
                "nama_cabang" => "Gianyar"
            ]
        ];

        foreach ($cabangs as $cabang) {
            Cabang::create($cabang);
        }
    }
}
