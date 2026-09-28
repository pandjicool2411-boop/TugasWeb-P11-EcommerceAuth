<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ProductFactory extends Factory
{
    public function definition(): array
    {
        $name = ucwords($this->faker->words(3, true));

        return [
            'category_id' => Category::factory(),
            'name' => $name,
            'slug' => Str::slug($name) . '-' . $this->faker->unique()->numberBetween(1000, 99999),
            'description' => $this->faker->paragraph(),
            'price' => $this->faker->numberBetween(20, 5000) * 1000,
            'stock' => $this->faker->numberBetween(0, 100),
            'is_active' => $this->faker->boolean(90),
        ];
    }
}