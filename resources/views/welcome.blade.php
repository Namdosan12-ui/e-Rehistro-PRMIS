@extends('layouts.public')

@section('content')
    <!-- Main Content -->
    <div class="welcome-section text-center py-1 mb-0">
        <h2 class="text-6xl font-bold mb-0" style="color: #1D2736;">Welcome to e-Rehistro EPH</h2>
        <p class="text-2xl text-gray-700">Please <a href="{{ route('login') }}" class="text-blue-600 hover:underline">log in</a> to continue.</p>
    </div>

    <!-- Services Section -->
    <section class="grid-container grid grid-cols-1 sm:grid-cols-2 md:grid-cols-2 lg:grid-cols-4 gap-4 p-4 mt-0">
        <div class="welcomecard bg-white shadow-lg rounded-lg overflow-hidden border-t-4" style="border-color: #1D2736;">
            <img src="{{ asset('images/annual_pe.jpg') }}" alt="Annual PE" class="w-full h-64 object-cover">
            <div class="welcomecard-body p-3">
                <h3 class="welcomecard-title text-xl font-semibold" style="color: #1D2736;">Annual PE</h3>
                <p class="welcomecard-text text-gray-700 mt-1">Comprehensive annual physical exams to ensure your health and wellbeing.</p>
            </div>
        </div>
        <div class="welcomecard bg-white shadow-lg rounded-lg overflow-hidden border-t-4" style="border-color: #1D2736;">
            <img src="{{ asset('images/laboratory.jpg') }}" alt="Laboratory" class="w-full h-64 object-cover">
            <div class="welcomecard-body p-3">
                <h3 class="welcomecard-title text-xl font-semibold" style="color: #1D2736;">Laboratory</h3>
                <p class="welcomecard-text text-gray-700 mt-1">State-of-the-art laboratory services for accurate and timely results.</p>
            </div>
        </div>
        <div class="welcomecard bg-white shadow-lg rounded-lg overflow-hidden border-t-4" style="border-color: #1D2736;">
            <img src="{{ asset('images/consultation.jpg') }}" alt="Consultation" class="w-full h-64 object-cover">
            <div class="welcomecard-body p-3">
                <h3 class="welcomecard-title text-xl font-semibold" style="color: #1D2736;">Consultation</h3>
                <p class="welcomecard-text text-gray-700 mt-1">Professional consultations with our experienced medical team.</p>
            </div>
        </div>
        <div class="welcomecard bg-white shadow-lg rounded-lg overflow-hidden border-t-4" style="border-color: #1D2736;">
            <img src="{{ asset('images/pharmacy.jpg') }}" alt="Pharmacy" class="w-full h-64 object-cover">
            <div class="welcomecard-body p-3">
                <h3 class="welcomecard-title text-xl font-semibold" style="color: #1D2736;">Pharmacy</h3>
                <p class="welcomecard-text text-gray-700 mt-1">Quality pharmaceutical services with a wide range of medications.</p>
            </div>
        </div>
    </section>
@endsection
