<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Project;
use App\Models\Activity;
use App\Models\SubtaskContributor;
use App\Models\AcademicYear;
use App\Models\CalendarYear;
use Carbon\Carbon;

class TasksController extends Controller
{
    //

    public function showtasks($username)
    {
        $user = User::where('username', $username)->firstOrFail();

        $userid = $user->id;

        $currentDate = Carbon::now();
        $currentYear = $currentDate->year;


        $currentproject = $user->projects()
            ->where('calendaryear', $currentYear)
            ->get();


        $inCurrentYear = true;

        $projectIds = $currentproject->pluck('id')->toArray();


        $activities = $user->activities()
            ->whereIn('project_id', $projectIds)
            ->get();

        $activityIds = $activities->pluck('id')->toArray();

        $subtasks = $user->subtasks()
            ->whereIn('activity_id', $activityIds)
            ->get();


        $contributions = SubtaskContributor::where('user_id', $userid)
            ->where('approval', 1)
            ->get();

        $calendaryears = CalendarYear::pluck('year');

        return view('implementer.index', [
            'currentproject' => $currentproject,
            'activities' => $activities,
            'subtasks' => $subtasks,
            'contributions' => $contributions,
            'calendaryears' => $calendaryears,
            'inCurrentYear' => $inCurrentYear,
            'currentYear' => $currentYear
        ]);
    }

    public function showacadtasks($username, $currentYear)
    {
        $user = User::where('username', $username)->firstOrFail();

        $userid = $user->id;


        $currentDate = Carbon::now();
        $otheryear = $currentDate->year;

        if ($otheryear == $currentYear) {
            $inCurrentYear = true;
        } else {
            $inCurrentYear = false;
        }


        $currentproject = $user->projects()
            ->where('calendaryear', $currentYear)
            ->get();




        $projectIds = $currentproject->pluck('id')->toArray();


        $activities = $user->activities()
            ->whereIn('project_id', $projectIds)
            ->get();

        $activityIds = $activities->pluck('id')->toArray();

        $subtasks = $user->subtasks()
            ->whereIn('activity_id', $activityIds)
            ->get();


        $contributions = SubtaskContributor::where('user_id', $userid)
            ->where('approval', 1)
            ->get();

        $calendaryears = CalendarYear::pluck('year');

        return view('implementer.index', [
            'currentproject' => $currentproject,
            'activities' => $activities,
            'subtasks' => $subtasks,
            'contributions' => $contributions,
            'calendaryears' => $calendaryears,
            'inCurrentYear' => $inCurrentYear,
            'currentYear' => $currentYear
        ]);
    }

    public function showactivities($username)
    {
        $user = User::where('username', $username)->firstOrFail();


        $activities = $user->activities;

        return view('implementer.activities', ['activities' => $activities]);
    }
}
