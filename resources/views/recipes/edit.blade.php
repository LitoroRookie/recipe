@extends('layouts.app')

@section('title', '編輯配方')

@section('content')
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-green-800">✏️ 編輯植物魔法配方</h1>
    </div>

    @if ($errors->any())
        <div class="mb-4 p-4 bg-red-100 border border-red-300 text-red-800 rounded">
            <ul class="list-disc pl-5">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('recipes.update', $recipe) }}" method="POST" enctype="multipart/form-data" class="space-y-4">
        @csrf
        @method('PUT')

        <!-- 標題 -->
        <div>
            <label for="title" class="block text-sm font-medium text-gray-700">標題</label>
            <input type="text" id="title" name="title" value="{{ old('title', $recipe->title) }}"
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-green-500 focus:border-green-500" required>
        </div>

        <!-- 描述 -->
        <div>
            <label for="description" class="block text-sm font-medium text-gray-700">描述</label>
            <textarea id="description" name="description" rows="4"
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-green-500 focus:border-green-500">{{ old('description', $recipe->description) }}</textarea>
        </div>

        <!-- 原本圖片預覽 -->
        @if ($recipe->image_path)
            <div>
                <label class="block text-sm font-medium text-gray-700">目前圖片</label>
                <img src="{{ asset('storage/' . $recipe->image_path) }}" alt="配方圖片" class="w-48 h-auto rounded shadow">
            </div>
        @endif

        <!-- 上傳新圖片 -->
        <div>
            <label for="image" class="block text-sm font-medium text-gray-700">上傳新圖片（選填）</label>
            <input type="file" id="image" name="image" accept="image/*" class="mt-1 block w-full">
        </div>

        <!-- 按鈕 -->
        <div class="flex justify-between items-center pt-4">
            <a href="{{ route('recipes.index') }}" class="text-gray-600 hover:underline">← 返回配方列表</a>
            <button type="submit"
                class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">💾 儲存變更</button>
        </div>
    </form>
@endsection
