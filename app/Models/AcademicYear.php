<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AcademicYear extends Model
{
    use HasFactory;

    protected $fillable = [
        'acadstartdate',
        'acadenddate',
        'firstsem_startdate',
        'firstsem_enddate',
        'secondsem_startdate',
        'secondsem_enddate',
    ];

    protected $casts = [
        'acadstartdate' => 'datetime',
        'acadenddate' => 'datetime', // Cast acadstartdate attribute as a DateTime object.
    ];
}
