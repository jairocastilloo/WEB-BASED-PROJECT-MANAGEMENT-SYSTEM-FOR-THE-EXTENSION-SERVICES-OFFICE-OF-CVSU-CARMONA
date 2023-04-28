<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Project;
use App\Models\ProjectUser;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class ProjectController extends Controller
{
    //
    public function show($id)
    {
        $id = User::findOrFail($id);

        return view('project.index', ['id' => $id]);
    }

    public function getMembers()
    {
        // Retrieve all user names
        $users = User::all(['id', 'name']);

        // Pass the user names to the view
        return view('project.create')->with('members', $users);
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
        $memberindex = $request->input('memberindex');
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

        $allmembers = [];
        for ($x = 0; $x < $memberindex; $x++) {
            $aacti = $request->input('actname.' . $x);
            $validatedData = $request->validate([
                'projectmember.' . $x => 'required',
            ]);
            $allmember = [
                'projectid' => $newProjectId,
                'userid' => $validatedData['projectmember.' . $x],
            ];
            $allmembers[] = $allmember;
        }
        DB::table('project_users')->insert($allmembers);


        return response()->json(['success' => true]);
    }
}
