<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function checkLogin(LoginRequest $request)
    {
        return redirect()->route('home');
    }

    public function login()
    {
        if (Auth::check()) {
            return redirect()->route('home');
        } else {
            return view("login");
        }
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('login');
    }
}
