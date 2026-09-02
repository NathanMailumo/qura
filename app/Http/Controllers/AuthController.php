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
        if (Auth::check()) {
            return redirect()->route('index');
        }
        return view('user.auth.register');
    }

    public function register(Request $request)
    {
        $incomingFields = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $incomingFields['password'] = Hash::make($incomingFields['password']);

        $user = User::create($incomingFields);

        Auth::login($user);
        $request->session()->regenerate();

        return redirect()->route('index')->with('success', 'Account created successfully! Welcome to Qura.');
    }



    public function showLogin()
    {
        if (Auth::check()) {
            return redirect()->route('index');
        }
        return view('user.auth.login');
    }

    public function login(Request $request)
    {
        $incomingfields = $request->validate([
            'email' => 'required|string|max:255',
            'password' => 'required|string|min:8',
        ]);

        if (Auth::attempt($incomingfields, $request->filled('remember'))) {
            $request->session()->regenerate();
            return redirect()->intended(route('index'))->with('success', 'Signed in successfully.');
        }
        return back()->withErrors([
            'email' => 'Invalid email or password, please try again.',
        ])->onlyInput('email');
    }


    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('success', 'You have been logged out.');
    }
}
