<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class settingsController extends Controller
{
    public function update(Request $request)
    {
        $changeUsername = $request->input('changeUsername');
        $currentPassword = $request->input('currentPassword');
        $newPassword = $request->input('newPassword');

        if ($changeUsername) {
            if (User::where('username', $changeUsername)->exists()) {
                return back()->with('error', 'Username already exists');
            }

            User::where('username', session('username'))->update(['username' => $changeUsername]);
            Transaction::where('user', session('username'))->update(['user' => $changeUsername]);

            session()->put('username', $changeUsername);

            return back()->with('success', 'Username changed successfully!');
        }

        if ($request->hasFile('changeProfilePicture')) {
            $profilePicture = $request->file('changeProfilePicture');

            // Validate file
            $request->validate([
                'changeProfilePicture' => 'image|mimes:jpeg,png,jpg,gif' // adjust max size as needed
            ]);

            // Generate unique file name
            $profilePictureName = time() . '.' . $profilePicture->getClientOriginalExtension();

            // Store file in storage/app/public/images/profilePictures
            $profilePicture->storeAs('public/images/profile-picture', $profilePictureName);

            // Update profile picture path in database
            $changeProfilePicture = 'images/profile-picture/' . $profilePictureName;
            User::where('username', session('username'))->update(['profilePicture' => $changeProfilePicture]);

            session()->put('profilePicture', $changeProfilePicture);

            return back()->with('success', 'Profile picture changed successfully!');
        }

        if ($currentPassword && $newPassword) {
            $password = User::where('username', session('username'))->first();

            if (Hash::check($currentPassword, $password->password)) {
                User::where('username', session('username'))->update(['password' => Hash::make($newPassword)]);

                return back()->with('success', 'Password changed successfully!');
            }
        }
    }
}
