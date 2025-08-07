@extends('layouts.app')

@section('title', '探索魔法配方')
@php(session(['return_to' => request()->fullUrl()]))
@section('content')
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold">🔍 探索他人的植物魔法配方</h1>

        @guest
            <a href="{{ route('login') }}"
               class="bg-green-700 text-white px-4 py-2 rounded hover:bg-green-800 shadow">
                登入
            </a>
        @endguest
    </div>

    {{-- 搜尋表單 --}}
    <form action="{{ route('home') }}" method="GET" class="mb-6">
        <input type="text" name="search" value="{{ request('search') }}"
               placeholder="搜尋配方名稱..."
               class="w-full px-4 py-2 border border-green-300 rounded shadow focus:outline-none focus:ring-2 focus:ring-green-400">
    </form>

    {{-- 結果列表 --}}
    @if($recipes->count())
        <div class="grid gap-4">
            
            @foreach($recipes as $recipe)
                <div class="p-4 bg-white/80 rounded-xl border border-green-300 shadow">
                    <h2 class="text-xl font-semibold text-green-800">{{ $recipe->title }}</h2>
                    <p class="text-sm text-green-700 mb-2">由 {{ $recipe->user->name }} 製作</p>
                    <p class="text-gray-700">{{ Str::limit($recipe->description, 100) }}</p>
                    <a href="{{ route('recipes.show', ['recipe' => $recipe->id, 'from' => 'home']) }}"
   class="text-blue-600 hover:underline">查看</a>
                </div>
            @endforeach
        </div>
    @else
        <p class="text-center text-gray-600">找不到符合條件的配方。</p>
    @endif
@endsection
