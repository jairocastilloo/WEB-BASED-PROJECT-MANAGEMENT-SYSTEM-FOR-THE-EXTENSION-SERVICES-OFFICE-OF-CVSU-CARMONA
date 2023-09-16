<?php

namespace App\Http\Controllers;


<<<<<<< HEAD
=======
use App\Models\Notification;
use App\Models\SubtaskcontributionsUser;
>>>>>>> origin/main
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\SubtaskContributor;
use App\Models\Subtask;
use App\Models\Activity;
<<<<<<< HEAD
=======
use Carbon\Carbon;
use App\Models\AcademicYear;
use App\Models\activityContribution;
use App\Models\ActivitycontributionsUser;
use App\Models\Contribution;
use Illuminate\Support\Facades\Auth;
>>>>>>> origin/main

class RecordController extends Controller
{
    //
    public function showrecords($username)
    {
<<<<<<< HEAD
        $user = User::where('username', $username)->firstOrFail();
        $userid = $user->id;
        $subtask_hours = SubtaskContributor::where('user_id', $userid)
            ->where('activity_id', null)
            ->where('approval', 1)
            ->get();
        $subtasksid = $subtask_hours->pluck('subtask_id')->unique();
        $allsubtasks = Subtask::whereIn('id', $subtasksid)->get();



        $allonlyactivities = SubtaskContributor::where('user_id', $userid)
            ->where('subtask_id', null)
            ->where('approval', 1)
            ->get();

        $activitiesid = $allsubtasks->pluck('activity_id')->unique();
        $onlyactivitiesid = $allonlyactivities->pluck('activity_id')->unique()->toArray();


        $activitiesid = $allsubtasks->pluck('activity_id')->merge($allonlyactivities->pluck('activity_id'))->unique();
        $allactivities = Activity::whereIn('id', $activitiesid)->get(['id', 'actname', 'project_id', 'actstartdate', 'actenddate']);
        return view('records.index', [
            'allactivities' => $allactivities,
            'allsubtasks' => $allsubtasks,
            'onlyactivitiesid' => $onlyactivitiesid,
=======

        $user = User::where('username', $username)->firstOrFail();

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

        $subhours = $subtaskcontributions->sum('hours_rendered');
        $acthours = $activityContributions->sum('hours_rendered');
        $totalhoursrendered = $subhours + $acthours;
        $notifications = Notification::where('user_id', Auth::user()->id)
            ->get();
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
            'totalhoursrendered' => $totalhoursrendered,
            'notifications' => $notifications,
        ]);
    }

    public function selectrecords($username, $ayid, $semester)
    {

        $user = User::where('username', $username)->firstOrFail();

        $ayfirstsem = [];
        $aysecondsem = [];
        $latestAy = [];

        $inCurrentYear = false;

        $allAY = AcademicYear::all(['id', 'acadstartdate', 'acadenddate']);

        $minSemDate = null;
        $maxSemDate = null;

        if ($semester == "1STSEM") {
            $ayfirstsem = AcademicYear::findorFail($ayid);
            $minSemDate = $ayfirstsem->firstsem_startdate;
            $maxSemDate = $ayfirstsem->firstsem_enddate;
        } else if ($semester == "2NDSEM") {
            $aysecondsem = AcademicYear::findorFail($ayid);
            $minSemDate = $aysecondsem->secondsem_startdate;
            $maxSemDate = $aysecondsem->secondsem_enddate;
        }

        $currentDate = Carbon::now();
        if ($currentDate >= $minSemDate && $currentDate <= $maxSemDate) {
            $inCurrentYear = true;
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

        $subhours = $subtaskcontributions->sum('hours_rendered');
        $acthours = $activityContributions->sum('hours_rendered');
        $totalhoursrendered = $subhours + $acthours;
        $notifications = Notification::where('user_id', Auth::user()->id)
            ->get();
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
            'totalhoursrendered' => $totalhoursrendered,
            'notifications' => $notifications,
>>>>>>> origin/main
        ]);
    }
}
