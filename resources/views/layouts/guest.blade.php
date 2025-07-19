<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>{{ config('app.name', 'Novafix') }}</title>
        <script src="https://cdn.tailwindcss.com"></script>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        @livewireStyles
    </head>
    <body class="font-sans antialiased">
        <nav class="bg-white shadow">
            <div class="max-w-7xl mx-auto px-4">
                <div class="flex justify-between h-16">
                    <div class="flex">
                        <div class="flex-shrink-0 flex items-center">
                            <a href="/" class="text-2xl font-bold text-orange-500">Novafix</a>
                        </div>
                    </div>
                    <div class="flex items-center">
                        <a href="{{ route('franchise.login') }}" class="text-gray-700 hover:text-orange-500">Franchise Login</a>
                        <a href="{{ route('frontdesk.login') }}" class="ml-4 text-gray-700 hover:text-orange-500">Frontdesk Login</a>
                        <a href="{{ route('staff.login') }}" class="ml-4 text-gray-700 hover:text-orange-500">Staff Login</a>
                    </div>
                </div>
            </div>
        </nav>

        <main>
            {{ $slot }}
        </main>

        <footer class="bg-gray-800 text-white mt-12">
            <div class="max-w-7xl mx-auto px-4 py-8">
                <p class="text-center">&copy; {{ date('Y') }} Novafix. All rights reserved.</p>
            </div>
        </footer>

        @livewireScripts
    </body>
</html>
