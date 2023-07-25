<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Project;
use App\Models\Activity;

class TasksController extends Controller
{
    //

    public function showtasks($id)
    {
        $user = User::findOrFail($id);
        $department = $user->department;
        $projects = $user->projects;




        return view('implementer.index', ['projects' => $projects, 'department' => $department]);
    }

    public function showactivities($id)
    {
        $user = User::findOrFail($id);
        $activities = $user->activities;

        return view('implementer.activities', ['activities' => $activities]);
    }
}
