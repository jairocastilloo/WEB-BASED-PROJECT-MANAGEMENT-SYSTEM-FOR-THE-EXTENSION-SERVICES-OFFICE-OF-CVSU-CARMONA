<?php

namespace App\Http\Controllers;

use App\Models\ActivityUser;
use App\Models\Activity;
use App\Models\Objective;
use Illuminate\Http\Request;
use App\Models\User;

use App\Models\Project;
use App\Models\ProjectUser;
use App\Models\Subtask;
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


        $activityData = [
            'actname' => $activityname,
            'actobjectives' => $objectives,
            'actoutput' => $expectedoutput,
            'actstartdate' => $activitystartdate,
            'actenddate' => $activityenddate,
            'actbudget' => $budget,
            'actsource' => $source,
            'project_id' => $projectindex,
        ];
        DB::table('activities')->insert($activityData);
        $newactivityId = DB::getPdo()->lastInsertId();

        $validatedData = $request->validate([
            'assignees.*' => 'required|integer', // Validate each select input
            'assigneesindex' => 'required|integer',
            'assigneesname.*' => 'required',
            // Validate select count
        ]);
        for ($i = 0; $i < $validatedData['assigneesindex']; $i++) {
            $assignees = new ActivityUser();
            $assignees->user_id = $validatedData['assignees'][$i];
            $assignees->assignees_name = $validatedData['assigneesname'][$i];
            $assignees->activity_id = $newactivityId;
            $assignees->save();
        }


        return response()->json(['success' => true]);
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

        $subtasks = new Subtask();
        $subtasks->subtask_name = $subtaskname;
        $subtasks->subtask_assignee = $subtaskassignee;
        $subtasks->activity_id = $activitynumber;
        $subtasks->user_id = $userid;
        $subtasks->save();

        return response()->json(['success' => true]);
    }
}
