<?php

namespace App\Http\Controllers;

<<<<<<< HEAD
use App\Models\Subtask;
use App\Models\Activity;
=======
use App\Models\Notification;
use App\Models\Subtask;
use App\Models\Activity;
use Illuminate\Support\Facades\Auth;
>>>>>>> origin/main
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\SubtaskUser;
use App\Models\SubtaskContributor;
use App\Models\ActivityUser;
<<<<<<< HEAD
use Illuminate\Support\Carbon;
=======
use App\Models\Contribution;
use App\Models\SubtaskcontributionsUser;
use Illuminate\Support\Carbon;
use App\Models\User;
>>>>>>> origin/main

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
<<<<<<< HEAD
            'subtaskstartdate' => 'required|date|before_or_equal:subtaskenddate',
            'subtaskenddate' => 'required|date',
=======
            'subtaskduedate' => 'required|date',
>>>>>>> origin/main
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()]);
        }

        $subtaskname = $request->input('subtaskname');
        $activitynumber = $request->input('activitynumber');
<<<<<<< HEAD
        $subtaskstartdate = $request->input('subtaskstartdate');
        $subtaskenddate = $request->input('subtaskenddate');
=======
        $subtaskduedate = $request->input('subtaskduedate');
>>>>>>> origin/main
        $subtasks = new Subtask();

        $subtasks->subtask_name = $subtaskname;
        $subtasks->activity_id = $activitynumber;
<<<<<<< HEAD
        $subtasks->substartdate = $subtaskstartdate;
        $subtasks->subenddate = $subtaskenddate;
=======
        $subtasks->subduedate = $subtaskduedate;
>>>>>>> origin/main
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
<<<<<<< HEAD

=======
        $notifications = Notification::where('user_id', Auth::user()->id)
            ->get();
>>>>>>> origin/main
        return view('activity.submitsubtask', [
            'activity' => $activity,
            'subtask' => $subtask,
            'projectName' => $projectName,
            'projectId' => $projectId,
            'currentassignees' => $currentassignees,
<<<<<<< HEAD
=======
            'notifications' => $notifications,
>>>>>>> origin/main
        ]);
    }

    public function addtosubtask(Request $request)
    {

        $validatedData = $request->validate([
            'subtask-id' => 'required|integer',
            'subtask-contributor.*' => 'required|integer',
            'contributornumber' => 'required|integer',
            'hours-rendered' => 'required|integer',
<<<<<<< HEAD
        ]);

=======
            'subtask-date' => 'required|date',
        ]);

        $subtaskcontributor = new Contribution();
        $subtaskcontributor->subtask_id = $validatedData['subtask-id'];
        $subtaskcontributor->hours_rendered = $validatedData['hours-rendered'];
        $subtaskcontributor->date = $validatedData['subtask-date'];
        $subtaskcontributor->submitter_id = Auth::user()->id;
        $subtaskcontributor->save();
        $newsubtaskcontributor = $subtaskcontributor->id;
>>>>>>> origin/main

        for ($i = 0; $i < $validatedData['contributornumber']; $i++) {


<<<<<<< HEAD
            $subtaskcontributor = new SubtaskContributor();
            $subtaskcontributor->user_id = $validatedData['subtask-contributor'][$i];
            $subtaskcontributor->subtask_id = $validatedData['subtask-id'];
            $subtaskcontributor->hours_rendered = $validatedData['hours-rendered'];
=======
            $subtaskcontributor = new SubtaskcontributionsUser();
            $subtaskcontributor->user_id = $validatedData['subtask-contributor'][$i];
            $subtaskcontributor->contribution_id = $newsubtaskcontributor;
>>>>>>> origin/main
            $subtaskcontributor->save();
        }

        $request->validate([
            'subtaskdocs' => 'required|mimes:docx|max:2048',
        ]);


        $file = $request->file('subtaskdocs');
        $originalName = $file->getClientOriginalName();
        $extension = $file->getClientOriginalExtension();
<<<<<<< HEAD
        $fileName = Str::slug(pathinfo($originalName, PATHINFO_FILENAME)) . '.' . $extension;
=======
        $fileName = pathinfo($originalName, PATHINFO_FILENAME) . '.' . $extension;
>>>>>>> origin/main
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

<<<<<<< HEAD
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


=======
        $contributions = Contribution::where('subtask_id', $subtaskid)
            ->get();
        $notifications = Notification::where('user_id', Auth::user()->id)
            ->get();

>>>>>>> origin/main
        return view('activity.subtask', [
            'activity' => $activity,
            'subtask' => $subtask,
            'subtasks' => $subtasks,
            'projectName' => $projectName,
            'projectId' => $projectId,
            'assignees' => $assignees,
            'currentassignees' => $currentassignees,
<<<<<<< HEAD
            'unapprovedsubtaskdata' => $unapprovedsubtaskdata,
            'usersWithSameCreatedAt' => $usersWithSameCreatedAt,
=======
            'contributions' => $contributions,
            'notifications' => $notifications,
>>>>>>> origin/main
        ]);
    }

    public function accepthours(Request $request)
    {

        $acceptIds = $request->input('acceptids');
<<<<<<< HEAD

        // Update the 'approval' field in SubtaskContributor table
        SubtaskContributor::where('created_at', $acceptIds)->update(['approval' => 1]);

        // Get the subtask_id and hours_rendered for the first record with the specified created_at value
        $subtaskContributor = SubtaskContributor::where('created_at', $acceptIds)->first();
        $subtaskid = $subtaskContributor->subtask_id;
        $hoursrendered = $subtaskContributor->hours_rendered;

        // Update the 'hours_rendered' field in the Subtask table
        Subtask::where('id', $subtaskid)->increment('hours_rendered', $hoursrendered);

=======
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
>>>>>>> origin/main
        return 'File uploaded successfully.';
    }
}
