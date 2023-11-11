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
    public function showtaskscalendar($username)
    {
        $user = User::where('username', $username)->firstOrFail();

        $subtasks = $user->subtasks;
        $subtasksArray = $subtasks->map(function ($subtask) {
            return (object) [
                'subtask_name' => $subtask->subtask_name,
                'subduedate' => $subtask->subduedate,
            ];
        })->toArray();

        $scheduledSubtasks = $user->scheduledSubtasks()
            ->join('subtasks as st1', 'scheduled_tasks.subtask_id', '=', 'st1.id')
            ->orderBy('scheduled_tasks.scheduledDate', 'asc')
            ->select('st1.subtask_name', 'st1.subduedate', 'st1.created_at', 'scheduled_tasks.scheduledDate')
            ->get();
        $scheduledSubtasksArray = $scheduledSubtasks->map(function ($scheduledSubtask) {
            return (object) [
                'subtask_name' => $scheduledSubtask->subtask_name,
                'subduedate' => $scheduledSubtask->subduedate,
                'scheduledDate' => $scheduledSubtask->scheduledDate
            ];
        })->toArray();

        return view('implementer.taskscalendar', [
            'subtasksArray' => $subtasksArray,
            'scheduledSubtasksArray' => $scheduledSubtasksArray
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
