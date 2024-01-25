<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\ProductDetail;
use App\Models\ProductImage;
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
            'category_id' => '1',
            'name' => 'Sepatu Running',
            'description' => 'Sepatu untuk olahraga running terbaik yang pernah ada',
            'thumbnail' => 'thumbnail-photo.png',
            'price' => 350000,
            'stock' => 20
        ]);

        ProductDetail::create([
            'product_id' => 1,
            'color' => 'Black',
            'size' => '43',
            'weight' => '100'
        ]);

        ProductCategory::create([
            'product_id' => 1,
            'category_id' => 1
        ]);

        ProductImage::create([
            'product_id' => 1,
            'image' => '1.jpg',
        ]);
    }
}
