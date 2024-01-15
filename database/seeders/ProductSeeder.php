<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\ProductCategory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Product::create([
            'name' => 'Sepatu Running',
            'description' => 'Sepatu untuk olahraga running terbaik yang pernah ada',
            'thumbnail' => 'thumbnail-photo.png',
            'price' => 350000,
        ]);

        ProductCategory::create([
            'product_id' => 1,
            'category_id' => 1
        ]);
    }
}
