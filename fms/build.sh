#!/usr/bin/env bash
set -e

echo ">>> Installing Composer dependencies..."
composer install --no-dev --optimize-autoloader

echo ">>> Caching config, routes, views..."
php artisan config:cache
php artisan route:cache
php artisan view:cache

echo ">>> Running database migrations and seeding..."
php artisan migrate --force --seed

echo ">>> Done! TransRoute FMS deployed successfully."