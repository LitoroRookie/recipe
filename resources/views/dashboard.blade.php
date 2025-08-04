@extends('layouts.app')

@section('title', '儀表板')

@section('content')
    <div class="max-w-3xl mx-auto p-6 bg-white rounded-xl shadow space-y-6">
        <div class="text-center">
            <h1 class="text-3xl font-bold mb-4 text-green-900">🌿 歡迎使用植物魔法網站 🌿</h1>
            <p class="text-lg">您已成功登入，現在可以開始管理您的植物魔法配方。</p>
        </div>

        <section class="bg-green-50 p-6 rounded shadow">
            <h3 class="text-xl font-semibold mb-4 text-green-800">您的帳號資料</h3>
            <p><strong>姓名：</strong> {{ auth()->user()->name }}</p>
            <p><strong>電子郵件：</strong> {{ auth()->user()->email }}</p>

            <div class="mt-6 flex flex-wrap gap-4 justify-center">
                <a href="{{ route('profile.edit') }}" 
                   class="inline-block bg-green-600 hover:bg-green-700 text-white px-5 py-2 rounded shadow">
                   編輯資料
                </a>

                <form action="{{ route('profile.destroy') }}" method="POST" onsubmit="return confirm('確定要刪除您的帳號嗎？此操作無法復原！');" class="inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" 
                            class="bg-red-600 hover:bg-red-700 text-white px-5 py-2 rounded shadow">
                        刪除帳號
                    </button>
                </form>
            </div>
        </section>

        <div class="text-center">
            <a href="{{ route('recipes.index') }}" 
               class="inline-block mt-6 bg-green-600 hover:bg-green-700 text-white px-6 py-3 rounded shadow">
                前往配方列表
            </a>
        </div>
    </div>
@endsection
