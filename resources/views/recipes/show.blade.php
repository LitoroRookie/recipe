@extends('layouts.app')

@section('title', $recipe->title)

@section('content')
    <div class="max-w-3xl mx-auto p-6 bg-white rounded shadow">
        <h1 class="text-3xl font-bold text-green-800 mb-4">{{ $recipe->title }}</h1>

        @if ($recipe->image_path)
            <img src="{{ asset('storage/' . $recipe->image_path) }}" alt="{{ $recipe->title }}" class="mb-6 rounded shadow max-w-full h-auto">
        @endif

        <div class="prose mb-6">
             <p>{!! nl2br(e($recipe->description)) !!}</p>
        </div>

        <div class="flex justify-between items-center">
            <a href="{{ route('recipes.index') }}" class="text-green-600 hover:underline">← 返回配方列表</a>

            <div class="space-x-4">
                <a href="{{ route('recipes.edit', $recipe) }}" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded">編輯配方</a>

                <form action="{{ route('recipes.destroy', $recipe) }}" method="POST" class="inline" onsubmit="return confirm('確定要刪除此配方嗎？');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded">刪除配方</button>
                </form>
            </div>
        </div>
    </div>
@endsection
