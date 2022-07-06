<?php

namespace App\Http\Controllers;

use App\Actions\Product\CreateProduct;
use App\Actions\Product\DeleteProduct;
use App\Actions\Product\UpdateProduct;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Inertia\Inertia;
use Inertia\Response;

class ProductController extends Controller
{
    public function index(Request $request): Response
    {
        return Inertia::render('Products/Index', [
            'products' => Product::with('category')->get()
        ]);
    }

    public function create(Request $request): Response
    {
        return Inertia::render('Products/Create', [
            'categories' => Category::all()->pluck('title', 'id')
        ]);
    }

    public function edit(Request $request, Product $product): Response
    {
        return Inertia::render('Products/Edit', [
            'product' => $product,
            'categories' => Category::all()->pluck('title', 'id')
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'title' => ['required'],
            'description' => ['required'],
            'price' => ['required'],
            'inStock' => ['required'],
            'categoryId' => ['required']
        ]);

        app(CreateProduct::class)->execute(
            $request->title,
            $request->description,
            $request->categoryId,
            $request->price,
            $request->inStock,
            $request->allFiles()
        );

        return Redirect::route('products.index', [], 303)->with('success', 'Product created');
    }

    public function update(Request $request, Product $product)
    {
        $request->validate([
            'title' => ['required'],
            'description' => ['required'],
            'price' => ['required'],
            'categoryId' => ['required']
        ]);

        app(UpdateProduct::class)->execute(
            $product,
            $request->title,
            $request->description,
            $request->categoryId,
            $request->price,
            !!$request->inStock,
            $request->allFiles()
        );

        return Redirect::route('products.index', [], 303)->with('warning', 'Product updated');
    }


    public function delete(Request $request, Product $product)
    {
        app(DeleteProduct::class)->execute($product);
        return Redirect::route('products.index', [], 303)->with('error', 'Product deleted');
    }
}
