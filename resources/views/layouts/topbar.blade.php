<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <title>PRMIS</title>
</head>
<body>

<div class="topbar">
    <div class="prmis">
        <h2 class="logo">PRMIS</h2>
    </div>
    <div>
        <div class="user-info">
            <div class="mr-4">{{ Auth::user()->name }}</div>
            <div class="user-role">{{ Auth::user()->role->role_name }}</div>
        </div>
        <form method="POST" action="{{ route('logout') }}" class="inline">
            @csrf
            <button type="submit" onclick="return confirm('Are you sure you want to log out?')">
                {{ __('Log Out') }}
            </button>
        </form>
    </div>
    <div class="square"></div>
</div>

<script src="{{ asset('js/app.js') }}"></script>
</body>
</html>
