<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CategoryControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_that_you_can_create_a_category(): void
    {
        $payload = [
            'title' => 'This is a test title',
            'description' => 'This is a test description'
        ];

        $this->assertDatabaseCount('categories', 0);

        $response = $this->post(route('categories.store'), $payload);

        $this->assertDatabaseCount('categories', 1);

        // Defaults to the ID: 1.
        $response->assertRedirect(route('categories.index'));

        $this->assertDatabaseHas('categories', [
            'title' => $payload['title'],
            'description' => $payload['description']
        ]);
    }

    public function test_that_you_can_update_a_category(): void
    {
        $category = Category::factory()->create();

        $payload = [
            'title' => 'Title Updated',
            'description' => 'Description Updated'
        ];

        $this->assertDatabaseCount('categories', 1);

        $response = $this->patch(route('categories.update', $category), $payload, [
            'HTTP_REFERER' => route('categories.edit', $category)
        ]);

        $this->assertDatabaseCount('categories', 1);

        $response->assertRedirect(route('categories.index'));

        $this->assertDatabaseHas('categories', [
            'title' => $payload['title'],
            'description' => $payload['description']
        ]);
    }
}
