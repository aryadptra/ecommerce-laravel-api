<?php

namespace App\Repositories;

use App\Interfaces\CategoryRepositoryInterface;
use App\Models\Category;

class CategoryRepository implements CategoryRepositoryInterface
{
    public function getAll()
    {
        return Category::all();
    }
    public function getById($id)
    {
        return Category::find($id);
    }
    public function delete($id)
    {
        Category::destroy($id);
    }
    public function create(array $params)
    {
        return Category::create($params);
    }
    public function update($id, array $params)
    {
        return Category::whereId($id)->update($params);
    }
}
