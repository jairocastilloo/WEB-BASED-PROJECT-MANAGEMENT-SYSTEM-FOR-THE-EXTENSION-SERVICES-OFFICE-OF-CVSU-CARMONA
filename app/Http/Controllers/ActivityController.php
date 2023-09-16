<?php

namespace App\Http\Controllers;

use App\Models\ActivityUser;
<<<<<<< HEAD
use App\Models\Output;
use App\Models\Activity;
=======
use App\Models\Notification;
use App\Models\Output;
use App\Models\Activity;
use App\Models\activityContribution;
use App\Models\ActivitycontributionsUser;
>>>>>>> origin/main
use App\Models\Objective;
use Illuminate\Http\Request;
use App\Models\User;

use App\Models\Project;
use App\Models\ProjectUser;
use App\Models\OutputUser;
use App\Models\Subtask;
use App\Models\SubtaskUser;
use App\Models\SubtaskContributor;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Str;

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
        $newActId = $activity->id;
        Artisan::call('activity:status:update');
        return response()->json([
            'actid' => $newActId,
        ]);
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

    public function getoutput($activityid, $outputtype)
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
<<<<<<< HEAD

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


=======
        $outputNames = Output::where('activity_id', $activityid)
            ->where('output_type', $outputtype)
            ->pluck('output_name')
            ->toArray();
        $submittedoutput = OutputUser::whereIn('output_id', $outputids)
            ->get();
        $notifications = Notification::where('user_id', Auth::user()->id)
            ->get();
>>>>>>> origin/main

        return view('activity.output', [
            'activity' => $activity,
            'currentoutputtype' => $currentoutputtype,
            'projectName' => $projectName,
            'projectId' => $projectId,
            'outputtype' => $outputtype,
            'alloutputtypes' => $allOutputTypes,
<<<<<<< HEAD
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
            ->where('subtask_id', $subtaskid)
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
=======
            'submittedoutput' => $submittedoutput,
            'outputNames' => $outputNames,
            'notifications' => $notifications,
        ]);
    }

>>>>>>> origin/main

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

        //add assignees
        $projectuser = ProjectUser::where('project_id', $projectId)
            ->whereNotIn('user_id', $excludeUserIds)
            ->with('user:id,name,middle_name,last_name')
            ->get();
        $addassignees = $projectuser->map(function ($item) {
            return $item->user;
        });

        // all activities in a project
        $activities = Activity::where('project_id', $projectId)
            ->whereNotIn('id', [$activityid])
            ->get();
<<<<<<< HEAD

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
=======
        $notifications = Notification::where('user_id', Auth::user()->id)
>>>>>>> origin/main
            ->get();

        return view('activity.index', [
            'activity' => $activity,
            'activities' => $activities,
            'assignees' => $assignees,
            'subtasks' => $subtasks,
            'outputs' => $outputs,
            'outputTypes' => $outputTypes,
            'addassignees' => $addassignees,
            'projectName' => $projectName,
            'projectId' => $projectId,
            'objectives' => $objectives,
<<<<<<< HEAD
            'unapprovedactivitydata' => $unapprovedactivitydata,
            'usersWithSameCreatedAt' => $usersWithSameCreatedAt,
=======
            'notifications' => $notifications,
>>>>>>> origin/main
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
    public function setnosubtask(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'act-id' => 'required|integer',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()]);
        }

        $actid = $request->input('act-id');

        $activity = Activity::findOrFail($actid);
<<<<<<< HEAD
        $activity->update(['totalhours_rendered' => 0]);


        return response()->json(['success' => true]);
=======
        $activity->update(['subtask' => 0]);


        return response()->json(['success' => true, 'actid' => $actid]);
>>>>>>> origin/main
    }

    public function complyactivity($activityid, $activityname)
    {

        $activity = Activity::findOrFail($activityid);
        $currentassignees = $activity->users;

        $projectId = $activity->project_id;
        $projectName = $activity->project->projecttitle;
<<<<<<< HEAD

=======
        $notifications = Notification::where('user_id', Auth::user()->id)
            ->get();
>>>>>>> origin/main
        return view('activity.submitactivity', [
            'activity' => $activity,
            'projectName' => $projectName,
            'projectId' => $projectId,
            'currentassignees' => $currentassignees,
<<<<<<< HEAD
=======
            'notifications' => $notifications,
>>>>>>> origin/main
        ]);
    }

    public function addtoactivity(Request $request)
    {

        $validatedData = $request->validate([
            'activity-id' => 'required|integer',
            'activity-contributor.*' => 'required|integer',
<<<<<<< HEAD
=======
            'start-date' => 'required|date',
            'end-date' => 'required|date',
>>>>>>> origin/main
            'contributornumber' => 'required|integer',
            'hours-rendered' => 'required|integer',
        ]);

<<<<<<< HEAD
=======
        $activitycontributions = new activityContribution();
        $activitycontributions->activity_id = $validatedData['activity-id'];
        $activitycontributions->startdate = $validatedData['start-date'];
        $activitycontributions->enddate = $validatedData['end-date'];
        $activitycontributions->hours_rendered = $validatedData['hours-rendered'];
        $activitycontributions->submitter_id = Auth::user()->id;
        $activitycontributions->save();
        $newActContri = $activitycontributions->id;
>>>>>>> origin/main

        for ($i = 0; $i < $validatedData['contributornumber']; $i++) {


<<<<<<< HEAD
            $subtaskcontributor = new SubtaskContributor();
            $subtaskcontributor->user_id = $validatedData['activity-contributor'][$i];
            $subtaskcontributor->activity_id = $validatedData['activity-id'];
            $subtaskcontributor->hours_rendered = $validatedData['hours-rendered'];
=======
            $subtaskcontributor = new ActivitycontributionsUser();
            $subtaskcontributor->user_id = $validatedData['activity-contributor'][$i];
            $subtaskcontributor->activitycontribution_id = $newActContri;
>>>>>>> origin/main
            $subtaskcontributor->save();
        }

        $request->validate([
            'activitydocs' => 'required|mimes:docx|max:2048',
        ]);


        $file = $request->file('activitydocs');
        $originalName = $file->getClientOriginalName();
        $extension = $file->getClientOriginalExtension();
<<<<<<< HEAD
        $fileName = Str::slug(pathinfo($originalName, PATHINFO_FILENAME)) . '.' . $extension;
=======
        $fileName = pathinfo($originalName, PATHINFO_FILENAME) . '.' . $extension;
>>>>>>> origin/main
        $currentDateTime = date('Y-m-d_H-i-s');
        // Store the file
        $path = $request->file('activitydocs')->storeAs('uploads/' . $currentDateTime, $fileName);
        // Save the file path to the database or perform any other necessary actions
        // ...

        return 'File uploaded successfully.';
    }
<<<<<<< HEAD

    public function acceptacthours(Request $request)
    {

        $acceptIds = $request->input('acceptids');

        // Update the 'approval' field in SubtaskContributor table
        SubtaskContributor::where('created_at', $acceptIds)->update(['approval' => 1]);

        // Get the subtask_id and hours_rendered for the first record with the specified created_at value
        $subtaskContributor = SubtaskContributor::where('created_at', $acceptIds)->first();
        $activityid = $subtaskContributor->activity_id;
        $hoursrendered = $subtaskContributor->hours_rendered;

        // Update the 'hours_rendered' field in the Subtask table
        Activity::where('id', $activityid)->increment('totalhours_rendered', $hoursrendered);

        return 'File uploaded successfully.';
    }
=======
>>>>>>> origin/main
}
