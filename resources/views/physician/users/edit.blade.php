@extends('layouts.app')

@section('content')
<head>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>

<div class="card min-h-screen bg-gradient-to-br from-gray-50 to-gray-100 transition-all duration-300 ease-in-out">
    <!-- Main Card -->
    <div class="bg-white rounded-2xl shadow-xl overflow-hidden border border-gray-100">
        <!-- Header with Background -->
                <div class="relative bg-gradient-to-r from-blue-500 to-white-600 px-8 py-12 overflow-hidden">
                    <div class="absolute inset-0 bg-grid-white/[0.1] bg-[length:16px_16px]"></div>
                    <div class="absolute h-32 w-32 rounded-full bg-blue-400/20 -top-16 -left-16"></div>
                    <div class="absolute h-32 w-32 rounded-full bg-blue-400/20 -bottom-16 -right-16"></div>
                    <div class="relative flex justify-between items-center">
                        <div>
                            <h1 class="text-2xl font-bold text-white mb-2">Edit User Profile</h1>
                            <p class="text-blue-100">Update user information and settings</p>
                        </div>
                        <div class="flex space-x-4">
                            <button type="submit" form="editUserForm"
                                    class="px-6 py-3 bg-white text-blue-600 rounded-xl font-semibold shadow-lg hover:shadow-xl transition-all duration-200 flex items-center space-x-2">
                                <i class="fas fa-save"></i>
                                <span>Update Profile</span>
                            </button>
                            <a href="{{ route('physician.users.index') }}"
                               class="px-6 py-3 bg-blue-400/40 text-blue rounded-xl font-semibold hover:bg-blue-400/40 transition-all duration-200 flex items-center space-x-2">
                                <i class="fas fa-times"></i>
                                <span>Cancel</span>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Form Content -->
                <form id="editUserForm" action="{{ route('physician.users.update', $user->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="p-8">
                        <div class="grid grid-cols-12 gap-8">
                            <!-- Left Column -->
                            <div class="col-span-12 lg:col-span-4">
                                <!-- Profile Card -->
                                <div class="bg-gray-50 rounded-2xl p-6 border border-gray-100">
                                    <div class="flex flex-col items-center">
                                        @if ($user->profile_picture)
                                            <div class="relative group">
                                                <img src="{{ asset('storage/' . $user->profile_picture) }}"
                                                     alt="Profile Picture"
                                                     class="w-40 h-40 rounded-2xl object-cover ring-4 ring-white shadow-lg">
                                                <div class="absolute inset-0 bg-black/50 rounded-2xl opacity-0 group-hover:opacity-100 transition-opacity duration-200 flex items-center justify-center">
                                                    <span class="text-white text-sm">Change Photo</span>
                                                </div>
                                            </div>
                                        @else
                                            <div class="w-40 h-40 rounded-2xl bg-gradient-to-br from-gray-100 to-gray-200 flex items-center justify-center shadow-lg">
                                                <i class="fas fa-user text-gray-400 text-4xl"></i>
                                            </div>
                                        @endif
                                        <input type="file"
                                               name="profile_picture"
                                               id="profile_picture"
                                               class="mt-6 block w-full text-sm text-gray-600 file:mr-4 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:font-medium file:bg-blue-50 file:text-blue-600 hover:file:bg-blue-100">
                                    </div>

                                    <div class="mt-8 space-y-6">
                                        <div>
                                            <label class="text-sm font-medium text-gray-600">Account Status</label>
                                            <div class="mt-2 flex items-center space-x-2 bg-emerald-50 text-emerald-600 px-4 py-2 rounded-xl">
                                                <i class="fas fa-check-circle"></i>
                                                <span class="text-sm font-medium">Active</span>
                                            </div>
                                        </div>
                                        <div>
                                            <label class="text-sm font-medium text-gray-600">Member Since</label>
                                            <div class="mt-2 text-sm text-gray-600">
                                                {{ $user->created_at->format('F d, Y') }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Right Column -->
                            <div class="col-span-12 lg:col-span-8 space-y-8">
                                <!-- Personal Information -->
                                <div class="bg-gray-50 rounded-2xl p-6 border border-gray-100">
                                    <h2 class="text-lg font-semibold text-gray-900 mb-6">Personal Information</h2>
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                        <div class="space-y-2">
                                            <label for="name" class="block text-sm font-medium text-gray-700">Full Name</label>
                                            <input type="text"
                                                   name="name"
                                                   id="name"
                                                   value="{{ $user->name }}"
                                                   required
                                                   class="w-full px-4 py-2.5 rounded-xl border-gray-300 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200">
                                        </div>

                                        <div class="space-y-2">
                                            <label for="email" class="block text-sm font-medium text-gray-700">Email Address</label>
                                            <input type="email"
                                                   name="email"
                                                   id="email"
                                                   value="{{ $user->email }}"
                                                   required
                                                   class="w-full px-4 py-2.5 rounded-xl border-gray-300 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200">
                                        </div>

                                        <div class="space-y-2">
                                            <label for="role_id" class="block text-sm font-medium text-gray-700">Role</label>
                                            <select name="role_id"
                                                    id="role_id"
                                                    required
                                                    class="w-full px-4 py-2.5 rounded-xl border-gray-300 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200">
                                                @foreach($roles as $role)
                                                    <option value="{{ $role->id }}" {{ $user->role_id == $role->id ? 'selected' : '' }}>
                                                        {{ $role->role_name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="space-y-2">
                                            <label for="birthday" class="block text-sm font-medium text-gray-700">Birthday</label>
                                            <input type="date"
                                                   name="birthday"
                                                   id="birthday"
                                                   value="{{ old('birthday', $user->birthday ? $user->birthday->format('Y-m-d') : '') }}"
                                                   class="w-full px-4 py-2.5 rounded-xl border-gray-300 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200">
                                        </div>
                                    </div>
                                </div>

                                <!-- Professional Information -->
                                <div class="bg-gray-50 rounded-2xl p-6 border border-gray-100">
                                    <h2 class="text-lg font-semibold text-gray-900 mb-6">Professional Details</h2>
                                    <div class="space-y-2">
                                        <label for="license_no" class="block text-sm font-medium text-gray-700">License Number</label>
                                        <input type="text"
                                               name="license_no"
                                               id="license_no"
                                               value="{{ $user->license_no ?? old('license_no') }}"
                                               placeholder="Current: {{ $user->license_no ?: 'No license number set' }}"
                                               class="w-full px-4 py-2.5 rounded-xl border-gray-300 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200">
                                    </div>
                                </div>

                                <!-- Security Information -->
                                <div class="bg-gray-50 rounded-2xl p-6 border border-gray-100">
                                    <h2 class="text-lg font-semibold text-gray-900 mb-6">Security</h2>
                                    <div class="space-y-2">
                                        <label for="password" class="block text-sm font-medium text-gray-700">
                                            New Password
                                            <span class="text-gray-500 font-normal">(Leave blank to keep current password)</span>
                                        </label>
                                        <input type="password"
                                               name="password"
                                               id="password"
                                               class="w-full px-4 py-2.5 rounded-xl border-gray-300 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
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
