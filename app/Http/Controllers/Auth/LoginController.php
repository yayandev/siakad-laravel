<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    public function index()
    {
        return view('login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (auth()->attempt(['email' => $request->email, 'password' => $request->password])) {
            if ($request->remember === '0') {
                $request->session()->regenerate();
                return redirect('/')->with(['success' => 'Login success']);
            }

            return redirect('/')->with(['success' => 'Login success']);
        }

        return redirect('/login')->with(['error' => 'Email or password is incorrect']);
    }

    public function logout()
    {
        auth()->logout();
        return redirect('/login')->with(['success' => 'Logout success']);
    }
}
