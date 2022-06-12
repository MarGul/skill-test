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

    public function store(Request $request): RedirectResponse
    {
        $attributes = $request->validate([
            "title" => ["required", "string", "max:255"],
            "description" => ["required", "string", "max:2000"],
            "image" => ["required", "image", "max:2000"],
            "price" => ["required", "numeric", "min:0.1"],
            "in_stock" => ["required", Rule::in(["yes", "no"])],
            "category" => ["required", Rule::exists("categories", "id")]
        ]);

        $product = app(CreateProduct::class)->execute(
            $attributes['title'],
            $attributes['description'],
            $attributes['image'],
            $attributes['price'],
            $attributes['in_stock'] === "yes" ? true : false,
            Category::find($attributes['category']),
        );

        return Redirect::route('products.edit', $product);
    }

    public function edit(Product $product)
    {
        return Inertia::render('Products/Edit', [
            'product' => $product,
            'categories' => Category::query()->pluck('title', 'id'),
        ]);
    }

    public function update(Request $request, Product $product)
    {
        $attributes = $request->validate([
            "title" => ["required", "string", "max:255"],
            "description" => ["required", "string", "max:2000"],
            "image" => ["sometimes", "nullable", "image", "max:2000"],
            "price" => ["required", "numeric", "min:0.1"],
            "in_stock" => ["required", Rule::in(["yes", "no"])],
            "category" => ["required", Rule::exists("categories", "id")]
        ]);

        $product = app(UpdateProduct::class)->execute(
            $product,
            $attributes['title'],
            $attributes['description'],
            $attributes['image'] ?? null,
            $attributes['price'],
            $attributes['in_stock'] === "yes" ? true : false,
            $attributes['category'],
        );

        return Redirect::back();
    }

    public function destroy(Product $product): RedirectResponse
    {
        app(DeleteProduct::class)->execute($product);

        return Redirect::route('products.index');
    }
}
