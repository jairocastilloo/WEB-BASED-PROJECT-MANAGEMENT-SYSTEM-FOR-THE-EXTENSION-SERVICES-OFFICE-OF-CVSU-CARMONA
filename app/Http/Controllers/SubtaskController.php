<?php

namespace App\Http\Controllers;

use App\Models\Subtask;
use App\Models\Activity;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\SubtaskUser;
use App\Models\SubtaskContributor;
use App\Models\ActivityUser;
use Illuminate\Support\Carbon;

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
        $projectName = $activity->project->projecttitle;

        return view('activity.submitsubtask', [
            'activity' => $activity,
            'subtask' => $subtask,
            'projectName' => $projectName,
            'projectId' => $projectId,
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
        ]);


        for ($i = 0; $i < $validatedData['contributornumber']; $i++) {


            $subtaskcontributor = new SubtaskContributor();
            $subtaskcontributor->user_id = $validatedData['subtask-contributor'][$i];
            $subtaskcontributor->subtask_id = $validatedData['subtask-id'];
            $subtaskcontributor->hours_rendered = $validatedData['hours-rendered'];
            $subtaskcontributor->save();
        }

        $request->validate([
            'subtaskdocs' => 'required|mimes:docx|max:2048',
        ]);


        $file = $request->file('subtaskdocs');
        $originalName = $file->getClientOriginalName();
        $extension = $file->getClientOriginalExtension();
        $fileName = Str::slug(pathinfo($originalName, PATHINFO_FILENAME)) . '.' . $extension;
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

    public function accepthours(Request $request)
    {

        $acceptIds = $request->input('acceptids');

        // Update the 'approval' field in SubtaskContributor table
        SubtaskContributor::where('created_at', $acceptIds)->update(['approval' => 1]);

        // Get the subtask_id and hours_rendered for the first record with the specified created_at value
        $subtaskContributor = SubtaskContributor::where('created_at', $acceptIds)->first();
        $subtaskid = $subtaskContributor->subtask_id;
        $hoursrendered = $subtaskContributor->hours_rendered;

        // Update the 'hours_rendered' field in the Subtask table
        Subtask::where('id', $subtaskid)->increment('hours_rendered', $hoursrendered);

        return 'File uploaded successfully.';
    }
}
