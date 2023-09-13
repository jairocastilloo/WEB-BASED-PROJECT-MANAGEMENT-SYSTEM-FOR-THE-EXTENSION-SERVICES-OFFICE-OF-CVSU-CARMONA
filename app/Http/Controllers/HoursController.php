<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\Activity;
use App\Models\activityContribution;
use App\Models\ActivitycontributionsUser;
use App\Models\User;

class HoursController extends Controller
{
    //

    public function displayhours($activityid, $activityname)
    {
        $activity = Activity::findOrFail($activityid);

        $project = Project::findorFail($activity->project_id);
        $projectId = $project->id;
        $projectName = $project->projecttitle;


        $activitycontributions = activityContribution::where('activity_id', $activityid)
            ->get();


        return view('activity.hours', [
            'activity' => $activity,
            'projectId' => $projectId,
            'projectName' => $projectName,
            'activitycontributions' => $activitycontributions,
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
