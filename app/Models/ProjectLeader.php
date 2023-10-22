<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjectLeader extends Model
{
    use HasFactory;
    protected $table = 'project_leaders'; // Specify the table name if it's different from the default naming convention
    protected $fillable = [
        'project_id',
        'leader_id',
    ];
    // Define relationships

}
