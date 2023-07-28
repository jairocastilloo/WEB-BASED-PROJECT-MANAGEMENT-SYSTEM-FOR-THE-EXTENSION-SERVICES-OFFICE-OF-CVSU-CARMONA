<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Activity;
use App\Models\User;
use App\Models\Project;

class ReportController extends Controller
{
    //

    public function showinsights($department)
    {
        $user = User::where('department', $department)->firstOrFail();
        $projects = $user->projects;
        return view('report.selectinsights', ['projects' => $projects]);
    }
    public function indexinsights($projectid, $department, $projectname)
    {
        $user = User::where('department', $department)->firstOrFail();
        $projects = $user->projects;

        $selectedproject = Project::findOrFail($projectid);
        $activities = $selectedproject->activities;

        return view('report.indexinsights', ['projectid' => $projectid, 'selectedproject' => $selectedproject, 'projects' => $projects, 'activities' => $activities]);
    }
}
