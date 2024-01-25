<?php

namespace App\Models;

use App\Traits\DeleteFiles;
use App\Traits\UploadFiles;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory, UploadFiles, DeleteFiles;

    protected $guarded = ['id'];

    public function uploadIcon($icon)
    {
        return $this->uploadFile($icon, 'public/categories/icon');
    }

    public function deleteIcon($icon)
    {
        return $this->deleteFile('public/categories/icon/' . $icon);
    }

    // Definisikan mutator untuk atribut created_at
    public function getCreatedAtAttribute($value)
    {
        // Ubah format atribut created_at menggunakan Carbon
        return Carbon::parse($value)->format('Y-m-d H:i:s');
    }

    // Definisikan mutator untuk atribut created_at
    public function getUpdateddAtAttribute($value)
    {
        // Ubah format atribut created_at menggunakan Carbon
        return Carbon::parse($value)->format('Y-m-d H:i:s');
    }
}
