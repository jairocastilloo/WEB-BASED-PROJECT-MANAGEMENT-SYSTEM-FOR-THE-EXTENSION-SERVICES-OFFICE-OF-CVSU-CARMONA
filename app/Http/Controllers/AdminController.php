<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Models\User;

class AdminController extends Controller
{
    //
    public function manageaccount($id)
    {
        $user = User::findOrFail($id);
        $allusers = User::all();
        return view('admin.accountmanagement', ['allusers' => $allusers]);
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

        if ($record) {
            $record->approval = 1;
            $record->role = $role;
            $record->save();

            // Optionally, you can perform additional actions or return a response
            return redirect()->route('admin.approve', ['id' => $id]);
        } else {
            // Handle the case where the record is not found
            return response()->json(['message' => 'Record not found'], 404);
        }
    }
    public function declineaccount(Request $request)
    {

        $id = $request->input('user_id');
        $record = User::find($id);

        if ($record) {
            $record->delete();

            // Optionally, you can perform additional actions or return a response
            return redirect()->route('admin.approve', ['id' => $id]);
        } else {
            // Handle the case where the record is not found
            return response()->json(['message' => 'Record not found'], 404);
        }
    }
}
