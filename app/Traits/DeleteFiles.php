<?php

namespace App\Traits;

use Illuminate\Support\Facades\Storage;

trait DeleteFiles
{
    public function deleteFile($path)
    {
        if (Storage::exists($path)) {
            Storage::delete($path);
        }
    }
}
