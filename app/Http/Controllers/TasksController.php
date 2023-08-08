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
        $latestacadyear_id = AcademicYear::latest()->value('id');
        if ($acadyear_id) {
            $currentproject = $user->projects()
                ->where('academicyear_id', $acadyear_id)
                ->get();
        } elseif ($latestacadyear_id) {
            $currentproject = $user->projects()
                ->where('academicyear_id', $latestacadyear_id)
                ->get();
        } else {
            $currentproject = [];
        }



        $projectIds = [];

        if (!$currentproject->isEmpty()) {
            $projectIds = $currentproject->pluck('id')->toArray();
        }

        $activities = $user->activities()
            ->whereIn('project_id', $projectIds)
            ->get();

        $activityIds = [];

        if (!$activities->isEmpty()) {
            $activityIds = $activities->pluck('id')->toArray();
        }

        $subtasks = $user->subtasks()
            ->whereIn('activity_id', $activityIds)
            ->get();


        $contributions = SubtaskContributor::where('user_id', $userid)
            ->where('approval', 1)
            ->get();

        $acadyears = AcademicYear::get(['id', 'acadstartdate', 'acadenddate']);
        return view('implementer.index', [
            'currentproject' => $currentproject,
            'activities' => $activities,
            'subtasks' => $subtasks,
            'contributions' => $contributions,
            'latestacadyear_id' => $latestacadyear_id, 'acadyear_id' => $acadyear_id, 'acadyears' => $acadyears
        ]);
    }

    public function showactivities($username)
    {
        $user = User::where('username', $username)->firstOrFail();


        $activities = $user->activities;

        return view('implementer.activities', ['activities' => $activities]);
    }
}
