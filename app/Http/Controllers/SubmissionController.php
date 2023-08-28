<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Contribution;
use App\Models\Subtask;
use App\Models\Activity;
use Illuminate\Support\Facades\Storage;


class SubmissionController extends Controller
{
    //
    public function displaysubmission($submissionid, $submissionname)
    {
        $nameofsubmission = str_replace('-', ' ', $submissionname);
        $contribution = Contribution::findorFail($submissionid);

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

        return view('activity.subtaskcontribution', [
            'contribution' => $contribution,
            'subtask' => $subtask,
            'subtasks' => $subtasks,
            'activity' => $activity,
            'projectName' => $projectName,
            'projectId' => $projectId,
            'nameofsubmission' => $nameofsubmission,
            'uploadedFiles' => $uploadedFiles,
            'currentDateTime' => $currentDateTime

        ]);
    }
}
