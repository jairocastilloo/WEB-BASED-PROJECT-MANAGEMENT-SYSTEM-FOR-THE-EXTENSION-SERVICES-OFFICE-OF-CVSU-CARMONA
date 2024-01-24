<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;


class AdminController extends Controller
{
    //
    public function index($department)
    {
        $user = User::findOrFail(Auth::user()->id);
        $user->department = $department;
        $user->save();
        return redirect()->route('tasks.show', ['username' => Auth::user()->username]);
    }
    public function manageaccount()
    {

        return view('admin.accountmanagement');
    }

    public function editaccount()
    {
        return view('admin.editaccount');
    }

    public function failedEmailTransmission()
    {
        return view('admin.failed-email-transmission');
    }
    public function showAllSubmission()
    {
        return view('admin.all-submission');
    }

    public function approveaccount($id)
    {
        $user = User::findOrFail($id);
        $allusers = User::all();
        return view('admin.accountapproval', ['allusers' => $allusers]);
    }

    public function acceptaccount(Request $request)
    {

        $id = $request->input('user_id');
        $role = $request->input('user_role');
        $record = User::find($id);
        $currentid = $request->input('currentid');
        if ($record) {
            $record->approval = 1;
            $record->role = $role;
            $record->save();

            // Optionally, you can perform additional actions or return a response
            return redirect()->route('admin.approve', ['id' => $currentid]);
        } else {
            // Handle the case where the record is not found
            return response()->json(['message' => 'Record not found'], 404);
        }
    }
    public function declineaccount(Request $request)
    {

        $id = $request->input('user_id');
        $record = User::find($id);
        $currentid = $request->input('currentid');
        if ($record) {
            $record->delete();

            // Optionally, you can perform additional actions or return a response
            return redirect()->route('admin.approve', ['id' => $currentid]);
        } else {
            // Handle the case where the record is not found
            return response()->json(['message' => 'Record not found'], 404);
        }
    }
    public function deleteaccount(Request $request)
    {

        $id = $request->input('editid');
        $record = User::find($id);
        $currentid = $request->input('currentid');

        if ($record) {
            $record->delete();

            // Optionally, you can perform additional actions or return a response
            return redirect()->route('admin.manage', ['id' => $currentid]);
        } else {
            // Handle the case where the record is not found
            return response()->json(['message' => 'Record not found'], 404);
        }
    }
    public function addaccount(Request $request)
    {
        $currentid = $request->input('currentid');

        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'department' => ['required', 'string', 'max:255'],
            'role' => ['required', 'string'],
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()]);
        }

        User::create([
            'name' => $request['name'],
            'email' => $request['email'],
            'password' => Hash::make($request['password']),
            'department' => $request['department'],
            'middle_name' => $request['middle_name'],
            'last_name' => $request['last_name'],
            'role' => $request['role'],
            'approval' => 1,
        ]);
        return redirect()->route('admin.manage', ['id' => $currentid]);
    }
}
