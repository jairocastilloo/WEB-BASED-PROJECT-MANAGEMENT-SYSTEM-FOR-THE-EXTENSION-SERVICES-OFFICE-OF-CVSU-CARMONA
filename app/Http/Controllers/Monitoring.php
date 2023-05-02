<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Objectives;
use App\Models\Activity;
use App\Models\User;
use App\Models\Project;
use App\Models\ProjectUser;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class Monitoring extends Controller
{
    //
    public function show($id)
    {
        $user = User::findOrFail($id);
        $activities = $user->activities()->with('project', 'subtasks')->get();
        return view('project.index', ['user' => $user, 'activities' => $activities]);
    }
}
