# 使用官方 PHP + Apache image（Laravel 用）
FROM php:8.2-apache

# 安裝系統依賴與 PHP 擴充
RUN apt-get update && apt-get install -y \
    git unzip libpq-dev libzip-dev zip \
    && docker-php-ext-install pdo pdo_pgsql zip

# 啟用 Apache rewrite module（Laravel 路由需要）
RUN a2enmod rewrite

# 安裝 Composer
COPY --from=composer:2.6 /usr/bin/composer /usr/bin/composer

# 設定工作目錄
WORKDIR /var/www/html

# 複製專案檔案
COPY . .

# 安裝 PHP 套件
RUN composer install --no-dev --optimize-autoloader

# 權限設定
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

# Laravel 快取
RUN php artisan config:cache && php artisan route:cache && php artisan view:cache

# 對外開放 port 80
EXPOSE 80

# 啟動 Apache server
CMD ["apache2-foreground"]
