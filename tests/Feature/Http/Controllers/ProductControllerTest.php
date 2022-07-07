<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Category;
use Tests\TestCase;
use App\Models\Product;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProductControllerTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function test_products_can_be_listed()
    {
        $this->get(route('products.index'))->assertOk();
    }

    public function test_product_create_page_can_be_visited()
    {
        $this->get(route('products.create'))->assertOk();
    }

    public function test_product_can_be_created()
    {
        Storage::fake();

        $product = Product::factory()->make();
        $category = Category::factory()->create();

        $payload = [
            'title' => $product->title,
            'description' => $product->description,
            'image' => UploadedFile::fake()->image('image.jpeg'),
            'price' => $product->price,
            'in_stock' => $product->in_stock,
            'category' => [$category->id]
        ];

        $this->assertDatabaseCount('products', 0);

        $response = $this->post(route('products.store'), $payload);

        $this->assertDatabaseCount('products', 1);

        // Defaults to the ID: 1.
        $response->assertRedirect(route('products.edit', 1));

        $this->assertDatabaseCount('products', 1);
        $this->assertDatabaseHas('products', [
            'title' => $product->title,
            'description' => $product->description,
            'price' => $product->price,
            'in_stock' => $product->in_stock,
        ]);
        $this->assertFileExists(Storage::disk('public')->path(Product::first()->image));
    }

    public function test_product_edit_page_can_be_visited()
    {
        $product = product::factory()->create();

        $this->get(route('products.edit', $product->id))->assertOk();

        $this->get(route('products.edit', 100))->assertNotFound();
    }

    public function test_product_can_be_updated()
    {
        Storage::fake();

        $product = Product::factory()->create();
        $updatedProduct = Product::factory()->make();
        $category = Category::factory()->create();

        $payload = [
            'title' => $updatedProduct->title,
            'description' => $updatedProduct->description,
            'image' => UploadedFile::fake()->image('image.jpeg'),
            'price' => $updatedProduct->price,
            'in_stock' => $updatedProduct->in_stock,
            'categoriesIds' => [$category->id],
        ];

        $this->assertDatabaseCount('products', 1);

        $response = $this->patch(route('products.update', $product), $payload, [
            'HTTP_REFERER' => route('products.edit', $product)
        ]);

        $this->assertDatabaseCount('products', 1);

        $response->assertRedirect(route('products.edit', $product));

        $this->assertDatabaseHas('products',  [
            'title' => $updatedProduct->title,
            'description' => $updatedProduct->description,
            'price' => $updatedProduct->price,
            'in_stock' => $updatedProduct->in_stock,
        ]);
        $this->assertDatabaseCount('products', 1);

        $this->assertFileExists(Storage::disk('public')->path(Product::first()->image));
    }

    public function test_old_image_will_be_used_if_image_is_not_supplied_while_updating()
    {
        Storage::fake();

        $product = Product::factory()->create();
        $updatedProduct = Product::factory()->make();

        $this->patch(route('products.update', $product->id), [
            'title' => $updatedProduct->title,
            'description' => $updatedProduct->description,
            'price' => $updatedProduct->price,
            'in_stock' => $updatedProduct->in_stock,
        ]);

        $this->assertSame($product->image, $product->refresh()->image);
    }

    public function test_old_image_will_be_deleted_if_image_is_supplied_while_updating()
    {
        Storage::fake();

        $product = Product::factory()->create([
            'image' => UploadedFile::fake()->create('image.jpeg')->store('products', 'public')
        ]);
        $updatedProduct = Product::factory()->make();

        $this->patch(route('products.update', $product->id), [
            'title' => $updatedProduct->title,
            'description' => $updatedProduct->description,
            'image' => UploadedFile::fake()->create('image.jpeg'),
            'price' => $updatedProduct->price,
            'in_stock' => $updatedProduct->in_stock,
        ]);

        $this->assertFileDoesNotExist($product->image);
        $this->assertFileExists(Storage::disk('public')->path($product->refresh()->image));
    }

    public function test_product_can_be_deleted()
    {
        Storage::fake();

        $product = Product::factory()->create();

        $this->delete(route('products.destroy', $product->id))
            ->assertRedirect(route('products.index'));

        $this->assertDatabaseCount('products', 0);
        $this->assertFileDoesNotExist(Storage::disk('public')->path($product->image));

        $this->delete(route('products.destroy', 100))
            ->assertNotFound();
    }
}
