<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">

    <div class="topbar">

        <div class="title-container absolute top-4 left-8">
            <h1 class="text-2xl text-white font-bold tracking-[3px]">e-Rehistro</h1>
        </div>

        <div class="profile-card">
            <div class="profile-image-container">
                @if(Auth::user()->profile_picture)
                    <img
                        src="{{ asset('storage/' . Auth::user()->profile_picture) }}"
                        alt="Profile"
                        class="profile-image"
                    >
                @else
                    <div class="profile-image-fallback">
                        {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                    </div>
                @endif
                <div class="status-indicator"></div>
            </div>

            <div class="profile-info">
                <h3 class="profile-name">{{ Auth::user()->name }}</h3>
                <span class="profile-role">{{ Auth::user()->role->role_name }}</span>
            </div>

            <form method="POST" action="{{ route('logout') }}" class="logout-form">
                @csrf
                <button type="submit" class="logout-btn" onclick="return confirm('Are you sure you want to log out?')">
                    <svg class="logout-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                    </svg>
                    Log Out
                </button>
            </form>
        </div>
    </div>

    <style>
    .topbar {
        position: fixed;
        top: 0;
        right: 0;
        left: 0;
        height: 64px;
        background-color: #1e1e2d;
        border-bottom: 1px solid #2b2b40;
        display: flex;
        align-items: center;
        justify-content: flex-end;
        padding: 0 24px;
        z-index: 50;
    }

    .profile-card {
        position: fixed;
        display: flex;
        align-items: center;
        gap: 16px;
        padding: 8px 16px;
        background-color: #1b1b29;
        border: 1px solid #435464;
        border-radius: 8px;
        transition: all 0.2s ease;
        right: 3px;
    }

    .profile-image-container {
        position: relative;
        flex-shrink: 0;
    }

    .profile-image, .profile-image-fallback {
        width: 38px;
        height: 38px;
        border-radius: 50%;
    }

    .profile-image-fallback {
        display: flex;
        align-items: center;
        justify-content: center;
        background: linear-gradient(135deg, #3699ff 0%, #2284f7 100%);
        color: white;
        font-weight: 600;
        font-size: 16px;
    }

    .status-indicator {
        position: absolute;
        bottom: 0;
        right: 0;
        width: 10px;
        height: 10px;
        border-radius: 50%;
        background-color: #0bb783;
        border: 2px solid #1e1e2d;
    }

    .profile-info {
        min-width: 0;
    }

    .profile-name {
        font-size: 14px;
        font-weight: 500;
        color: #ffffff;
        margin: 0;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .profile-role {
        font-size: 12px;
        color: #92929f;
    }

    .logout-form {
        margin-left: 8px;
    }

    .logout-btn {
        display: flex;
        align-items: center;
        gap: 8px;
        padding: 8px 12px;
        background-color: rgba(241, 65, 108, 0.1);
        color: #f1416c;
        border: none;
        border-radius: 6px;
        font-size: 13px;
        font-weight: 500;
        cursor: pointer;
        transition: all 0.2s ease;
    }

    .logout-btn:hover {
        background-color: rgba(241, 65, 108, 0.2);
    }

    .logout-icon {
        width: 16px;
        height: 16px;
    }
    </style>
