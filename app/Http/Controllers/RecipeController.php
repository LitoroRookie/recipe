<?php

namespace App\Http\Controllers;

use App\Models\Recipe;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class RecipeController extends Controller
{
    public function index()
    {
        $recipes = Recipe::where('user_id', Auth::id())->latest()->paginate(10);
        return view('recipes.index', compact('recipes'));
    }

    public function create()
    {
        return view('recipes.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:4096',
        ]);

        $imagePath = null;

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('recipes', 'public'); // 儲存在 storage/app/public/recipes
        }

        Recipe::create([
            'title' => $request->title,
            'description' => $request->description,
            'user_id' => Auth::id(),
            'image_path' => $imagePath,
        ]);

        return redirect()->route('recipes.index')->with('success', '配方新增成功！');
    }



    public function show(Recipe $recipe)
    {
        return view('recipes.show', compact('recipe'));
    }

    public function edit(Recipe $recipe)
    {
        $this->authorizeOwner($recipe);
        return view('recipes.edit', compact('recipe'));
    }

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
            if ($recipe->image_path && Storage::disk('public')->exists($recipe->image_path)) {
                Storage::disk('public')->delete($recipe->image_path);
            }

            $path = $request->file('image')->store('recipes', 'public');
            $recipe->image_path = $path;
        }

        $recipe->save();

        return redirect()->route('recipes.index')->with('success', '配方已成功更新！');
    }

    public function destroy(Recipe $recipe)
    {
        $this->authorizeOwner($recipe);

        if ($recipe->image_path && Storage::disk('public')->exists($recipe->image_path)) {
            Storage::disk('public')->delete($recipe->image_path);
        }

        $recipe->delete();

        return redirect()->route('recipes.index')->with('success', '刪除成功');
    }

    protected function authorizeOwner(Recipe $recipe)
    {
        if ($recipe->user_id !== Auth::id()) {
            abort(403, '無權限');
        }
    }

    public function publicIndex(Request $request)
    {
        $query = Recipe::query();

        if ($search = $request->input('search')) {
            $query->where('title', 'like', "%{$search}%");
        }

        $recipes = $query->latest()->paginate(6);

        return view('home', compact('recipes', 'search'));
    }

    public function dashboard(Request $request)
    {
        $query = Recipe::query();

        if ($search = $request->input('search')) {
            $query->where('title', 'like', "%{$search}%")
                ->orWhere('description', 'like', "%{$search}%");
        }

        $recipes = $query->latest()->paginate(6);

        return view('dashboard', compact('recipes'));
    }

}
