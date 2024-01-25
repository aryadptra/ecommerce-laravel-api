<?php

namespace App\Repositories;

use App\Interfaces\CartRepositoryInterface;
use App\Models\Cart;

class CartRepository implements CartRepositoryInterface
{
    public function getAll()
    {
        return Cart::all();
    }
    public function getById($id)
    {
        return Cart::find($id);
    }
    public function delete($id)
    {
        return Cart::destroy($id);
    }
    public function create(array $params)
    {
        return Cart::create($params);
    }
    public function update($id, array $params)
    {
        return Cart::whereId($id)->update($params);
    }
}
