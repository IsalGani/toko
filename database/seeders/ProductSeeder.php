<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Category;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $categoryIds = Category::pluck('id');

        for ($i = 1; $i <= 50; $i++) {
            Product::create([
                'name' => "Produk $i",
                'category_id' => $categoryIds->random(),
                'stock' => rand(10, 100),
                'price' => rand(1000, 50000),
                'discount' => rand(0, 10000),
                'description' => "Deskripsi produk ke-$i"
            ]);
        }
    }
}
