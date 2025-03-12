@extends('layouts.app')

@section('content')
<head>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>

<div class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-100 transition-all duration-300 ease-in-out"
     :class="{ 'pl-64': !document.getElementById('sidebar').classList.contains('closed'), 'pl-0': document.getElementById('sidebar').classList.contains('closed') }">

    <!-- Main Content Area -->
    <div class="pt-28">
        <div class="container mx-auto px-4 pb-8">
  <!-- Main Card -->
<div class="bg-white rounded-2xl shadow-xl overflow-hidden border border-gray-100">
    <!-- Header with Minimal Padding -->
    <div class="relative bg-gradient-to-r from-gray-800 to-gray-900 px-6 py-3 overflow-hidden">
        <div class="absolute inset-0 bg-grid-white/[0.1] bg-[length:16px_16px]"></div>
        <div class="absolute h-20 w-24 rounded-full bg-gray-700/20 -top-12 -left-12"></div>
        <div class="absolute h-24 w-24 rounded-full bg-gray-700/20 -bottom-12 -right-12"></div>
        <div class="relative flex justify-between items-center">
            <div class="flex items-center space-x-4">
                <i class="fas fa-user text-2xl text-white"></i>
                <div>
                    <h2 class="text-xl font-semibold text-white">{{ __('Create New User') }}</h2>
                    <p class="text-sm text-gray-300 mt-0.5">Add a new user to the system</p>
                </div>
            </div>
            <!-- Quick Actions -->
            <div class="flex space-x-4">
                <button type="submit" form="createUserForm"
                        class="px-4 py-2 bg-white text-gray-800 rounded-lg font-medium shadow hover:shadow-lg transition-all duration-200 flex items-center space-x-2">
                    <i class="fas fa-user-plus"></i>
                    <span>Create User</span>
                </button>
                <a href="{{ route('admin.users.index') }}"
                   class="px-4 py-2 bg-gray-700/25 text-white rounded-lg font-medium hover:bg-gray-700/40 transition-all duration-200 flex items-center space-x-2">
                    <i class="fas fa-times"></i>
                    <span>Cancel</span>
                </a>
            </div>
        </div>
    </div>

<!-- [Rest of the form content remains the same] -->
                <!-- Form Content -->
                <div class="p-8">
                    <form id="createUserForm" action="{{ route('admin.users.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="grid grid-cols-12 gap-8">
                            <!-- Left Column - Basic Information -->
                            <div class="col-span-12 lg:col-span-6">
                                <div class="bg-gray-50 rounded-2xl p-6 border border-gray-100">
                                    <h3 class="text-lg font-semibold text-gray-900 mb-6">Basic Information</h3>

                                    <!-- Name Field -->
                                    <div class="space-y-2 mb-6">
                                        <label for="name" class="block text-sm font-medium text-gray-700">
                                            {{ __('Full Name') }} <span class="text-red-500">*</span>
                                        </label>
                                        <div class="mt-1 relative rounded-xl shadow-sm">
                                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                                <i class="far fa-user text-gray-400"></i>
                                            </div>
                                            <input type="text"
                                                   name="name"
                                                   id="name"
                                                   required
                                                   class="pl-10 w-full px-4 py-3 rounded-xl border-gray-300 focus:ring-gray-500 focus:border-gray-500 transition-colors duration-200"
                                                   placeholder="Enter user's full name">
                                        </div>
                                    </div>

                                    <!-- Email Field -->
                                    <div class="space-y-2 mb-6">
                                        <label for="email" class="block text-sm font-medium text-gray-700">
                                            {{ __('Email Address') }} <span class="text-red-500">*</span>
                                        </label>
                                        <div class="mt-1 relative rounded-xl shadow-sm">
                                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                                <i class="far fa-envelope text-gray-400"></i>
                                            </div>
                                            <input type="email"
                                                   name="email"
                                                   id="email"
                                                   required
                                                   class="pl-10 w-full px-4 py-3 rounded-xl border-gray-300 focus:ring-gray-500 focus:border-gray-500 transition-colors duration-200"
                                                   placeholder="user@example.com">
                                        </div>
                                    </div>

                                    <!-- Role Field -->
                                    <div class="space-y-2">
                                        <label for="role_id" class="block text-sm font-medium text-gray-700">
                                            {{ __('User Role') }} <span class="text-red-500">*</span>
                                        </label>
                                        <div class="mt-1 relative rounded-xl shadow-sm">
                                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                                <i class="fas fa-user-tag text-gray-400"></i>
                                            </div>
                                            <select name="role_id"
                                                    id="role_id"
                                                    required
                                                    class="pl-10 w-full px-4 py-3 rounded-xl border-gray-300 focus:ring-gray-500 focus:border-gray-500 transition-colors duration-200">
                                                <option value="" selected disabled>{{ __('Select Role') }}</option>
                                                @foreach ($roles as $role)
                                                    <option value="{{ $role->id }}">{{ $role->role_name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Right Column - Security Information -->
                            <div class="col-span-12 lg:col-span-6">
                                <div class="bg-gray-50 rounded-2xl p-6 border border-gray-100">
                                    <h3 class="text-lg font-semibold text-gray-900 mb-6">Security Information</h3>

                                    <!-- Password Field -->
                                    <div class="space-y-2 mb-6">
                                        <label for="password" class="block text-sm font-medium text-gray-700">
                                            {{ __('Password') }} <span class="text-red-500">*</span>
                                        </label>
                                        <div class="mt-1 relative rounded-xl shadow-sm">
                                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                                <i class="fas fa-lock text-gray-400"></i>
                                            </div>
                                            <input type="password"
                                                   name="password"
                                                   id="password"
                                                   required
                                                   class="pl-10 w-full px-4 py-3 rounded-xl border-gray-300 focus:ring-gray-500 focus:border-gray-500 transition-colors duration-200"
                                                   placeholder="Enter strong password">
                                        </div>
                                        <p class="text-sm text-gray-500 mt-2">
                                            Password must be at least 8 characters long and include uppercase, lowercase, numbers, and special characters.
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Error Messages -->
                        @if ($errors->any())
                            <div class="bg-red-50 border border-red-200 rounded-xl p-4 mt-6">
                                <h4 class="text-sm font-medium text-red-800 mb-2">Please correct the following errors:</h4>
                                <ul class="list-disc pl-5 space-y-1">
                                    @foreach ($errors->all() as $error)
                                        <li class="text-sm text-red-600">{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.bg-grid-white {
    background-image: linear-gradient(to right, rgba(255,255,255,0.1) 1px, transparent 1px),
                      linear-gradient(to bottom, rgba(255,255,255,0.1) 1px, transparent 1px);
}
</style>

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
