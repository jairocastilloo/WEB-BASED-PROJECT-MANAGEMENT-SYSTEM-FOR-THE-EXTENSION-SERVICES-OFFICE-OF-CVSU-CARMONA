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
    public function showReports($department)
    {
        if (Auth::user()->role == "Admin") {
            $alldepartments = ['Department of Management', 'Department of Industrial and Information Technology', 'Department of Teacher Education', 'Department of Arts and Science', 'All'];
        } else {
            $alldepartments = [Auth::user()->department, 'All'];
        }

        return view('report.select', [
            'department' => $department,
            'alldepartments' => $alldepartments,
        ]);
    }
    public function displayReports($projectid, $department)
    {
        $indexproject = Project::findOrFail($projectid);
        $department = $indexproject->department;
        /*
        $totaloutput_submitted = $indexproject->activities->sum('outputs.totaloutput_submitted');
        $expectedoutput = $indexproject->activities->sum('outputs.expectedoutput');
        $outputPercent = ($expectedoutput !== 0) ? number_format($totaloutput_submitted / $expectedoutput, 2) : null;
*/
        $totalActivitiesCount = $indexproject->activities()
            ->count();
        $completedActivitiesCount = $indexproject->activities()
            ->where('actremark', 'Completed')
            ->count();

        $ongoingActivitiesCount = $indexproject->activities()
            ->where('actremark', 'Incomplete')
            ->where('actstartdate', '<=', now())
            ->where('actenddate', '>=', now())
            ->count();

        $overdueActivitiesCount = $indexproject->activities()
            ->where('actremark', 'Incomplete')
            ->where('actenddate', '<', now())
            ->count();

        $upcomingActivitiesCount = $indexproject->activities()
            ->where('actremark', 'Incomplete')
            ->where('actstartdate', '>', now())
            ->count();
        if ($indexproject->projectstatus == "Incomplete" && $indexproject->projectstartdate <= now() && $indexproject->projectenddate >= now()) {
            $status = "Ongoing";
        } else if ($indexproject->projectstatus == "Incomplete" && $indexproject->projectstartdate > now()) {
            $status = "Upcoming";
        } else if ($indexproject->projectstatus == "Incomplete" && $indexproject->projectenddate < now()) {
            $status = "Overdue";
        } else if ($indexproject->projectstatus == "Completed") {
            $status = "Completed";
        } else {
            $status = null;
        }


        if (Auth::user()->role == "Admin") {
            $alldepartments = ['Department of Management', 'Department of Industrial and Information Technology', 'Department of Teacher Education', 'Department of Arts and Science', 'All'];
        } else {
            $alldepartments = [Auth::user()->department, 'All'];
        }

        return view('report.display', [
            'department' => $department,
            'alldepartments' => $alldepartments,
            'totalActivitiesCount' => $totalActivitiesCount,
            'completedActivitiesCount' => $completedActivitiesCount,
            'ongoingActivitiesCount' => $ongoingActivitiesCount,
            'overdueActivitiesCount' => $overdueActivitiesCount,
            'upcomingActivitiesCount' => $upcomingActivitiesCount,
            'status' => $status
        ]);
    }
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
