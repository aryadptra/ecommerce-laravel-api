<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Http\Requests\UploadImageProductRequest;
use App\Http\Resources\ResponseResource;
use App\Repositories\ProductRepository;
use Illuminate\Http\Request;

class ProductController extends Controller
{

    protected $productRepository;

    public function __construct(ProductRepository $productRepository)
    {
        $this->productRepository = $productRepository;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = $this->productRepository->getAll();

        return new ResponseResource(true, 'Data berhasil diambil.', $products);
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
    public function store(StoreProductRequest $request)
    {
        $thumbnail = $request->thumbnail;

        $product = $this->productRepository->create([
            'category_id' => $request->category_id,
            'name' => $request->name,
            'description' => $request->description,
            'thumbnail' => $thumbnail->hashName(),
            'price' => $request->price,
            'stock' => $request->stock
        ]);

        $product->uploadThumbnail($thumbnail);

        $this->productRepository->createDetail(
            $product->id,
            [
                'product_id' => $request->product_id,
                'size' => $request->size,
                'color' => $request->color,
                'weight' => $request->weight
            ]
        );

        $this->productRepository->createProductCategory($product->category_id, $product->id);

        $product = $this->productRepository->getById($product->id);

        return new ResponseResource(true, 'Data berhasil dibuat.', $product);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $product = $this->productRepository->getById($id);

        if ($product) {
            //return success with Api Resource
            return new ResponseResource(true, 'Berhasil mengambil data produk.', $product);
        }

        //return failed with Api Resource
        return new ResponseResource(false, 'Produk tidak ditemukan.', null);
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
    public function update(UpdateProductRequest $request, string $id)
    {
        $product = $this->productRepository->getById($id);
        $thumbnail = $request->thumbnail;

        // Cek apakah ada file thumbnail yang diupload
        if ($thumbnail) {
            // Hapus thumbnail lama dari storage jika ada
            if ($product->thumbnail) {
                $product->deleteThumbnail($product->thumbnail);
            }

            // Simpan thumbnail baru ke storage
            $product->uploadThumbnail($thumbnail);

            $thumbnailPath = $thumbnail->hashName();
        } else {
            // Jika tidak ada file thumbnail yang diupload, gunakan thumbnail yang sudah ada
            $thumbnailPath = $product->thumbnail;
        }

        $params = [
            'product' => [
                'category_id' => $request->category_id,
                'name' => $request->name,
                'description' => $request->description,
                'thumbnail' => $thumbnailPath,
                'price' => $request->price,
                'stock' => $request->stock,
                // tambahkan field lainnya sesuai kebutuhan
            ],
            'product_detail' => [
                'product_id' => $product->id,
                'size' => $request->size,
                'color' => $request->color,
                'weight' => $request->weight,
                // tambahkan field lainnya sesuai kebutuhan
            ],
            // tambahkan bagian ini jika ada update image
        ];

        // proses update
        $this->productRepository->update($product->id, $params['product']);
        $this->productRepository->updateDetail($product, $params['product_detail']);

        $product = $this->productRepository->getById($product->id);

        return new ResponseResource(true, 'Data Product berhasil diupdate.', $product);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $product = $this->productRepository->getById($id);

        if (!$product) {
            return new ResponseResource(false, 'Data produk tidak ditemukan!', null);
        }

        // Hapus icon
        $product->deleteThumbnail($product->thumbnail);

        // Return success dengan Api Resource
        return new ResponseResource(true, 'Data produk berhasil dihapus.', null);
    }

    /**
     * Upload image
     */
    public function upload_image(UploadImageProductRequest $request, string $id)
    {
        $product = $this->productRepository->getById($id);
        $image = $request->image;
        if ($image) {
            $product->uploadImage($image);
            $this->productRepository->createImage($id, $image->hashName());
            $message = "Upload gambar berhasil.";
        } else {
            $message = "Gagal mengupload gambar.";
        }

        $product = $this->productRepository->getById($id);

        return new ResponseResource(true, $message, $product);
    }

    /**
     * Delete image
     */
    public function delete_image($id_product, $id)
    {
        $product = $this->productRepository->getById($id_product);
        $image = $this->productRepository->getImageById($id);

        $product->deleteImage($image->image);

        $image->delete();

        $product = $this->productRepository->getById($id_product);

        return new ResponseResource(true, 'Berhasil menghapus gambar produk.', $product);
    }
}
