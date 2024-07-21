<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'PRMIS_EPH') }}</title>
        <!-- Favicon -->
        <link rel="shortcut icon" type="image/png" href="{{ asset('images/logo.png') }}">
    @vite(['resources/css/app.css', 'resources/css/custom.css'])
    
</head>
<body class="bg-gray-100">
    <!-- Topbar -->
    <div class="topbar flex justify-between items-center bg-gray-800 text-white p-4">
        <div class="flex items-center">
            <!-- Replace text logo with image logo -->
            <div class="logo">
                <img src="{{ asset('images/logo.png') }}" alt="PRMIS EPH Logo">
            </div>
        </div>
        <div class="flex items-center space-x-4">
            <div>
                <a href="{{ route('login') }}" class="text-white hover:underline">Login</a>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="main-content container mx-auto py-12">
        <div class="text-center mb-12">
            <h2 class="text-4xl font-semibold mb-4">Welcome to PRMIS EPH</h2>
            <p class="text-gray-700 text-lg mb-4">Please log in to continue.</p>
        </div>

        <!-- Services Section -->
        <section class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
            <div class="card bg-white rounded-lg shadow-md overflow-hidden transition-transform transform hover:translate-y-[-10px]">
                <img src="annual_pe.jpg" alt="Annual PE" class="w-full h-48 object-cover">
                <div class="card-body p-4">
                    <h3 class="card-title text-xl font-bold mb-2">Annual PE</h3>
                    <p class="card-text text-gray-600">Comprehensive annual physical exams to ensure your health and wellbeing.</p>
                </div>
            </div>
            <div class="card bg-white rounded-lg shadow-md overflow-hidden transition-transform transform hover:translate-y-[-10px]">
                <img src="laboratory.jpg" alt="Laboratory" class="w-full h-48 object-cover">
                <div class="card-body p-4">
                    <h3 class="card-title text-xl font-bold mb-2">Laboratory</h3>
                    <p class="card-text text-gray-600">State-of-the-art laboratory services for accurate and timely results.</p>
                </div>
            </div>
            <div class="card bg-white rounded-lg shadow-md overflow-hidden transition-transform transform hover:translate-y-[-10px]">
                <img src="consultation.jpg" alt="Consultation" class="w-full h-48 object-cover">
                <div class="card-body p-4">
                    <h3 class="card-title text-xl font-bold mb-2">Consultation</h3>
                    <p class="card-text text-gray-600">Professional consultations with our experienced medical team.</p>
                </div>
            </div>
            <div class="card bg-white rounded-lg shadow-md overflow-hidden transition-transform transform hover:translate-y-[-10px]">
                <img src="pharmacy.jpg" alt="Pharmacy" class="w-full h-48 object-cover">
                <div class="card-body p-4">
                    <h3 class="card-title text-xl font-bold mb-2">Pharmacy</h3>
                    <p class="card-text text-gray-600">Quality pharmaceutical services with a wide range of medications.</p>
                </div>
            </div>
        </section>
    </div>

    @vite('resources/js/app.js')
</body>
</html>
