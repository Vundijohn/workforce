#!/usr/bin/env bash
# Creates a fresh Laravel app and layers the Workforce Platform starter on top.
# Requirements: PHP 8.2+, Composer 2, Node 20+, and (optionally) MySQL 8 / Redis.
set -euo pipefail

KIT="$(cd "$(dirname "$0")" && pwd)"
APP="${1:-workforce-platform}"

composer create-project laravel/laravel "$APP"
cd "$APP"

composer require spatie/laravel-permission
composer require laravel/breeze --dev
php artisan breeze:install blade --no-interaction

php artisan vendor:publish --provider="Spatie\Permission\PermissionServiceProvider" --no-interaction

# Overlay AFTER Breeze so our routes/web.php and User model replace the defaults.
cp -R "$KIT/overlay/." .

php artisan migrate --seed --no-interaction

npm install
npm run build

cat <<MSG

Done. Start developing:
  cd $APP
  php artisan serve        # http://127.0.0.1:8000
  php artisan test         # run the workflow tests

Demo logins (local only, password: password):
  worker@example.test   reviewer@example.test   admin@example.test
MSG
