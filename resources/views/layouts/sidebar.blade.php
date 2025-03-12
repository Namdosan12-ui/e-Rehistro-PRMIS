<div id="sidebar" class="sidebar closed fixed top-16 left-0 h-[calc(100vh-4rem)] overflow-y-auto bg-[#1D2736] z-20">
    <!-- User profile section (fixed at the top of the sidebar) -->
    <div class="flex flex-col items-center space-y-4 py-6 bg-[#1D2736] sticky top-0 z-30">
        <!-- Profile Picture -->
        <div class="relative">
            @if(Auth::user()->profile_picture)
                <img src="{{ asset('storage/' . Auth::user()->profile_picture) }}"
                     alt="Profile Picture"
                     class="w-32 h-32 rounded-full object-cover border-4 border-gray-600 shadow-lg">
            @else
                <div class="w-32 h-32 rounded-full bg-gradient-to-br from-blue-500 to-blue-600
                            flex items-center justify-center text-white text-3xl font-bold border-4 border-gray-600">
                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                </div>
            @endif
        </div>

        <!-- User Info - Centered -->
        <div class="text-center">
            <h2 class="text-white font-bold text-lg">{{ Auth::user()->name }}</h2>
            <span class="text-gray-300 text-sm">{{ Auth::user()->role->role_name }}</span>
        </div>
    </div>

    <!-- Sidebar links -->
    <nav>
        @php
            $isAdmin = Auth::user()->role->role_name === 'Admin';
            $isReception = Auth::user()->role->role_name === 'Reception';
            $isMedTech = Auth::user()->role->role_name === 'Medical Technologist';
            $isRadTech = Auth::user()->role->role_name === 'Radiologic Technologist';
            $isPhysician = Auth::user()->role->role_name === 'Physician';
        @endphp

        <!-- Links for Admin Users -->
        @if($isAdmin)
            <li>
                <a href="{{ route('admin.index') }}" class="{{ request()->routeIs('admin.index') ? 'active' : '' }}">
                    <span class="fas fa-file-medical-alt text-2xl text-white-400 mr-2"></span>
                    <span class="nav-text">{{ __('Dashboard') }}</span>
                </a>
            </li>
            <li>
                <a href="{{ route('admin.users.index') }}" class="{{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                    <span class="fas fa-users-cog text-2xl text-white-400 mr-2"></span>
                    <span class="nav-text">{{ __('Manage Users') }}</span>
                </a>
            </li>
            <li>
                <a href="{{ route('admin.patients.index') }}" class="{{ request()->routeIs('admin.patients.*') ? 'active' : '' }}">
                    <span class="fas fa-user-injured text-2xl text-white-400 mr-2"></span>
                    <span class="nav-text">{{ __('Manage Patients') }}</span>
                </a>
            </li>
            <li>
                <a href="{{ route('admin.laboratory_services.index') }}" class="{{ request()->routeIs('admin.laboratory_services.*') ? 'active' : '' }}">
                    <span class="fas fa-vials text-2xl text-white-400 mr-2"></span>
                    <span class="nav-text">{{ __('Manage Services') }}</span>
                </a>
            </li>
            <li>
                <a href="{{ route('admin.transactions.index') }}" class="{{ request()->routeIs('admin.transactions.*') ? 'active' : '' }}">
                    <span class="fas fa-file-invoice-dollar text-2xl text-white-400 mr-2"></span>
                    <span class="nav-text">{{ __('Manage Transactions') }}</span>
                </a>
            </li>
            <li>
                <a href="{{ route('admin.queues.index') }}" class="{{ request()->routeIs('admin.queues.*') ? 'active' : '' }}">
                    <span class="fas fa-list-ol text-2xl text-white-400 mr-2"></span>
                    <span class="nav-text">{{ __('Queue') }}</span>
                </a>
            </li>
            <li>
                <a href="{{ route('admin.releasings.index') }}" class="{{ request()->routeIs('admin.releasings.*') ? 'active' : '' }}">
                    <span class="fas fa-file-export text-2xl text-white-400 mr-2"></span>
                    <span class="nav-text">{{ __('Releasing') }}</span>
                </a>
            </li>
            <li>
                <a href="{{ route('admin.consultations.index') }}" class="{{ request()->routeIs('admin.consultation.*') ? 'active' : '' }}">
                    <span class="fas fa-stethoscope text-2xl text-white-400 mr-2"></span>
                    <span class="nav-text">{{ __('Consultation') }}</span>
                </a>
            </li>
        @endif

        <!-- Links for Reception Users -->
        @if($isReception)
            <li>
                <a href="{{ route('reception.index') }}" class="{{ request()->routeIs('reception.index') ? 'active' : '' }}">
                    <span class="fas fa-file-medical-alt text-2xl text-white-400 mr-2"></span>
                    <span class="nav-text">{{ __('Dashboard') }}</span>
                </a>
            </li>
            <li>
                <a href="{{ route('reception.users.index') }}" class="{{ request()->routeIs('reception.users.*') ? 'active' : '' }}">
                    <span class="fas fa-user-cog text-2xl text-white-400 mr-2"></span>
                    <span class="nav-text">{{ __('Manage Profile') }}</span>
                </a>
            </li>
            <li>
                <a href="{{ route('reception.patients.index') }}" class="{{ request()->routeIs('reception.patients.*') ? 'active' : '' }}">
                    <span class="fas fa-user-injured text-2xl text-white-400 mr-2"></span>
                    <span class="nav-text">{{ __('Manage Patients') }}</span>
                </a>
            </li>
            <li>
                <a href="{{ route('reception.laboratory_services.index') }}" class="{{ request()->routeIs('reception.laboratory_services.*') ? 'active' : '' }}">
                    <span class="fas fa-vials text-2xl text-white-400 mr-2"></span>
                    <span class="nav-text">{{ __('Manage Services') }}</span>
                </a>
            </li>
            <li>
                <a href="{{ route('reception.transactions.index') }}" class="{{ request()->routeIs('reception.transactions.*') ? 'active' : '' }}">
                    <span class="fas fa-file-invoice-dollar text-2xl text-white-400 mr-2"></span>
                    <span class="nav-text">{{ __('Manage Transactions') }}</span>
                </a>
            </li>
            <li>
                <a href="{{ route('reception.queues.index') }}" class="{{ request()->routeIs('reception.queues.*') ? 'active' : '' }}">
                    <span class="fas fa-list-ol text-2xl text-white-400 mr-2"></span>
                    <span class="nav-text">{{ __('Queue') }}</span>
                </a>
            </li>
            <li>
                <a href="{{ route('reception.releasings.index') }}" class="{{ request()->routeIs('reception.releasings.*') ? 'active' : '' }}">
                    <span class="fas fa-file-export text-2xl text-white-400 mr-2"></span>
                    <span class="nav-text">{{ __('Manage Releasing') }}</span>
                </a>
            </li>
        @endif

        <!-- Links for Medical Technologist Users -->
        @if($isMedTech)
            <li>
                <a href="{{ route('medicaltechnologist.index') }}" class="{{ request()->routeIs('medicaltechnologist.index') ? 'active' : '' }}">
                    <span class="fas fa-file-medical-alt text-2xl text-white-400 mr-2"></span>
                    <span class="nav-text">{{ __('Dashboard') }}</span>
                </a>
            </li>
            <li>
                <a href="{{ route('medicaltechnologist.users.index') }}" class="{{ request()->routeIs('medicaltechnologist.users.*') ? 'active' : '' }}">
                    <span class="fas fa-user-cog text-2xl text-white-400 mr-2"></span>
                    <span class="nav-text">{{ __('Manage Profile') }}</span>
                </a>
            </li>
            <li>
                <a href="{{ route('medicaltechnologist.patients.index') }}" class="{{ request()->routeIs('medicaltechnologist.patients.*') ? 'active' : '' }}">
                    <span class="fas fa-user-injured text-2xl text-white-400 mr-2"></span>
                    <span class="nav-text">{{ __('View Patients') }}</span>
                </a>
            </li>
            <li>
                <a href="{{ route('medicaltechnologist.laboratory_services.index') }}" class="{{ request()->routeIs('medicaltechnologist.laboratory_services.*') ? 'active' : '' }}">
                    <span class="fas fa-vials text-2xl text-white-400 mr-2"></span>
                    <span class="nav-text">{{ __('View Services') }}</span>
                </a>
            </li>
            <li>
                <a href="{{ route('medicaltechnologist.queues.index') }}" class="{{ request()->routeIs('medicaltechnologist.queues.*') ? 'active' : '' }}">
                    <span class="fas fa-list-ol text-2xl text-white-400 mr-2"></span>
                    <span class="nav-text">{{ __('Queue') }}</span>
                </a>
            </li>
            <li>
                <a href="{{ route('medicaltechnologist.releasings.index') }}" class="{{ request()->routeIs('medicaltechnologist.releasings.*') ? 'active' : '' }}">
                    <span class="fas fa-file-export text-2xl text-white-400 mr-2"></span>
                    <span class="nav-text">{{ __('Manage Releasing') }}</span>
                </a>
            </li>
        @endif

        <!-- Links for Radiologic Technologist Users -->
        @if($isRadTech)
            <li>
                <a href="{{ route('radiologictechnologist.index') }}" class="{{ request()->routeIs('radiologictechnologist.index') ? 'active' : '' }}">
                    <span class="fas fa-file-medical-alt text-2xl text-white-400 mr-2"></span>
                    <span class="nav-text">{{ __('Dashboard') }}</span>
                </a>
            </li>
            <li>
                <a href="{{ route('radiologictechnologist.users.index') }}" class="{{ request()->routeIs('radiologictechnologist.users.*') ? 'active' : '' }}">
                    <span class="fas fa-user-cog text-2xl text-white-400 mr-2"></span>
                    <span class="nav-text">{{ __('Manage Profile') }}</span>
                </a>
            </li>
            <li>
                <a href="{{ route('radiologictechnologist.patients.index') }}" class="{{ request()->routeIs('radiologictechnologist.patients.*') ? 'active' : '' }}">
                    <span class="fas fa-user-injured text-2xl text-white-400 mr-2"></span>
                    <span class="nav-text">{{ __('View Patients') }}</span>
                </a>
            </li>
            <li>
                <a href="{{ route('radiologictechnologist.laboratory_services.index') }}" class="{{ request()->routeIs('radiologictechnologist.laboratory_services.*') ? 'active' : '' }}">
                    <span class="fas fa-vials text-2xl text-white-400 mr-2"></span>
                    <span class="nav-text">{{ __('View Services') }}</span>
                </a>
            </li>
            <li>
                <a href="{{ route('radiologictechnologist.queues.index') }}" class="{{ request()->routeIs('radiologictechnologist.queues.*') ? 'active' : '' }}">
                    <span class="fas fa-list-ol text-2xl text-white-400 mr-2"></span>
                    <span class="nav-text">{{ __('Queue') }}</span>
                </a>
            </li>
            <li>
                <a href="{{ route('radiologictechnologist.releasings.index') }}" class="{{ request()->routeIs('radiologictechnologist.releasings.*') ? 'active' : '' }}">
                    <span class="fas fa-file-export text-2xl text-white-400 mr-2"></span>
                    <span class="nav-text">{{ __('Manage Releasing') }}</span>
                </a>
            </li>
        @endif

        <!-- Links for Physician Users -->
        @if($isPhysician)
            <li>
                <a href="{{ route('physician.index') }}" class="{{ request()->routeIs('physician.index') ? 'active' : '' }}">
                    <span class="fas fa-file-medical-alt text-2xl text-white-400 mr-2"></span>
                    <span class="nav-text">{{ __('Dashboard') }}</span>
                </a>
            </li>
            <li>
                <a href="{{ route('physician.users.index') }}" class="{{ request()->routeIs('physician.users.*') ? 'active' : '' }}">
                    <span class="fas fa-user-cog text-2xl text-white-400 mr-2"></span>
                    <span class="nav-text">{{ __('Manage Profile') }}</span>
                </a>
            </li>
            <li>
                <a href="{{ route('physician.patients.index') }}" class="{{ request()->routeIs('physician.patients.*') ? 'active' : '' }}">
                    <span class="fas fa-user-injured text-2xl text-white-400 mr-2"></span>
                    <span class="nav-text">{{ __('View Patients') }}</span>
                </a>
            </li>
            <li>
                <a href="{{ route('physician.laboratory_services.index') }}" class="{{ request()->routeIs('physician.laboratory_services.*') ? 'active' : '' }}">
                    <span class="fas fa-vials text-2xl text-white-400 mr-2"></span>
                    <span class="nav-text">{{ __('View Services') }}</span>
                </a>
            </li>
            <li>
                <a href="{{ route('physician.queues.index') }}" class="{{ request()->routeIs('physician.queues.*') ? 'active' : '' }}">
                    <span class="fas fa-list-ol text-2xl text-white-400 mr-2"></span>
                    <span class="nav-text">{{ __('Queue') }}</span>
                </a>
            </li>
            <li>
                <a href="{{ route('physician.consultations.index') }}" class="{{ request()->routeIs('admin.consultation.*') ? 'active' : '' }}">
                    <span class="fas fa-stethoscope text-2xl text-white-400 mr-2"></span>
                    <span class="nav-text">{{ __('Consultation') }}</span>
                </a>
            </li>
        @endif
    </nav>
</div>

<!-- Sidebar Toggle Button -->
<button id="sidebarToggle" class="sidebar-toggle-btn">☰</button>

<script src="{{ asset('js/app.js') }}"></script>
