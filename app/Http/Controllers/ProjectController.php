<?php

namespace App\Http\Controllers;

<<<<<<< HEAD
use App\Models\ActivityUser;
=======
use App\Models\AcademicYear;
use App\Models\ActivityUser;
use App\Models\Notification;
>>>>>>> origin/main
use App\Models\Objective;
use App\Models\Output;
use App\Models\SubtaskContributor;
use Illuminate\Http\Request;
use App\Models\User;
<<<<<<< HEAD
=======
use App\Models\CalendarYear;
>>>>>>> origin/main
use App\Models\Project;
use App\Models\ProjectUser;
use App\Models\Subtask;
use App\Models\Activity;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Redirector;
<<<<<<< HEAD
=======
use Carbon\Carbon;
use Illuminate\Support\Facades\Artisan;
use App\Events\NewNotification;
>>>>>>> origin/main

class ProjectController extends Controller
{
    //

    public function showproject($department)
    {
<<<<<<< HEAD
        $projects = Project::where('department', $department)->get();
=======
>>>>>>> origin/main

        $users = User::where('department', $department)
            ->where('role', '!=', 'Admin')
            ->get(['id', 'name', 'middle_name', 'last_name']);
<<<<<<< HEAD

        return view('project.create', ['members' => $users, 'projects' => $projects]);
    }

    public function displayproject($projectid, $department, $projectname)
    {

        $projects = Project::findOrFail($projectid);


        $projects = Project::where('department', $department)->get();
=======
        $currentDate = Carbon::now();
        $currentyear = $currentDate->year;

        $currentproject = Project::where('department', $department)
            ->where('calendaryear', $currentyear)
            ->get();

        $inCurrentYear = true;


        $calendaryears = CalendarYear::pluck('year');
        $notifications = Notification::where('user_id', Auth::user()->id)
            ->get();

        return view('project.create', [
            'members' => $users,
            'calendaryears' => $calendaryears,
            'currentproject' => $currentproject,
            'inCurrentYear' => $inCurrentYear,
            'currentyear' => $currentyear,
            'notifications' => $notifications,
        ]);
    }

    public function showyearproject($department, $currentyear)
    {

        $users = User::where('department', $department)
            ->where('role', '!=', 'Admin')
            ->get(['id', 'name', 'middle_name', 'last_name']);
        $currentDate = Carbon::now();
        $otheryear = $currentDate->year;

        if ($otheryear == $currentyear) {
            $inCurrentYear = true;
        } else {
            $inCurrentYear = false;
        }

        $currentproject = Project::where('department', $department)
            ->where('calendaryear', $currentyear)
            ->get();

        $calendaryears = CalendarYear::pluck('year');
        $notifications = Notification::where('user_id', Auth::user()->id)
            ->get();


        return view('project.create', [
            'members' => $users,
            'calendaryears' => $calendaryears,
            'currentproject' => $currentproject,
            'inCurrentYear' => $inCurrentYear,
            'currentyear' => $currentyear,
            'notifications' => $notifications,
        ]);
    }

    public function displayproject($projectid, $department)
    {

        $indexproject = Project::findOrFail($projectid);
        $currentyear = $indexproject->calendaryear;
        $currentproject = Project::where('department', $department)
            ->whereNotIn('id', [$projectid])
            ->where('calendaryear', $currentyear)
            ->get();
        $currentDate = Carbon::now();
        $otheryear = $currentDate->year;

        if ($otheryear == $currentyear) {
            $inCurrentYear = true;
        } else {
            $inCurrentYear = false;
        }

        $calendaryears = CalendarYear::pluck('year');
>>>>>>> origin/main

        $users = User::where('department', $department)
            ->where('role', '!=', 'Admin')
            ->get(['id', 'name', 'middle_name', 'last_name']);

<<<<<<< HEAD
        $currentproject = Project::findOrFail($projectid);
        $objectives = $currentproject->objectives;
        $activities = Project::findOrFail($projectid);
        $activities = $currentproject->activities;

        $sortedActivities = $activities->sortBy('actobjectives');
        //return response()->json(['members' => $users, 'projects' => $projects, 'objectives' => $objectives, 'projectid' => $projectid, 'assignees' => $assignees]);

        //return response()->json(['members' => $users, 'projects' => $projects, 'objectives' => $objectives]);
        return view('project.select', ['members' => $users, 'projects' => $projects, 'currentproject' => $currentproject, 'objectives' => $objectives, 'projectid' => $projectid, 'activities' => $activities, 'sortedActivities' => $sortedActivities]);
    }
=======

        $objectives = $indexproject->objectives;
        $activities = $indexproject->activities;

        $sortedActivities = $activities->sortBy('actobjectives');

        $notifications = Notification::where('user_id', Auth::user()->id)
            ->get();
        //return response()->json(['members' => $users, 'projects' => $projects, 'objectives' => $objectives, 'projectid' => $projectid, 'assignees' => $assignees]);

        //return response()->json(['members' => $users, 'projects' => $projects, 'objectives' => $objectives]);
        return view('project.select', [
            'members' => $users, 'currentproject' => $currentproject, 'indexproject' => $indexproject,
            'calendaryears' => $calendaryears,
            'inCurrentYear' => $inCurrentYear,
            'currentyear' => $currentyear,
            'objectives' => $objectives, 'projectid' => $projectid, 'activities' => $activities, 'sortedActivities' => $sortedActivities,
            'notifications' => $notifications,
        ]);
    }

    public function displayActivityCalendar($projectid, $department)
    {

        $indexproject = Project::findOrFail($projectid);
        $currentyear = $indexproject->calendaryear;
        $currentproject = Project::where('department', $department)
            ->whereNotIn('id', [$projectid])
            ->where('calendaryear', $currentyear)
            ->get();
        $currentDate = Carbon::now();
        $otheryear = $currentDate->year;

        if ($otheryear == $currentyear) {
            $inCurrentYear = true;
        } else {
            $inCurrentYear = false;
        }

        $calendaryears = CalendarYear::pluck('year');

        $users = User::where('department', $department)
            ->where('role', '!=', 'Admin')
            ->get(['id', 'name', 'middle_name', 'last_name']);

        $activities = $indexproject->activities;
        $activityArray = $activities->map(function ($activity) {
            return (object) [
                'actname' => $activity->actname,
                'actstartdate' => $activity->actstartdate,
                'actenddate' => $activity->actenddate,
            ];
        })->toArray();
        $notifications = Notification::where('user_id', Auth::user()->id)
            ->get();

        return view('project.calendar', [
            'members' => $users, 'currentproject' => $currentproject,
            'indexproject' => $indexproject,
            'calendaryears' => $calendaryears,
            'inCurrentYear' => $inCurrentYear,
            'currentyear' => $currentyear, 'projectid' => $projectid,
            'activityArray' => $activityArray,
            'notifications' => $notifications,
        ]);
    }

>>>>>>> origin/main
    /*
    public function getactivity($id, $activityid)
    {
        // activity details
        $activity = Activity::find($activityid);
        // activity assignees
        $activityUser = ActivityUser::where('activity_id', $activityid)
            ->with('user:id,name,middle_name,last_name,email,role')
            ->get();

        $assignees = $activityUser->map(function ($item) {
            return $item->user;
        });

        // activity assignees that can be added
        $user = User::findOrFail($id);
        $department = $user->department;
        $excludeUserIds = $activityUser->pluck('user_id')->toArray();

        $addassignees = User::where('department', $department)
            ->where('role', '!=', 'Admin')
            ->whereNotIn('id', $excludeUserIds)
            ->get(['id', 'name', 'last_name']);
        // activity subtasks
        $subtasks = Subtask::where('activity_id', $activityid)->get();
        // activity outputs
        $outputs = Output::where('activity_id', $activityid)->get();
        $outputTypes = $outputs->unique('output_type')->pluck('output_type');
        // project name
        $activity = Activity::findOrFail($activityid);
        $projectId = $activity->project_id;
        $projectName = $activity->project->projecttitle;
        $objectiveset = $activity->actobjectives;
        $objectives = Objective::where('project_id', $projectId)
            ->where('objectiveset_id', $objectiveset)
            ->get('name');

        $usersWithSameCreatedAt = SubtaskContributor::select(DB::raw('created_at, GROUP_CONCAT(user_id) as user_ids'))
            ->where('approval', 0)
            ->where('activity_id', $activityid)
            ->groupBy('created_at')
            ->get();
        $unapprovedactivity = SubtaskContributor::selectRaw('MAX(id) as id')
            ->where('approval', 0)
            ->where('activity_id', $activityid)
            ->groupByRaw('created_at')
            ->pluck('id');


        $unapprovedactivitydata = SubtaskContributor::whereIn('id', $unapprovedactivity)
            ->get();

        return view('activity.index', [
            'activity' => $activity,
            'assignees' => $assignees,
            'subtasks' => $subtasks,
            'outputs' => $outputs,
            'outputTypes' => $outputTypes,
            'addassignees' => $addassignees,
            'projectName' => $projectName,
            'projectId' => $projectId,
            'objectives' => $objectives,
            'unapprovedactivitydata' => $unapprovedactivitydata,
            'usersWithSameCreatedAt' => $usersWithSameCreatedAt,
        ]);
    }
*/

    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
<<<<<<< HEAD
            'projecttitle' => 'required|unique:projects|max:255',
            'projectleader' => 'required|max:255',
            'programtitle' => 'required|max:255',
            'programleader' => 'required|max:255',
            'projectstartdate' => 'required|date',
            'projectenddate' => 'required|date|after:project_startdate',
            'department' => 'required|max:255',
=======
            'projecttitle' => 'required|max:255',
            'projectleader' => 'required|max:255',
            'programtitle' => 'required|max:255',
            'programleader' => 'required|max:255',
            'projectstartdate' => "required|date",
            'projectenddate' => "required|date|after:projectstartdate",
            'department' => 'required|max:255',
            'currentyear' => 'required|integer',
>>>>>>> origin/main
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()]);
        }

        $project = new Project([
            'projecttitle' => $request->input('projecttitle'),
            'projectleader' => $request->input('projectleader'),
            'programtitle' => $request->input('programtitle'),
            'programleader' => $request->input('programleader'),
            'projectstartdate' => $request->input('projectstartdate'),
            'projectenddate' => $request->input('projectenddate'),
            'department' => $request->input('department'),
<<<<<<< HEAD
        ]);

        $project->save();
        $newProjectId = $project->id;


=======
            'calendaryear' => $request->input('currentyear'),
        ]);

        $project->save();
        Artisan::call('project:status:update');
        $newProjectId = $project->id;



>>>>>>> origin/main
        $validatedData = $request->validate([
            'projectmember.*' => 'required|integer', // Validate each select input
            'memberindex' => 'required|integer',
            'projectobjective.*' => 'required',
            'objectiveindex' => 'required|integer',
            'objectivesetid.*' => 'required|integer',
            // Validate select count
        ]);
<<<<<<< HEAD
=======

>>>>>>> origin/main
        for ($i = 0; $i < $validatedData['memberindex']; $i++) {
            $projectmembers = new ProjectUser;
            $projectmembers->user_id = $validatedData['projectmember'][$i];
            $projectmembers->project_id = $newProjectId;
<<<<<<< HEAD
            $projectmembers->save();
=======

            $projectmembers->save();
            $notification = new Notification([
                'user_id' => $validatedData['projectmember'][$i],
                'message' => 'You have been added to a new project.',
            ]);
            $notification->save();
>>>>>>> origin/main
        }
        for ($i = 0; $i < $validatedData['objectiveindex']; $i++) {
            $projectobjective = new Objective;
            $projectobjective->name = $validatedData['projectobjective'][$i];
            $projectobjective->project_id = $newProjectId;
            $projectobjective->objectiveset_id = $validatedData['objectivesetid'][$i];
            $projectobjective->save();
        }


        return response()->json([
            'projectid' => $newProjectId,
        ]);
    }
}
