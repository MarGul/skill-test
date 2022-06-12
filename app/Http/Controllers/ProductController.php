<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use Inertia\Response;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Http\RedirectResponse;
use App\Actions\Products\CreateProduct;
use App\Actions\Products\DeleteProduct;
use App\Actions\Products\UpdateProduct;
use App\Http\Requests\ProductRequest;
use Illuminate\Support\Facades\Redirect;

class ProductController extends Controller
{
    public function index(): Response
    {
        return Inertia::render('Products/Index', [
            'products' => Product::all(),
        ]);
    }

    public function create(): Response
    {
        return Inertia::render('Products/Create', [
            'categories' => Category::query()->pluck('title', 'id'),
        ]);
    }

    public function store(ProductRequest $request): RedirectResponse
    {
        $attributes = $request->validated();

        $product = app(CreateProduct::class)->execute(
            $attributes['title'],
            $attributes['description'],
            $attributes['image'],
            $attributes['price'],
            $attributes['in_stock'] === "yes" ? true : false,
            Category::find($attributes['category']),
        );

        return Redirect::route('products.edit', $product)
            ->with('success', 'Product created successfully');
    }

    public function edit(Product $product)
    {
        return Inertia::render('Products/Edit', [
            'product' => $product,
            'categories' => Category::query()->pluck('title', 'id'),
        ]);
    }

    public function update(ProductRequest $request, Product $product)
    {
        $attributes = $request->validated();

        $product = app(UpdateProduct::class)->execute(
            $product,
            $attributes['title'] ?? $product->title,
            $attributes['description'] ?? $product->description,
            $attributes['image'] ?? null,
            $attributes['price'] ?? $product->price,
            $attributes['in_stock'] === "yes" ? true : false,
            $attributes['category'] ?? $product->category_id,
        );

        return Redirect::back()
            ->with('success', 'Product updated successfully');
    }

    public function destroy(Product $product): RedirectResponse
    {
        app(DeleteProduct::class)->execute($product);

        return Redirect::route('products.index')
            ->with('success', 'Product deleted successfully');
    }
}
