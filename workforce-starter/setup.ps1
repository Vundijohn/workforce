param(
    [string]$App = "workforce-platform"
)

$ErrorActionPreference = "Stop"
$Kit = $PSScriptRoot

Write-Host "==> Creating Laravel application: $App"
composer create-project laravel/laravel $App
Set-Location $App

Write-Host "==> Installing dependencies..."
composer require spatie/laravel-permission --no-interaction
composer require laravel/breeze --dev --no-interaction
php artisan breeze:install blade --no-interaction

Write-Host "==> Publishing Spatie Permission Provider..."
php artisan vendor:publish --provider="Spatie\Permission\PermissionServiceProvider" --no-interaction

Write-Host "==> Applying Workforce Platform overlay..."
Copy-Item -Path "$Kit\overlay\*" -Destination "." -Recurse -Force

Write-Host "==> Running migrations and seeders..."
php artisan migrate --seed --no-interaction

Write-Host "==> Building frontend assets..."
npm install
npm run build

Write-Host @"

Done. Start developing:
  cd $App
  php artisan serve        # http://127.0.0.1:8000
  php artisan test         # run the workflow tests

Demo logins (local only, password: password):
  worker@example.test   reviewer@example.test   admin@example.test
"@
