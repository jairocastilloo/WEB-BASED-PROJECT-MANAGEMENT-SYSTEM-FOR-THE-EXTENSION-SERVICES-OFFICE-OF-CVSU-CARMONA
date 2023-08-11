<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\Activity;
use App\Models\activityContribution;
use App\Models\ActivitycontributionsUser;

class HoursController extends Controller
{
    //

    public function displayhours($activityid, $department, $activityname)
    {
        $activity = Activity::findOrFail($activityid);

        $project = Project::findorFail($activity->project_id);
        $projectId = $project->id;
        $projectName = $project->projecttitle;


        $unapprovedhours = activityContribution::where('activity_id', $activityid)
            ->where('approval', 0)
            ->first();
        $unapprovedhoursContributors = [];
        if ($unapprovedhours) {
            $unapprovedhoursid = $unapprovedhours->id;
            $unapprovedhoursContributors = ActivityContributionsUser::where('activity_id', $activityid)
                ->whereIn('activitycontribution_id', $unapprovedhoursid)
                ->pluck('user_id');
        }


        return view('activity.hours', [
            'activity' => $activity,
            'projectId' => $projectId,
            'projectName' => $projectName,
            'unapprovedhours' => $unapprovedhours,
            'unapprovedhoursContributors' => $unapprovedhoursContributors
        ]);
    }
}
