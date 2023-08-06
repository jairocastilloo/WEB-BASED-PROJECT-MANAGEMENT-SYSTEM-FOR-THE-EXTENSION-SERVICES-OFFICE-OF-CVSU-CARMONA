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

        $projects = Project::where('department', $department)->get();
        return view('report.selectinsights', ['projects' => $projects]);
    }
    public function indexinsights($projectid, $department, $projectname)
    {

        $projects = Project::where('department', $department)->get();

        $selectedproject = Project::findOrFail($projectid);
        $activities = $selectedproject->activities;

        return view('report.indexinsights', ['projectid' => $projectid, 'selectedproject' => $selectedproject, 'projects' => $projects, 'activities' => $activities]);
    }
}
