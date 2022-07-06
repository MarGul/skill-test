<?php

namespace App\Actions;

use App\Models\Products;

class DeleteProduct
{
    /**
     * Update the product.
     *
     * @param Products $product
     * @param string $title
     * @param string $description
     * @return Products
     */
    public function execute(string $product): Products
    {
        $product = Products::find($product)->delete();
        return $product;
    }
}