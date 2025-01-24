<?php

namespace Database\Seeders;

use App\Models\TransaksiPengeluaran;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TransaksiPengeluaranSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $transaksiPengeluarans = [
            [
                "nomor_order" => "INV-001",
                "order_date" => "2024-10-30",
                "produk_id" => 2,
                "user_id" => 4,
                "cabang_id" => 1,
                "quantity" => 8,
                "total_price" => 40000000,
                "deskripsi" => "produk telah terjual",
            ],
            [
                "nomor_order" => "INV-002",
                "order_date" => "2024-10-31",
                "produk_id" => 2,
                "user_id" => 4,
                "cabang_id" => 2,
                "quantity" => 8,
                "total_price" => 40000000,
                "deskripsi" => "produk telah terjual",
            ],
        ];

        foreach ($transaksiPengeluarans as $transaksiPengeluaran) {
            TransaksiPengeluaran::create($transaksiPengeluaran);
        }
    }
}
