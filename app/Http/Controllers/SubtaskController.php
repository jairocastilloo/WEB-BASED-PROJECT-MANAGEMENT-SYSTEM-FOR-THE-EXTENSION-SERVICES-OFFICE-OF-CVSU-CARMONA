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
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()]);
        }

        $subtaskname = $request->input('subtaskname');
        $activitynumber = $request->input('activitynumber');

        $subtasks = new Subtask();

        $subtasks->subtask_name = $subtaskname;
        $subtasks->activity_id = $activitynumber;
        $subtasks->save();
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

    public function complysubtask($id, $activityid, $subtaskid)
    {
        // activity details
        $activity = Activity::findOrFail($activityid);
        $subtask = Subtask::findOrFail($subtaskid);
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

        // Store the file
        $path = $request->file('subtaskdocs')->storeAs('uploads', $fileName);
        // Save the file path to the database or perform any other necessary actions
        // ...

        return 'File uploaded successfully.';
    }
}
