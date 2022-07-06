<?php

namespace App\Actions\Product;

use App\Models\Product;
use App\Services\StorageService;

class CreateProduct
{
    public function __construct(private StorageService $storageService)
    {}

    public function execute(
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
            'in_stock' => $inStock
        ];

        if ($image) {
            $data['image'] = $this->storageService->saveImage($image);
        }

        return Product::create($data);
    }
}