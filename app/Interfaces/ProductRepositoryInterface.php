<?php

namespace App\Interfaces;

interface ProductRepositoryInterface
{
    public function getAll();
    public function getById($id);
    public function getImageById($id);
    public function delete($id);
    public function create(array $params);
    public function createProductCategory($category_id, $product_id);
    public function createDetail($product_id, array $params);
    public function createImage($product_id, array $params);
    public function deleteImage($id);
    public function update($id, array $params);
    public function updateDetail($id, array $params);
}
