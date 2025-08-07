<!DOCTYPE html>
<html lang="zh-Hant">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', '植物魔法網站')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <style>
        .leaf {
            position: absolute;
            width: 100px;
            height: 100px;
            background-image: url('{{ asset('images/leaf.png') }}');
            background-size: cover;
            opacity: 0.2;
            animation: float 8s infinite ease-in-out, sway 10s infinite linear, rotate 12s infinite linear;
        }
        .leaf1 { top: 10%; left: 5%; animation-delay: 0s; }
        .leaf2 { top: 30%; right: 10%; animation-delay: 2s; }
        .leaf3 { bottom: 15%; left: 10%; animation-delay: 4s; }
        .leaf4 { bottom: 25%; right: 5%; animation-delay: 6s; }

        @keyframes float {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-20px); }
        }

        @keyframes sway {
            0% { transform: translateX(0); }
            50% { transform: translateX(20px); }
            100% { transform: translateX(0); }
        }

        @keyframes rotate {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
    </style>
</head>
<body class="min-h-screen text-green-900 bg-gradient-to-br from-green-100 to-green-200 relative">

    {{-- 背景葉子 --}}
    <div class="leaf leaf1"></div>
    <div class="leaf leaf2"></div>
    <div class="leaf leaf3"></div>
    <div class="leaf leaf4"></div>

    {{-- 右上角帳號選單 --}}
    @auth
        <div class="absolute top-4 right-4 z-50">
            <div x-data="{ open: false }" class="relative">
                <button @click="open = !open"
                        class="bg-green-700 text-white px-4 py-2 rounded shadow hover:bg-green-800">
                    {{ Auth::user()->name }}
                </button>

                <div x-show="open" @click.away="open = false"
                     class="absolute right-0 mt-2 w-48 bg-white border rounded shadow z-50">
                    <a href="{{ route('profile.edit') }}"
                       class="block px-4 py-2 text-green-700 hover:bg-green-100">編輯魔藥師資料</a>
                    <a href="{{ route('recipes.index') }}"
                       class="block px-4 py-2 text-green-700 hover:bg-green-100">我的魔法配方</a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit"
                                class="w-full text-left px-4 py-2 text-red-600 hover:bg-red-100">
                            登出
                        </button>
                    </form>
                </div>
            </div>
        </div>
    @endauth

    {{-- 主要內容區塊 --}}
    <main class="w-full max-w-3xl mx-auto p-6 bg-white/60 rounded-2xl shadow-xl backdrop-blur border border-green-300 my-8">
        @yield('content')
    </main>

    {{-- 閒置自動登出功能 --}}
    @auth
        <script>
            (function () {
                let timeout;
                const logout = () => {
                    fetch("{{ route('logout') }}", {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Content-Type': 'application/json',
                            'Accept': 'application/json',
                        },
                    }).then(() => {
                        alert('您已閒置超過 2 分鐘，自動登出。');
                        window.location.href = '/login';
                    }).catch(() => {
                        window.location.href = '/login';
                    });
                };

                const resetTimer = () => {
                    clearTimeout(timeout);
                    timeout = setTimeout(logout, 60 * 60 * 1000);
                };

                window.onload = resetTimer;
                document.onmousemove = resetTimer;
                document.onkeypress = resetTimer;
                document.onscroll = resetTimer;
                document.onclick = resetTimer;
            })();
        </script>
    @endauth
</body>
</html>
