<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RecipeController;

// 首頁公開配方探索
Route::get('/', [RecipeController::class, 'publicIndex'])->name('home');

// 儀表板（所有配方）
Route::get('/dashboard', [RecipeController::class, 'dashboard'])->middleware('auth')->name('dashboard');

// 登入後功能
Route::middleware('auth')->group(function () {
    // 個人資料管理
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // 使用者自己的配方管理（除了 show）
    Route::resource('recipes', RecipeController::class)->except(['show']);
});

// show 不能放在 resource 裡，否則 middleware auth 會限制訪客查看
Route::get('/recipes/{recipe}', [RecipeController::class, 'show'])->name('recipes.show');

require __DIR__.'/auth.php';