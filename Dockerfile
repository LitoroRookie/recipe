FROM php:8.2-fpm

# 安裝系統依賴和 PHP 擴充
RUN apt-get update && apt-get install -y \
    libzip-dev zip unzip git libonig-dev \
    && docker-php-ext-install pdo_mysql zip mbstring

WORKDIR /var/www/html

# 複製整個專案到映像
COPY . /var/www/html

# 安裝 composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# 安裝依賴
RUN composer install --no-dev --optimize-autoloader --no-interaction


# 複製整個專案其他檔案
COPY . /var/www/html

# 建立 storage link
RUN php artisan storage:link

# 設定權限（可依需要調整）
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

EXPOSE 9000

CMD ["php-fpm"]
