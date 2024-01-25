<?php

namespace App\Models;

use App\Traits\DeleteFiles;
use App\Traits\UploadFiles;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory, UploadFiles, DeleteFiles;

    protected $guarded = ['id'];

    public function uploadThumbnail($thumbnail)
    {
        return $this->uploadFile($thumbnail, 'public/products/thumbnail');
    }

    public function uploadImage($image)
    {
        return $this->uploadFile($image, 'public/products/image');
    }

    public function deleteThumbnail($thumbnail)
    {
        return $this->deleteFile('public/products/thumbnail/' . $thumbnail);
    }

    public function deleteImage($image)
    {
        return $this->deleteFile('public/products/image/' . $image);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function detail()
    {
        return $this->hasOne(ProductDetail::class);
    }

    public function images()
    {
        return $this->hasMany(ProductImage::class);
    }
}
