<?php

namespace App\Actions;

use App\Models\Product;
use Illuminate\Http\UploadedFile;

class CreateProduct
{
    public function execute(string $title, string $description, UploadedFile $image, float $price, bool $inStock, $categories): Product
    {
        $product = Product::create([
            'title' => $title,
            'description' => $description,
            'image' => $image->store('products', 'public'),
            'price' => $price,
            'in_stock' => $inStock,
        ]);

        $product->categories()->attach($categories);

        return $product;
    }
}
