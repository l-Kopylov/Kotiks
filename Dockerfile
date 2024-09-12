# Используем официальный образ PHP с поддержкой FPM
FROM php:8.2-fpm

# Устанавливаем необходимые зависимости
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libzip-dev \
    unzip \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd zip pdo pdo_mysql

# Копируем исходный код приложения в контейнер
COPY . /var/www/html

# Устанавливаем рабочую директорию
WORKDIR /var/www/html

# Открываем порт 9000 для PHP-FPM
EXPOSE 9000