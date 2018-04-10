<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use App\Http\Controllers\Controller;

use Illuminate\Foundation\Auth\SendsPasswordResetEmails;

class ForgotPasswordController extends Controller
{
    use SendsPasswordResetEmails;

    /**
     * Shows form to request password reset
     * 
     * @return \Response
     */
    public function showLinkRequestForm()
    {
        return view('admin.password.email');
    }

    /**
     * Password Broker for Admin
     * 
     * @return \Password::broker
     */
    public function broker()
    {
        return Password::broker('admins');
    }
}