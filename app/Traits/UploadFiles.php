<?php

namespace App\Traits;

use Illuminate\Support\Facades\Storage;

trait UploadFiles
{
    public function uploadFile($file, $path)
    {
        $uploadedFile = $file->store($path);
        return Storage::url($uploadedFile);
    }
}
