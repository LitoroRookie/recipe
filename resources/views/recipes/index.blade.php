@extends('layouts.app')

@section('title', '我的配方列表')

@section('content')
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-green-900"> 我的植物魔法配方 </h1>
        <a href="{{ session('return_to', route('dashboard')) }}" class="text-green-600 hover:underline">← 返回上一頁</a>
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
                <div class="p-4 border rounded shadow hover:shadow-md transition">
                    <h2 class="text-xl font-bold text-green-800">
                        <a href="{{ route('recipes.show', $recipe->id) }}">{{ $recipe->title }}</a>
                    </h2>

                    @if ($recipe->image_path)
                        <img src="{{ Storage::url($recipe->image_path) }}" alt="配方圖片" class="mt-2 w-full max-w-md rounded">
                    @endif

                    <p class="text-gray-600 mt-2">{{ Str::limit(strip_tags($recipe->description), 100) }}</p>

                    <div class="mt-4 flex flex-wrap gap-2">
                        <a href="{{ route('recipes.show', $recipe->id) }}"
                           class="text-sm px-3 py-1 bg-blue-100 text-blue-800 rounded hover:bg-blue-200">
                            查看詳細
                        </a>
                        <a href="{{ route('recipes.edit', $recipe->id) }}"
                           class="text-sm px-3 py-1 bg-yellow-100 text-yellow-800 rounded hover:bg-yellow-200">
                            編輯
                        </a>
                        <form action="{{ route('recipes.destroy', $recipe->id) }}" method="POST"
                              onsubmit="return confirm('確定要刪除這個配方嗎？')">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                    class="text-sm px-3 py-1 bg-red-100 text-red-800 rounded hover:bg-red-200">
                                刪除
                            </button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="mt-6">
            {{ $recipes->links() }}
        </div>
    @endif
@endsection
