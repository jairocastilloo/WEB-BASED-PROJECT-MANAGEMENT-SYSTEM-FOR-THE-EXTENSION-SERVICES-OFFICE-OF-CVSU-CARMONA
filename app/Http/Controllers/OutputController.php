<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use App\Models\Output;
use App\Models\Activity;
use App\Models\User;
use App\Models\ActivityUser;

class OutputController extends Controller
{
    //
    public function submitoutput(Request $request)
    {

        $validatedData = $request->validate([
            'output-number.*' => 'required|integer',
            'out-name.*' => 'required',
            'out-type.*' => 'required',
            'submitoutputindex' => 'required|integer',
        ]);

        for ($i = 0; $i < $validatedData['submitoutputindex']; $i++) {
            $output = Output::where('output_name', $validatedData['out-name'][$i])
                ->where('output_type', $validatedData['out-type'][$i])
                ->first();

            if ($output) {
                // Update the value of output_submitted
                $output->output_submitted = $validatedData['output-number'][$i];
                $output->save();
            }
        }
        return response()->json(['success' => true]);
    }
    public function addoutput(Request $request)
    {

        $validatedData = $request->validate([
            'outputactnumber' => 'required|integer',
            'outputindex' => 'required|integer',
            'outputtype' => 'required|max:255',
            'newoutput.*' => 'required|max:255'
        ]);

        for ($i = 0; $i < $validatedData['outputindex']; $i++) {
            $output = new Output();
            $output->output_type = $validatedData['outputtype'];
            $output->output_name = $validatedData['newoutput'][$i];
            $output->activity_id = $validatedData['outputactnumber'];
            $output->save();
        }
    }

    public function complyoutput($id, $activityid, $outputtype)
    {

        // activity details
        $activity = Activity::findOrFail($activityid);

        // activity outputs
        $currentoutputtype = Output::where('activity_id', $activityid)
            ->where('output_type', $outputtype)
            ->get();
        // activity assignees
        $activityUser = ActivityUser::where('activity_id', $activityid)
            ->with('user:id,name,middle_name,last_name,email,role')
            ->get();

        $assignees = $activityUser->map(function ($item) {
            return $item->user;
        });

        $projectId = $activity->project_id;
        $projectName = $activity->project->projecttitle;

        return view('activity.submitoutput', [
            'activity' => $activity,
            'currentoutputtype' => $currentoutputtype,
            'projectName' => $projectName,
            'projectId' => $projectId,
            'outputtype' => $outputtype,
            'assignees' => $assignees,
        ]);
    }
}
