<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Workforce Platform') }} · Expert Portal</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased text-ink-900 bg-mesh-radial min-h-screen selection:bg-outlier-500 selection:text-white flex flex-col justify-center items-center p-4 sm:p-6">
        <div class="mb-6 transform hover:scale-105 transition-transform">
            <a href="/">
                <x-application-logo />
            </a>
        </div>

        <div class="w-full sm:max-w-md bg-white/95 backdrop-blur-md p-8 rounded-4xl border border-gray-200/80 shadow-soft">
            {{ $slot }}
        </div>

        <div class="mt-8 text-center text-xs text-ink-400">
            © {{ date('Y') }} Workforce Platform. Secure Expert Access.
        </div>
    </body>
</html>
