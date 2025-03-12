<x-guest-layout>
    <div class="flex w-full h-screen">
        <!-- Left Column: Branding / Welcome -->
        <div class="w-1/2 flex flex-col items-center justify-center bg-[#1D2736] text-white p-12">
            <div class="text-center">
                <img src="{{ asset('images/logo.png') }}" alt="Logo" class="w-40 h-40 mb-6 mx-auto rounded-full object-cover">
                <h1 class="text-4xl font-bold">
                    Welcome Back to <span class="italic font-extrabold">e-Rehistro</span>
                </h1>
                <p class="mt-3 text-lg opacity-90">Sign in to continue managing your account.</p>
            </div>
        </div>

        <!-- Right Column: Login Form -->
        <div class="w-1/2 flex items-center justify-center p-10 bg-gray-100">
            <div class="w-full max-w-md bg-white shadow-lg rounded-lg p-8">
                <x-auth-session-status class="mb-4" :status="session('status')" />

                <h2 class="text-3xl font-bold text-gray-700 text-center">Login</h2>
                <p class="text-gray-500 text-center mb-6">Enter your credentials to access your account.</p>

                <form method="POST" action="{{ route('login') }}" class="space-y-5">
                    @csrf

                    <!-- Email Address -->
                    <div class="relative">
                        <span class="absolute inset-y-0 left-3 flex items-center text-gray-400">
                            <i class="fas fa-user"></i>
                        </span>
                        <x-text-input id="email"
                            class="w-full pl-10 py-2 rounded-lg bg-gray-200 border border-gray-300 focus:ring-2 focus:ring-[#1D2736] focus:border-[#1D2736]"
                            type="email" name="email" :value="old('email')" required autofocus autocomplete="username" placeholder="Username" />
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>

                    <!-- Password -->
                    <div class="relative">
                        <span class="absolute inset-y-0 left-3 flex items-center text-gray-400">
                            <i class="fas fa-lock"></i>
                        </span>
                        <x-text-input id="password"
                            class="w-full pl-10 py-2 rounded-lg bg-gray-200 border border-gray-300 focus:ring-2 focus:ring-[#1D2736] focus:border-[#1D2736]"
                            type="password" name="password" required autocomplete="current-password" placeholder="Password" />
                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                    </div>

                    <!-- Submit Button -->
                    <div>
                        <button type="submit"
                            class="w-full bg-[#1D2736] text-white py-3 rounded-lg hover:bg-[#131B27] transition shadow-md">
                            LOGIN
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</x-guest-layout>
