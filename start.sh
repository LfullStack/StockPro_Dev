#!/bin/sh

if [ ! -f .env ]; then
  cp .env.example .env
fi

php artisan config:clear
php artisan cache:clear
php artisan config:cache

php artisan key:generate --force
php artisan migrate --force
php artisan serve --host=0.0.0.0 --port=8000
