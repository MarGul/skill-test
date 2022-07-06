<?php

namespace App\Actions;

use App\Models\Products;

class CreateProduct
{
    /**
     * Store a new products in storage.
     *
     * @param string $title
     * @param string $description
     * @return Products
     */
    public function execute(string $title, string $description, string $category, string $price, string $stock, object $request): Products
    {

        $products = new Products;
        $products->title = $title;
        $products->description = $description;
        $products->category = $category;
        $products->price = $price;
        $products->stock = $stock;
        if($request->file('image')) {
            $products->image = $this->upload($request);
        }
        $products->save();
        return $products;
    }

    private function upload($request)
    {
        $image = $request->file('image');
        $imageName = md5(uniqid()) . "." . $image->getClientOriginalExtension();
        $image->move(public_path('uploads'), $imageName);
        return $imageName;
    }
}