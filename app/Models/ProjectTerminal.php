<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjectTerminal extends Model
{
    use HasFactory;
    protected $table = 'project_terminal'; // Specify the table name

    protected $fillable = ['project_id', 'startdate', 'enddate', 'submitter_id', 'approval', 'notes'];
}
