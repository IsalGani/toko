<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            'Makanan',
            'Minuman',
            'Elektronik',
            'Pakaian',
            'Aksesoris',
            'Alat Tulis',
            'Kecantikan',
            'Olahraga',
            'Mainan',
            'Buku'
        ];

        foreach ($categories as $name) {
            Category::create(['nama_category' => $name]);
        }
    }
}
