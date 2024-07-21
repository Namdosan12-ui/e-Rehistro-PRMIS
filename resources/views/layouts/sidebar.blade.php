<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>

    @include('layouts.topbar')

    <div id="sidebar" class="sidebar closed">
        <nav>
            <li>
                <a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">
                    <span class="icon"></span>
                    <span class="nav-text">{{ __('Dashboard') }}</span>
                </a>
            </li>
            <li>
                <a href="{{ route('users.index') }}" class="{{ request()->routeIs('users.*') ? 'active' : '' }}">
                    <span class="icon"></span>
                    <span class="nav-text">{{ __('Manage Users') }}</span>
                </a>
            </li>
            <li>
                <a href="{{ route('patients.index') }}" class="{{ request()->routeIs('patients.*') ? 'active' : '' }}">
                    <span class="icon"></span>
                    <span class="nav-text">{{ __('Manage Patients') }}</span>
                </a>
            </li>
            <li>
                <a href="{{ route('laboratory_services.index') }}" class="{{ request()->routeIs('laboratory_services.*') ? 'active' : '' }}">
                    <span class="icon"></span>
                    <span class="nav-text">{{ __('Manage Services') }}</span>
                </a>
            </li>
            <li>
                <a href="{{ route('transactions.index') }}" class="{{ request()->routeIs('transactions.*') ? 'active' : '' }}">
                    <span class="icon"></span>
                    <span class="nav-text">{{ __('Manage Transactions') }}</span>
                </a>
            </li>
            <li>
                <a href="{{ route('queue.index') }}" class="{{ request()->routeIs('queue.*') ? 'active' : '' }}">
                    <span class="icon"></span>
                    <span class="nav-text">{{ __('Queue') }}</span>
                </a>
            </li>
            <li>
                <a href="{{ route('releasings.index') }}" class="{{ request()->routeIs('releasings.*') ? 'active' : '' }}">
                    <span class="icon"></span>
                    <span class="nav-text">{{ __('Releasing') }}</span>
                </a>
            </li>
        </nav>
    </div>
    <button id="sidebarToggle" class="sidebar-toggle-btn">☰</button>

    <script src="{{ asset('js/app.js') }}"></script>
</body>
</html>
