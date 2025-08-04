<?php

namespace App\Http\Controllers;

use App\Models\Recipe;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class RecipeController extends Controller
{
    // 顯示目前使用者的所有配方
    public function index()
    {
        $recipes = Recipe::where('user_id', Auth::id())->latest()->paginate(10);
        return view('recipes.index', compact('recipes'));
    }

    // 顯示新增配方表單
    public function create()
    {
        return view('recipes.create');
    }

    // 儲存新配方
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|max:2048', // 限制圖片最大2MB
        ]);

        $path = null;
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('recipes', 'public');
        }

        Recipe::create([
            'title' => $request->title,
            'description' => $request->description,
            'user_id' => Auth::id(),
            'image_path' => $path,
        ]);

        return redirect()->route('recipes.index')->with('success', '新增成功');
    }

    // 顯示單一配方詳情
    public function show(Recipe $recipe)
    {
        $this->authorizeOwner($recipe);
        return view('recipes.show', compact('recipe'));
    }

    // 顯示編輯配方表單
    public function edit(Recipe $recipe)
    {
        $this->authorizeOwner($recipe);
        return view('recipes.edit', compact('recipe'));
    }

    // 更新配方資料與圖片
    public function update(Request $request, Recipe $recipe)
    {
        $this->authorizeOwner($recipe);

        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'image' => 'nullable|image|max:2048',
        ]);

        $recipe->title = $validatedData['title'];
        $recipe->description = $validatedData['description'];

        if ($request->hasFile('image')) {
            // 刪除舊圖片
            if ($recipe->image_path && Storage::disk('public')->exists($recipe->image_path)) {
                Storage::disk('public')->delete($recipe->image_path);
            }

            // 儲存新圖片
            $path = $request->file('image')->store('recipes', 'public');
            $recipe->image_path = $path;
        }

        $recipe->save();

        return redirect()->route('recipes.index')->with('success', '配方已成功更新！');
    }

    // 刪除配方與圖片檔案
    public function destroy(Recipe $recipe)
    {
        $this->authorizeOwner($recipe);

        if ($recipe->image_path && Storage::disk('public')->exists($recipe->image_path)) {
            Storage::disk('public')->delete($recipe->image_path);
        }

        $recipe->delete();

        return redirect()->route('recipes.index')->with('success', '刪除成功');
    }

    // 檢查是否為配方擁有者，無權限則 403
    protected function authorizeOwner(Recipe $recipe)
    {
        if ($recipe->user_id !== Auth::id()) {
            abort(403, '無權限');
        }
    }
}
