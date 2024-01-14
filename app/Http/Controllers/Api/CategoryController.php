<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Http\Resources\ResponseResource;
use App\Models\Category;
use App\Repositories\CategoryRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use App\Interfaces\CategoryRepositoryInterface;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;

class CategoryController extends Controller
{
    protected $categoryRepository;

    public function __construct(CategoryRepository $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = $this->categoryRepository->getAll();

        return new ResponseResource(true, 'Data berhasil diambil.', $categories);
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
    public function store(StoreCategoryRequest $request)
    {
        $icon = $request->icon;

        $category = $this->categoryRepository->create([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'icon' => $icon->hashName()
        ]);

        $icon->storeAs('public/categories/thumbnail', $icon->hashName());

        $message = $category ? 'Sukses membuat kategori baru.' : 'Gagal membuat kategori baru.';
        $status = $category ? true : false;

        return new ResponseResource($status, $message, $category);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $category = $this->categoryRepository->getById($id);

        if ($category) {
            //return success with Api Resource
            return new ResponseResource(true, 'Berhasil mengambil data kategori.', $category);
        }

        //return failed with Api Resource
        return new ResponseResource(false, 'Kategori tidak ditemukan.', null);
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
    public function update(UpdateCategoryRequest $request, string $id)
    {
        $category = $this->categoryRepository->getById($id);

        // Cek apakah ada file icon yang diupload
        if ($request->hasFile('icon')) {
            // Hapus icon lama dari storage jika ada
            if ($category->icon) {
                Storage::delete('public/categories/thumbnail/' . $category->icon);
            }

            // Simpan icon baru ke storage
            $icon = $request->file('icon');
            $iconPath = $icon->storeAs('public/categories/thumbnail', $icon->hashName());
        }

        $params =  [
            'name' => $request->name,
            'slug' => Str::slug($request->name, '-'),
            'icon' => $request->hasFile('icon') ? $icon->hashName() : $category->icon,
        ];

        // Update data kategori
        $update = $this->categoryRepository->update($id, $params);

        if ($update) {
            //return success with Api Resource
            return new ResponseResource(true, 'Berhasil memperbaharui data kategori.', $params);
        }

        //return failed with Api Resource
        return new ResponseResource(false, 'Gagal memperbaharui data kategori.', null);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $category = $this->categoryRepository->getById($id);

        if (!$category) {
            return new ResponseResource(false, 'Data Category tidak ditemukan!', null);
        }

        // Hapus icon
        Storage::delete('public/categories/thumbnail/' . $category->icon);
        // Gunakan metode delete untuk menghapus kategori
        $category->delete();

        // Return success dengan Api Resource
        return new ResponseResource(true, 'Data kategori berhasil dihapus.', null);

        // try {
        //     // Hapus icon
        //     Storage::delete('public/categories/thumbnail/' . $category->icon);
        //     // Gunakan metode delete untuk menghapus kategori
        //     $category->delete();

        //     // Return success dengan Api Resource
        //     return new ResponseResource(true, 'Data kategori berhasil dihapus.', null);
        // } catch (\Exception $e) {
        //     // Return failed dengan Api Resource dan pesan kesalahan
        //     return new ResponseResource(false, 'Terjadi kesalahan saat menghapus data: ' . $e->getMessage(), null);
        // }
    }
}
