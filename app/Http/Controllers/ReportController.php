<?php

namespace App\Http\Controllers;

use App\Models\CalendarYear;
use App\Models\Notification;
use Illuminate\Http\Request;
use App\Models\Activity;
use App\Models\User;
use App\Models\Project;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class ReportController extends Controller
{
    //

    public function showinsights($department)
    {

        $users = User::where('department', $department)
            ->where('role', '!=', 'FOR APPROVAL')
            ->get(['id', 'name', 'middle_name', 'last_name', 'role']);
        $currentDate = Carbon::now();
        $currentyear = $currentDate->year;

        $currentproject = Project::where('department', $department)
            ->where('calendaryear', $currentyear)
            ->where('projectenddate', '>=', $currentDate)
            ->get();

        $pastproject = Project::where('department', $department)
            ->where('calendaryear', $currentyear)
            ->where('projectenddate', '<', $currentDate)
            ->get();

        $inCurrentYear = true;

        $calendaryears = CalendarYear::pluck('year');


        return view('report.selectinsights', [
            'members' => $users,
            'calendaryears' => $calendaryears,
            'currentproject' => $currentproject,
            'pastproject' => $pastproject,
            'inCurrentYear' => $inCurrentYear,
            'currentyear' => $currentyear,
        ]);
    }

    public function showyearinsights($department, $currentyear)
    {

        $users = User::where('department', $department)
            ->where('role', '!=', 'Admin')
            ->where('role', '!=', 'FOR APPROVAL')
            ->get(['id', 'name', 'middle_name', 'last_name', 'role']);
        $currentDate = Carbon::now();
        $otheryear = $currentDate->year;

        if ($otheryear == $currentyear) {
            $inCurrentYear = true;
        } else {
            $inCurrentYear = false;
        }

        $currentproject = Project::where('department', $department)
            ->where('calendaryear', $currentyear)
            ->where('projectenddate', '>=', $currentDate)
            ->get();
        $pastproject = Project::where('department', $department)
            ->where('calendaryear', $currentyear)
            ->where('projectenddate', '<', $currentDate)
            ->get();
        $calendaryears = CalendarYear::pluck('year');


        return view('report.selectinsights', [
            'members' => $users,
            'calendaryears' => $calendaryears,
            'currentproject' => $currentproject,
            'pastproject' => $pastproject,
            'inCurrentYear' => $inCurrentYear,
            'currentyear' => $currentyear,
        ]);
    }
    public function indexinsights($projectid, $department, $projectname)
    {

        $projects = Project::where('department', $department)->get();

        $selectedproject = Project::findOrFail($projectid);

        $activities = $selectedproject->activities;

        return view('report.indexinsights', [
            'projectid' => $projectid,
            'selectedproject' => $selectedproject,
            'projects' => $projects,
            'activities' => $activities,
        ]);
    }
}
