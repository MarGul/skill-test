<?php

namespace App\Actions\Product;

use App\Models\Product;
use App\Services\StorageService;

class UpdateProduct
{
    public function __construct(private StorageService $storageService)
    {}

    public function execute(
        Product $product,
        string $title,
        string $description,
        int $categoryId,
        float $price,
        int $inStock,
        $image): Product
    {
        $data = [
            'title' => $title,
            'description' => $description,
            'category_id' => $categoryId,
            'price' => $price,
            'in_stock' => $inStock,
        ];
        if (count($image)) {
            $data['image'] = $this->storageService->saveImage($image, $product, true);
        }

        $product->update($data);

        return $product;
    }
}