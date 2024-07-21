<!-- Inside your app.blade.php or similar layout file -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <!-- Title and Meta -->
    <title>{{ config('app.name', 'PRMIS EPH') }}</title>
    <meta name="description" content="Your website description here">

    <!-- Favicon -->
    <link rel="shortcut icon" type="image/png" href="{{ asset('images/logo.png') }}">
    
    <!-- CSS -->
    @vite('resources/css/app.css')
</head>
<body class="bg-gray-100">
    <div id="app" class="flex">
        @include('layouts.sidebar') <!-- Include the sidebar -->

        <div class="flex-1">
            @include('layouts.topbar') <!-- Include the top navigation for user settings and time -->
            <main class="container mx-auto py-4">
                @yield('content')
            </main>
        </div>
    </div>
    <!-- JavaScript -->
    @vite('resources/js/app.js')
</body>
</html>
