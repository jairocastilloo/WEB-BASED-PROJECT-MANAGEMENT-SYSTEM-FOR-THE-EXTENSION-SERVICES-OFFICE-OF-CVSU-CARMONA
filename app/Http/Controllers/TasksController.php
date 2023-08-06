<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Project;
use App\Models\Activity;
use App\Models\SubtaskContributor;
use App\Models\AcademicYear;
use Carbon\Carbon;

class TasksController extends Controller
{
    //

    public function showtasks($username)
    {
        $user = User::where('username', $username)->firstOrFail();

        $userid = $user->id;


        $currentDate = Carbon::now();
        $acadyear_id = AcademicYear::where('acadstartdate', '<=', $currentDate)
            ->where('acadenddate', '>=', $currentDate)
            ->value('id');
        $currentproject = $user->projects->where('academicyear_id', $acadyear_id);


        $activities = $user->activities;
        $subtasks = $user->subtasks;
        $contributions = SubtaskContributor::where('user_id', $userid)
            ->where('approval', 1)
            ->get();


        return view('implementer.index', [
            'currentproject' => $currentproject,
            'activities' => $activities,
            'subtasks' => $subtasks,
            'contributions' => $contributions
        ]);
    }

    public function showactivities($username)
    {
        $user = User::where('username', $username)->firstOrFail();


        $activities = $user->activities;

        return view('implementer.activities', ['activities' => $activities]);
    }
}
