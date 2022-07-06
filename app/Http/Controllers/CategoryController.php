<?php

namespace App\Http\Controllers;

use App\Actions\CreateCategory;
use App\Actions\UpdateCategory;
use App\Models\Category;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use Inertia\Response;

class CategoryController extends Controller
{
    /**
     * Show all the categories.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request): Response
    {
        return Inertia::render('Categories/Index', [
            'categories' => Category::all()
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
        return Inertia::render('Categories/Create');
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
            'description' => ['required']
        ]);

        $category = app(CreateCategory::class)->execute($request->title, $request->description);

        return Redirect::route('categories.edit', $category, 303)->with('success', 'Category created');
    }

    /**
     * Show the edit category view.
     *
     * @param Request $request
     * @param Category $category
     * @return Response
     */
    public function edit(Request $request, Category $category): Response
    {
        return Inertia::render('Categories/Edit', [
            'category' => $category
        ]);
    }

    /**
     * Update the category.
     *
     * @param Request $request
     * @param Category $category
     * @return RedirectResponse
     */
    public function update(Request $request, Category $category): RedirectResponse
    {
        // If we had any authorization, it would be here.

        $request->validate([
            'title' => ['required'],
            'description' => ['required']
        ]);

        $category = app(UpdateCategory::class)->execute($category, $request->title, $request->description);

        return Redirect::back(303)->with('warning', 'Category updated');
    }
}
