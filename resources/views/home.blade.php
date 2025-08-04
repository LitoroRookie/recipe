{{-- resources/views/home.blade.php --}}
@extends('layouts.app')

@section('title', '料理魔法配方')

@section('content')
    <div class="text-center">
        <h1 class="text-4xl font-bold text-green-800 drop-shadow-md">歡迎留下你的料理魔法配方</h1>
        <p class="mt-4 text-green-700">用植物與心靈創造魔法般的味道</p>
        <a href="{{ route('login') }}" class="mt-6 inline-block text-white bg-green-500 hover:bg-green-600 px-6 py-2 rounded-full shadow-md transition duration-300">
            留下你的足跡
        </a>
    </div>
@endsection
