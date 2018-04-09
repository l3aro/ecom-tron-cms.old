<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;

//Class needed for login and Logout logic
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller
{
    //Trait
    use AuthenticatesUsers;

    //Where to redirect after login
    protected $redirectTo = '/admin/dashboard';

    //Shows seller login form
    public function showLoginForm()
    {
        return view('admin.auth.login');
    }

    public function logout() {
        Auth::logout();
        session()->flush();
        return redirect()->guest('admin');
    }
}
