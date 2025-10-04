<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;

class addUserController extends Controller
{
    public function register(Request $request)
    {
        $request->validate([
            'username' => 'required|string|max:255|unique:users',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:6',
            'reenterPassword' => 'required|string|same:password',
        ]);

        $user = User::create([
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'is_verified' => false,
            'verification_code' => rand(100000, 999999),
            'code_expires_at' => Carbon::now()->addHour(),
        ]);

        // Send email
        Mail::raw("Your verification code is: {$user->verification_code}", function ($msg) use ($user) {
            $msg->to($user->email)->subject('Email Verification Code');
        });

        session(['email' => $user->email]);

        return redirect()->route('register.verify')->with('success', 'A verification code was sent to your email.');
    }

    public function verify(Request $request)
    {
        $request->validate([
            'code' => 'required|digits:6',
        ]);

        $user = User::where('verification_code', $request->code)
            ->where('code_expires_at', '>', now())
            ->first();

        if (!$user) {
            return back()->with('error', 'Invalid or expired code.');
        }

        $user->is_verified = true;
        $user->email_verified_at = now();
        $user->verification_code = null;
        $user->code_expires_at = null;
        $user->save();

        return redirect('/login')->with('success', 'Email verified successfully! You can now log in.');
    }

    public function resend(Request $request)
    {
        $email = $request->email ?? session('email');
        $user = User::where('email', $email)->first();

        if (!$user) {
            return back()->with('error', 'User not found.');
        }

        if ($user->is_verified) {
            return back()->with('success', 'Your email is already verified.');
        }

        $user->verification_code = rand(100000, 999999);
        $user->code_expires_at = now()->addHour();
        $user->save();

        Mail::raw("Your new verification code is: {$user->verification_code}", function ($msg) use ($user) {
            $msg->to($user->email)->subject('Resent Verification Code');
        });

        return back()->with('success', 'A new code has been sent to your email.');
    }
}
