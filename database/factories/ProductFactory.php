<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
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
        return [
            'title' => $this->faker->sentence(3),
            'description' => $this->faker->sentence(10),
            'in_stock' => $this->faker->numberBetween(0, 1),
            'price' => $this->faker->numberBetween(0, 10000),
            'category_id' => Category::first()->id,
            'image' => $this->createFile()
        ];
    }

    private function createFile(): string
    {
        $file = UploadedFile::fake()->image('product.jpg');
        $fileName = Str::random(30) . '.' . $file->getClientOriginalExtension();
        $file->storeAs("images/products", $fileName);
        return "images/products/" . $fileName;
    }
}
