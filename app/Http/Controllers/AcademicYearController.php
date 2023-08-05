<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;

class AcademicYearController extends Controller
{
    //

    public function setacadyear()
    {
        return view('academicyear.set');
    }
}
