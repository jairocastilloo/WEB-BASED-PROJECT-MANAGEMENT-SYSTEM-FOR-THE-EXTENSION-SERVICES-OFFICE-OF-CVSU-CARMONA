<?php

namespace App\Http\Controllers;

use App\Models\ActivityUser;
use App\Models\Objective;
use App\Models\Output;
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

class ProjectController extends Controller
{
    //

    public function showproject($department)
    {
        $user = User::where('department', $department)->first();

        $projects = $user->projects;
        $users = User::where('department', $department)
            ->where('role', '!=', 'Admin')
            ->get(['id', 'name', 'middle_name', 'last_name']);

        return view('project.create', ['members' => $users, 'projects' => $projects]);
    }

    public function displayproject($projectid, $department, $projectname)
    {

        $projects = Project::findOrFail($projectid);

        $user = User::where('department', $department)->first();

        $projects = $user->projects;

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
        ]);
    }


    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'projecttitle' => 'required|unique:projects|max:255',
            'projectleader' => 'required|max:255',
            'programtitle' => 'required|max:255',
            'programleader' => 'required|max:255',
            'projectstartdate' => 'required|date',
            'projectenddate' => 'required|date|after:project_startdate',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()]);
        }

        $projecttitle = $request->input('projecttitle');
        $projectleader = $request->input('projectleader');
        $programtitle = $request->input('programtitle');
        $programleader = $request->input('programleader');
        $projectstartdate = $request->input('projectstartdate');
        $projectenddate = $request->input('projectenddate');

        $projectData = [
            'projecttitle' => $projecttitle,
            'projectleader' => $projectleader,
            'programtitle' => $programtitle,
            'programleader' => $programleader,
            'projectstartdate' => $projectstartdate,
            'projectenddate' => $projectenddate,
        ];
        DB::table('projects')->insert($projectData);
        $newProjectId = DB::getPdo()->lastInsertId();

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


        //$id = Auth::user()->id;

        //return redirect()->route('get.objectives', ['id' => $id, 'projectid' => $newProjectId]);

        //$url = route('get.objectives', ['id' => $id, 'projectid' => $newProjectId]);

        //return redirect($url);
        return response()->json(['success' => true]);
    }
}
