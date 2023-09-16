<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\Request;
use App\Models\Activity;
use App\Models\User;
use App\Models\Project;
use Illuminate\Support\Facades\Auth;

class ReportController extends Controller
{
    //

    public function showinsights($department)
    {

        $projects = Project::where('department', $department)->get();
        $notifications = Notification::where('user_id', Auth::user()->id)
            ->get();
        return view('report.selectinsights', [
            'projects' => $projects,
            'notifications' => $notifications,
        ]);
    }
    public function indexinsights($projectid, $department, $projectname)
    {

        $projects = Project::where('department', $department)->get();

        $selectedproject = Project::findOrFail($projectid);
        $activities = $selectedproject->activities;
        $notifications = Notification::where('user_id', Auth::user()->id)
            ->get();
        return view('report.indexinsights', [
            'projectid' => $projectid,
            'selectedproject' => $selectedproject,
            'projects' => $projects,
            'activities' => $activities,
            'notifications' => $notifications,
        ]);
    }
}
