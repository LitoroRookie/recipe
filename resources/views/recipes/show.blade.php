@extends('layouts.app')

@section('title', $recipe->title)

@section('content')
    <div class="mb-6">
        <a href="{{ route('recipes.index') }}" class="text-green-600 hover:underline">← 返回配方列表</a>
    </div>

    <div class="bg-white p-6 rounded shadow">
        <h1 class="text-2xl font-bold text-green-900">{{ $recipe->title }}</h1>

        @if ($recipe->image_path)
            <img src="{{ Storage::url($recipe->image_path) }}" alt="配方圖片" class="mt-4 w-full max-w-lg rounded">
        @endif

        <div class="mt-6 prose max-w-none">
            {!! nl2br(e($recipe->description)) !!}
        </div>
    </div>
@endsection
