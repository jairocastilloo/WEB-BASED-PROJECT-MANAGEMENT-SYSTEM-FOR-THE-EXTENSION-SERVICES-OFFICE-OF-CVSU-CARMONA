<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\AcademicYear;
use Illuminate\Support\Facades\Validator;

class AcademicYearController extends Controller
{
    //

    public function setacadyear()
    {
        return view('academicyear.set');
    }
    public function setFiscalYear()
    {
        return view('academicyear.setFiscal');
    }

    public function saveacadyear(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'academic-startdate' => 'required|date',
            'academic-enddate' => 'required|date',
            'firstsem-startdate' => 'required|date',
            'firstsem-enddate' => 'required|date',
            'secondsem-startdate' => 'required|date',
            'secondsem-enddate' => 'required|date',
        ]);


        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()]);
        }

        $academicstartdate = $request->input('academic-startdate');
        $academicenddate = $request->input('academic-enddate');
        $firstsemstartdate = $request->input('firstsem-startdate');
        $firstsemenddate = $request->input('firstsem-enddate');
        $secondsemstartdate = $request->input('secondsem-startdate');
        $secondsemenddate = $request->input('secondsem-enddate');

        $acadyear = new AcademicYear();
        $acadyear->acadstartdate = $academicstartdate;
        $acadyear->acadenddate = $academicenddate;
        $acadyear->firstsem_startdate = $firstsemstartdate;
        $acadyear->firstsem_enddate = $firstsemenddate;
        $acadyear->secondsem_startdate = $secondsemstartdate;
        $acadyear->secondsem_enddate = $secondsemenddate;
        $acadyear->save();
    }
}
