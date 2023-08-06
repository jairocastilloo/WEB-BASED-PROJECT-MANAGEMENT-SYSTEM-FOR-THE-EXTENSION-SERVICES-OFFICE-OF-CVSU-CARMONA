<?php

namespace App\Http\Controllers;

use App\Models\AcademicYear;
use App\Models\ActivityUser;
use App\Models\Objective;
use App\Models\Output;
use App\Models\SubtaskContributor;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Project;
use App\Models\ProjectUser;
use App\Models\Subtask;
use App\Models\Activity;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Redirector;
use Carbon\Carbon;
use Illuminate\Support\Facades\Artisan;

class ProjectController extends Controller
{
    //

    public function showproject($department)
    {
        $projects = Project::where('department', $department)->get();

        $users = User::where('department', $department)
            ->where('role', '!=', 'Admin')
            ->get(['id', 'name', 'middle_name', 'last_name']);
        $currentDate = Carbon::now();
        $acadyear_id = AcademicYear::where('acadstartdate', '<=', $currentDate)
            ->where('acadenddate', '>=', $currentDate)
            ->value('id');
        $currentproject = Project::where('department', $department)
            ->where('academicyear_id', $acadyear_id)
            ->get();
        $acadyears = AcademicYear::get(['id', 'acadstartdate', 'acadenddate']);

        return view('project.create', ['members' => $users, 'projects' => $projects, 'acadyear_id' => $acadyear_id, 'acadyears' => $acadyears, 'currentproject' => $currentproject]);
    }

    public function displayproject($projectid, $department)
    {

        $projects = Project::findOrFail($projectid);


        $projects = Project::where('department', $department)->get();

        $users = User::where('department', $department)
            ->where('role', '!=', 'Admin')
            ->get(['id', 'name', 'middle_name', 'last_name']);

        $currentproject = Project::findOrFail($projectid);
        $objectives = $currentproject->objectives;
        $activities = Project::findOrFail($projectid);
        $activities = $currentproject->activities;

        $sortedActivities = $activities->sortBy('actobjectives');
        //return response()->json(['members' => $users, 'projects' => $projects, 'objectives' => $objectives, 'projectid' => $projectid, 'assignees' => $assignees]);

        //return response()->json(['members' => $users, 'projects' => $projects, 'objectives' => $objectives]);
        return view('project.select', ['members' => $users, 'projects' => $projects, 'currentproject' => $currentproject, 'objectives' => $objectives, 'projectid' => $projectid, 'activities' => $activities, 'sortedActivities' => $sortedActivities]);
    }
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
            'projecttitle' => 'required|unique:projects|max:255',
            'projectleader' => 'required|max:255',
            'programtitle' => 'required|max:255',
            'programleader' => 'required|max:255',
            'projectstartdate' => 'required|date',
            'projectenddate' => 'required|date|after:project_startdate',
            'department' => 'required|max:255',
            'acadyear-id' => 'required|integer',
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
            'academicyear_id' => $request->input('acadyear-id'),

        ]);

        $project->save();
        Artisan::call('project:status:update');
        $newProjectId = $project->id;


        $validatedData = $request->validate([
            'projectmember.*' => 'required|integer', // Validate each select input
            'memberindex' => 'required|integer',
            'projectobjective.*' => 'required',
            'objectiveindex' => 'required|integer',
            'objectivesetid.*' => 'required|integer',
            // Validate select count
        ]);
        for ($i = 0; $i < $validatedData['memberindex']; $i++) {
            $projectmembers = new ProjectUser;
            $projectmembers->user_id = $validatedData['projectmember'][$i];
            $projectmembers->project_id = $newProjectId;
            $projectmembers->save();
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
