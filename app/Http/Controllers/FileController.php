<?php

namespace App\Http\Controllers;

use App\Models\ProjectTerminal;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use App\Models\Contribution;
use App\Models\OutputUser;
use App\Models\activityContribution;

class FileController extends Controller
{
    //
    public function upload(Request $request)
    {
        $request->validate([
            'outputdocs' => 'required|mimes:docx|max:2048',
        ]);


        $file = $request->file('outputdocs');
        $originalName = $file->getClientOriginalName();
        $extension = $file->getClientOriginalExtension();
        $fileName = Str::slug(pathinfo($originalName, PATHINFO_FILENAME)) . '.' . $extension;

        // Store the file
        $path = $request->file('outputdocs')->storeAs('uploads', $fileName);
        // Save the file path to the database or perform any other necessary actions
        // ...

        return 'File uploaded successfully.';
    }
    public function download($contributionid, $filename)
    {
        $contribution = Contribution::findorFail($contributionid);
        $dateTime = $contribution->created_at;
        $currentDateTime = str_replace(' ', '_', $dateTime);
        $currentDateTime = str_replace(':', '-', $currentDateTime);
        $file = 'uploads/' . $currentDateTime . '/' . str_replace('/', DIRECTORY_SEPARATOR, $filename);
        return Storage::download($file);
    }
    public function downloadoutput($submittedoutputid, $filename)
    {
        $output = OutputUser::findorFail($submittedoutputid);
        $dateTime = $output->created_at;
        $currentDateTime = str_replace(' ', '_', $dateTime);
        $currentDateTime = str_replace(':', '-', $currentDateTime);
        $file = 'uploads/' . $currentDateTime . '/' . str_replace('/', DIRECTORY_SEPARATOR, $filename);
        return Storage::download($file);
    }
    public function downloadactivity($actcontributionid, $filename)
    {
        $output = activityContribution::findorFail($actcontributionid);
        $dateTime = $output->created_at;
        $currentDateTime = str_replace(' ', '_', $dateTime);
        $currentDateTime = str_replace(':', '-', $currentDateTime);
        $file = 'uploads/' . $currentDateTime . '/' . str_replace('/', DIRECTORY_SEPARATOR, $filename);
        return Storage::download($file);
    }
    public function downloadterminal($projcontributionid, $filename)
    {
        $terminal = ProjectTerminal::findorFail($projcontributionid);
        $dateTime = $terminal->created_at;
        $currentDateTime = str_replace(' ', '_', $dateTime);
        $currentDateTime = str_replace(':', '-', $currentDateTime);
        $file = 'uploads/' . $currentDateTime . '/' . str_replace('/', DIRECTORY_SEPARATOR, $filename);
        return Storage::download($file);
    }
}
