@extends('layouts.app')

@section('content')
<head>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>

<style>
    .bg-grid-white {
        background-image: linear-gradient(to right, rgba(255,255,255,0.1) 1px, transparent 1px),
                          linear-gradient(to bottom, rgba(255,255,255,0.1) 1px, transparent 1px);
    }

    .card {
        position: relative;
        width: 1450px;
        right: 75px;
        height: 600px;
        margin-top: 45px;
        transition: width 0.3s ease, right 0.3s ease, transform 0.3s ease;
        padding: 20px;
        border: 1px solid #ddd;
        border-radius: 8px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        background-color: #fff;
        color: #333;
    }

    </style>

<div class="card">
    <!-- Main Card -->
    <div class="bg-white rounded-2xl shadow-xl overflow-hidden border border-gray-100">
                <!-- Profile Header Card -->
                <div class="relative bg-gradient-to-r from-blue-500 to-white-600 px-8 py-12 overflow-hidden">
                    <div class="absolute inset-0 bg-grid-white/[0.1] bg-[length:16px_16px]"></div>
                    <div class="absolute h-32 w-32 rounded-full bg-blue-400/20 -top-16 -left-16"></div>
                    <div class="absolute h-32 w-32 rounded-full bg-blue-400/20 -bottom-16 -right-16"></div>
                    <div class="relative flex justify-between items-center">
                        <div class="flex items-center space-x-4">
                            @if (auth()->user()->profile_picture)
                                <img src="{{ asset('storage/' . auth()->user()->profile_picture) }}"
                                     alt="Profile Picture"
                                     class="w-16 h-16 rounded-full object-cover ring-4 ring-gray-50">
                            @else
                                <div class="w-16 h-16 rounded-full bg-gradient-to-r from-blue-500 to-indigo-500 flex items-center justify-center text-white text-2xl font-bold ring-4 ring-gray-50">
                                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                                </div>
                            @endif
                            <div>
                                <h1 class="text-2xl font-bold text-gray-900">{{ auth()->user()->name }}</h1>
                                <div class="flex items-center mt-1 space-x-2">
                                    <span class="px-3 py-1 text-sm font-medium text-blue-600 bg-blue-50 rounded-full">
                                        {{ auth()->user()->role->role_name }}
                                    </span>
                                    <span class="text-sm text-black-500">
                                        {{ auth()->user()->email }}
                                    </span>
                                </div>
                            </div>
                        </div>
                        <a href="{{ route('radiologictechnologist.users.edit', auth()->user()->id) }}"
                           class="inline-flex items-center px-4 py-2 bg-white border border-gray-200 rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-50 transition-colors duration-150 ease-in-out shadow-sm hover:shadow">
                            <i class="fas fa-edit mr-2 text-gray-500"></i>
                            {{ __('Edit Profile') }}
                        </a>

                    </div>
                </div>


                <!-- Information Grid -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mt-5">
                    <!-- Personal Information -->
                    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                        <h2 class="text-lg font-semibold text-gray-900 mb-4">Personal Information</h2>
                        <div class="space-y-10">
                            <div>
                                <label class="text-sm font-medium text-gray-500">Full Name</label>
                                <div class="mt-1 text-gray-900 font-medium">
                                    {{ auth()->user()->name }}
                                </div>
                            </div>
                            <div>
                                <label class="text-sm font-medium text-gray-500">Email Address</label>
                                <div class="mt-1 text-gray-900 font-medium">
                                    {{ auth()->user()->email }}
                                </div>
                            </div>
                            <div>
                                <label class="text-sm font-medium text-gray-500">Role</label>
                                <div class="mt-1">
                                    <span class="inline-flex px-2.5 py-1 text-sm font-medium text-blue-600 bg-blue-50 rounded-full">
                                        {{ auth()->user()->role->role_name }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Additional Information -->
                    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                        <h2 class="text-lg font-semibold text-gray-900 mb-4">Account Details</h2>
                        <div class="space-y-4">
                            <div>
                                <label class="text-sm font-medium text-gray-500">Birthday</label>
                                <div class="mt-1 text-gray-900 font-medium">
                                    {{ auth()->user()->birthday ? date('F d, Y', strtotime(auth()->user()->birthday)) : 'Not provided' }}
                                </div>
                            </div>
                            <div>
                                <label class="text-sm font-medium text-gray-500">Account Created</label>
                                <div class="mt-1 text-gray-900 font-medium">
                                    {{ auth()->user()->created_at->format('F d, Y h:i A') }}
                                </div>
                            </div>
                            <div>
                                <label class="text-sm font-medium text-gray-500">Last Updated</label>
                                <div class="mt-1 text-gray-900 font-medium">
                                    {{ auth()->user()->updated_at->format('F d, Y h:i A') }}
                                </div>
                            </div>
                        </div>
                    </div>



                    <!-- License Information -->
                    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                        <h2 class="text-sm font-semibold text-gray-900 mb-4 uppercase tracking-wider">License Information</h2>
                        <div class="space-y-3">
                            <div>
                                <label class="text-sm font-medium text-gray-500">License Number</label>
                                <div class="mt-1 text-lg font-semibold text-gray-900">
                                    {{ auth()->user()->license_no ?? 'Not provided' }}
                                </div>
                            </div>

                        </div>
                    </div>
                    </div>
                </div>
            </div>

            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    const sidebar = document.getElementById('sidebar');
                    const mainContent = document.querySelector('.min-h-screen');

                    // Initial state
                    mainContent.classList.toggle('pl-64', !sidebar.classList.contains('closed'));

                    // Create a MutationObserver to watch for changes in sidebar's classes
                    const observer = new MutationObserver(function(mutations) {
                        mutations.forEach(function(mutation) {
                            if (mutation.attributeName === 'class') {
                                mainContent.classList.toggle('pl-64', !sidebar.classList.contains('closed'));
                            }
                        });
                    });

                    // Start observing the sidebar for attribute changes
                    observer.observe(sidebar, {
                        attributes: true
                    });
                });
                </script>

                @endsection

