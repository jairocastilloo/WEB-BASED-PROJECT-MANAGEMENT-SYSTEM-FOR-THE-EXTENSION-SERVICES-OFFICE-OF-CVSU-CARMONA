<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Contribution;
use App\Models\Subtask;
use App\Models\Activity;
use App\Models\User;
use Illuminate\Support\Facades\Storage;
use App\Models\SubtaskcontributionsUser;

class SubmissionController extends Controller
{
    //
    public function displaysubmission($submissionid, $submissionname)
    {
        $nameofsubmission = str_replace('-', ' ', $submissionname);
        $contribution = Contribution::findorFail($submissionid);

        $submitterid = $contribution->submitter_id;
        $submitter = User::where('id', $submitterid)->get(['name', 'last_name']);

        $contributorids = SubtaskcontributionsUser::where('contribution_id', $submissionid)
            ->pluck('user_id');
        $contributors = User::whereIn('id', $contributorids)->get(['name', 'last_name']);

        $subtaskid = $contribution->subtask_id;
        $subtask = Subtask::findorFail($subtaskid);
        $activityid = $subtask->activity_id;
        $activity = Activity::findOrFail($activityid);

        $projectId = $activity->project_id;
        $projectName = $activity->project->projecttitle;

        $subtasks = Subtask::where('activity_id', $activityid)->get();

        $dateTime = $contribution->created_at;
        $currentDateTime = str_replace(' ', '_', $dateTime);
        $currentDateTime = str_replace(':', '-', $currentDateTime);
        $uploadedFiles = Storage::files('uploads/' . $currentDateTime);

        $othercontribution = Contribution::where('subtask_id', $subtaskid)
            ->whereNotIn('id', [$submissionid])
            ->get();

        return view('activity.subtaskcontribution', [
            'contribution' => $contribution,
            'subtask' => $subtask,
            'subtasks' => $subtasks,
            'activity' => $activity,
            'projectName' => $projectName,
            'projectId' => $projectId,
            'nameofsubmission' => $nameofsubmission,
            'uploadedFiles' => $uploadedFiles,
            'currentDateTime' => $currentDateTime,
            'othercontribution' => $othercontribution,
            'contributors' => $contributors,
            'submitter' => $submitter
        ]);
    }
}
