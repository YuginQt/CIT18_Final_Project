<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>DoctorFileSafe</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />
        
        <!-- Tailwind CSS -->
        <script src="https://cdn.tailwindcss.com"></script>
    </head>
    <body class="bg-gray-100 dark:bg-gray-900 text-gray-900 dark:text-gray-100 flex items-center justify-center min-h-screen">
        <div class="w-full max-w-4xl text-center p-6">
            <h1 class="text-4xl font-bold">Welcome to DoctorFileSafe</h1>
            <p class="mt-2 text-lg">A secure and efficient way to manage patient records with ease.</p>
            
            @if (Route::has('login'))
                <div class="mt-6">
                    @auth
                        <a href="{{ url('/dashboard') }}" class="px-5 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}" class="px-5 py-2 bg-green-600 text-white rounded-md hover:bg-green-700">Login</a>
                        <a href="{{ route('register') }}" class="ml-4 px-5 py-2 border border-gray-400 text-gray-900 rounded-md hover:bg-gray-200">Register</a>
                    @endauth
                </div>
            @endif
        </div>
    </body>
</html>