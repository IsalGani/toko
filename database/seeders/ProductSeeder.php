<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        Product::create([
            'name' => 'Contoh Produk',
            'description' => 'Produk contoh untuk testing',
            'category_id' => null,
            'stock' => 100,
            'price' => 15000,
        ]);
    }
}
