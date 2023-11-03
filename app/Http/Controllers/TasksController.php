<?php

namespace App\Http\Controllers;

use App\Models\FiscalYear;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Project;
use App\Models\Activity;
use App\Models\SubtaskContributor;
use App\Models\AcademicYear;
use App\Models\CalendarYear;
use App\Models\Notification;
use Carbon\Carbon;
use App\Http\Controllers\DateTime;
use Illuminate\Support\Facades\Auth;

class TasksController extends Controller
{
    //

    public function showtasks($username)
    {
        /*
        $currentDate = Carbon::now();
       
        $currentfiscalyear = FiscalYear::where('startdate', '<=', $currentDate)
            ->where('enddate', '>=', $currentDate)
            ->first();
        $currentfiscalyearid = $currentfiscalyear->id;
        $inCurrentYear = true;
        $fiscalyears = FiscalYear::all();
       


        return view('implementer.index', [
            'fiscalyears' => $fiscalyears,
            'inCurrentYear' => $inCurrentYear,
            'currentfiscalyear' => $currentfiscalyear,
            'currentfiscalyearid' => $currentfiscalyearid,
        ]);
         */

        return view('implementer.index');
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
            ->where('status', 'Incomplete')
            ->where('subduedate', '>=', $currentDate)
            ->get();
        $overduesubtasks = $user->subtasks()
            ->whereIn('activity_id', $activityIds)
            ->where('status', 'Incomplete')
            ->where('subduedate', '<', $currentDate)
            ->get();
        $completedsubtasks = $user->subtasks()
            ->whereIn('activity_id', $activityIds)
            ->where('status', 'Completed')
            ->get();

        $contributions = SubtaskContributor::where('user_id', $userid)
            ->where('approval', 1)
            ->get();

        $calendaryears = CalendarYear::pluck('year');
        $notifications = Notification::where('user_id', Auth::user()->id)
            ->get();
        return view('implementer.index', [
            'currentproject' => $currentproject,
            'activities' => $activities,
            'contributions' => $contributions,
            'calendaryears' => $calendaryears,
            'inCurrentYear' => $inCurrentYear,
            'currentYear' => $currentYear,
            'notifications' => $notifications,
            'subtasks' => $subtasks,
            'overduesubtasks' => $overduesubtasks,
            'completedsubtasks' => $completedsubtasks,

        ]);
    }

    public function showactivities($username)
    {
        $user = User::where('username', $username)->firstOrFail();


        $activities = $user->activities;

        return view('implementer.activities', ['activities' => $activities]);
    }
}
