<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    protected $redirectTo = '/dashboard';

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    // Customize authenticated method to redirect to dashboard
    protected function authenticated(Request $request, $user)
    {
        return redirect()->intended($this->redirectPath())->with('success', 'You have successfully logged in.');
    }

    // Customize logout method
    public function logout(Request $request)
    {
        $this->guard()->logout();

        $request->session()->invalidate();

        return redirect('/welcome'); // Redirect to your welcome page
    }
}
