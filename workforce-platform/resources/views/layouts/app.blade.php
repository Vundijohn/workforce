<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Workforce Platform') }} · Train Frontier AI</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased text-ink-900 bg-mesh-radial min-h-screen selection:bg-outlier-500 selection:text-white">
        <div class="min-h-screen flex flex-col">
            @include('layouts.navigation')

            <!-- Page Heading -->
            @isset($header)
                <header class="bg-white/70 backdrop-blur-md border-b border-gray-200/70">
                    <div class="max-w-6xl mx-auto py-5 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            <!-- Page Content -->
            <main class="flex-1 pb-16">
                {{ $slot }}
            </main>

            <!-- Minimalist Footer -->
            <footer class="border-t border-gray-200/60 bg-white/60 backdrop-blur-sm py-6 mt-auto">
                <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col sm:flex-row items-center justify-between text-xs text-ink-500 gap-3">
                    <div class="flex items-center gap-2">
                        <span class="font-bold text-ink-900 text-sm">Workforce<span class="text-outlier-500">.</span></span>
                        <span>· High-Quality Human Feedback for Frontier AI</span>
                    </div>
                    <div>
                        © {{ date('Y') }} Workforce Platform. All rights reserved.
                    </div>
                </div>
            </footer>
        </div>
    </body>
</html>
