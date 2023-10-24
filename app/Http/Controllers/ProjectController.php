<?php

namespace App\Http\Controllers;

use App\Models\AcademicYear;
use App\Models\ActivityUser;
use App\Models\Notification;
use App\Models\Objective;
use App\Models\Output;
use App\Models\ProgramLeader;
use App\Models\ProjectLeader;
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
        if (Auth::user()->role === 'Admin') {
            $users = User::where('department', $department)
                ->where('role', '!=', 'FOR APPROVAL')
                ->get(['id', 'name', 'middle_name', 'last_name', 'role']);
            $currentDate = Carbon::now();
            $currentyear = $currentDate->year;

            $currentproject = Project::where('department', $department)
                ->where('fiscalyear', 4)
                ->where('projectenddate', '>=', $currentDate)
                ->get();

            $pastproject = Project::where('department', $department)
                ->where('calendaryear', $currentyear)
                ->where('projectenddate', '<', $currentDate)
                ->get();

            $inCurrentYear = true;

            $calendaryears = CalendarYear::pluck('year');


            return view('project.create', [
                'members' => $users,
                'calendaryears' => $calendaryears,
                'currentproject' => $currentproject,
                'pastproject' => $pastproject,
                'inCurrentYear' => $inCurrentYear,
                'currentyear' => $currentyear,
                'department' => $department
            ]);
        } else {
            $users = User::where('department', $department)
                ->where('role', '!=', 'FOR APPROVAL')
                ->get(['id', 'name', 'middle_name', 'last_name', 'role']);
            $currentDate = Carbon::now();
            $currentyear = $currentDate->year;
            $user = User::findorFail(Auth::user()->id);

            $currentproject = $user->projects()
                ->where('department', $department)
                ->where('calendaryear', $currentyear)
                ->where('projectenddate', '>=', $currentDate)
                ->get();

            $pastproject = $user->projects()
                ->where('department', $department)
                ->where('calendaryear', $currentyear)
                ->where('projectenddate', '<', $currentDate)
                ->get();

            $inCurrentYear = true;

            $calendaryears = CalendarYear::pluck('year');


            return view('project.create', [
                'members' => $users,
                'calendaryears' => $calendaryears,
                'currentproject' => $currentproject,
                'pastproject' => $pastproject,
                'inCurrentYear' => $inCurrentYear,
                'currentyear' => $currentyear,
                'department' => $department
            ]);
        }
    }

    public function showyearproject($department, $currentyear)
    {
        if (Auth::user()->role === 'Admin') {
            $users = User::where('department', $department)
                ->where('role', '!=', 'Admin')
                ->where('role', '!=', 'FOR APPROVAL')
                ->get(['id', 'name', 'middle_name', 'last_name', 'role']);
            $currentDate = Carbon::now();
            $otheryear = $currentDate->year;

            if ($otheryear == $currentyear) {
                $inCurrentYear = true;
            } else {
                $inCurrentYear = false;
            }

            $currentproject = Project::where('department', $department)
                ->where('calendaryear', $currentyear)
                ->where('projectenddate', '>=', $currentDate)
                ->get();
            $pastproject = Project::where('department', $department)
                ->where('calendaryear', $currentyear)
                ->where('projectenddate', '<', $currentDate)
                ->get();
            $calendaryears = CalendarYear::pluck('year');


            return view('project.create', [
                'members' => $users,
                'calendaryears' => $calendaryears,
                'currentproject' => $currentproject,
                'pastproject' => $pastproject,
                'inCurrentYear' => $inCurrentYear,
                'currentyear' => $currentyear,
                'department' => $department
            ]);
        } else {
            $users = User::where('department', $department)
                ->where('role', '!=', 'Admin')
                ->where('role', '!=', 'FOR APPROVAL')
                ->get(['id', 'name', 'middle_name', 'last_name', 'role']);
            $currentDate = Carbon::now();
            $otheryear = $currentDate->year;

            if ($otheryear == $currentyear) {
                $inCurrentYear = true;
            } else {
                $inCurrentYear = false;
            }
            $user = User::findorFail(Auth::user()->id);

            $currentproject = $user->projects()
                ->where('department', $department)
                ->where('calendaryear', $currentyear)
                ->where('projectenddate', '>=', $currentDate)
                ->get();
            $pastproject = $user->projects()
                ->where('department', $department)
                ->where('calendaryear', $currentyear)
                ->where('projectenddate', '<', $currentDate)
                ->get();
            $calendaryears = CalendarYear::pluck('year');


            return view('project.create', [
                'members' => $users,
                'calendaryears' => $calendaryears,
                'currentproject' => $currentproject,
                'pastproject' => $pastproject,
                'inCurrentYear' => $inCurrentYear,
                'currentyear' => $currentyear,
                'department' => $department
            ]);
        }
    }

    public function displayproject($projectid, $department)
    {
        if (Auth::user()->role === 'Admin') {
            $indexproject = Project::findOrFail($projectid);
            $currentyear = $indexproject->fiscalyear;

            $projectleaders = $indexproject->projectleaders;
            $projectleaders = $indexproject->projectleaders;

            $currentproject = Project::where('department', $department)
                ->whereNotIn('id', [$projectid])
                ->where('fiscalyear', $currentyear)
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
                'projectleaders' => $projectleaders,
                'calendaryears' => $calendaryears,
                'inCurrentYear' => $inCurrentYear,
                'currentyear' => $currentyear,
                'objectives' => $objectives,
                'activities' => $activities,
                'department' => $department
            ]);
        } else {
            $indexproject = Project::findOrFail($projectid);
            $currentyear = $indexproject->calendaryear;
            $user = User::findorFail(Auth::user()->id);
            $currentproject = $user->projects()
                ->where('department', $department)
                ->whereNotIn('projects.id', [$projectid])
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
                'department' => $department
            ]);
        }
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
            ->get(['id', 'name', 'middle_name', 'last_name', 'role']);

        $activities = $indexproject->activities;
        $activityArray = $activities->map(function ($activity) {
            return (object) [
                'actname' => $activity->actname,
                'actstartdate' => $activity->actstartdate,
                'actenddate' => $activity->actenddate,
            ];
        })->toArray();

        return view('project.calendar', [
            'members' => $users,
            'currentproject' => $currentproject,
            'indexproject' => $indexproject,
            'calendaryears' => $calendaryears,
            'inCurrentYear' => $inCurrentYear,
            'currentyear' => $currentyear,
            'activities' => $activities,
            'activityArray' => $activityArray,
            'department' => $department
        ]);
    }


    public function store(Request $request)
    {
        $isMailSendable = 1;


        $projecttitle = $request->input('projecttitle');
        $projectleaderid = $request->input('projectleader');
        $projectstartdate = $request->input('projectstartdate');
        $projectenddate = $request->input('projectenddate');

        $projectleaders = $request->input('projectleader');

        $programleaders = $request->input('programleader');
        $project = new Project([
            'projecttitle' => $projecttitle,
            //'projectleader' => $request->input('projectleader'),
            'programtitle' => $request->input('programtitle'),
            //'programleader' => $request->input('programleader'),
            'projectstartdate' => $request->input('projectstartdate'),
            'projectenddate' => $request->input('projectenddate'),
            'department' => $request->input('department'),
            'calendaryear' => $request->input('currentyear'),
        ]);

        $project->save();
        $newProjectId = $project->id;
        /**if (!is_array($projectleaders)) {
            // Convert a string to an array if needed, assuming it's a comma-separated list
            $projectleaders = explode(',', $projectleaders);
        }*/
        foreach ($projectleaders as $userId) {
            ProjectLeader::create([
                'project_id' => $newProjectId,
                'leader_id' => $userId,
            ]);
            $sendername = Auth::user()->name . ' ' . Auth::user()->last_name;
            $message =  $sendername . ' appointed you as a Project Leader to a new project: "' . $projecttitle . '".';

            $notification = new Notification([
                'user_id' => $userId,
                'task_id' => $newProjectId,
                'task_type' => "project",
                'task_name' => $projecttitle,
                'message' => $message,
            ]);
            $notification->save();
            if ($isMailSendable === 1) {
                try {
                    $projectleader = User::findOrFail($userId);
                    $email = $projectleader->email;
                    $name = $projectleader->name . ' ' . $projectleader->last_name;
                    $taskname = $projecttitle;
                    $tasktype = "project";
                    $startDate = date('F d, Y', strtotime($projectstartdate));
                    $endDate = date('F d, Y', strtotime($projectenddate));

                    $taskdeadline = $startDate . ' - ' . $endDate;
                    $senderemail = Auth::user()->email;

                    Mail::to($email)->send(new MyMail($message, $name, $sendername, $taskname, $tasktype, $taskdeadline, $senderemail));
                } catch (\Exception $e) {
                    $isMailSendable = 0;
                }
            }
        }

        if (count($programleaders) > 0) {
            foreach ($programleaders as $userId) {
                ProgramLeader::create([
                    'project_id' => $newProjectId,
                    'leader_id' => $userId,
                ]);
            }

            $notification = new Notification([
                'user_id' => $userId,
                'task_id' => $newProjectId,
                'task_type' => "project",
                'task_name' => $projecttitle,
                'message' => $message,
            ]);
            $notification->save();
            if ($isMailSendable === 1) {
                try {
                    $programleader = User::findorFail($userId);
                    $email =  $programleader->email;
                    $name =  $programleader->name . ' ' . $projectleader->last_name;
                    $taskname = $projecttitle;
                    $tasktype = "project";
                    $startDate = date('F d, Y', strtotime($projectstartdate));
                    $endDate = date('F d, Y', strtotime($projectenddate));

                    $taskdeadline = $startDate . ' - ' . $endDate;
                    $senderemail = Auth::user()->email;
                    Mail::to($email)->send(new MyMail($message, $name, $sendername, $taskname, $tasktype, $taskdeadline, $senderemail));
                } catch (\Exception $e) {
                    $isMailSendable = 0;
                }
            }
        }

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
        /*
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
*/
        return response()->json([
            'projectid' => $newProjectId,
            'isMailSent' => $isMailSendable,
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
            ->get(['id', 'name', 'middle_name', 'last_name', 'role']);

        $activities = $indexproject->activities;

        return view('project.members', [
            'members' => $users,
            'currentproject' => $currentproject,
            'indexproject' => $indexproject,
            'calendaryears' => $calendaryears,
            'inCurrentYear' => $inCurrentYear,
            'currentyear' => $currentyear,
            'activities' => $activities,
            'department' => $department
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
            ->get(['id', 'name', 'middle_name', 'last_name', 'role']);

        $activities = $indexproject->activities;
        return view('project.details', [
            'members' => $users,
            'currentproject' => $currentproject,
            'indexproject' => $indexproject,
            'calendaryears' => $calendaryears,
            'inCurrentYear' => $inCurrentYear,
            'currentyear' => $currentyear,
            'activities' => $activities,
            'department' => $department
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
            ->get(['id', 'name', 'middle_name', 'last_name', 'role']);


        return view('project.objectives', [
            'members' => $users,
            'currentproject' => $currentproject,
            'indexproject' => $indexproject,
            'calendaryears' => $calendaryears,
            'inCurrentYear' => $inCurrentYear,
            'currentyear' => $currentyear,
            'department' => $department
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
            ->get(['id', 'name', 'middle_name', 'last_name', 'role']);

        $activities = $indexproject->activities;;

        return view('project.activities', [
            'members' => $users,
            'currentproject' => $currentproject,
            'indexproject' => $indexproject,
            'calendaryears' => $calendaryears,
            'inCurrentYear' => $inCurrentYear,
            'currentyear' => $currentyear,
            'activities' => $activities,
            'department' => $department
        ]);
    }
}
