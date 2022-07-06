<?php

namespace App\Services;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class StorageService
{
    public function saveImage($file, $model = null, $removeExisted = false): ?string
    {
        if (isset($file)) {
            if ($removeExisted && $model) {
                Storage::delete($model->image);
            }

            $fileName = Str::random(30) . '.' . $file->getClientOriginalExtension();

            $file->storeAs("public/products/images/", $fileName);
            return "storage/products/images/" . $fileName;
        }
    }
}