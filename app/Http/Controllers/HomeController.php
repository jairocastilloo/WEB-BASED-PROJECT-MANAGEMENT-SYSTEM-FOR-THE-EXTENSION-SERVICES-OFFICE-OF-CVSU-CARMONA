<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $user = Auth::user();
        $approval = $user->approval;
        $username = $user->username;
        $role = $user->role;
        if ($role == "Admin") {
            return redirect()->route('admin.choosedepartment');
        }
        if ($approval == 1) {
            return redirect()->route('tasks.show', ["username" => $username]);
        } else {
            return view('home');
        }
    }
}
