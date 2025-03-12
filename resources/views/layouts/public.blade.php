<!-- resources/views/layouts/public.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'PRMIS_EPH') }}</title>

    <!-- Favicon -->
    <link rel="shortcut icon" type="image/png" href="{{ asset('images/logo.png') }}">

    @vite(['resources/css/app.css', 'resources/css/custom.css'])

    <!-- Additional Styles -->
    @stack('styles')
</head>
<body class="bg-gray-100">
    <!-- Topbar -->
    <div class="topbar flex justify-between items-center text-white p-4 shadow-lg" style="background-color: #1D2736;">
        <div class="flex items-center space-x-2">
            <img src="{{ asset('images/logo.png') }}" alt="PRMIS EPH Logo" class="w-10 h-8 rounded-full">
            <span class="text-lg font-bold">e-Rehistro</span>
        </div>
        <div class="flex items-center space-x-4">
            <a href="{{ route('patient-registration') }}" class="flex items-center text-white bg-blue-600 hover:bg-blue-700 px-4 py-2 rounded-lg transition duration-300">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path>
                </svg>
                Register
            </a>
            <a href="{{ route('login') }}" class="text-white hover:underline font-medium">Login</a>
        </div>
    </div>

    <!-- Main Content -->
    <main>
        @yield('content')
    </main>

    @vite('resources/js/app.js')
    @stack('scripts')
</body>
</html>
