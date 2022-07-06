<?php

namespace App\Actions;

use App\Models\Products;

class UpdateProduct
{
    /**
     * Update the product.
     *
     * @param Products $product
     * @param string $title
     * @param string $description
     * @return Products
     */
    public function execute(
        Products $product, 
        string $title, 
        string $description,
        string $category,
        string $price,
        string $stock,
        object $request
    ): Products {
        
        $product->update([
            'title' => $title,
            'description' => $description,
            'category' => $category,
            'price' => $price,
            'stock' => $stock
        ]);

        if($request->file('image')) {
            $product->update([
                'image' => $this->upload($request)
            ]);
        }

        return $product;
    }

    private function upload($request)
    {
        $image = $request->file('image');
        $imageName = md5(uniqid()) . "." . $image->getClientOriginalExtension();
        $image->move(public_path('uploads'), $imageName);
        return $imageName;
    }
}