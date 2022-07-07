<?php

namespace App\Actions;

use App\Models\Product;
use Illuminate\Support\Facades\Storage;

class DeleteProduct
{
    public function execute(Product $product): ?bool
    {
        $product->categories()->detach();
        $image = $product->image;
        return tap($product->delete(), fn() => Storage::disk('public')->delete($image));
    }
}
