<!DOCTYPE html>
<html lang="zh-Hant">
<head>
    <meta charset="UTF-8" />
    <title>@yield('title', '料理魔法世界')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet" />

    <style>
        body, html {
            margin: 0; padding: 0;
            width: 100%; height: 100%;
            overflow: hidden;
            background: linear-gradient(to bottom right, #fff0f5, #ffe4e1);
            font-family: "Noto Sans", sans-serif;
            position: relative;
        }
        #sakura-canvas {
            position: fixed;
            top: 0; left: 0;
            width: 100vw;
            height: 100vh;
            pointer-events: none;
            z-index: 0;
        }
        .bg-overlay {
            position: relative;
            z-index: 10;
            background-color: rgba(255, 255, 255, 0.75);
            max-width: 400px;
            margin: 2rem auto;
            padding: 2rem;
            border-radius: 1rem;
            box-shadow: 0 8px 24px rgba(0,0,0,0.15);
        }
    </style>
</head>
<body>

    <canvas id="sakura-canvas"></canvas>

    <div class="bg-overlay">
        @yield('content')
    </div>

<script>
(() => {
    const canvas = document.getElementById('sakura-canvas');
    const ctx = canvas.getContext('2d');
    let width = window.innerWidth;
    let height = window.innerHeight;
    canvas.width = width;
    canvas.height = height;

    // 櫻花瓣圖案 (簡單用 Path 畫一片花瓣)
    function drawPetal(ctx, x, y, scale, rotation) {
        ctx.save();
        ctx.translate(x, y);
        ctx.rotate(rotation);
        ctx.scale(scale, scale);
        ctx.fillStyle = 'rgba(255, 182, 193, 0.8)'; // 粉色
        ctx.beginPath();
        ctx.moveTo(0, 0);
        ctx.bezierCurveTo(10, -10, 20, -10, 20, 0);
        ctx.bezierCurveTo(20, 10, 10, 20, 0, 20);
        ctx.bezierCurveTo(-10, 20, -20, 10, -20, 0);
        ctx.bezierCurveTo(-20, -10, -10, -10, 0, 0);
        ctx.fill();
        ctx.restore();
    }

    class Petal {
        constructor() {
            this.reset();
        }
        reset() {
            this.x = Math.random() * width;
            this.y = Math.random() * height - height;
            this.scale = 0.5 + Math.random() * 0.7;
            this.rotation = Math.random() * 2 * Math.PI;
            this.speedY = 1 + Math.random() * 2;
            this.speedX = (Math.random() - 0.5) * 1;
            this.rotationSpeed = (Math.random() - 0.5) * 0.02;
        }
        update() {
            this.x += this.speedX;
            this.y += this.speedY;
            this.rotation += this.rotationSpeed;

            if (this.y > height + 20 || this.x < -50 || this.x > width + 50) {
                this.reset();
                this.y = -20;
            }
        }
        draw(ctx) {
            drawPetal(ctx, this.x, this.y, this.scale, this.rotation);
        }
    }

    let petals = [];
    const PETAL_COUNT = 40;

    function init() {
        petals = [];
        for(let i = 0; i < PETAL_COUNT; i++) {
            petals.push(new Petal());
        }
    }

    function animate() {
        ctx.clearRect(0, 0, width, height);
        petals.forEach(p => {
            p.update();
            p.draw(ctx);
        });
        requestAnimationFrame(animate);
    }

    function onResize() {
        width = window.innerWidth;
        height = window.innerHeight;
        canvas.width = width;
        canvas.height = height;
    }

    window.addEventListener('resize', onResize);

    init();
    animate();
})();
</script>

</body>
</html>
