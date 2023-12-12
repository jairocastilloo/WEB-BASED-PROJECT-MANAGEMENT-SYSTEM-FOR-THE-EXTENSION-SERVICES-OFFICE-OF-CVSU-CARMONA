<?php

namespace App\Http\Controllers;

use App\Models\ActivityUser;
use App\Models\Notification;
use App\Models\Output;
use App\Models\Subtask;
use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\Activity;
use App\Models\activityContribution;
use App\Models\ActivitycontributionsUser;
use App\Models\User;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class HoursController extends Controller
{
    //

    public function displayhours($activityid)
    {
        $activity = Activity::findOrFail($activityid);

        $project = Project::findorFail($activity->project_id);

        $outputTypes = Output::where('activity_id', $activityid)
            ->distinct('output_type')
            ->pluck('output_type');
        $outputs = Output::where('activity_id', $activityid)
            ->get();

        $allSubtasks = Subtask::where('activity_id', $activityid)->count();
        $completedSubtasks = Subtask::where('activity_id', $activityid)
            ->where('status', 'Completed')
            ->count();
        $activeSubtasks = Subtask::where('activity_id', $activityid)
            ->where('status', 'Incomplete')
            ->where('subduedate', '>=', Carbon::now())
            ->count();
        $missingSubtasks = Subtask::where('activity_id', $activityid)
            ->where('status', 'Incomplete')
            ->where('subduedate', '<', Carbon::now())
            ->count();
        $activitycontributions = activityContribution::where('activity_id', $activityid)
            ->get();
        $implementerIds = ActivityUser::where('activity_id', $activityid)
            ->pluck('user_id')
            ->toArray();
        $implementers = User::whereIn('id', $implementerIds)
            ->select('id', 'name', 'last_name', 'middle_name')
            ->get();
        return view('activity.hours', [
            'activity' => $activity,
            'project' => $project,
            'activitycontributions' => $activitycontributions,
            'outputTypes' => $outputTypes,
            'outputs' => $outputs,
            'allSubtasks' => $allSubtasks,
            'completedSubtasks' => $completedSubtasks,
            'activeSubtasks' => $activeSubtasks,
            'missingSubtasks' => $missingSubtasks,
            'implementers' => $implementers
        ]);
    }

    public function acceptacthours(Request $request)
    {
        $acceptIds = $request->input('acceptids');
        $isApprove = $request->input('isApprove');
        if ($isApprove === 'true') {
            $isApprove = 1;
        } elseif ($isApprove === 'false') {
            $isApprove = 0;
        }
        // Update the 'approval' field in SubtaskContributor table
        $actcontribution = activityContribution::findorFail($acceptIds);
        $actcontribution->update(['approval' => $isApprove]);

        if ($isApprove == 1) {
            $activityid = $actcontribution->activity_id;
            $hoursrendered = $actcontribution->hours_rendered;
            Activity::where('id', $activityid)->increment('totalhours_rendered', $hoursrendered);
            activityContribution::where('activity_id', $activityid)
                ->where('approval', null)
                ->delete();
        }
        return 'File uploaded successfully.';
    }
}