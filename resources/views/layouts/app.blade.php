<!DOCTYPE html>
<html lang="zh-Hant">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', '植物魔法網站')</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">

    <style>
        body {
            background-color: #f0fdf4;
        }

        @keyframes leafFloat {
            0% {
                transform: translate(0, 0) rotate(0deg);
                opacity: 0.3;
            }
            25% {
                transform: translate(20px, -15px) rotate(5deg);
                opacity: 0.4;
            }
            50% {
                transform: translate(0, -30px) rotate(0deg);
                opacity: 0.3;
            }
            75% {
                transform: translate(-20px, -15px) rotate(-5deg);
                opacity: 0.4;
            }
            100% {
                transform: translate(0, 0) rotate(0deg);
                opacity: 0.3;
            }
        }

        .leaf {
            position: absolute;
            background-image: url('/images/leaf.png'); /* ✅ 確保圖片路徑正確 */
            background-size: cover;
            opacity: 0.3;
            width: 80px;
            height: 80px;
            z-index: -1;
            animation: leafFloat 8s ease-in-out infinite;
        }

        .leaf1 { top: 20px; left: 40px; animation-delay: 0s; }
        .leaf2 { top: 150px; right: 60px; animation-delay: 2s; }
        .leaf3 { bottom: 200px; left: 100px; animation-delay: 1s; }
        .leaf4 { bottom: 80px; right: 30px; animation-delay: 3s; }

        .glow {
            box-shadow: 0 0 30px rgba(34, 197, 94, 0.3);
        }

        .backdrop-blur {
            backdrop-filter: blur(8px);
        }
    </style>
</head>
<body class="min-h-screen text-green-900 relative">

    {{-- 登出按鈕 --}}
    <div class="absolute top-4 right-4">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit"
                class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded shadow">
                登出
            </button>
        </form>
    </div>

    {{-- 飄動葉子 --}}
    <div class="leaf leaf1"></div>
    <div class="leaf leaf2"></div>
    <div class="leaf leaf3"></div>
    <div class="leaf leaf4"></div>

    {{-- 內容區塊 --}}
    <main class="w-full max-w-3xl mx-auto p-6 bg-white/60 rounded-2xl shadow-xl backdrop-blur glow border border-green-300 my-8">
        @yield('content')
    </main>

    {{-- 閒置自動登出功能 --}}
    <script>
        (function(){
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
                    alert('您已閒置超過 2 分鐘，將自動登出');
                    window.location.href = '/login';
                }).catch(() => {
                    window.location.href = '/login';
                });
            };

            const resetTimer = () => {
                clearTimeout(timeout);
                timeout = setTimeout(logout, 2 * 60 * 1000); // 2 分鐘
            };

            window.onload = resetTimer;
            document.onmousemove = resetTimer;
            document.onkeypress = resetTimer;
            document.onscroll = resetTimer;
            document.onclick = resetTimer;
        })();
    </script>

</body>
</html>
