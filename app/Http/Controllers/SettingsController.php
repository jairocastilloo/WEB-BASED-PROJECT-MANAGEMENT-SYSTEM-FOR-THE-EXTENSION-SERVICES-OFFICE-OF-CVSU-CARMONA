<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;



class SettingsController extends Controller
{
    public function configureSettings($username)
    {
        $user = User::where('username', $username)->first();
        return view("implementer.configuration", [
            "user" => $user
        ]);
    }
    public function updateUserAccount(Request $request)
    {
        try {
            $request->validate([
                'username' => 'required|string|max:255|unique:users,username,' . Auth::id(),
                'currentPassword' => 'required',
                'newPassword' => 'required|min:8|confirmed',
            ]);

            $user = User::findOrFail(Auth::id());

            // Check if the entered current password is correct
            if (!Hash::check($request->currentPassword, $user->password)) {
                throw ValidationException::withMessages(['currentPassword' => 'Incorrect current password.']);
            }

            // Update the user account
            $user->username = $request->username;
            $user->password = Hash::make($request->newPassword);
            $user->save();

            return redirect()->back()->with('success', 'User account updated successfully.');
        } catch (ValidationException $e) {
            return redirect()->back()->withErrors($e->errors());
        }
    }
}
