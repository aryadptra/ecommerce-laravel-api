<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCartRequest;
use App\Http\Resources\ResponseResource;
use App\Repositories\CartRepository;
use Illuminate\Http\Request;

class CartController extends Controller
{

    protected $cartRepository;

    public function __construct(CartRepository $cartRepository)
    {
        $this->cartRepository = $cartRepository;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $carts = $this->cartRepository->getAll();

        return new ResponseResource(true, 'Data berhasil diambil.', $carts);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCartRequest $request)
    {
        $cart = $this->cartRepository->create([
            'product_id' => $request->product_id,
            'user_id' => auth()->guard('api')->user()->id,
            'quantity' => $request->quantity
        ]);

        return new ResponseResource(true, 'Berhasil menambahkan ke keranjang.', $cart);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $cart = $this->cartRepository->getById($id);

        return new ResponseResource(true, 'Berhasil mengambil data keranjang.', $cart);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $cart = $this->cartRepository->getById($id);

        $cart->update($id, [
            'product_id' => $request->product_id,
            'quantity' => $request->quantity
        ]);

        return new ResponseResource(true, 'Berhasil mengupdate data keranjang.', $cart);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $cart = $this->cartRepository->delete($id);

        return new ResponseResource(true, 'Berhasil menghapus data keranjang.', $cart);
    }
}
