<?php

namespace App\Http\Controllers;

use App\Models\ActivitycontributionsUser;
use App\Models\Notification;
use App\Models\Output;
use App\Models\OutputUser;
use App\Models\Project;
use App\Models\ProjectTerminal;
use Illuminate\Http\Request;
use App\Models\Contribution;
use App\Models\Subtask;
use App\Models\Activity;

use App\Models\activityContribution;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
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
        $submitter = User::where('id', $submitterid)->get(['name', 'last_name', 'middle_name']);

        $contributorids = SubtaskcontributionsUser::where('contribution_id', $submissionid)
            ->pluck('user_id');
        $contributors = User::whereIn('id', $contributorids)->get(['name', 'last_name', 'middle_name']);

        $subtaskid = $contribution->subtask_id;
        $subtask = Subtask::findorFail($subtaskid);
        $activityid = $subtask->activity_id;
        $activity = Activity::findOrFail($activityid);

        $projectId = $activity->project_id;
        $project = Project::findorFail($projectId);


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
            'activity' => $activity,
            'project' => $project,
            'nameofsubmission' => $nameofsubmission,
            'uploadedFiles' => $uploadedFiles,
            'currentDateTime' => $currentDateTime,
            'othercontribution' => $othercontribution,
            'contributors' => $contributors,
            'submitter' => $submitter,
        ]);
    }

    public function displaysubmittedoutput($submittedoutputid, $outputtype, $submissionname)
    {
        $nameofsubmission = str_replace('-', ' ', $submissionname);
        $outputtype = str_replace('-', ' ', $outputtype);
        $submittedoutput = OutputUser::findorFail($submittedoutputid);
        $created = $submittedoutput->created_at;

        $submittedoutputs = OutputUser::where('created_at', $created)
            ->get();
        $submittedoutputids = $submittedoutputs->pluck('id')->toArray();


        $submitterid = $submittedoutput->user_id;
        $submitter = User::where('id', $submitterid)->get(['name', 'last_name', 'middle_name']);


        $outputids = OutputUser::where('created_at', $created)
            ->pluck('output_id')
            ->toArray();

        $outputs = Output::whereIn('id', $outputids)->get();
        $outputNames = $outputs->pluck('output_name')
            ->toArray();
        $activityid = $outputs[0]->activity_id;
        $activity = Activity::findOrFail($activityid);

        $projectId = $activity->project_id;
        $project = Project::findorFail($projectId);

        $dateTime = $submittedoutput->created_at;
        $currentDateTime = str_replace(' ', '_', $dateTime);
        $currentDateTime = str_replace(':', '-', $currentDateTime);
        $uploadedFiles = Storage::files('uploads/' . $currentDateTime);

        $othersubmittedoutput = OutputUser::whereIn('output_id', $outputids)
            ->whereNotIn('id', $submittedoutputids)
            ->get();

        return view('activity.outputsubmitted', [
            'submittedoutputs' => $submittedoutputs,
            'outputs' => $outputs,
            'outputtype' => $outputtype,
            'outputNames' => $outputNames,
            'activity' => $activity,
            'project' => $project,
            'nameofsubmission' => $nameofsubmission,
            'uploadedFiles' => $uploadedFiles,
            'currentDateTime' => $currentDateTime,
            'othersubmittedoutput' => $othersubmittedoutput,
            'submitter' => $submitter,
        ]);
    }

    public function displayactsubmission($actsubmissionid, $actsubmissionname)
    {
        $nameofactsubmission = str_replace('-', ' ', $actsubmissionname);
        $actcontribution = activityContribution::findorFail($actsubmissionid);

        $submitterid = $actcontribution->submitter_id;
        $submitter = User::where('id', $submitterid)->get(['name', 'last_name', 'middle_name']);

        $actcontributorids = ActivitycontributionsUser::where('activitycontribution_id', $actsubmissionid)
            ->pluck('user_id');
        $actcontributors = User::whereIn('id', $actcontributorids)->get(['name', 'last_name', 'middle_name']);

        $activityid = $actcontribution->activity_id;
        $activity = Activity::findOrFail($activityid);

        $projectId = $activity->project_id;
        $project = Project::findorFail($projectId);

$outputTypes = Output::where('activity_id', $activityid)
->pluck('output_type')
->unique()
->toArray();

// Assuming $activityid and $actsubmissionid are defined

// Fetch all outputs related to the given activity
$outputs = Output::where('activity_Id', $activityid)
    ->get(['id', 'output_name', 'output_type']);

// Fetch all output submissions related to the given activity submission
$outputSubmissions = OutputUser::where('actcontribution_id', $actsubmissionid)
    ->get(['output_id', 'output_submitted']);

// Organize output submissions into an associative array for quick lookup
$outputSubmissionsMap = $outputSubmissions->keyBy('output_id');

// Loop through each output and attach the output_submitted attribute
foreach ($outputs as $output) {
    $outputId = $output->id;

    // Check if there is a corresponding output submission
    if ($outputSubmissionsMap->has($outputId)) {
        $output->output_submitted = $outputSubmissionsMap[$outputId]->output_submitted;
    } else {
        // If no submission found, set output_submitted to null or a default value
        $output->output_submitted = null; // You can set a default value if needed
    }
}



        $dateTime = $actcontribution->created_at;
        $currentDateTime = str_replace(' ', '_', $dateTime);
        $currentDateTime = str_replace(':', '-', $currentDateTime);
        $uploadedFiles = Storage::files('uploads/' . $currentDateTime);

        $otheractcontribution = activityContribution::where('activity_id', $activityid)
            ->whereNotIn('id', [$actsubmissionid])
            ->get();

        return view('activity.activitycontributions', [
            'actcontribution' => $actcontribution,
            'activity' => $activity,
            'project' => $project,
            'nameofactsubmission' => $nameofactsubmission,
            'uploadedFiles' => $uploadedFiles,
            'currentDateTime' => $currentDateTime,
            'otheractcontribution' => $otheractcontribution,
            'actcontributors' => $actcontributors,
            'submitter' => $submitter,
            'outputTypes' => $outputTypes,
            'outputs' => $outputs
        ]);
    }

    public function displayprojsubmission($projsubmissionid, $projsubmissionname)
    {
        $nameofprojsubmission = str_replace('-', ' ', $projsubmissionname);
        $projcontribution = ProjectTerminal::findorFail($projsubmissionid);

        $submitterid = $projcontribution->submitter_id;
        $submitter = User::where('id', $submitterid)->first(['name', 'last_name']);


        $projectId = $projcontribution->project_id;
        $project = Project::findorFail($projectId);


        $dateTime = $projcontribution->created_at;
        $currentDateTime = str_replace(' ', '_', $dateTime);
        $currentDateTime = str_replace(':', '-', $currentDateTime);
        $uploadedFiles = Storage::files('uploads/' . $currentDateTime);

        $otherprojcontribution = ProjectTerminal::where('project_id', $projectId)
            ->whereNotIn('id', [$projsubmissionid])
            ->get();

        return view('project.terminalreport', [
            'projcontribution' => $projcontribution,
            'project' => $project,
            'nameofprojsubmission' => $nameofprojsubmission,
            'uploadedFiles' => $uploadedFiles,
            'currentDateTime' => $currentDateTime,
            'otherprojcontribution' => $otherprojcontribution,
            'submitter' => $submitter,
        ]);
    }
}
