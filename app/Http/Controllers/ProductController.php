<?php

namespace App\Http\Controllers;

use App\Actions\CreateProduct;
use App\Actions\UpdateProduct;
use App\Models\Category;
use App\Models\Products;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use Inertia\Response;

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
            'products' => Products::all(),
            'category' => Category::all()
        ]);
    }

    /**
     * Show the create category view.
     *
     * @param Request $request
     * @return Response
     */
    public function create(Request $request): Response
    {
        $category = Category::all();
        return Inertia::render('Products/Create', [
            'category' => $category
        ]);
    }

    /**
     * Store a new category.
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function store(Request $request): RedirectResponse
    {
        // If we had any authorization, it would be here.
        $request->validate([
            'title' => ['required'],
            'description' => ['required'],
            'category' => ['required'],
            'price' => ['required'],
            'stock' => ['required'],
            'image' => ['required']
        ]);

        $product = app(CreateProduct::class)->execute(
            $request->title,
            $request->description,
            (int)$request->category,
            $request->price,
            $request->stock,
            $request
        );

        return Redirect::route('products.edit', $product)->with('success', 'Product created successfully!');
    }

    /**
     * Show the edit products view.
     *
     * @param Request $request
     * @param Products $products
     * @return Response
     */
    public function edit(Request $request, $product): Response
    {
        return Inertia::render('Products/Edit', [
            'product' => Products::find($product),
            'category' => Category::all()
        ]);
    }

    /**
     * Update the product.
     *
     * @param Request $request
     * @param Products $product
     * @return RedirectResponse
     */
    public function update(Request $request, Products $product): RedirectResponse
    {
        // If we had any authorization, it would be here.
        $request->validate([
            'title' => ['required'],
            'description' => ['required'],
            'category' => ['required'],
            'price' => ['required'],
            'stock' => ['required'],
        ]);


        $product = app(UpdateProduct::class)->execute($product,
            $request->title,
            $request->description,
            (int)$request->category,
            $request->price,
            $request->stock,
            $request
        );

        return Redirect::back()->with('success', 'Product updated successfully!');
    }

    public function destroy(Request $request, $product)
    {
        $product = Products::find($product)->delete();
        return Redirect::route('products.index')->with('success', 'Product deleted successfully!');;
    }
}
