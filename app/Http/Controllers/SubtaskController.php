<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use App\Models\Project;
use App\Models\Subtask;
use App\Models\Activity;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\SubtaskUser;
use App\Models\SubtaskContributor;
use App\Models\ActivityUser;
use App\Models\Contribution;
use App\Models\SubtaskcontributionsUser;
use Illuminate\Support\Carbon;
use App\Models\User;

class SubtaskController extends Controller
{
    //
    public function submithoursrendered(Request $request)
    {

        $validatedData = $request->validate([
            'hours-rendered-input' => 'required|integer',
            'hours-subname' => 'required',
            'hours-actid' => 'required',

        ]);


        $output = Subtask::where('subtask_name', $validatedData['hours-subname'])
            ->where('activity_id', $validatedData['hours-actid'])
            ->first();
        if ($output) {
            // Update the value of output_submitted
            $output->hours_rendered = $validatedData['hours-rendered-input'];
            $output->save();
        }


        return response()->json(['success' => true]);
    }
    public function addsubtask(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'subtaskname' => 'required|max:255',
            'activitynumber' => 'required|integer',
            'subtaskduedate' => 'required|date',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()]);
        }

        $subtaskname = $request->input('subtaskname');
        $activitynumber = $request->input('activitynumber');
        $subtaskduedate = $request->input('subtaskduedate');
        $subtasks = new Subtask();

        $subtasks->subtask_name = $subtaskname;
        $subtasks->activity_id = $activitynumber;
        $subtasks->subduedate = $subtaskduedate;
        $subtasks->save();
        $lastsubtaskid = $subtasks->id;

        return response()->json([
            'lastsubtaskid' => $lastsubtaskid,
        ]);
    }
    public function addsubtaskassignee(Request $request)
    {
        $validator = Validator::make($request->all(), [

            'subtaskid' => 'required|integer',
            'userid' => 'required|integer',

        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()]);
        }

        $subtaskid = $request->input('subtaskid');
        $userid = $request->input('userid');

        $subtaskuser = new SubtaskUser();

        $subtaskuser->subtask_id = $subtaskid;
        $subtaskuser->user_id = $userid;

        $subtaskuser->save();
    }

    public function complysubtask($subtaskid, $subtaskname)
    {

        $subtask = Subtask::findOrFail($subtaskid);
        $activityid = Subtask::where('id', $subtaskid)
            ->value('activity_id');
        $activity = Activity::findOrFail($activityid);
        $currentassignees = $subtask->users;

        $projectId = $activity->project_id;
        $project = Project::findorFail($projectId);

        return view('activity.submitsubtask', [
            'activity' => $activity,
            'subtask' => $subtask,
            'project' => $project,
            'currentassignees' => $currentassignees,
        ]);
    }

    public function addtosubtask(Request $request)
    {

        $validatedData = $request->validate([
            'subtask-id' => 'required|integer',
            'subtask-contributor.*' => 'required|integer',
            'contributornumber' => 'required|integer',
            'hours-rendered' => 'required|integer',
            'subtask-date' => 'required|date',
            'subtask-enddate' => 'required|date',
        ]);

        $subtaskcontributor = new Contribution();
        $subtaskcontributor->subtask_id = $validatedData['subtask-id'];
        $subtaskcontributor->hours_rendered = $validatedData['hours-rendered'];
        $subtaskcontributor->date = $validatedData['subtask-date'];
        $subtaskcontributor->enddate = $validatedData['subtask-enddate'];
        $subtaskcontributor->submitter_id = Auth::user()->id;
        $subtaskcontributor->save();
        $newsubtaskcontributor = $subtaskcontributor->id;

        for ($i = 0; $i < $validatedData['contributornumber']; $i++) {


            $subtaskcontributor = new SubtaskcontributionsUser();
            $subtaskcontributor->user_id = $validatedData['subtask-contributor'][$i];
            $subtaskcontributor->contribution_id = $newsubtaskcontributor;
            $subtaskcontributor->save();
        }




        $request->validate([
            'subtaskdocs' => 'required|mimes:docx|max:10240',
        ]);


        $file = $request->file('subtaskdocs');
        $originalName = $file->getClientOriginalName();
        $extension = $file->getClientOriginalExtension();
        $fileName = pathinfo($originalName, PATHINFO_FILENAME) . '.' . $extension;
        $currentDateTime = date('Y-m-d_H-i-s');
        // Store the file
        $path = $request->file('subtaskdocs')->storeAs('uploads/' . $currentDateTime, $fileName);
        // Save the file path to the database or perform any other necessary actions
        // ...

        return 'File uploaded successfully.';
    }

    public function displaysubtask($subtaskid, $subtaskname)
    {
        // activity details

        $subtask = Subtask::findOrFail($subtaskid);
        $activityid = Subtask::where('id', $subtaskid)
            ->value('activity_id');
        $activity = Activity::findOrFail($activityid);
        $subtasks = Subtask::where('activity_id', $activityid)
            ->where('id', '!=', $subtaskid) // Corrected to use '!='
            ->get();
        $projectId = $activity->project_id;
        $project = Project::findorFail($projectId);

        $contributions = Contribution::where('subtask_id', $subtaskid)
            ->get();
        $assigneesIds = SubtaskUser::where('subtask_id', $subtaskid)
            ->pluck('user_id')
            ->toArray();

        $assignees = User::whereIn('id', $assigneesIds)
            ->get(['id', 'name', 'last_name']);


        return view('activity.subtask', [
            'activity' => $activity,
            'subtask' => $subtask,
            'subtasks' => $subtasks,
            'project' => $project,
            'contributions' => $contributions,
            'assignees' => $assignees
        ]);
    }

    public function accepthours(Request $request)
    {

        $acceptIds = $request->input('acceptids');
        $isApprove = $request->input('isApprove');
        if ($isApprove === 'true') {
            $isApprove = 1;
        } elseif ($isApprove === 'false') {
            $isApprove = 0;
        }
        // Update the 'approval' field in SubtaskContributor table
        $contribution = Contribution::findorFail($acceptIds);
        $contribution->update(['approval' => $isApprove]);

        if ($isApprove == 1) {
            $subtaskid = $contribution->subtask_id;
            $hoursrendered = $contribution->hours_rendered;
            Subtask::where('id', $subtaskid)->increment('hours_rendered', $hoursrendered);
            Contribution::where('subtask_id', $subtaskid)
                ->where('approval', null)
                ->delete();
        }
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
        $subtaskstartdate = date("Y-m-d", strtotime($request->input('subtaskstartdate')));
        $subtaskenddate = date("Y-m-d", strtotime($request->input('subtaskenddate')));

        $subtaskcontribution = new Contribution([
            'subtask_id' => $request->input('subtask-id'),
            'date' => $subtaskstartdate,
            'enddate' => $subtaskenddate,
            'submitter_id' => $request->input('submitter-id'),
            'hours_rendered' => $request->input('hours-rendered'),
            'relatedPrograms' => $request->input('related-program'),
            'clientNumbers' => $request->input('client-numbers'),
            'agency' => $request->input('agency'),
        ]);
        $subtaskcontribution->save();
        $subtaskcontributors = $request->input('subtaskcontributors');

        foreach ($subtaskcontributors as $subtaskcontributors) {
            SubtaskcontributionsUser::create([
                'contribution_id' => $subtaskcontribution->id,
                'user_id' => $subtaskcontributors,
            ]);
        }

        $selectedAssignees = User::where('role', 'Admin')
            ->get(['id']);
        $subtask = Subtask::where('id', $request->input('subtask-id'))->first();
        $subtaskname = $subtask ? $subtask->subtask_name : 'Unknown Subtask';

        $message = Auth::user()->name . ' ' . Auth::user()->last_name . ' submitted an accomplishment report for subtask: ' . $subtaskname . '.';

        foreach ($selectedAssignees as $selectedAssignee) {




            $notification = new Notification([
                'user_id' => $selectedAssignee->id,
                'task_id' => $subtaskcontribution->id,
                'task_type' => "subtaskcontribution",
                'task_name' => $subtaskname,
                'message' => $message,
            ]);
            $notification->save();
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
            'submissionid' => $subtaskcontribution->id,
        ]);
    }

    public function deleteSubtask(Request $request)
    {
        $subtaskid = $request->input('subtaskId');
        $subtask = Subtask::findorFail($subtaskid);
        $activityId = $subtask->activity_id;
        $subtask->delete();
        Notification::where('task_id', $subtaskid)
            ->where('task_type', 'subtask')
            ->delete();
        return response()->json([
            'actid' => $activityId,
        ]);
    }
}
