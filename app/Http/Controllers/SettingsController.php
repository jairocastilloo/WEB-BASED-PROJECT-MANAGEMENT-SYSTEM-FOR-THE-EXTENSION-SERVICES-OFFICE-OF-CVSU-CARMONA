<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;


class SettingsController extends Controller
{
    public function configureSettings($username)
    {
        $user = User::where('username', $username)->first();
        return view("implementer.configuration", [
            "user" => $user
        ]);
    }
}
