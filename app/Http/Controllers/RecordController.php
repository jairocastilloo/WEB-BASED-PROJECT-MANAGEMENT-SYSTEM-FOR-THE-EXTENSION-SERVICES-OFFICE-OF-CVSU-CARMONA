<?php

namespace App\Http\Controllers;


use App\Models\Notification;
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
use App\Models\ProjectLeader;
use App\Models\ProgramLeader;
use App\Models\Project;
use Illuminate\Support\Facades\Auth;

class RecordController extends Controller
{
    //
    public function showrecords($username)
    {

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
        $allprojects = [];
        $allprojectIds = [];

        if (!$subtaskcontributions->isEmpty()) {
            $subtaskcontributionsIds = $subtaskcontributions->pluck('subtask_id')->toArray();
            $subtasks = Subtask::whereIn('id', $subtaskcontributionsIds)->get();
            $otheractivities = $subtasks->pluck('activity_id')->unique()->toArray();
        }

        $activityContributions = $user->activitycontributions()
            ->where('approval', 1)
            ->whereDate('startdate', '>=', $minSemDate)
            ->whereDate('enddate', '<=', $maxSemDate)
            ->get();

        if (!$activityContributions->isEmpty()) {
            $activitiesid = $activityContributions->pluck('activity_id')->unique()->toArray();
        }

        $allactivitiesid = array_unique(array_merge($otheractivities, $activitiesid));

        if ($allactivitiesid) {
            $allactivities = Activity::whereIn('id', $allactivitiesid)
                ->get();
            $allprojectIds = $allactivities->pluck('project_id')->unique()->toArray();
            $allprojects = Project::whereIn('id', $allprojectIds)
                ->get(['id', 'projecttitle', 'department']);
        }
        if ($allprojects) {
            foreach ($allprojects as $allproject) {
                $programLeader = ProgramLeader::where('user_id', $user->id)
                    ->where('program_id', $allproject->id)
                    ->first();

                $projectLeader = ProjectLeader::where('user_id', $user->id)
                    ->where('project_id', $allproject->id)
                    ->first();

                if ($programLeader) {
                    $allproject->role = 'Program Leader';
                } elseif ($projectLeader) {
                    $allproject->role = 'Project Leader';
                } else {
                    $allproject->role = 'Implementer';
                }
            }
        }

        $subhours = $subtaskcontributions->sum('hours_rendered');
        $acthours = $activityContributions->sum('hours_rendered');
        $totalhoursrendered = $subhours + $acthours;

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
            'allprojects' => $allprojects,
            'ayid' => false,
            'semester' => false,

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
        $allprojects = [];
        $allprojectIds = [];

        if (!$subtaskcontributions->isEmpty()) {
            $subtaskcontributionsIds = $subtaskcontributions->pluck('subtask_id')->toArray();
            $subtasks = Subtask::whereIn('id', $subtaskcontributionsIds)->get();
            $otheractivities = $subtasks->pluck('activity_id')->unique()->toArray();
        }

        $activityContributions = $user->activitycontributions()
            ->where('approval', 1)
            ->whereDate('startdate', '>=', $minSemDate)
            ->whereDate('enddate', '<=', $maxSemDate)
            ->get();

        if (!$activityContributions->isEmpty()) {
            $activitiesid = $activityContributions->pluck('activity_id')->unique()->toArray();
        }

        $allactivitiesid = array_unique(array_merge($otheractivities, $activitiesid));

        if ($allactivitiesid) {
            $allactivities = Activity::whereIn('id', $allactivitiesid)
                ->get();
            $allprojectIds = $allactivities->pluck('project_id')->unique()->toArray();
            $allprojects = Project::whereIn('id', $allprojectIds)
                ->get(['id', 'projecttitle', 'department']);
        }
        if ($allprojects) {
            foreach ($allprojects as $allproject) {
                $programLeader = ProgramLeader::where('user_id', $user->id)
                    ->where('program_id', $allproject->id)
                    ->first();

                $projectLeader = ProjectLeader::where('user_id', $user->id)
                    ->where('project_id', $allproject->id)
                    ->first();

                if ($programLeader) {
                    $allproject->role = 'Program Leader';
                } elseif ($projectLeader) {
                    $allproject->role = 'Project Leader';
                } else {
                    $allproject->role = 'Implementer';
                }
            }
        }

        $subhours = $subtaskcontributions->sum('hours_rendered');
        $acthours = $activityContributions->sum('hours_rendered');
        $totalhoursrendered = $subhours + $acthours;

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
            'allprojects' => $allprojects,
            'ayid' => $ayid,
            'semester' => $semester

        ]);
    }
}
