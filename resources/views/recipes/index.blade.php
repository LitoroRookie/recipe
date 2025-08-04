@extends('layouts.app')

@section('title', '我的配方列表')

@section('content')
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-green-900">🌿 我的植物魔法配方 🌿</h1>
        <a href="{{ route('dashboard') }}" class="text-gray-600 hover:underline self-center">
                ← 返回儀表板
            </a>
        <a href="{{ route('recipes.create') }}"
           class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700 transition">
            ➕ 新增配方
        </a>
    </div>

    @if (session('success'))
        <div class="mb-4 p-4 bg-green-100 border border-green-300 rounded text-green-800">
            {{ session('success') }}
        </div>
    @endif

    @if ($recipes->isEmpty())
        <p class="text-gray-600">目前尚未建立任何配方。</p>
    @else
        <div class="space-y-6">
            @foreach ($recipes as $recipe)
                <div class="p-6 bg-white/80 rounded-xl shadow hover:shadow-lg transition relative">
                    {{-- 有圖片時，名稱在圖片上方 --}}
                    @if ($recipe->image_path)
                        <h2 class="text-xl font-semibold text-green-800 mb-2">{{ $recipe->title }}</h2>
                        <img src="{{ asset('storage/' . $recipe->image_path) }}"
                             alt="配方圖片"
                             class="w-full h-48 object-cover rounded mb-4 transform hover:scale-105 transition-transform duration-300">
                    @else
                        {{-- 無圖片時直接顯示名稱 --}}
                        <h2 class="text-xl font-semibold text-green-800 mb-4">{{ $recipe->title }}</h2>
                    @endif

                   

                    {{-- 操作按鈕 --}}
                    <div class="mt-4 flex gap-4">
                        <a href="{{ route('recipes.show', $recipe) }}"
                           class="text-blue-600 hover:underline">查看</a>
                        <a href="{{ route('recipes.edit', $recipe) }}"
                           class="text-yellow-600 hover:underline">編輯</a>
                        <form action="{{ route('recipes.destroy', $recipe) }}"
                              method="POST"
                              onsubmit="return confirm('確定要刪除這個配方嗎？')">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                    class="px-3 py-1 border border-red-500 text-red-500 rounded hover:bg-red-500 hover:text-white transition">
                                刪除
                            </button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>

        {{-- 分頁控制（如有使用 paginate） --}}
        <div class="mt-6">
            {{ $recipes->links() }}
        </div>
    @endif
@endsection
