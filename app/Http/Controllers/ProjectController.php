<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class ProjectController extends Controller
{
    //
    public function show($id)
    {
        $id = User::findOrFail($id);

        return view('project.index', ['id' => $id]);
    }

    public function getMembers()
    {
        // Retrieve all user names
        $users = User::all(['id', 'name']);

        // Pass the user names to the view
        return view('project.create')->with('members', $users);
    }
}
