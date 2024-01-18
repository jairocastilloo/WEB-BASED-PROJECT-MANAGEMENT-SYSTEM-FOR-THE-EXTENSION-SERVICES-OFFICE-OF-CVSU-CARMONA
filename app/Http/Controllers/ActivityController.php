<?php

namespace App\Http\Controllers;

use App\Models\ActivityUser;
use App\Models\Notification;
use App\Models\Output;
use App\Models\Activity;
use App\Models\activityContribution;
use App\Models\ActivitycontributionsUser;
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
        $project = Project::findorFail($projectId);

        $outputids = Output::where('activity_id', $activityid)
            ->where('output_type', $outputtype)
            ->pluck('id');
        $outputNames = Output::where('activity_id', $activityid)
            ->where('output_type', $outputtype)
            ->pluck('output_name')
            ->toArray();
        $submittedoutput = OutputUser::whereIn('output_id', $outputids)
            ->get();

        return view('activity.output', [
            'activity' => $activity,
            'currentoutputtype' => $currentoutputtype,
            'project' => $project,
            'outputtype' => $outputtype,
            'alloutputtypes' => $allOutputTypes,
            'submittedoutput' => $submittedoutput,
            'outputNames' => $outputNames,
        ]);
    }


    public function displayactivity($activityid)
    {
        // activity details
        $activity = Activity::find($activityid);
        // activity assignees

        // activity subtasks
        $subtasks = Subtask::where('activity_id', $activityid)->get();
        // activity outputs
        $outputs = Output::where('activity_id', $activityid)->get();
        $outputTypes = $outputs->unique('output_type')->pluck('output_type');
        // project name
        $activity = Activity::findOrFail($activityid);
        $projectId = $activity->project_id;
        $project = Project::findorFail($projectId);
        $objectiveset = $activity->actobjectives;
        $objectives = Objective::where('project_id', $projectId)
            ->where('objectiveset_id', $objectiveset)
            ->get();

        // all activities in a project
        $activities = Activity::where('project_id', $projectId)
            ->whereNotIn('id', [$activityid])
            ->get();

        return view('activity.index', [
            'activity' => $activity,
            'activities' => $activities,
            'subtasks' => $subtasks,
            'outputs' => $outputs,
            'outputTypes' => $outputTypes,
            'project' => $project,
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
        $activity->update(['subtask' => 0]);


        return response()->json(['success' => true, 'actid' => $actid]);
    }

    public function complyactivity($activityid, $activityname)
    {

        $activity = Activity::findOrFail($activityid);
        $currentassignees = $activity->users;

        $projectId = $activity->project_id;
        $project = Project::findorFail($projectId);

        return view('activity.submitactivity', [
            'activity' => $activity,
            'project' => $project,
            'currentassignees' => $currentassignees,
        ]);
    }

    public function addtoactivity(Request $request)
    {

        $validatedData = $request->validate([
            'activity-id' => 'required|integer',
            'activity-contributor.*' => 'required|integer',
            'start-date' => 'required|date',
            'end-date' => 'required|date',
            'contributornumber' => 'required|integer',
            'hours-rendered' => 'required|integer',
            'outputQuantity.*' => 'required|integer',
            'outputId.*' => 'required|integer',
            'related-program' => 'required|max:255',
            'client-numbers' => 'required|integer',
            'agency' => 'required|max:255',
        ]);

        $activitycontributions = new activityContribution();
        $activitycontributions->activity_id = $validatedData['activity-id'];
        $activitycontributions->startdate = $validatedData['start-date'];
        $activitycontributions->enddate = $validatedData['end-date'];
        $activitycontributions->hours_rendered = $validatedData['hours-rendered'];
        $activitycontributions->relatedPrograms = $validatedData['related-program'];
        $activitycontributions->clientNumbers = $validatedData['client-numbers'];
        $activitycontributions->agency = $validatedData['agency'];
        $activitycontributions->submitter_id = Auth::user()->id;
        $activitycontributions->save();
        $newActContri = $activitycontributions->id;

        for ($i = 0; $i < count($validatedData['outputId']); $i++) {
            $outputUser = new OutputUser();
            $outputUser->output_id = $validatedData['outputId'][$i];
            $outputUser->output_submitted = $validatedData['outputQuantity'][$i];
            $outputUser->actcontribution_id = $newActContri;
        }
        for ($i = 0; $i < $validatedData['contributornumber']; $i++) {


            $subtaskcontributor = new ActivitycontributionsUser();
            $subtaskcontributor->user_id = $validatedData['activity-contributor'][$i];
            $subtaskcontributor->activitycontribution_id = $newActContri;
            $subtaskcontributor->save();
        }

        $request->validate([
            'activitydocs' => 'required|mimes:docx|max:10240',
        ]);


        $file = $request->file('activitydocs');
        $originalName = $file->getClientOriginalName();
        $extension = $file->getClientOriginalExtension();
        $fileName = pathinfo($originalName, PATHINFO_FILENAME) . '.' . $extension;
        $currentDateTime = date('Y-m-d_H-i-s');
        // Store the file
        $path = $request->file('activitydocs')->storeAs('uploads/' . $currentDateTime, $fileName);
        // Save the file path to the database or perform any other necessary actions
        // ...

        return 'File uploaded successfully.';
    }
    public function uploadAccomplishmentReport(Request $request)
    {
        /*
        $request->validate([
            'projectstartdate' => 'required|date_format:m/d/Y|before_or_equal:projectenddate',
            'projectenddate' => 'required|date_format:m/d/Y|after_or_equal:projectstartdate',
            'terminal_file' => 'required|mimes:docx|max:4096',
        ]);
        */
        $activitystartdate = date("Y-m-d", strtotime($request->input('activitystartdate')));
        $activityenddate = date("Y-m-d", strtotime($request->input('activityenddate')));

        $activitycontribution = new activityContribution([
            'activity_id' => $request->input('activity-id'),
            'startdate' => $activitystartdate,
            'enddate' => $activityenddate,
            'submitter_id' => $request->input('submitter-id'),
            'hours_rendered' => $request->input('hours-rendered'),
            'relatedPrograms' => $request->input('related-program'),
            'clientNumbers' => $request->input('client-numbers'),
            'agency' => $request->input('agency'),
        ]);
        $activitycontribution->save();
        $activityimplementers = $request->input('activityimplementers');

        foreach ($activityimplementers as $activityimplementer) {
            ActivitycontributionsUser::create([
                'activitycontribution_id' => $activitycontribution->id,
                'user_id' => $activityimplementer,
            ]);
        }
        $selectedAssignees = User::where('role', 'Admin')
            ->get(['id']);
        $activity = Activity::where('id', $request->input('activity-id'))->first();
        $activityname = $activity ? $activity->actname : 'Unknown Activity';

        $message = Auth::user()->name . ' ' . Auth::user()->last_name . ' submitted an accomplishment report for activity: ' . $activityname . '.';

        foreach ($selectedAssignees as $selectedAssignee) {


            $notification = new Notification([
                'user_id' => $selectedAssignee->id,
                'task_id' => $activitycontribution->id,
                'task_type' => "activitycontribution",
                'task_name' => $activityname,
                'message' => $message,
            ]);
            $notification->save();
        }


        $outputIds = $request->input('outputId.*');
        $outputQuantities = $request->input('outputQuantity.*');
        if ($outputIds) {
            foreach ($outputIds as $i => $outputId) {
                OutputUser::create([
                    'output_id' => $outputId,
                    'output_submitted' => $outputQuantities[$i],
                    'actcontribution_id' => $activitycontribution->id,
                ]);
            }
        }
        $request->validate([
            'accomplishment_file' => 'required|mimetypes:application/vnd.openxmlformats-officedocument.wordprocessingml.document,application/pdf|max:10240',
        ]);


        $file = $request->file('accomplishment_file');
        $originalName = $file->getClientOriginalName();
        $extension = $file->getClientOriginalExtension();
        $fileName = pathinfo($originalName, PATHINFO_FILENAME) . '.' . $extension;
        $currentDateTime = date('Y-m-d_H-i-s');
        // Store the file
        $path = $request->file('accomplishment_file')->storeAs('uploads/' . $currentDateTime, $fileName);
        // Save the file path to the database or perform any other necessary actions
        // ...
        /*
        $url = URL::route('projsubmission.display', ['projsubmissionid' => $projectterminal->id, 'projsubmissionname' => "Unevaluated-Submission"]);
        return redirect($url);*/
        return response()->json([
            'actsubmissionid' => $activitycontribution->id,
        ]);
    }

    public function deleteActivity($activityid)
    {

        $activity = Activity::findorFail($activityid);

        $project = Project::findOrFail($activity->project_id);

        $department = $project->department;

        $activity->delete();
        Notification::where('task_id', $activityid)
            ->where('task_type', 'activity')
            ->delete();
        return redirect()->route('projects.display', ['projectid' => $project->id, 'department' => $department]);
    }
}
