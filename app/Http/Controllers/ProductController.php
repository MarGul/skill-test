<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use Inertia\Response;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Http\RedirectResponse;
use App\Actions\CreateProduct;
use App\Actions\DeleteProduct;
use App\Actions\UpdateProduct;
use Illuminate\Support\Facades\Redirect;

class ProductController extends Controller
{
    /**
     * Show all the products.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request): Response
    {
        return Inertia::render('Products/Index', [
            'products' => Product::all(),
        ]);
    }

    /**
     * Show the create product view.
     *
     * @param Request $request
     * @return Response
     */
    public function create(Request $request): Response
    {
        return Inertia::render('Products/Create', [
            'categories' => Category::query()->pluck('title', 'id')
        ]);
    }

    /**
     * Store a new product.
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function store(Request $request): RedirectResponse
    {
        // If we had any authorization, it would be here.

        $attributes = $request->validate([
            "title" => ["required", "string", "max:255"],
            "description" => ["required", "string", "max:2000"],
            "image" => ["required", "image"],
            "price" => ["required", "numeric", "min:0.1"],
            "in_stock" => ["required"],
            "category" => ["required", Rule::exists("categories", "id")]
        ]);

        $product = app(CreateProduct::class)->execute(
            $attributes['title'],
            $attributes['description'],
            $attributes['image'],
            $attributes['price'],
            $attributes['in_stock'],
            Category::find($attributes['category']),
        );

        return Redirect::route('products.edit', $product, 303)->with('success', 'Product created successfully!');
    }

    /**
     * Show the edit product view.
     *
     * @param Request $request
     * @param Product $product
     * @return Response
     */
    public function edit(Request $request, Product $product): Response
    {
        return Inertia::render('Products/Edit', [
            'product' => $product,
            'categories' => Category::query()->pluck('title', 'id'),
        ]);
    }

    /**
     * Update the product.
     *
     * @param Request $request
     * @param Product $product
     * @return RedirectResponse
     */
    public function update(Request $request, Product $product)
    {
        // If we had any authorization, it would be here.

        $attributes = $request->validate([
            "title" => ["required", "string", "max:255"],
            "description" => ["required", "string", "max:2000"],
            "image" => ["sometimes", "nullable", "image"],
            "price" => ["required", "numeric", "min:0.1"],
            "in_stock" => ["required"],
            "category" => ["required", Rule::exists("categories", "id")]
        ]);

        $product = app(UpdateProduct::class)->execute(
            $product,
            $attributes['title'],
            $attributes['description'],
            $attributes['image'] ?? null,
            $attributes['price'],
            $attributes['in_stock'],
            $attributes['category']
        );

        return Redirect::back()->with('success', 'Product updated successfully!');
    }

    /**
     * Destroy the product
     *
     * @param Product $product
     * @return RedirectResponse
     */
    public function destroy(Product $product): RedirectResponse
    {
        app(DeleteProduct::class)->execute($product);

        return Redirect::route('products.index', [], 303)->with('success', 'Product deleted successfully!');
    }
}
