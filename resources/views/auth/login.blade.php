<x-guest-layout>
    <!-- 替換 logo 區域為葉子圖示 -->
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}">
    @csrf

    <!-- Email -->
    <div>
        <x-input-label for="email" :value="'電子郵件'" />
        <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
        <x-input-error :messages="$errors->get('email')" class="mt-2" />
    </div>

    <!-- Password -->
    <div class="mt-4">
        <x-input-label for="password" :value="'密碼'" />
        <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="current-password" />
        <x-input-error :messages="$errors->get('password')" class="mt-2" />
    </div>

    <!-- Remember Me -->
    <div class="block mt-4 text-left">
        <label for="remember_me" class="inline-flex items-center">
            <input id="remember_me" type="checkbox" class="rounded border-pink-400 text-pink-600 shadow-sm focus:ring-pink-500" name="remember">
            <span class="ms-2 text-sm text-pink-700">記住我</span>
        </label>
    </div>

    <!-- 操作列 -->
    <div class="flex items-center justify-between mt-6 flex-wrap">
    {{-- 左側：註冊 --}}
    @if (Route::has('register'))
        <a href="{{ route('register') }}"
           class="text-pink-600 hover:text-pink-800 text-sm">
            註冊
        </a>
    @endif

        {{-- 右側：忘記密碼 + 登入按鈕 --}}
        <div class="flex items-center gap-3 ml-auto">
            @if (Route::has('password.request'))
                <a href="{{ route('password.request') }}"
                class="underline text-pink-600 hover:text-pink-800 text-sm">
                    忘記密碼？
                </a>
            @endif

            <x-primary-button class="bg-gray-900 text-white hover:bg-gray-800">
                登入
            </x-primary-button>
        </div>
    </div>

</form>

</x-guest-layout>
