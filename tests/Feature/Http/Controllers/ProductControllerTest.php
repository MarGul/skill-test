<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Product;
use Tests\TestCase;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;

class ProductControllerTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function test_products_can_be_listed()
    {
        $this->get(route('products.index'))
            ->assertOk();
    }

    public function test_product_create_page_can_be_visited()
    {
        $this->get(route('products.create'))
            ->assertOk();
    }

    public function test_product_can_be_created()
    {
        Storage::fake();

        $product = Product::factory()->make();

        $this->post(route('products.store'), [
            'title' =>  $product->title,
            'description' =>  $product->description,
            'image' =>  UploadedFile::fake()->image('test_image.jpeg'),
            'price' =>  $product->price,
            'in_stock' =>  $product->in_stock ? "yes" : "no",
            'category' =>  $product->category->id,
        ])
            ->assertRedirect(route("products.update", Product::first()->id));

        $this->assertDatabaseCount('products', 1);
        $this->assertDatabaseHas('products', [
            'title' =>  $product->title,
            'description' =>  $product->description,
            'price' =>  $product->price,
            'category_id' =>  $product->category->id,
            'in_stock' => $product->in_stock,
        ]);
        $this->assertFileExists(Storage::disk('public')->path(Product::first()->image));
    }

    public function test_product_edit_page_can_be_visited()
    {
        $product = product::factory()->create();

        $this->get(route('products.edit', $product->id))
            ->assertOk();

        $this->get(route('products.edit', 100))
            ->assertNotFound();
    }

    public function test_product_can_be_updated()
    {
        Storage::fake();

        $product = Product::factory()->create();
        $updatedProduct = Product::factory()->make();

        $this->from(route("products.edit", $product->id))
            ->patch(route('products.update', $product->id), [
                'title' =>  $updatedProduct->title,
                'description' =>  $updatedProduct->description,
                'image' =>  UploadedFile::fake()->image('test_image.jpeg'),
                'price' =>  $updatedProduct->price,
                'in_stock' =>  $updatedProduct->in_stock ? "yes" : "no",
                'category' =>  $updatedProduct->category->id,
            ])
            ->assertRedirect(route("products.edit", $product->id));

        $this->assertDatabaseCount('products', 1);
        $this->assertDatabaseHas('products', [
            'title' =>  $updatedProduct->title,
            'description' =>  $updatedProduct->description,
            'price' =>  $updatedProduct->price,
            'category_id' =>  $updatedProduct->category->id,
            'in_stock' => $updatedProduct->in_stock,
        ]);
        $this->assertFileExists(Storage::disk('public')->path(Product::first()->image));
    }

    public function test_old_image_will_be_used_if_image_is_not_supplied_while_updating()
    {
        Storage::fake();

        $product = Product::factory()->create();

        $this->patch(route('products.update', $product->id), [
            'title' => 'updated title',
        ]);

        $this->assertSame($product->image, $product->refresh()->image);
    }

    public function test_old_image_will_be_deleted_if_image_is_supplied_while_updating()
    {
        Storage::fake();

        $product = Product::factory()->create([
            'image' => UploadedFile::fake()->create('test_image.jpeg')->store('products', 'public')
        ]);

        $this->patch(route('products.update', $product->id), [
            'image' => UploadedFile::fake()->create('test_image.jpeg'),
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
