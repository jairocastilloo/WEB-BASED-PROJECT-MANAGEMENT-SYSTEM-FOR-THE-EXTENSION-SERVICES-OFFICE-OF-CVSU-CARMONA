<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Contribution;
use App\Models\Subtask;

class SubmissionController extends Controller
{
    //
    public function displaysubmission($submissionid, $asubmissionname)
    {
        $contribution = Contribution::findorFail($submissionid);

        $subtaskid = $contribution->subtask_id;
        $subtask = Subtask::findorFail($subtaskid);

        return view('activity.subtaskcontribution', [
            'contribution' => $contribution,
            'subtask' => $subtask
        ]);
    }
}
