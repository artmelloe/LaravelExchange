<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class AuthenticationController extends Controller
{
    public function login() :View
    {
        return view('login');
    }

    public function submitLogin(Request $request) :RedirectResponse
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials))
        {
            return Redirect::route('index');
        }

        return Redirect::route('login')->with('error', 'Your email or password is invalid!');
    }

    public function logout() :RedirectResponse {
        Session::flush();
        Auth::logout();

        return Redirect::route('login');
    }
}
