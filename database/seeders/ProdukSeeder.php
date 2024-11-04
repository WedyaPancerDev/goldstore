<?php

namespace Database\Seeders;

use App\Models\Produk;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProdukSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $products = [
            [
                "nama" => "UBS gold",
                "kode_produk" => "PRD0001",
                "satuan" => "gr",
                "harga_beli" => 2000000,
                "harga_jual" => 4000000,
                "deskripsi" => "terjual UBS Gold",
                "foto" => "http://127.0.0.1:8120/storage/photos/product/1729826971cincin.jpg",
                "stok" => 299,
                "created_by" => 1,
                "kategori_id" => 4,
            ],
            [
                "nama" => "Ring gold ",
                "kode_produk" => "PRD0002",
                "satuan" => "gr",
                "harga_beli" => 3000000,
                "harga_jual" => 5000000,
                "deskripsi" => "terjual UBS Gold",
                "foto" => "http://127.0.0.1:8120/storage/photos/product/1729826971cincin.jpg",
                "stok" => 200,
                "created_by" => 1,
                "kategori_id" => 4,
            ],
        ];

        foreach ($products as $product) {
            Produk::create($product);
        }
    }
}
