<?php

namespace App\Http\Controllers;


use App\Models\SubtaskcontributionsUser;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\SubtaskContributor;
use App\Models\Subtask;
use App\Models\Activity;
use Carbon\Carbon;
use App\Models\AcademicYear;
use App\Models\activityContribution;
use App\Models\ActivitycontributionsUser;
use App\Models\Contribution;

class RecordController extends Controller
{
    //
    public function showrecords($username)
    {

        $user = User::where('username', $username)->firstOrFail();
        $userid = $user->id;

        $currentDate = Carbon::now();

        $ayfirstsem = AcademicYear::where('firstsem_startdate', '<=', $currentDate)
            ->where('firstsem_enddate', '>=', $currentDate)
            ->first();

        $aysecondsem = AcademicYear::where('secondsem_startdate', '<=', $currentDate)
            ->where('secondsem_enddate', '>=', $currentDate)
            ->first();

        $allAY = AcademicYear::all(['id', 'acadstartdate', 'acadenddate']);

        $latestAy = AcademicYear::latest()->first();
        $inCurrentYear = false;
        $minSemDate = null;
        $maxSemDate = null;
        if ($ayfirstsem) {
            $inCurrentYear = true;
            $minSemDate = $ayfirstsem->firstsem_startdate;
            $maxSemDate = $ayfirstsem->firstsem_enddate;
        } elseif ($aysecondsem) {
            $inCurrentYear = true;
            $minSemDate = $aysecondsem->secondsem_startdate;
            $maxSemDate = $aysecondsem->secondsem_enddate;
        } elseif ($latestAy) {

            $minSemDate = $latestAy->firstsem_startdate;
            $maxSemDate = $latestAy->firstsem_enddate;
        }

        $subtaskcontributions = $user->contributions()
            ->where('approval', 1)
            ->whereDate('date', '>=', $minSemDate)
            ->whereDate('date', '<=', $maxSemDate)
            ->get();

        $subtasks = [];
        $otheractivities = [];
        $activitiesid = [];
        $allactivities = [];

        if (!$subtaskcontributions->isEmpty()) {
            $subtaskcontributionsIds = $subtaskcontributions->pluck('subtask_id')->toArray();
            $subtasks = Subtask::whereIn('id', $subtaskcontributionsIds)->get();
            $otheractivities = $subtasks->pluck('activity_id')->toArray();
        }

        $activityContributions = $user->activitycontributions()
            ->where('approval', 1)
            ->whereDate('startdate', '>=', $minSemDate)
            ->whereDate('enddate', '<=', $maxSemDate)
            ->get();

        if (!$activityContributions->isEmpty()) {
            $activitiesid = $activityContributions->pluck('activity_id')->toArray();
        }

        $allactivitiesid = array_unique(array_merge($otheractivities, $activitiesid));

        if ($allactivitiesid) {
            $allactivities = Activity::whereIn('id', $allactivitiesid)
                ->get();
        }

        return view('records.index', [
            'user' => $user,
            'ayfirstsem' => $ayfirstsem,
            'aysecondsem' => $aysecondsem,
            'allAY' => $allAY,
            'inCurrentYear' => $inCurrentYear,
            'latestAy' => $latestAy,
            'subtasks' => $subtasks,
            'subtaskcontributions' => $subtaskcontributions,
            'activityContributions' => $activityContributions,
            'allactivities' => $allactivities,
            'otheractivities' => $otheractivities,
        ]);
    }
}
