<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ProductControllerTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_can_create_product()
    {
        $category = Category::create(['title' => 'Test Category', 'description' => 'Test']);
        $data = [
            'title' => 'Test Product Title',
            'description' => 'Test Product Description',
            'categoryId' => $category->id,
            'price' => 1000,
            'inStock' => 0,
            'image' => UploadedFile::fake()->image('product.jpg')
        ];

        $response = $this->post(route('products.store'), $data);

        $response->assertRedirect(route('products.index'));

        $this->assertDatabaseHas('products', [
            'title' => $data['title'],
            'description' => $data['description'],
            'category_id' => $data['categoryId'],
            'price' => $data['price'],
            'in_stock' => $data['inStock']
        ]);

        $product = Product::first();

        $this->assertTrue(Storage::exists($product->image), 'Image not created');

        Storage::delete($product->image);
        $this->assertFalse(Storage::exists($product->image), 'New image not deleted');
    }

    public function test_can_update_product()
    {
        Category::factory()->create();
        $product = Product::factory()->create();

        $updateData = [
            'title' => $this->faker->sentence(3),
            'description' => $this->faker->sentence(8),
            'categoryId' => Category::first()->id,
            'price' => $this->faker->numberBetween(0, 100000),
            'image' => UploadedFile::fake()->image('product.jpg')
        ];

        $this->assertTrue(Storage::exists($product->image), 'Image not created');

        $this->assertDatabaseCount('products', 1);

        $response = $this->post(route('products.update', ['product' => $product->id]), $updateData);

        $this->assertDatabaseCount('products', 1);

        $response->assertRedirect(route('products.index'));

        $this->assertFalse(Storage::exists($product->image), 'Image not deleted');

        $this->assertDatabaseHas('products', [
            'title' => $updateData['title'],
            'description' => $updateData['description'],
            'price' => $updateData['price'],
            'category_id' => $updateData['categoryId']
        ]);

        $product = Product::first();
        Storage::delete($product->image);
        $this->assertFalse(Storage::exists($product->image), 'New image not deleted');
    }

    public function test_can_delete_product()
    {
        Category::factory()->create();
        $product = Product::factory()->create();

        $this->assertDatabaseCount('products', 1);

        $response = $this->delete(route('products.delete', $product));

        $this->assertDatabaseCount('products', 0);

        $this->assertFalse(Storage::exists($product->image), 'Image not deleted');

        $response->assertRedirect(route('products.index'));
    }
}
