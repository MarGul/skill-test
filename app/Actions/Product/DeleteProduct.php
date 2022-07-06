<?php

namespace App\Actions\Product;

use App\Models\Product;
use Illuminate\Support\Facades\Storage;

class DeleteProduct
{
    public function execute(Product $product)
    {
        Storage::delete($product->image);
        $product->delete();
    }
}