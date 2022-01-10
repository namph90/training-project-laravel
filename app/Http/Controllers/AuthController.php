<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    public function login()
    {
        $email = request('email');
        $password = request('password');
        Session::flash('value_old', request()->all());
        if (empty($email)||empty($password)) {
            Session::flash('login_err_blank');
            return redirect()->route('login');

        } elseif(Auth::attempt(['email' => $email, 'password' => $password])) {
            return redirect()->route('home');

        } else {
            Session::flash('login_err');
            return redirect()->route('login');
        }
    }
    public function logout()
    {
        Auth::logout();
        return redirect()->route('login');
    }
}
