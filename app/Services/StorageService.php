<?php

namespace App\Services;

use Illuminate\Support\Facades\Storage;

class StorageService
{
    public function saveImage($file, $model, $isDeleted = false): string
    {
        if (isset($file['image'])) {
            if ($isDeleted && $model->image) {
                Storage::delete($model->image);
            }

            $file['image']->storeAs("public/products/{$model->id}/image/", $file['image']
                ->getClientOriginalName());
            return "storage/products/{$model->id}/image/" . $file['image']
                    ->getClientOriginalName();
        }
    }
}