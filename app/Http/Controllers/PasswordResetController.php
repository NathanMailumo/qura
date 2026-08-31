<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PasswordReset;
use App\Mail\SendOtpMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class PasswordResetController extends Controller
{
    // 1. Show Forgot Password Email Form
    public function showReset()
    {
        return view('user.auth.reset'); // Ensure this matches your forgot-password filename
    }

    // 2. Handle Sending OTP
    public function sendOtp(Request $request)
    {
        $validate_email = $request->validate([
            'email' => 'required|email|string|exists:users,email',
        ], [
            'email.exists' => 'Invalid email address',
        ]);

        $otp = random_int(100000, 999999);

        PasswordReset::updateOrCreate(
            ['email' => $validate_email['email']],
            [
                'token'      => Hash::make($otp),
                'expires_at' => now()->addMinutes(15),
                'created_at' => now(),
            ]
        );

        Mail::to($validate_email['email'])->send(new SendOtpMail($otp));

        return redirect()
            ->route('verify')
            ->with('reset_email', $validate_email['email']);
    }

    // 3. Show OTP Verification Form
    public function showVerify()
    {
        if (! session('reset_email')) {
            return redirect()->route('password.reset');
        }

        session()->reflash(); // Keeps reset_email in session for the POST submit

        return view('user.auth.verify');
    }

    // 4. Verify OTP Code
    public function verifyOtp(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
            'otp'   => 'required|string|size:6',
        ]);

        $record = PasswordReset::where('email', $request->email)->first();

        if (! $record || ! Hash::check($request->otp, $record->token) || now()->greaterThan($record->expires_at)) {
            session()->flash('reset_email', $request->email); // Keep email on error
            return back()->withErrors(['otp' => 'Invalid or expired verification code.'])->withInput();
        }

        return redirect()->route('password.reset.show')->with('reset_email', $request->email);
    }

    // 5. Show New Password Form
    public function showResetForm()
    {
        if (! session('reset_email')) {
            return redirect()->route('password.reset');
        }

        session()->reflash();

        return view('user.auth.reset-form'); // Adjust filename if named reset-password.blade.php
    }

    // 6. Save New Password
    public function updatePassword(Request $request)
    {
        $request->validate([
            'email'    => 'required|email|exists:users,email',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = User::where('email', $request->email)->first();
        $user->update([
            'password' => Hash::make($request->password),
        ]);

        PasswordReset::where('email', $request->email)->delete();

        return redirect()->route('login')->with('status', 'Password reset successfully! Please log in.');
    }
}