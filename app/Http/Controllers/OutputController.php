<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Routing\RedirectController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use App\Models\Output;
use App\Models\Activity;
use App\Models\User;
use App\Models\ActivityUser;
use App\Models\OutputUser;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Routing\Redirector;

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

    public function complyoutput($activityid, $outputtype)
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
        $project = Project::findorFail($projectId);

        return view('activity.submitoutput', [
            'activity' => $activity,
            'currentoutputtype' => $currentoutputtype,
            'project' => $project,
            'outputtype' => $outputtype,
            'assignees' => $assignees,
        ]);
    }

    public function addtooutput(Request $request)
    {
        $redirectId = 0;
        $validatedData = $request->validate([
            'output-id.*' => 'required|integer',
            'output-quantity.*' => 'required|integer',
            // return if facilitator need 'output-facilitator.*' => 'required|integer',
            'outputnumber' => 'required|integer',
            // return if facilitator need 'facilitatornumber' => 'required|integer',
        ]);

        /*  remove the save if facilitator back
        for ($i = 0; $i < $validatedData['facilitatornumber']; $i++) {
            
            for ($j = 0; $j < $validatedData['outputnumber']; $j++) {
                $outputuser = new OutputUser();
                $outputuser->output_id = $validatedData['output-id'][$j];
                $outputuser->user_id = $validatedData['output-facilitator'][$i];
                $outputuser->output_submitted = $validatedData['output-quantity'][$j];
                $outputuser->save();
            }
            
        }
        */
        for ($j = 0; $j < $validatedData['outputnumber']; $j++) {
            $outputuser = new OutputUser();
            $outputuser->output_id = $validatedData['output-id'][$j];
            $outputuser->output_submitted = $validatedData['output-quantity'][$j];
            $outputuser->user_id = Auth::user()->id;
            $outputuser->save();
            if ($j == 0) {
                $redirectId = $outputuser->id;
            }
        }
        $request->validate([
            'outputdocs' => 'required|mimes:docx|max:2048',
        ]);


        $file = $request->file('outputdocs');
        $originalName = $file->getClientOriginalName();
        $extension = $file->getClientOriginalExtension();
        $fileName = pathinfo($originalName, PATHINFO_FILENAME) . '.' . $extension;
        $currentDateTime = date('Y-m-d_H-i-s');
        // Store the file
        $path = $request->file('outputdocs')->storeAs('uploads/' . $currentDateTime, $fileName);

        return response()->json(['success' => true, 'redirectId' => $redirectId]);
    }

    public function acceptoutput(Request $request)
    {

        $acceptIds = $request->input('acceptids');
        $isApprove = $request->input('isApprove');

        if ($isApprove === 'true') {
            // Update the 'approval' field in SubtaskContributor table
            OutputUser::where('created_at', $acceptIds)->update(['approval' => 1]);
            $outputids = OutputUser::where('created_at', $acceptIds)
                ->distinct()
                ->pluck('output_id');
            foreach ($outputids as $outputid) {

                $outputuser = OutputUser::where('created_at', $acceptIds)
                    ->where('output_id', $outputid)
                    ->first();
                $outputsubmitted = $outputuser->output_submitted;
                Output::where('id', $outputid)->increment('totaloutput_submitted', $outputsubmitted);
            }
        } else {
            OutputUser::where('created_at', $acceptIds)->update(['approval' => 0]);
        }

        $id =   18;
        $cap = 'Capacity Building';
        $url = URL::route('get.output', ['activityid' => $id, 'outputtype' => $cap]);
        return redirect($url);
    }
}
