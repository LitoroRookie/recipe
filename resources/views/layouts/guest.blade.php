<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>{{ config('app.name', 'Laravel') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans text-gray-900 antialiased relative">
    <canvas id="sakura-canvas" class="fixed top-0 left-0 w-full h-full pointer-events-none z-0"></canvas>

    <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-transparent relative z-10">
        <div>
            <a href="/">
                <x-application-logo class="w-20 h-20 fill-current text-gray-500" />
            </a>
        </div>

        <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white bg-opacity-70 shadow-md overflow-hidden sm:rounded-lg">
            {{ $slot }}
        </div>
    </div>

    <script>
    (() => {
        const canvas = document.getElementById('sakura-canvas');
        const ctx = canvas.getContext('2d');
        let width = window.innerWidth;
        let height = window.innerHeight;
        canvas.width = width;
        canvas.height = height;

        function drawPetal(x, y, scale, rotation) {
            ctx.save();
            ctx.translate(x, y);
            ctx.rotate(rotation);
            ctx.scale(scale, scale);
            ctx.fillStyle = 'rgba(255, 182, 193, 0.8)';
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
                drawPetal(this.x, this.y, this.scale, this.rotation);
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
