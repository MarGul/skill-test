<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Products;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Http\UploadedFile;

class ProductControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_that_you_can_create_a_product(): void
    {
        $payload = [
            'title' => 'This is a test title',
            'description' => 'This is a test description',
            'category' => 1,
            'price' => 120,
            'stock' => 1,
            'image' => UploadedFile::fake()->image('avatar.jpg')
        ];

        
        $this->assertDatabaseCount('products', 0);
        $response = $this->post(route('products.store'), $payload);

        $this->assertDatabaseCount('products', 1);

        // Defaults to the ID: 1.
        $response->assertRedirect(route('products.edit', 1));

        $this->assertDatabaseHas('products', [
            'title' => $payload['title'],
            'description' => $payload['description'],
            'category' => $payload['category'],
            'price' => $payload['price'],
            'stock' => $payload['stock'],
        ]);
    }

    public function test_that_you_can_update_a_product(): void
    {
        $product = Products::factory()->create();

        $payload = [
            'title' => 'Title Updated',
            'description' => 'Description Updated',
            'category' => 2,
            'price' => 125,
            'stock' => 0,
            'image' => UploadedFile::fake()->image('avatar.jpg')
        ];

        $this->assertDatabaseCount('products', 1);

        $response = $this->patch(route('products.update', $product), $payload, [
            'HTTP_REFERER' => route('products.edit', $product)
        ]);

        $this->assertDatabaseCount('products', 1);

        $this->assertDatabaseHas('products', [
            'title' => $product['title'],
            'description' => $product['description'],
            'category' => $product['category'],
            'price' => $product['price'],
            'stock' => $product['stock']
        ]);
    }

    public function test_that_you_can_delete_a_product(): void
    {
        $product = Products::factory()->create();

        $payload = [
            'title' => 'Title Updated',
            'description' => 'Description Updated',
            'category' => 2,
            'price' => 125,
            'stock' => 0,
            'image' => UploadedFile::fake()->image('avatar.jpg')
        ];

        $this->assertDatabaseCount('products', 1);

        $response = $this->post(route('products.destroy', $product), $payload, [
            'HTTP_REFERER' => route('products.index')
        ]);

        $this->assertDatabaseCount('products', 0);
    }
}
