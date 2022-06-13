<?php

namespace App\Actions\Products;

use App\Models\Product;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class UpdateProduct
{
    public function execute(
        Product $product,
        string $title,
        string $description,
        ?UploadedFile $image,
        float $price,
        bool $in_stock,
        int $categoryId,
    ): Product {
        $oldImagePath = $product->image;

        $product->update([
            'title' => $title,
            'description' => $description,
            'image' => $image ? $image->store('products', 'public') : $product->image,
            'price' => $price,
            'in_stock' => $in_stock,
            'category_id' => $categoryId,
        ]);

        if ($image){
            Storage::disk('public')->delete($oldImagePath);
        }

        return $product;
    }
}
