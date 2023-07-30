<?php

namespace App\Http\Controllers;

use App\Models\ActivityUser;
use App\Models\Output;
use App\Models\Activity;
use App\Models\Objective;
use Illuminate\Http\Request;
use App\Models\User;

use App\Models\Project;
use App\Models\ProjectUser;
use App\Models\OutputUser;
use App\Models\Subtask;
use App\Models\SubtaskUser;
use App\Models\SubtaskContributor;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Redirector;

class ActivityController extends Controller
{
    //
    public function storeactivity(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'activityname' => 'required|max:255',
            'objectives' => 'required|max:255',
            'expectedoutput' => 'required|max:255',
            'activitystartdate' => 'required|date',
            'activityenddate' => 'required|date|after:project_startdate',
            'budget' =>  'required|max:255',
            'source' => 'required|max:255',
            'projectindex' => 'required|integer',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()]);
        }

        $activityname = $request->input('activityname');
        $objectives = $request->input('objectives');
        $expectedoutput = $request->input('expectedoutput');
        $activitystartdate = $request->input('activitystartdate');
        $activityenddate = $request->input('activityenddate');
        $budget = $request->input('budget');
        $source = $request->input('source');
        $projectindex = $request->input('projectindex');

        $activity = new Activity();
        $activity->actname = $activityname;
        $activity->actobjectives = $objectives;
        $activity->actoutput = $expectedoutput;
        $activity->actstartdate = $activitystartdate;
        $activity->actenddate = $activityenddate;
        $activity->actbudget = $budget;
        $activity->actsource = $source;
        $activity->project_id = $projectindex;
        $activity->save();



        return response()->json(['message' => 'Activity created successfully.']);
    }

    public function storesubtask(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'subtaskname' => 'required|max:255',
            'subtaskassignee' => 'required|max:255',
            'activitynumber' => 'required|integer',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()]);
        }

        $subtaskname = $request->input('subtaskname');
        $subtaskassignee = $request->input('subtaskassignee');
        $activitynumber = $request->input('activitynumber');

        $user = User::where('name', $subtaskassignee)->first();
        $userid = $user->id;

        $activity = Activity::findOrFail($activitynumber); // Retrieve the activity using the activity number
        $projectid = $activity->project->id; // Retrieve the project_id through the relationship

        $subtasks = new Subtask();
        $subtasks->subtask_name = $subtaskname;
        $subtasks->subtask_assignee = $subtaskassignee;
        $subtasks->activity_id = $activitynumber;
        $subtasks->project_id = $projectid;
        $subtasks->user_id = $userid;
        $subtasks->save();

        return response()->json(['success' => true]);
    }
    public function completeactivity(Request $request)
    {

        $validatedData = $request->validate([
            'completedactid' => 'required|integer',
        ]);

        $output = Activity::where('id', $validatedData['completedactid'])->first();
        if ($output) {
            // Update the value of actremark
            $output->actremark = "Completed";
            $output->save();
        } else {
            // Handle the case when the activity is not found
            return response()->json(['error' => 'Activity not found.'], 404);
        }

        return response()->json(['success' => true]);
    }

    public function addassignee(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'assigneeselect' => 'required|integer',
            'assigneeactnumber' => 'required|integer',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()]);
        }

        $assigneeid = $request->input('assigneeselect');
        $assigneeactnumber = $request->input('assigneeactnumber');

        $addassignee = new ActivityUser();

        $addassignee->user_id = $assigneeid;
        $addassignee->activity_id = $assigneeactnumber;
        $addassignee->save();
    }



    public function unassignassignee(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'unassignassigneeid' => 'required|integer',
            'unassignactivityid' => 'required|integer',
        ]);
        $unassignassigneeid = $request->input('unassignassigneeid');
        $unassignactivityid = $request->input('unassignactivityid');

        $unassignassignee = new ActivityUser();

        $unassignassignee = ActivityUser::where('activity_id', $unassignactivityid)
            ->where('user_id', $unassignassigneeid)
            ->delete();

        return response()->json(['success' => true], 200);
    }

    public function getoutput($id, $activityid, $outputtype)
    {
        // activity details
        $activity = Activity::findOrFail($activityid);

        // activity outputs
        $currentoutputtype = Output::where('activity_id', $activityid)
            ->where('output_type', $outputtype)
            ->get();


        // all output type
        $outputs = Output::where('activity_id', $activityid)->get();
        $allOutputTypes = $outputs->where('output_type', '!=', $outputtype)->pluck('output_type')->unique();

        $projectId = $activity->project_id;
        $projectName = $activity->project->projecttitle;

        $outputids = Output::where('activity_id', $activityid)
            ->where('output_type', $outputtype)
            ->pluck('id');

        $outputcreated_at_list = []; // Initialize an empty array to store the $outputcreated_at values
        $unapprovedoutputs = [];
        $first = true;
        foreach ($outputids as $outputid) {
            if ($first) {
                $usersWithSameCreatedAt = OutputUser::select(DB::raw('created_at, GROUP_CONCAT(user_id) as user_ids'))
                    ->where('approval', 0)
                    ->where('output_id', $outputid)
                    ->groupBy('created_at')
                    ->get();
                $first = false;
            }
            $unapprovedoutput = OutputUser::selectRaw('MAX(id) as id')
                ->where('approval', 0)
                ->where('output_id', $outputid)
                ->groupByRaw('created_at')
                ->pluck('id')
                ->toArray(); // Convert the plucked collection to an array

            $unapprovedoutputs = array_merge($unapprovedoutputs, $unapprovedoutput);

            $outputcreated_at = OutputUser::where('output_id', $outputid)
                ->where('approval', 0)
                ->pluck('created_at')
                ->toArray(); // Convert the plucked collection to an array

            $outputcreated_at_list = array_merge($outputcreated_at_list, $outputcreated_at);
        }

        $unique_outputcreated = array_unique($outputcreated_at_list);

        $unapprovedoutputdata = OutputUser::whereIn('id', $unapprovedoutputs)
            ->get();



        return view('activity.output', [
            'activity' => $activity,
            'currentoutputtype' => $currentoutputtype,
            'projectName' => $projectName,
            'projectId' => $projectId,
            'outputtype' => $outputtype,
            'alloutputtypes' => $allOutputTypes,
            'unique_outputcreated' => $unique_outputcreated,
            'unapprovedoutputdata' => $unapprovedoutputdata,
            'usersWithSameCreatedAt' => $usersWithSameCreatedAt
        ]);
    }

    public function getsubtask($id, $activityid, $subtaskid)
    {
        // activity details
        $activity = Activity::findOrFail($activityid);
        $subtask = Subtask::findOrFail($subtaskid);
        $subtasks = Subtask::where('activity_id', $activityid)->get();
        $projectId = $activity->project_id;
        $projectName = $activity->project->projecttitle;

        $currentassignees = $subtask->users;

        $subtaskuser = SubtaskUser::where('subtask_id', $subtaskid)->get();


        $excludeUserIds = $subtaskuser->pluck('user_id')->toArray();
        $activityUser = ActivityUser::where('activity_id', $activityid)
            ->whereNotIn('user_id', $excludeUserIds)
            ->with('user:id,name,middle_name,last_name,email,role')
            ->get();

        $assignees = $activityUser->map(function ($item) {
            return $item->user;
        });

        $usersWithSameCreatedAt = SubtaskContributor::select(DB::raw('created_at, GROUP_CONCAT(user_id) as user_ids'))
            ->where('approval', 0)
            ->groupBy('created_at')
            ->get();
        $unapprovedsubtask = SubtaskContributor::selectRaw('MAX(id) as id')
            ->where('approval', 0)
            ->where('subtask_id', $subtaskid)
            ->groupByRaw('created_at')
            ->pluck('id');


        $unapprovedsubtaskdata = SubtaskContributor::whereIn('id', $unapprovedsubtask)
            ->get();


        return view('activity.subtask', [
            'activity' => $activity,
            'subtask' => $subtask,
            'subtasks' => $subtasks,
            'projectName' => $projectName,
            'projectId' => $projectId,
            'assignees' => $assignees,
            'currentassignees' => $currentassignees,
            'unapprovedsubtaskdata' => $unapprovedsubtaskdata,
            'usersWithSameCreatedAt' => $usersWithSameCreatedAt,
        ]);
    }

    public function displayactivity($activityid, $department, $activityname)
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

    public function markcomplete(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'actid' => 'required|integer',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()]);
        }

        $actid = $request->input('actid');

        $unassignassignee = Activity::where('id', $actid)
            ->update(['actremark' => 'Completed']);
        return response()->json(['success' => true], 200);
    }
}
