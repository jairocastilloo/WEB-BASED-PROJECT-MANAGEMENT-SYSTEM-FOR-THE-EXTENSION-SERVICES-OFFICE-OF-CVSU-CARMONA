<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Models\User;
use App\Models\SubtaskContributor;
use App\Models\Subtask;
use App\Models\Activity;
use Carbon\Carbon;
use App\Models\AcademicYear;

class RecordController extends Controller
{
    //
    public function showrecords($username)
    {

        $user = User::where('username', $username)->firstOrFail();
        $userid = $user->id;

        $currentDate = Carbon::now();
        $ay = AcademicYear::where('acadstartdate', '<=', $currentDate)
            ->where('acadenddate', '>=', $currentDate)
            ->get();


        $minSemDate = null;
        $maxSemDate = null;
        if ($ay) {


            if ($currentDate >= $ay->firstsem_startdate && $currentDate <= $ay->firstsem_enddate) {

                $minSemDate = $ay->firstsem_startdate;
                $maxSemDate = $ay->firstsem_enddate;
            } elseif ($currentDate >= $ay->secondsem_startdate && $currentDate <= $ay->secondsem_enddate) {

                $minSemDate = $ay->secondsem_startdate;
                $maxSemDate = $ay->secondsem_enddate;
            }
        } elseif (!$ay) {

            $latestAy = AcademicYear::latest()->get();

            if ($currentDate >= $latestAy->firstsem_startdate && $currentDate <= $latestAy->firstsem_enddate) {

                $minSemDate = $latestAy->firstsem_startdate;
                $maxSemDate = $latestAy->firstsem_enddate;
            } elseif ($currentDate >= $latestAy->secondsem_startdate && $currentDate <= $latestAy->secondsem_enddate) {

                $minSemDate = $latestAy->secondsem_startdate;
                $maxSemDate = $latestAy->secondsem_enddate;
            }
        }


        $subtasksid = SubtaskContributor::where('user_id', $userid)
            ->where('activity_id', null)
            ->where('approval', 1)
            ->whereDate('created_at', '>=', $minSemDate)
            ->whereDate('created_at', '<=', $maxSemDate)
            ->pluck('subtask_id')
            ->unique();


        $allsubtasks = Subtask::whereIn('id', $subtasksid)
            ->get();

        $allonlyactivities = SubtaskContributor::where('user_id', $userid)
            ->where('subtask_id', null)
            ->where('approval', 1)
            ->whereDate('created_at', '')
            ->pluck('activity_id')
            ->unique();

        $onlyactivitiesid = Activity::whereIn('id', $allonlyactivities)
            ->where('actstartdate', '>=', $minSemDate)
            ->where('actenddate', '<=', $maxSemDate)
            ->pluck('id')
            ->unique()
            ->toArray();


        $activitiesid = $allsubtasks->pluck('activity_id')->merge($allonlyactivities->pluck('activity_id'))->unique();
        $allactivities = Activity::whereIn('id', $activitiesid)->get(['id', 'actname', 'project_id', 'actstartdate', 'actenddate']);
        return view('records.index', [
            'allactivities' => $allactivities,
            'allsubtasks' => $allsubtasks,
            'onlyactivitiesid' => $onlyactivitiesid,
        ]);
    }
}
