<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Category>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        Storage::disk('public')->makeDirectory('products');

        return [
            'title' => $this->faker->words(3, true),
            'description' => $this->faker->text(),
            'image' => $this->faker->imageUrl(),
            'price' => random_int(10, 100),
            'in_stock' => $this->faker->boolean()
        ];
    }
}
