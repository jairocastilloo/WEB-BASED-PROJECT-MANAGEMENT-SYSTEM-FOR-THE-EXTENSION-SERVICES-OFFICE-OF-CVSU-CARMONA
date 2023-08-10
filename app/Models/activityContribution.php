<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class activityContribution extends Model
{
    use HasFactory;

    protected $table = 'contributions';

    protected $fillable = [
        'activity_id',
        'startdate',
        'enddate',
        'hours_rendered',
        'approval',
    ];
}
