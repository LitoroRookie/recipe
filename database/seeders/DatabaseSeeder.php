<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Recipe;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 建立指定帳號
        $user = User::create([
            'name' => '示範帳號',
            'email' => 'demo@example.com',
            'password' => Hash::make('password'), // 密碼: password
        ]);

        // 建立 10 筆配方資料
        Recipe::factory()->count(10)->create([
            'user_id' => $user->id,
        ]);
    }
}
