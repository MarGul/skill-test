<?php

namespace App\Actions\Products;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\UploadedFile;

class CreateProduct
{
    public function execute(
        string $title,
        string $description,
        UploadedFile $image,
        float $price,
        bool $in_stock,
        Category $category,
    ): Product {
        $product = $category->products()->create([
            'title' => $title,
            'description' => $description,
            'image' => $image->store('products', 'public'),
            'price' => $price,
            'in_stock' => $in_stock,
        ]);

        return $product;
    }
}
