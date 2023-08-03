<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Models\User;
use App\Models\SubtaskContributor;
use App\Models\Subtask;
use App\Models\Activity;

class RecordController extends Controller
{
    //
    public function showrecords($username)
    {
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
        ]);
    }
}
