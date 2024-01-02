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
use App\Models\activityContribution;
use App\Models\ActivitycontributionsUser;

use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use PDF;

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
        $projecttitle = $indexproject->projecttitle;
        $currentDate = now();

        $activitiesQuery = $indexproject->activities();
        $activities = $activitiesQuery->get(['id', 'actname', 'actstartdate', 'actenddate', 'actremark']);



        /*
        $completedActivitiesCount = $activitiesQuery->where('actremark', 'Completed')->count();
        $ongoingActivitiesCount = $activitiesQuery->where('actremark', 'Incomplete')
            ->where('actstartdate', '<=', $currentDate)
            ->where('actenddate', '>=', $currentDate)
            ->count();
        $overdueActivitiesCount = $activitiesQuery->where('actremark', 'Incomplete')
            ->where('actenddate', '<', $currentDate)
            ->count();
        $upcomingActivitiesCount = $activitiesQuery->where('actremark', 'Incomplete')
            ->where('actstartdate', '>', $currentDate)
            ->count();

        $ongoingActivitiesCount = 0;
        $overdueActivitiesCount = 0;
        $upcomingActivitiesCount = 0;
*/

        foreach ($activities as $activity) {
            $activityId = $activity->id;

            $outputSubmitted = Output::where('activity_id', $activityId)->sum('totaloutput_submitted');
            $expectedOutput = Output::where('activity_id', $activityId)->sum('expectedoutput');

            $outputPercent = ($expectedOutput !== 0) ? number_format($outputSubmitted / $expectedOutput * 100, 0) : null;

            if ($outputPercent === null) {
                $outputPercent = 0;
            }

            $activeTasks = Subtask::where('activity_id', $activityId)
                ->where('status', 'Incomplete')
                ->where('subduedate', '>=', $currentDate)
                ->count();
            $missingTasks = Subtask::where('activity_id', $activityId)
                ->where('status', 'Incomplete')
                ->where('subduedate', '<', $currentDate)
                ->count();
            $completedTasks = Subtask::where('activity_id', $activityId)
                ->where('status', 'Completed')
                ->count();

            // Create an associative array with additional data
            $additionalData = [
                'outputPercent' => $outputPercent,
                'activeTasks' => $activeTasks,
                'missingTasks' => $missingTasks,
                'completedTasks' => $completedTasks,
            ];

            // Merge the additional data into the $activity object
            $activity->additionalData = $additionalData;
        }


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
            'status' => $status,
            'activities' => $activities,
            'projecttitle' => $projecttitle
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
    public function generateAccomplishmentReport(Request $request)
    {
        $department = $request->input('department');
        $startDate = $request->input('startDate');
        $endDate = $request->input('endDate');

        $projects = Project::where('department', $department)
            ->get(['id', 'projecttitle']);
        // Get project IDs based on the provided department
        $projectIds = $projects->pluck('id')
            ->toArray();

        // Get activities related to the obtained project IDs
        $activities = Activity::whereIn('project_id', $projectIds)
            ->get(['id', 'actname', 'project_id']);

        // Get activity IDs from the obtained activities
        $activityIds = $activities->pluck('id')->toArray();
        // Get activity contributions based on the obtained activity IDs
        $activityContributions = ActivityContribution::whereIn('activity_id', $activityIds)
            ->whereDate('startdate', '<=', $startDate)
            ->whereDate('enddate', '>=', $endDate)
            ->where('approval', 1)
            ->get();


        $activityContributionsIds = $activityContributions->pluck('id')
            ->toArray();

        // Add the 'actname' to each item in the original collection

        $activityContributionsUsers = ActivitycontributionsUser::whereIn('activitycontribution_id', $activityContributionsIds)
            ->get();
        $activityContributions->each(function ($item) use ($activities, $activityContributionsUsers, $projects) {
            $activity = $activities->where('id', $item->activity_id)->first();
            $item->actname = $activity->actname;

            $project = $projects->where('id', $activity->project_id)
                ->first();
            $item->projecttitle = $project->projecttitle;
            $userIds = $activityContributionsUsers->where('activitycontribution_id', $item->id)->pluck('user_id')->toArray();
            $users = [];
            foreach ($userIds as $userId) {
                $user = User::where('id', $userId)->first();
                $name = $user->name . ' ' . $user->last_name;
                $users[] = $name;
            }
            $item->users = $users;
        });

        // Pass the modified collection to the view
        return view('report.accomplishment', [
            'startDate' => $startDate,
            'endDate' => $endDate,
            'department' => $department,
            'activityContributions' => $activityContributions
        ]);
    }
}
