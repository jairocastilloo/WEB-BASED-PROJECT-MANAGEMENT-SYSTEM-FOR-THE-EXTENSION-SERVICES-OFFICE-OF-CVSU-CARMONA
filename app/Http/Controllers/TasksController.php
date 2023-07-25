<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Project;
use App\Models\Activity;
use App\Models\SubtaskContributor;

class TasksController extends Controller
{
    //

    public function showtasks($username)
    {
        $user = User::where('username', $username)->firstOrFail();

        $userid = $user->id;
        $projects = $user->projects;
        $activities = $user->activities;
        $subtasks = $user->subtasks;
        $contributions = SubtaskContributor::where('user_id', $userid)
            ->get();


        return view('implementer.index', [
            'projects' => $projects,
            'activities' => $activities,
            'subtasks' => $subtasks,
            'contributions' => $contributions
        ]);
    }

    public function showactivities($username)
    {
        $user = User::where('username', $username)->firstOrFail();


        $activities = $user->activities;

        return view('implementer.activities', ['activities' => $activities]);
    }
}
