<?php

namespace App\Repositories;

use App\Interfaces\ProductRepositoryInterface;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\ProductDetail;
use App\Models\ProductImage;

class ProductRepository implements ProductRepositoryInterface
{
    public function getAll()
    {
        return Product::with('detail', 'images')->get();
    }

    public function getById($id)
    {
        return Product::with('detail', 'images')->find($id);
    }

    public function delete($id)
    {
        return Product::destroy($id);
    }

    public function create(array $params)
    {
        return Product::create($params);
    }

    public function createProductCategory($category_id, $product_id)
    {
        $productCategory = ProductCategory::create([
            'category_id' => $category_id,
            'product_id' => $product_id
        ]);

        return $productCategory;
    }

    public function createDetail($product_id, array $params)
    {
        $detail = ProductDetail::create(
            [
                'product_id' => $product_id,
                'size' => $params['size'],
                'color' => $params['color'],
                'weight' => $params['weight'],
            ]
        );

        return $detail;
    }

    public function getImageById($id)
    {
        $image = ProductImage::whereId($id)->first();

        return $image;
    }

    public function createImage($product_id, $image)
    {
        $image = ProductImage::create([
            'product_id' => $product_id,
            'image' => $image,
        ]);

        return $image;
    }

    public function deleteImage($id)
    {
        $image = ProductImage::delete($id);

        return $image;
    }

    public function update($id, array $params)
    {
        $image = ProductImage::find($id);

        if ($image) {
            $image->deleteImage($image->image);

            $image->delete();
        }

        return $image;
    }

    public function updateDetail($product, $params)
    {
        $detail = ProductDetail::whereId($product->id)->update($params);

        return $detail;
    }
}
