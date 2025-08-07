<?php

namespace Database\Seeders;

use App\Models\Recipe;
use Illuminate\Database\Seeder;

class RecipeSeeder extends Seeder
{
    public function run(): void
    {
        Recipe::factory()->count(20)->create(); // 建立 20 筆假資料
    }
}
