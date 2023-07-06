<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use App\Models\Output;

class OutputController extends Controller
{
    //
    public function submitoutput(Request $request)
    {

        $validatedData = $request->validate([
            'output-number.*' => 'required|integer',
            'out-name.*' => 'required',
            'out-type.*' => 'required',
            'submitoutputindex' => 'required|integer',
        ]);

        for ($i = 0; $i < $validatedData['submitoutputindex']; $i++) {
            $output = Output::where('output_name', $validatedData['out-name'][$i])
                ->where('output_type', $validatedData['out-type'][$i])
                ->first();

            if ($output) {
                // Update the value of output_submitted
                $output->output_submitted = $validatedData['output-number'][$i];
                $output->save();
            }
        }
        return response()->json(['success' => true]);
    }
}
