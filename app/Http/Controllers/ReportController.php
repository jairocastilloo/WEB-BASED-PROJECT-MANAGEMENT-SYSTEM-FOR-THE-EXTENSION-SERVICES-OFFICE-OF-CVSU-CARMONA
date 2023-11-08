<?php

namespace App\Http\Controllers;

use App\Models\CalendarYear;
use App\Models\Notification;
use App\Models\Output;
use App\Models\Subtask;
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
        if (Auth::user()->role == "Admin") {
            $alldepartments = ['Department of Management', 'Department of Industrial and Information Technology', 'Department of Teacher Education', 'Department of Arts and Science', 'All'];
        } else {
            $alldepartments = [Auth::user()->department, 'All'];
        }


        // Retrieve projects based on department and calendar year
        $projects = Project::where('department', $department)
            ->get(['id', 'projecttitle', 'projectstartdate', 'projectenddate', 'projectstatus']);


        // Extract project IDs and convert them to an array
        $projectIds = $projects->pluck('id')->toArray();
        $activities = Activity::whereIn('project_id', $projectIds)
            ->get(['id', 'project_id', 'actremark', 'totalhours_rendered']);

        $activityHoursRendered = $activities->sum('totalhours_rendered');

        $completedActivities = $activities->where('actremark', 'Completed')->count();
        $incompleteActivities = $activities->whereIn('actremark', ['Incomplete'])->count();
        $activityIds = $activities->pluck('id')->toArray();
        $subtaskHoursRendered = Subtask::whereIn('activity_id', $activityIds)->sum('hours_rendered');

        $outputs = Output::whereIn('activity_id', $activityIds)
            ->get(['activity_id', 'expectedoutput', 'totaloutput_submitted']);


        return view('report.selectinsights', [
            'department' => $department,
            'alldepartments' => $alldepartments,
            'projects' => $projects,
            'activityHoursRendered' => $activityHoursRendered,
            'completedActivities' => $completedActivities,
            'incompleteActivities' => $incompleteActivities,
            'subtaskHoursRendered' => $subtaskHoursRendered,
            'activities' => $activities,
            'outputs' => $outputs
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

        $projects = Project::where('department', $department)
            ->where('calendaryear', $currentyear)
            ->get();

        if ($otheryear == $currentyear) {
            $inCurrentYear = true;
        } else {
            $inCurrentYear = false;
        }

        $calendaryears = CalendarYear::pluck('year');


        // Extract project IDs and convert them to an array
        $projectIds = $projects->pluck('id')->toArray();
        $activities = Activity::whereIn('project_id', $projectIds)
            ->get();

        $activityHoursRendered = $activities->sum('totalhours_rendered');

        $completedActivities = $activities->where('actremark', 'Completed')->count();
        $incompleteActivities = $activities->whereIn('actremark', ['Incomplete', 'Pending'])->count();
        $activityIds = $activities->pluck('id')->toArray();
        $subtaskHoursRendered = Subtask::whereIn('activity_id', $activityIds)->sum('hours_rendered');

        $outputs = Output::whereIn('activity_id', $activityIds)
            ->get();



        return view('report.selectinsights', [
            'members' => $users,
            'calendaryears' => $calendaryears,
            'inCurrentYear' => $inCurrentYear,
            'currentyear' => $currentyear,
            'activityHoursRendered' => $activityHoursRendered,
            'completedActivities' => $completedActivities,
            'incompleteActivities' => $incompleteActivities,
            'subtaskHoursRendered' => $subtaskHoursRendered,
            'activities' => $activities,
            'outputs' => $outputs,
            'projects' => $projects,
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
