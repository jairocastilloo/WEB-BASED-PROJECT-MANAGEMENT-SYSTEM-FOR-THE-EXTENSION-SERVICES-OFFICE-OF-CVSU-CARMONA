<?php

namespace App\Http\Controllers;

use App\Models\Objective;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Project;
use App\Models\ProjectUser;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Redirector;

class ProjectController extends Controller
{
    //

    public function showproject($id)
    {
        $user = User::findOrFail($id);
        $projects = $user->projects;
        $users = User::all(['id', 'name']);
        return view('project.create', ['members' => $users, 'projects' => $projects]);
    }
    public function getobjectives($id, $projectid)
    {
        $projects = Project::findOrFail($projectid);
        $assignees = $projects->users;

        $user = User::findOrFail($id);
        $projects = $user->projects;

        $users = User::all(['id', 'name']);

        $project = Project::findOrFail($projectid);
        $objectives = $project->objectives;
        $activities = Project::findOrFail($projectid);
        $activities = $project->activities;
        //return response()->json(['members' => $users, 'projects' => $projects, 'objectives' => $objectives, 'projectid' => $projectid, 'assignees' => $assignees]);

        //return response()->json(['members' => $users, 'projects' => $projects, 'objectives' => $objectives]);
        return view('project.select', ['members' => $users, 'projects' => $projects, 'objectives' => $objectives, 'projectid' => $projectid, 'assignees' => $assignees, 'activities' => $activities]);
    }
    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'projecttitle' => 'required|unique:projects|max:255',
            'projectleader' => 'required|max:255',
            'programtitle' => 'required|max:255',
            'programleader' => 'required|max:255',
            'projectstartdate' => 'required|date',
            'projectenddate' => 'required|date|after:project_startdate',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()]);
        }

        $projecttitle = $request->input('projecttitle');
        $projectleader = $request->input('projectleader');
        $programtitle = $request->input('programtitle');
        $programleader = $request->input('programleader');
        $projectstartdate = $request->input('projectstartdate');
        $projectenddate = $request->input('projectenddate');

        $projectData = [
            'projecttitle' => $projecttitle,
            'projectleader' => $projectleader,
            'programtitle' => $programtitle,
            'programleader' => $programleader,
            'projectstartdate' => $projectstartdate,
            'projectenddate' => $projectenddate,
        ];
        DB::table('projects')->insert($projectData);
        $newProjectId = DB::getPdo()->lastInsertId();

        $validatedData = $request->validate([
            'projectmember.*' => 'required|integer', // Validate each select input
            'memberindex' => 'required|integer',
            'projectobjective.*' => 'required',
            'objectiveindex' => 'required|integer',
            // Validate select count
        ]);
        for ($i = 0; $i < $validatedData['memberindex']; $i++) {
            $projectmembers = new ProjectUser;
            $projectmembers->user_id = $validatedData['projectmember'][$i];
            $projectmembers->project_id = $newProjectId;
            $projectmembers->save();
        }
        for ($i = 0; $i < $validatedData['objectiveindex']; $i++) {
            $projectobjective = new Objective;
            $projectobjective->name = $validatedData['projectobjective'][$i];
            $projectobjective->project_id = $newProjectId;
            $projectobjective->save();
        }


        //$id = Auth::user()->id;

        //return redirect()->route('get.objectives', ['id' => $id, 'projectid' => $newProjectId]);

        //$url = route('get.objectives', ['id' => $id, 'projectid' => $newProjectId]);

        //return redirect($url);
        return response()->json(['success' => true]);
    }
}
