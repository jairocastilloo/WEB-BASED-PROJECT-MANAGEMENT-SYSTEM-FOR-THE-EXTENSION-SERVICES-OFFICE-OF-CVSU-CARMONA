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


        $unapprovedhours = activityContribution::where('activity_id', $activityid)
            ->where('approval', 0)
            ->first();
        $hoursContributors = [];
        $contributors = [];
        if ($unapprovedhours) {
            $unapprovedhoursid = $unapprovedhours->id;
            $hoursContributors = ActivityContributionsUser::where('activitycontribution_id', $unapprovedhoursid)
                ->pluck('user_id');
            $contributors = User::whereIn('id', $hoursContributors)
                ->get();
        }

        $approvedhours = activityContribution::where('activity_id', $activityid)
            ->where('approval', 1)
            ->first();
        if ($approvedhours) {
            $approvedhoursid = $approvedhours->id;
            $hoursContributors = ActivityContributionsUser::where('activitycontribution_id', $approvedhoursid)
                ->pluck('user_id');
            $contributors = User::whereIn('id', $hoursContributors)
                ->get();
        }

        return view('activity.hours', [
            'activity' => $activity,
            'projectId' => $projectId,
            'projectName' => $projectName,
            'unapprovedhours' => $unapprovedhours,
            'approvedhours' => $approvedhours,
            'contributors' => $contributors,
            'hoursContributors' => $hoursContributors,
        ]);
    }

    public function acceptacthours(Request $request)
    {

        $acceptIds = $request->input('acceptids');

        $activitycontribution = activityContribution::findorFail($acceptIds);

        $activitycontribution->update(['approval' => 1]);

        $activityid = $activitycontribution->activity_id;
        $hoursrendered = $activitycontribution->hours_rendered;

        Activity::where('id', $activityid)->increment('totalhours_rendered', $hoursrendered);

        return 'File uploaded successfully.';
    }
}
