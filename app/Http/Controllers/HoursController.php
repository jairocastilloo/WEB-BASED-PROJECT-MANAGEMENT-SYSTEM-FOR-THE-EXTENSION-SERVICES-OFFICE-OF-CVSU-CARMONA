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

        $activitycontribution = activityContribution::findorFail($acceptIds);

        $activitycontribution->update(['approval' => 1]);

        $activityid = $activitycontribution->activity_id;
        $hoursrendered = $activitycontribution->hours_rendered;

        Activity::where('id', $activityid)->increment('totalhours_rendered', $hoursrendered);

        return 'File uploaded successfully.';
    }
}
