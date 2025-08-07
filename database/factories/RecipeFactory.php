<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class RecipeFactory extends Factory
{
    public function definition(): array
    {
        return [
            'title' => $this->faker->sentence(3),
            'description' => $this->faker->paragraph(4),
            'image_path' => 'recipes/sample.jpg',
            'user_id' => 1, // 固定使用自動建立的帳號
        ];
    }
}
