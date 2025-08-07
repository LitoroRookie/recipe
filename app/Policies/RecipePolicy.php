<?php

namespace App\Policies;

use App\Models\Recipe;
use App\Models\User;

class RecipePolicy
{
    // 判斷是否有權限編輯
    public function update(User $user, Recipe $recipe)
    {
        return $user->id === $recipe->user_id;
    }

    // 判斷是否有權限刪除
    public function delete(User $user, Recipe $recipe)
    {
        return $user->id === $recipe->user_id;
    }
}
