<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Models\User;
use App\Models\SubtaskContributor;
use App\Models\Subtask;
use App\Models\Activity;
use Carbon\Carbon;
use App\Models\AcademicYear;
use App\Models\activityContribution;
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
            ->get();

        $aysecondsem = AcademicYear::where('secondsem_startdate', '<=', $currentDate)
            ->where('secondsem_enddate', '>=', $currentDate)
            ->get();

        $allAY = AcademicYear::all(['id', 'firstsem_startdate', 'firstsem_enddate', 'secondsem_startdate', 'secondsem_enddate']);

        $latestAy = AcademicYear::latest()->get();
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


        $subtaskcontributions = Contribution::where('user_id', $userid)
            ->where('approval', 1)
            ->whereDate('date', '>=', $minSemDate)
            ->whereDate('date', '<=', $maxSemDate)
            ->get();
        if ($subtaskcontributions) {
            $subtasksid = $subtaskcontributions->pluck('subtask_id')->toArray();

            $allsubtasks = Subtask::whereIn('id', $subtasksid)
                ->get();

            $otheractivities = $allsubtasks->pluck('activity_id')->toArray();
        }
        $activitycontributions = activityContribution::where('user_id', $userid)
            ->where('approval', 1)
            ->whereDate('startdate', '>=', $minSemDate)
            ->whereDate('enddate', '<=', $maxSemDate)
            ->get();

        $activitiesid = $activitycontributions->pluck('activity_id')->toArray();

        $allactivities = array_merge($otheractivities, $activitiesid);

        $allactivities = Activity::whereIn('id', $allactivities)
            ->get();

        return view('records.index', [
            'user' => $user,
            'ayfirstsem' => $ayfirstsem,
            'aysecondsem' => $aysecondsem,
            'allAY' => $allAY,
        ]);
    }
}
