<?php

namespace Database\Seeders;

use App\Models\Kategori;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                "nama" => "Necklace"
            ],
            [
                "nama" => "Bracelet"
            ],
            [
                "nama" => "Earing"
            ],
            [
                "nama" => "Ring"
            ],
        ];

        foreach($categories as $category){
            Kategori::create($category);
        }
    }
}
