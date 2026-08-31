<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showRegister()
    {
        return view('user.auth.register');
    }

    public function register(Request $request)
    {
        $incomingFields = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|max:255',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $incomingFields['password'] = Hash::make($incomingFields['password']);

        User::create($incomingFields);

        return redirect()->route('index');
    }



    public function showLogin()
    {
        return view('user.auth.login');
    }

    public function login(Request $request)
    {
        $incomingfields = $request->validate([
            'email' => 'required|string|max:255',
            'password' => 'required|string|min:8',
        ]);

        if (Auth::attempt($incomingfields)) {
            $request->session()->regenerate();
            return redirect()->intended(route('index'));
        }
        return back()->withErrors([
            'email' => 'Invalid email or password, please try again.',
        ])->onlyInput('email');
    }


    public function logout(Request $request)
    {
        User::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
