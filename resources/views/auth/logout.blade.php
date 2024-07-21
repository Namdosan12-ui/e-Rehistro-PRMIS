<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <title>Logout Confirmation</title>
</head>
<body>

<div class="topbar">
    <div class="prmis">
        <h2 class="logo">PRMIS</h2>
    </div>
    <div>
        <div class="mr-4">{{ Auth::user()->name }}</div>
        <form id="logout-form" method="POST" action="{{ route('logout') }}" class="inline">
            @csrf
            <button type="button" id="logout-button">
                {{ __('Log Out') }}
            </button>
        </form>
    </div>
    <div class="square"></div>
</div>

</body>
</html>
