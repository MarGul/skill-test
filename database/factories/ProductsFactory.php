<?php

namespace Database\Factories;
use Illuminate\Http\UploadedFile;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Category>
 */
class ProductsFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'title' => $this->faker->sentence(3),
            'description' => $this->faker->sentence(10),
            'category' => $this->faker->randomDigit(),
            'price' => $this->faker->numberBetween(0, 100),
            'stock' => $this->faker->numberBetween(0, 1),
            'image' => UploadedFile::fake()->image('avatar.jpg')
        ];
    }
}
