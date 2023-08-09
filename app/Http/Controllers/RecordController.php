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
        $acadyear_id = AcademicYear::where('acadstartdate', '<=', $currentDate)
            ->where('acadenddate', '>=', $currentDate)
            ->value('id');


        $minSemDate = null;
        $maxSemDate = null;
        if ($acadyear_id) {
            $ay = AcademicYear::findorFail($acadyear_id);

            if ($currentDate >= $ay->firstsem_startdate && $currentDate <= $ay->firstsem_enddate) {

                $minSemDate = $ay->firstsem_startdate;
                $maxSemDate = $ay->firstsem_enddate;
            } elseif ($currentDate >= $ay->secondsem_startdate && $currentDate <= $ay->secondsem_enddate) {

                $minSemDate = $ay->secondsem_startdate;
                $maxSemDate = $ay->secondsem_enddate;
            }
        }
        $latestacadyear_id = AcademicYear::latest()->value('id');

        $subtasksid = SubtaskContributor::where('user_id', $userid)
            ->where('activity_id', null)
            ->where('approval', 1)
            ->pluck('subtask_id')
            ->unique();

        $allsubtasks = Subtask::whereIn('id', $subtasksid)
            ->where('substartdate', '>=', $minSemDate)
            ->where('subenddate', '<=', $maxSemDate)
            ->get();



        $allonlyactivities = SubtaskContributor::where('user_id', $userid)
            ->where('subtask_id', null)
            ->where('approval', 1)
            ->get();


        $onlyactivitiesid = $allonlyactivities->pluck('activity_id')->unique()->toArray();


        $activitiesid = $allsubtasks->pluck('activity_id')->merge($allonlyactivities->pluck('activity_id'))->unique();
        $allactivities = Activity::whereIn('id', $activitiesid)->get(['id', 'actname', 'project_id', 'actstartdate', 'actenddate']);
        return view('records.index', [
            'allactivities' => $allactivities,
            'allsubtasks' => $allsubtasks,
            'onlyactivitiesid' => $onlyactivitiesid,
        ]);
    }
}
