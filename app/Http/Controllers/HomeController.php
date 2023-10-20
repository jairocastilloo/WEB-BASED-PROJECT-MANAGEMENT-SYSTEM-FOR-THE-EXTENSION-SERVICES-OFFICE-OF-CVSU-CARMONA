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

        if ($user->email_verified_at == null) {
            return view('home');
        } elseif ($approval == 0) {
            return view('home');
        } else {
            return redirect()->route('tasks.show', ["username" => $username]);
        }
    }
}
