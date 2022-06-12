<?php

namespace App\Actions\Products;

use App\Models\Product;
use Illuminate\Support\Facades\Storage;

class DeleteProduct
{
    public function execute(
        Product $product,
    ): ?bool {
        $imagePath = $product->image;

        return tap($product->delete(), fn () => Storage::disk('public')->delete($imagePath));
    }
}
