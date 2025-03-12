<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class MedicalTechnologistMiddleware
{
    public function handle($request, Closure $next)
    {
        if (Auth::check() && Auth::user()->role->role_name === 'Medical Technologist') {
            return $next($request);
        }

        return redirect('/')->with('error', 'Unauthorized access');
    }
}
