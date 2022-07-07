<?php

namespace App\Actions;

use App\Models\Product;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class UpdateProduct
{
    public function execute(Product $product, string $title, string $description, ?UploadedFile $image, float $price, bool $inStock, array $categoryIds): Product
    {
        $oldImage = $product->image;

        $product->categories()->sync($categoryIds);

        $product->update([
            'title' => $title,
            'description' => $description,
            'image' => $image ? $image->store('products', 'public') : $product->image,
            'price' => $price,
            'in_stock' => $inStock
        ]);

        if ($image) {
            Storage::disk('public')->delete($oldImage);
        }

        return $product;
    }
}
