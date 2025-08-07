@extends('layouts.app')

@section('title', '儀表板')
@php(session(['return_to' => request()->fullUrl()]))
@section('content')
    <div class="text-center mb-6">
        <h1 class="text-3xl font-bold"> 歡迎來到魔法植物世界 </h1>
        <p class="text-lg text-gray-700">探索其他魔藥師的魔法配方吧！</p>
    </div>

    {{-- 搜尋 --}}
    <form method="GET" action="{{ route('dashboard') }}" class="mb-6">
        <input type="text" name="search" value="{{ request('search') }}"
            placeholder="搜尋配方名稱或材料..."
            class="w-full px-4 py-2 border border-green-300 rounded focus:outline-none focus:ring-2 focus:ring-green-500">
    </form>

    {{-- 配方列表 --}}
    @if ($recipes->isEmpty())
        <p class="text-gray-600">沒有符合的配方。</p>
    @else
        <div class="space-y-6">
            

            @foreach ($recipes as $recipe)
                <div class="p-6 bg-white/80 rounded-xl shadow hover:shadow-lg transition">
                    <h2 class="text-xl font-semibold text-green-800 mb-2">{{ $recipe->title }}</h2>

                    @if ($recipe->image_path)
                        <img src="{{ asset('storage/' . $recipe->image_path) }}"
                             alt="配方圖片"
                             class="w-full h-48 object-cover rounded mb-4">
                    @endif

                    <p class="text-sm text-gray-700">
                        作者：<span class="font-bold">{{ $recipe->user->name }}</span>
                    </p>

                    <a href="{{ route('recipes.show', ['recipe' => $recipe->id, 'from' => 'dashboard']) }}"
   class="text-blue-600 hover:underline">查看</a>
                </div>
            @endforeach
        </div>

        <div class="mt-6">
            {{ $recipes->appends(['search' => request('search')])->links() }}
        </div>
    @endif
@endsection
