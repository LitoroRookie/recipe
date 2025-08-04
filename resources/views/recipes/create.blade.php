@extends('layouts.app')

@section('title', '新增植物魔法配方')

@section('content')
    <h1 class="text-2xl font-bold mb-6">➕ 新增植物魔法配方</h1>

    @if ($errors->any())
        <div class="mb-4 p-4 bg-red-100 border border-red-300 rounded text-red-800">
            <strong>請修正以下錯誤：</strong>
            <ul class="list-disc pl-5 mt-2">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('recipes.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="mb-4">
            <label for="title" class="block text-sm font-medium text-green-900 mb-1">配方標題 <span class="text-red-600">*</span></label>
            <input type="text" id="title" name="title" class="w-full border border-green-300 rounded px-4 py-2" value="{{ old('title') }}" required>
        </div>

        <div class="mb-4">
            <label for="description" class="block text-sm font-medium text-green-900 mb-1">配方描述</label>
            <textarea id="description" name="description" rows="4" class="w-full border border-green-300 rounded px-4 py-2">{{ old('description') }}</textarea>
        </div>

        <div class="mb-6">
            <label for="image" class="block text-sm font-medium text-green-900 mb-1">上傳圖片（選填）</label>
            <input type="file" id="image" name="image" accept="image/*" class="w-full border border-green-300 rounded px-4 py-2">
        </div>

        <div class="flex justify-end gap-4">
            <a href="{{ route('recipes.index') }}" class="px-4 py-2 rounded bg-gray-300 hover:bg-gray-400 text-gray-800">取消</a>
            <button type="submit" class="px-4 py-2 rounded bg-green-600 text-white hover:bg-green-700">儲存配方</button>
        </div>
    </form>
@endsection
