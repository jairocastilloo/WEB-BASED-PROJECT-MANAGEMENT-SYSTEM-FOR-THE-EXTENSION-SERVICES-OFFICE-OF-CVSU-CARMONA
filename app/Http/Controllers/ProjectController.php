<?php

namespace App\Http\Controllers;

use App\Models\AcademicYear;
use App\Models\ActivityUser;
use App\Models\Notification;
use App\Models\Objective;
use App\Models\Output;
use App\Models\ProgramLeader;
use App\Models\ProjectLeader;
use App\Models\ProjectTerminal;
use App\Models\SubtaskContributor;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\CalendarYear;
use App\Models\Project;
use App\Models\ProjectUser;
use App\Models\Subtask;
use App\Models\Activity;
use Illuminate\Support\Facades\URL;
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
use App\Models\ActivityBudget;
use App\Models\ExpectedOutput;
use App\Models\FiscalYear;
use Illuminate\Support\Facades\Redirect;

class ProjectController extends Controller
{
    //

    public function showproject($department)
    {
        if (Auth::user()->role == "Admin") {
            $alldepartments = ['Department of Management', 'Department of Industrial and Information Technology', 'Department of Teacher Education', 'Department of Arts and Science', 'All'];
        } else {
            $alldepartments = [Auth::user()->department, 'All'];
        }
        $department = str_replace('+', ' ', $department);

        if (Auth::user()->role == 'Admin') {
            if ($department == 'All') {
                $users = User::where('approval', 1)
                    ->where('role', '!=', 'Implementer')
                    ->get(['id', 'name', 'middle_name', 'last_name', 'role']);
            } else {
                $users = User::where(function ($query) use ($department) {
                    $query->where('department', $department)
                        ->orWhere('department', 'All');
                })
                    ->where('approval', 1)
                    ->where('role', '!=', 'Implementer')
                    ->get(['id', 'name', 'middle_name', 'last_name', 'role']);
            }
        } else {
            $users = null;
        }


        return view('project.create', [
            'members' => $users,
            'department' => $department,
            'alldepartments' => $alldepartments,
        ]);
    }

    public function showyearproject($department, $currentyear)
    {

        $currentfiscalyear = FiscalYear::findorFail($currentyear);
        $currentfiscalyearid = $currentfiscalyear->id;

        $currentDate = Carbon::now();

        if ($currentDate >= $currentfiscalyear->startdate && $currentDate <= $currentfiscalyear->enddate) {
            $inCurrentYear = true;
        } else {
            $inCurrentYear = false;
        }

        $fiscalyears = FiscalYear::all();


        if (Auth::user()->role == 'Admin') {
            if ($department == 'All') {
                $users = User::where('approval', 1)
                    ->where('role', '!=', 'Implementer')
                    ->get(['id', 'name', 'middle_name', 'last_name', 'role']);
            } else {
                $users = User::where(function ($query) use ($department) {
                    $query->where('department', $department)
                        ->orWhere('department', 'All');
                })
                    ->where('approval', 1)
                    ->where('role', '!=', 'Implementer')
                    ->get(['id', 'name', 'middle_name', 'last_name', 'role']);
            }
        } else {
            $users = null;
        }
        return view('project.create', [
            'members' => $users,
            'fiscalyears' => $fiscalyears,
            'inCurrentYear' => $inCurrentYear,
            'currentfiscalyear' => $currentfiscalyear,
            'currentfiscalyearid' => $currentfiscalyearid,
            'department' => $department
        ]);
    }

    public function displayproject($projectid, $department)
    {

        $indexproject = Project::findOrFail($projectid);

        if (Auth::user()->role == "Admin") {
            $alldepartments = ['Department of Management', 'Department of Industrial and Information Technology', 'Department of Teacher Education', 'Department of Arts and Science', 'All'];
        } else {
            $alldepartments = [Auth::user()->department, 'All'];
        }

        $objectives = $indexproject->objectives;
        $activities = $indexproject->activities;
        $department = $indexproject->department;
        $activitiesIds = $activities->pluck('id')->toArray();
        $expectedOutputs = ExpectedOutput::whereIn('activity_id', $activitiesIds)->get();
        $activityBudgets = ActivityBudget::whereIn('activity_id', $activitiesIds)->get();

        foreach ($activities as $activity) {
            $activityExpectedOutputs = $expectedOutputs->where('activity_id', $activity->id);
            $budgets =  $activityBudgets->where('activity_id', $activity->id);

            $expectedOutputNames = $activityExpectedOutputs->pluck('name')->toArray();
            $activityBudgetItems = $budgets->pluck('item')->toArray();
            $activityBudgetPrices = $budgets->pluck('price')->toArray();
            $activity->expectedOutputs = $expectedOutputNames;
            $activity->budgetItems = $activityBudgetItems;
            $activity->budgetPrices = $activityBudgetPrices;
        }

        if (Auth::user()->role == 'Admin') {
            if ($department == 'All') {
                $users = User::where('approval', 1)
                    ->where('role', '!=', 'Implementer')
                    ->get(['id', 'name', 'middle_name', 'last_name', 'role']);
            } else {
                $users = User::where(function ($query) use ($department) {
                    $query->where('department', $department)
                        ->orWhere('department', 'All');
                })
                    ->where('approval', 1)
                    ->where('role', '!=', 'Implementer')
                    ->get(['id', 'name', 'middle_name', 'last_name', 'role']);
            }
        } else {
            $users = null;
        }


        /*
        $projectleaders = $indexproject->projectleaders;
        $programleaders = $indexproject->programleaders;
        

        $allfiscalyears = FiscalYear::all();
        */
        return view('project.select', [
            'members' => $users,
            'indexproject' => $indexproject,
            'alldepartments' => $alldepartments,
            'objectives' => $objectives,
            'activities' => $activities,
            'department' => $department,
        ]);
    }
    public function displayActivities($projectid, $department)
    {

        $indexproject = Project::findOrFail($projectid);

        if (Auth::user()->role == "Admin") {
            $alldepartments = ['Department of Management', 'Department of Industrial and Information Technology', 'Department of Teacher Education', 'Department of Arts and Science', 'All'];
        } else {
            $alldepartments = [Auth::user()->department, 'All'];
        }

        $department = $indexproject->department;
        if (Auth::user()->role == 'Admin') {
            if ($department == 'All') {
                $users = User::where('approval', 1)
                    ->where('role', '!=', 'Implementer')
                    ->get(['id', 'name', 'middle_name', 'last_name', 'role']);
            } else {
                $users = User::where(function ($query) use ($department) {
                    $query->where('department', $department)
                        ->orWhere('department', 'All');
                })
                    ->where('approval', 1)
                    ->where('role', '!=', 'Implementer')
                    ->get(['id', 'name', 'middle_name', 'last_name', 'role']);
            }
        } else {
            $users = null;
        }

        $activities = $indexproject->activities;

        return view('project.activities', [
            'members' => $users,
            'indexproject' => $indexproject,
            'alldepartments' => $alldepartments,
            'activities' => $activities,
            'department' => $department
        ]);
    }
    public function displayMembers($projectid, $department)
    {

        $indexproject = Project::findOrFail($projectid);

        if (Auth::user()->role == "Admin") {
            $alldepartments = ['Department of Management', 'Department of Industrial and Information Technology', 'Department of Teacher Education', 'Department of Arts and Science', 'All'];
        } else {
            $alldepartments = [Auth::user()->department, 'All'];
        }

        $department = $indexproject->department;
        if (Auth::user()->role == 'Admin') {
            if ($department == 'All') {
                $users = User::where('approval', 1)
                    ->where('role', '!=', 'Implementer')
                    ->get(['id', 'name', 'middle_name', 'last_name', 'role']);
            } else {
                $users = User::where(function ($query) use ($department) {
                    $query->where('department', $department)
                        ->orWhere('department', 'All');
                })
                    ->where('approval', 1)
                    ->where('role', '!=', 'Implementer')
                    ->get(['id', 'name', 'middle_name', 'last_name', 'role']);
            }
        } else {
            $users = null;
        }


        return view('project.members', [
            'members' => $users,
            'indexproject' => $indexproject,
            'alldepartments' => $alldepartments,
            'department' => $department
        ]);
    }

    public function displayActivityCalendar($projectid, $department)
    {

        $indexproject = Project::findOrFail($projectid);
        if (Auth::user()->role == "Admin") {
            $alldepartments = ['Department of Management', 'Department of Industrial and Information Technology', 'Department of Teacher Education', 'Department of Arts and Science', 'All'];
        } else {
            $alldepartments = [Auth::user()->department, 'All'];
        }

        $department = $indexproject->department;
        if (Auth::user()->role == 'Admin') {
            if ($department == 'All') {
                $users = User::where('approval', 1)
                    ->where('role', '!=', 'Implementer')
                    ->get(['id', 'name', 'middle_name', 'last_name', 'role']);
            } else {
                $users = User::where(function ($query) use ($department) {
                    $query->where('department', $department)
                        ->orWhere('department', 'All');
                })
                    ->where('approval', 1)
                    ->where('role', '!=', 'Implementer')
                    ->get(['id', 'name', 'middle_name', 'last_name', 'role']);
            }
        } else {
            $users = null;
        }

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
            'indexproject' => $indexproject,
            'alldepartments' => $alldepartments,
            'department' => $department,
            'activities' => $activities,
            'activityArray' => $activityArray,

        ]);
    }


    public function store(Request $request)
    {
        $isMailSendable = 1;


        $projecttitle = $request->input('projecttitle');
        //$projectleaderid = $request->input('projectleader');
        $projectstartdate = date("Y-m-d", strtotime($request->input('projectstartdate')));
        $projectenddate = date("Y-m-d", strtotime($request->input('projectenddate')));

        $projectleaders = $request->input('projectleader');

        $programleaders = $request->input('programleader');

        $project = new Project([
            'projecttitle' => $projecttitle,
            //'projectleader' => $request->input('projectleader'),
            'programtitle' => $request->input('programtitle'),
            //'programleader' => $request->input('programleader'),
            'projectstartdate' => $projectstartdate,
            'projectenddate' => $projectenddate,
            'department' => $request->input('department'),
            //'fiscalyear' => $request->input('fiscalyear'),
        ]);

        $project->save();
        $newProjectId = $project->id;
        /**if (!is_array($projectleaders)) {
            // Convert a string to an array if needed, assuming it's a comma-separated list
            $projectleaders = explode(',', $projectleaders);
        }*/
        foreach ($projectleaders as $userId) {

            $appointedUser = User::findOrFail($userId);

            ProjectLeader::create([
                'project_id' => $newProjectId,
                'user_id' => $userId,
            ]);
            ProjectUser::create([
                'project_id' => $newProjectId,
                'user_id' => $userId,
            ]);



            if ($appointedUser->notifyProjectAdded == 1) {
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
            }
            if ($appointedUser->emailProjectAdded == 1) {
                if ($isMailSendable === 1) {
                    try {

                        $email = $appointedUser->email;
                        $name = $appointedUser->name . ' ' . $appointedUser->last_name;
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
        }

        if ($programleaders) {
            foreach ($programleaders as $userId) {
                $appointedUser = User::findOrFail($userId);
                ProgramLeader::create([
                    'project_id' => $newProjectId,
                    'user_id' => $userId,
                ]);
                ProjectUser::create([
                    'project_id' => $newProjectId,
                    'user_id' => $userId,
                ]);

                if ($appointedUser->notifyProjectAdded == 1) {
                    $notification = new Notification([
                        'user_id' => $userId,
                        'task_id' => $newProjectId,
                        'task_type' => "project",
                        'task_name' => $projecttitle,
                        'message' => $message,
                    ]);

                    $notification->save();
                }
                if ($appointedUser->emailProjectAdded == 1) {
                    if ($isMailSendable === 1) {
                        try {

                            $email =  $appointedUser->email;
                            $name =  $appointedUser->name . ' ' . $appointedUser->last_name;
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
            }
        }

        $validatedData = $request->validate([
            'objectiveName.*' => 'required|string',
            'objectiveindex' => 'required|integer',
            'objectiveSetNumber.*' => 'required|integer',
        ]);

        for ($i = 0; $i < $validatedData['objectiveindex']; $i++) {
            $projectobjective = new Objective;
            $projectobjective->name = $validatedData['objectiveName'][$i];
            $projectobjective->project_id = $newProjectId;
            $projectobjective->objectiveset_id = $validatedData['objectiveSetNumber'][$i];
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

    /*
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
    */
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


    public function closeProject($projectid, $department)
    {

        $project = Project::findorFail($projectid);
        $currentDate = Carbon::now();

        $allActivities = Activity::where('project_id', $projectid)->count();

        $notStartedActivities = Activity::where('project_id', $projectid)
            ->where('actremark', 'Incomplete')
            ->where('actstartdate', '>', $currentDate)
            ->count();

        $inProgressActivities = Activity::where('project_id', $projectid)
            ->where('actremark', 'Incomplete')
            ->where('actstartdate', '<=', $currentDate)
            ->where('actenddate', '>=', $currentDate)
            ->count();

        $completedActivities = Activity::where('project_id', $projectid)
            ->where('actremark', 'Completed')
            ->count();

        $overdueActivities = Activity::where('project_id', $projectid)
            ->where('actremark', 'Incomplete')
            ->where('actenddate', '<', $currentDate)
            ->count();
        $projectTerminal = ProjectTerminal::where('project_id', $projectid)
            ->get();

        return view('project.close', [
            'project' => $project,
            'allActivities' => $allActivities,
            'notStartedActivities' => $notStartedActivities,
            'inProgressActivities' => $inProgressActivities,
            'completedActivities' => $completedActivities,
            'overdueActivities' => $overdueActivities,
            'projectTerminal' => $projectTerminal
        ]);
    }
    public function uploadTerminalReport(Request $request)
    {
        /*
        $request->validate([
            'projectstartdate' => 'required|date_format:m/d/Y|before_or_equal:projectenddate',
            'projectenddate' => 'required|date_format:m/d/Y|after_or_equal:projectstartdate',
            'terminal_file' => 'required|mimes:docx|max:4096',
        ]);
        */
        $projectstartdate = date("Y-m-d", strtotime($request->input('projectstartdate')));
        $projectenddate = date("Y-m-d", strtotime($request->input('projectenddate')));

        $projectterminal = new ProjectTerminal([
            'project_id' => $request->input('project-id'),
            'startdate' => $projectstartdate,
            'enddate' => $projectenddate,
            'submitter_id' => $request->input('submitter-id'),
        ]);
        $projectterminal->save();

        $request->validate([
            'terminal_file' => 'required|mimes:docx|max:2048',
        ]);
        $file = $request->file('terminal_file');
        $originalName = $file->getClientOriginalName();
        $extension = $file->getClientOriginalExtension();
        $fileName = pathinfo($originalName, PATHINFO_FILENAME) . '.' . $extension;
        $currentDateTime = date('Y-m-d_H-i-s');
        // Store the file
        $path = $request->file('terminal_file')->storeAs('uploads/' . $currentDateTime, $fileName);
        // Save the file path to the database or perform any other necessary actions
        // ...
        /*
        $url = URL::route('projsubmission.display', ['projsubmissionid' => $projectterminal->id, 'projsubmissionname' => "Unevaluated-Submission"]);
        return redirect($url);*/
        return response()->json([
            'projsubmissionid' => $projectterminal->id,
        ]);
    }
}
