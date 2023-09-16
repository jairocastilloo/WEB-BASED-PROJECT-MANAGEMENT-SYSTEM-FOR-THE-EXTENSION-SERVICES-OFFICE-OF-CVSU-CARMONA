<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
<<<<<<< HEAD
=======
use Illuminate\Support\Facades\Auth;

>>>>>>> origin/main

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
<<<<<<< HEAD
        return view('home');
    }
  
=======
        $user = Auth::user();
        $approval = $user->approval;
        $username = $user->username;
        if ($approval == 1) {
            return redirect()->route('tasks.show', ["username" => $username]);
        } else {
            return view('home');
        }
    }
>>>>>>> origin/main
}
