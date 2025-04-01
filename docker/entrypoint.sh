#!/bin/bash

set -ex

# Генерация .env файла, если отсутствует
if [ ! -f "/var/www/.env" ]; then
    echo "Creating .env file from .env.example..."
    if [ -f "/var/www/.env.example" ]; then
        cp /var/www/.env.example /var/www/.env
        echo ".env file created successfully."
    else
        echo "Warning: .env.example file not found. Creating empty .env file."
        touch /var/www/.env
    fi
fi

# Генерация ключа приложения, если не установлены
if ! grep -q "^APP_KEY=" .env || [ -z "$(grep "^APP_KEY=" .env | cut -d '=' -f2)" ]; then
    echo "Generating application key..."
    cd /var/www && php artisan key:generate --force
fi

# Установка Composer
echo "Installing Composer dependencies..."
composer install --no-interaction --prefer-dist --optimize-autoloader


# Запуск миграций базы данных
echo "Running database migrations..."
php artisan migrate --force

# Очистка кэша
echo "Clearing cache..."
php artisan optimize:clear

# Запуск PHP-FPM
exec php-fpm
