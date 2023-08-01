<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class RecordController extends Controller
{
    //
    public function showrecords($username)
    {
        $user = User::where('username', $username)->firstOrFail();

        return view('records.index');
    }
}
