<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;

class FileController extends Controller
{
    //
    public function upload(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:docx|max:2048',
        ]);


        $file = $request->file('file');
        $originalName = $file->getClientOriginalName();
        $extension = $file->getClientOriginalExtension();
        $fileName = Str::slug(pathinfo($originalName, PATHINFO_FILENAME)) . '.' . $extension;

        // Store the file
        $path = $request->file('file')->storeAs('uploads', $fileName);
        // Save the file path to the database or perform any other necessary actions
        // ...

        return 'File uploaded successfully.';
    }
}
