<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProgramLeader extends Model
{
    use HasFactory;
    protected $table = 'program_leaders'; // Specify the table name if it's different from the default naming convention
    protected $fillable = [
        'project_id',
        'user_id',
    ];
    // Define relationships

}
