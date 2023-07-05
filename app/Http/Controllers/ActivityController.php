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
            $assignees->project_id = $projectindex;
            $assignees->save();
        }

        $validatedOutput = $request->validate([
            'output.*' => 'required', // Validate each select input
            'outputindex' => 'required|integer',
            // Validate select count
        ]);

        for ($i = 0; $i < $validatedOutput['outputindex']; $i++) {
            if ($validatedOutput['output'][$i] === 'Capacity building') {
                $output1 = new Output();
                $output1->output_type = $validatedOutput['output'][$i];
                $output1->output_name = 'Number of trainees';
                $output1->activity_id = $newactivityId;
                $output1->save();

                $output2 = new Output();
                $output2->output_type = $validatedOutput['output'][$i];
                $output2->output_name = 'Number of training';
                $output2->activity_id = $newactivityId;
                $output2->save();
            } else if ($validatedOutput['output'][$i] === 'IEC Material') {
                $output1 = new Output();
                $output1->output_type = $validatedOutput['output'][$i];
                $output1->output_name = 'Number of recipient';
                $output1->activity_id = $newactivityId;
                $output1->save();

                $output2 = new Output();
                $output2->output_type = $validatedOutput['output'][$i];
                $output2->output_name = 'Number of IEC Material';
                $output2->activity_id = $newactivityId;
                $output2->save();
            } else if ($validatedOutput['output'][$i] === 'Advisory Services') {
                $output1 = new Output();
                $output1->output_type = $validatedOutput['output'][$i];
                $output1->output_name = 'Number of recipient';
                $output1->activity_id = $newactivityId;
                $output1->save();
            } else if ($validatedOutput['output'][$i] === 'Others') {
                $output1 = new Output();
                $output1->output_type = $validatedOutput['output'][$i];
                $output1->output_name = 'To be Added';
                $output1->activity_id = $newactivityId;
                $output1->save();
            }
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
