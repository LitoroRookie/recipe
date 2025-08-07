# 使用 PHP + FPM 作為基底映像
FROM php:8.2-fpm

# 安裝 PHP 擴展及系統套件
RUN apt-get update && apt-get install -y \
    unzip \
    zip \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    libzip-dev \
    && docker-php-ext-install pdo pdo_mysql zip mbstring exif pcntl

# 安裝 Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# 設定工作目錄
WORKDIR /var/www/html

# 複製 Laravel 專案內容
COPY . .

# 安裝 Laravel 相依套件
RUN composer install --no-dev --optimize-autoloader

# 快取 Laravel 設定
RUN php artisan config:cache && php artisan route:cache && php artisan view:cache

# 預設啟動 PHP-FPM
CMD ["php-fpm"]
