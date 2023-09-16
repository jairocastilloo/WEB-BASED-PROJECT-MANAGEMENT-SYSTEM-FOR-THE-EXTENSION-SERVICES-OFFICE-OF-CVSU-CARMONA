<?php

namespace App\Http\Controllers;

<<<<<<< HEAD
=======
use App\Models\Notification;
>>>>>>> origin/main
use Illuminate\Http\Request;
use App\Models\Activity;
use App\Models\User;
use App\Models\Project;
<<<<<<< HEAD
=======
use Illuminate\Support\Facades\Auth;
>>>>>>> origin/main

class ReportController extends Controller
{
    //

    public function showinsights($department)
    {

        $projects = Project::where('department', $department)->get();
<<<<<<< HEAD
        return view('report.selectinsights', ['projects' => $projects]);
=======
        $notifications = Notification::where('user_id', Auth::user()->id)
            ->get();
        return view('report.selectinsights', [
            'projects' => $projects,
            'notifications' => $notifications,
        ]);
>>>>>>> origin/main
    }
    public function indexinsights($projectid, $department, $projectname)
    {

        $projects = Project::where('department', $department)->get();

        $selectedproject = Project::findOrFail($projectid);
        $activities = $selectedproject->activities;
<<<<<<< HEAD

        return view('report.indexinsights', ['projectid' => $projectid, 'selectedproject' => $selectedproject, 'projects' => $projects, 'activities' => $activities]);
=======
        $notifications = Notification::where('user_id', Auth::user()->id)
            ->get();
        return view('report.indexinsights', [
            'projectid' => $projectid,
            'selectedproject' => $selectedproject,
            'projects' => $projects,
            'activities' => $activities,
            'notifications' => $notifications,
        ]);
>>>>>>> origin/main
    }
}
