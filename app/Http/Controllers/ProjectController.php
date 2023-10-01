<?php

namespace App\Http\Controllers;

use App\Models\AcademicYear;
use App\Models\ActivityUser;
use App\Models\Notification;
use App\Models\Objective;
use App\Models\Output;
use App\Models\SubtaskContributor;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\CalendarYear;
use App\Models\Project;
use App\Models\ProjectUser;
use App\Models\Subtask;
use App\Models\Activity;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Redirector;
use Carbon\Carbon;
use Illuminate\Support\Facades\Artisan;
use App\Events\NewNotificationEvent;
use Illuminate\Support\Facades\Mail;
use App\Mail\MyMail;

class ProjectController extends Controller
{
    //

    public function showproject($department)
    {

        $users = User::where('department', $department)
            ->where('role', '!=', 'FOR APPROVAL')
            ->get(['id', 'name', 'middle_name', 'last_name']);
        $currentDate = Carbon::now();
        $currentyear = $currentDate->year;

        $currentproject = Project::where('department', $department)
            ->where('calendaryear', $currentyear)
            ->get();

        $inCurrentYear = true;

        $calendaryears = CalendarYear::pluck('year');
        $notifications = Notification::where('user_id', Auth::user()->id)
            ->get();

        return view('project.create', [
            'members' => $users,
            'calendaryears' => $calendaryears,
            'currentproject' => $currentproject,
            'inCurrentYear' => $inCurrentYear,
            'currentyear' => $currentyear,
            'notifications' => $notifications,
        ]);
    }

    public function showyearproject($department, $currentyear)
    {

        $users = User::where('department', $department)
            ->where('role', '!=', 'Admin')
            ->where('role', '!=', 'FOR APPROVAL')
            ->get(['id', 'name', 'middle_name', 'last_name']);
        $currentDate = Carbon::now();
        $otheryear = $currentDate->year;

        if ($otheryear == $currentyear) {
            $inCurrentYear = true;
        } else {
            $inCurrentYear = false;
        }

        $currentproject = Project::where('department', $department)
            ->where('calendaryear', $currentyear)
            ->get();

        $calendaryears = CalendarYear::pluck('year');
        $notifications = Notification::where('user_id', Auth::user()->id)
            ->get();


        return view('project.create', [
            'members' => $users,
            'calendaryears' => $calendaryears,
            'currentproject' => $currentproject,
            'inCurrentYear' => $inCurrentYear,
            'currentyear' => $currentyear,
            'notifications' => $notifications,
        ]);
    }

    public function displayproject($projectid, $department)
    {

        $indexproject = Project::findOrFail($projectid);
        $currentyear = $indexproject->calendaryear;
        $currentproject = Project::where('department', $department)
            ->whereNotIn('id', [$projectid])
            ->where('calendaryear', $currentyear)
            ->get();
        $currentDate = Carbon::now();
        $otheryear = $currentDate->year;

        if ($otheryear == $currentyear) {
            $inCurrentYear = true;
        } else {
            $inCurrentYear = false;
        }

        $calendaryears = CalendarYear::pluck('year');

        $users = User::where('department', $department)
            ->where('role', '!=', 'FOR APPROVAL')
            ->get(['id', 'name', 'middle_name', 'last_name', 'role']);


        $objectives = $indexproject->objectives;
        $activities = $indexproject->activities;

        return view('project.select', [
            'members' => $users,
            'currentproject' => $currentproject,
            'indexproject' => $indexproject,
            'calendaryears' => $calendaryears,
            'inCurrentYear' => $inCurrentYear,
            'currentyear' => $currentyear,
            'objectives' => $objectives,
            'activities' => $activities,
        ]);
    }

    public function displayActivityCalendar($projectid, $department)
    {

        $indexproject = Project::findOrFail($projectid);
        $currentyear = $indexproject->calendaryear;
        $currentproject = Project::where('department', $department)
            ->whereNotIn('id', [$projectid])
            ->where('calendaryear', $currentyear)
            ->get();
        $currentDate = Carbon::now();
        $otheryear = $currentDate->year;

        if ($otheryear == $currentyear) {
            $inCurrentYear = true;
        } else {
            $inCurrentYear = false;
        }

        $calendaryears = CalendarYear::pluck('year');

        $users = User::where('department', $department)
            ->where('role', '!=', 'Admin')
            ->where('role', '!=', 'FOR APPROVAL')
            ->get(['id', 'name', 'middle_name', 'last_name']);

        $activities = $indexproject->activities;
        $activityArray = $activities->map(function ($activity) {
            return (object) [
                'actname' => $activity->actname,
                'actstartdate' => $activity->actstartdate,
                'actenddate' => $activity->actenddate,
            ];
        })->toArray();
        $notifications = Notification::where('user_id', Auth::user()->id)
            ->get();

        return view('project.calendar', [
            'members' => $users, 'currentproject' => $currentproject,
            'indexproject' => $indexproject,
            'calendaryears' => $calendaryears,
            'inCurrentYear' => $inCurrentYear,
            'currentyear' => $currentyear, 'projectid' => $projectid,
            'activityArray' => $activityArray,
            'notifications' => $notifications,
        ]);
    }


    public function store(Request $request)
    {

        $projecttitle = $request->input('projecttitle');
        $projectleaderid = $request->input('projectleader');
        $projectstartdate = $request->input('projectstartdate');
        $projectenddate = $request->input('projectenddate');
        $project = new Project([
            'projecttitle' => $projecttitle,
            'projectleader' => $request->input('projectleader'),
            'programtitle' => $request->input('programtitle'),
            'programleader' => $request->input('programleader'),
            'projectstartdate' => $request->input('projectstartdate'),
            'projectenddate' => $request->input('projectenddate'),
            'department' => $request->input('department'),
            'calendaryear' => $request->input('currentyear'),
        ]);

        $project->save();
        Artisan::call('project:status:update');
        $newProjectId = $project->id;

        $sendername = Auth::user()->name . ' ' . Auth::user()->last_name;
        $message =  $sendername . ' appointed you as a Project Leader to a new project: "' . $projecttitle . '".';

        $notification = new Notification([
            'user_id' => $projectleaderid,
            'task_id' => $newProjectId,
            'task_type' => "project",
            'task_name' => $projecttitle,
            'message' => $message,
        ]);
        $notification->save();

        $projectleader = User::findorFail($projectleaderid);
        $email = $projectleader->email;
        $name = $projectleader->name . ' ' . $projectleader->last_name;
        $taskname = $projecttitle;
        $tasktype = "project";
        $startDate = date('F d, Y', strtotime($projectstartdate));
        $endDate = date('F d, Y', strtotime($projectenddate));

        $taskdeadline = $startDate . ' - ' . $endDate;
        $senderemail = Auth::user()->email;
        Mail::to($email)->send(new MyMail($message, $name, $sendername, $taskname, $tasktype, $taskdeadline, $senderemail));



        $validatedData = $request->validate([
            'projectobjective.*' => 'required',
            'objectiveindex' => 'required|integer',
            'objectivesetid.*' => 'required|integer',
        ]);

        for ($i = 0; $i < $validatedData['objectiveindex']; $i++) {
            $projectobjective = new Objective;
            $projectobjective->name = $validatedData['projectobjective'][$i];
            $projectobjective->project_id = $newProjectId;
            $projectobjective->objectiveset_id = $validatedData['objectivesetid'][$i];
            $projectobjective->save();
        }

        return response()->json([
            'projectid' => $newProjectId,
        ]);
    }
    public function displayMembers($projectid, $department)
    {

        $indexproject = Project::findOrFail($projectid);
        $currentyear = $indexproject->calendaryear;
        $currentproject = Project::where('department', $department)
            ->whereNotIn('id', [$projectid])
            ->where('calendaryear', $currentyear)
            ->get();
        $currentDate = Carbon::now();
        $otheryear = $currentDate->year;

        if ($otheryear == $currentyear) {
            $inCurrentYear = true;
        } else {
            $inCurrentYear = false;
        }

        $calendaryears = CalendarYear::pluck('year');

        $users = User::where('department', $department)
            ->where('role', '!=', 'Admin')
            ->where('role', '!=', 'FOR APPROVAL')
            ->get(['id', 'name', 'middle_name', 'last_name']);


        $notifications = Notification::where('user_id', Auth::user()->id)
            ->get();

        return view('project.members', [
            'members' => $users, 'currentproject' => $currentproject,
            'indexproject' => $indexproject,
            'calendaryears' => $calendaryears,
            'inCurrentYear' => $inCurrentYear,
            'currentyear' => $currentyear, 'projectid' => $projectid,
            'notifications' => $notifications,
        ]);
    }
    public function displayDetails($projectid, $department)
    {

        $indexproject = Project::findOrFail($projectid);
        $currentyear = $indexproject->calendaryear;
        $currentproject = Project::where('department', $department)
            ->whereNotIn('id', [$projectid])
            ->where('calendaryear', $currentyear)
            ->get();
        $currentDate = Carbon::now();
        $otheryear = $currentDate->year;

        if ($otheryear == $currentyear) {
            $inCurrentYear = true;
        } else {
            $inCurrentYear = false;
        }

        $calendaryears = CalendarYear::pluck('year');

        $users = User::where('department', $department)
            ->where('role', '!=', 'Admin')
            ->where('role', '!=', 'FOR APPROVAL')
            ->get(['id', 'name', 'middle_name', 'last_name']);


        $notifications = Notification::where('user_id', Auth::user()->id)
            ->get();

        return view('project.details', [
            'members' => $users,
            'currentproject' => $currentproject,
            'indexproject' => $indexproject,
            'calendaryears' => $calendaryears,
            'inCurrentYear' => $inCurrentYear,
            'currentyear' => $currentyear,
            'projectid' => $projectid,
            'notifications' => $notifications,
        ]);
    }
    public function displayObjectives($projectid, $department)
    {

        $indexproject = Project::findOrFail($projectid);
        $currentyear = $indexproject->calendaryear;
        $currentproject = Project::where('department', $department)
            ->whereNotIn('id', [$projectid])
            ->where('calendaryear', $currentyear)
            ->get();
        $currentDate = Carbon::now();
        $otheryear = $currentDate->year;

        if ($otheryear == $currentyear) {
            $inCurrentYear = true;
        } else {
            $inCurrentYear = false;
        }

        $calendaryears = CalendarYear::pluck('year');

        $users = User::where('department', $department)
            ->where('role', '!=', 'Admin')
            ->where('role', '!=', 'FOR APPROVAL')
            ->get(['id', 'name', 'middle_name', 'last_name']);


        $notifications = Notification::where('user_id', Auth::user()->id)
            ->get();

        return view('project.objectives', [
            'members' => $users,
            'currentproject' => $currentproject,
            'indexproject' => $indexproject,
            'calendaryears' => $calendaryears,
            'inCurrentYear' => $inCurrentYear,
            'currentyear' => $currentyear,
            'projectid' => $projectid,
            'notifications' => $notifications,
        ]);
    }
    public function displayActivities($projectid, $department)
    {

        $indexproject = Project::findOrFail($projectid);
        $currentyear = $indexproject->calendaryear;
        $currentproject = Project::where('department', $department)
            ->whereNotIn('id', [$projectid])
            ->where('calendaryear', $currentyear)
            ->get();
        $currentDate = Carbon::now();
        $otheryear = $currentDate->year;

        if ($otheryear == $currentyear) {
            $inCurrentYear = true;
        } else {
            $inCurrentYear = false;
        }

        $calendaryears = CalendarYear::pluck('year');

        $users = User::where('department', $department)
            ->where('role', '!=', 'Admin')
            ->where('role', '!=', 'FOR APPROVAL')
            ->get(['id', 'name', 'middle_name', 'last_name']);


        $notifications = Notification::where('user_id', Auth::user()->id)
            ->get();

        return view('project.activities', [
            'members' => $users,
            'currentproject' => $currentproject,
            'indexproject' => $indexproject,
            'calendaryears' => $calendaryears,
            'inCurrentYear' => $inCurrentYear,
            'currentyear' => $currentyear,
            'projectid' => $projectid,
            'notifications' => $notifications,
        ]);
    }
}
