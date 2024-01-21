<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProgramUser extends Model
{
    use HasFactory;

    protected $table = 'program_users'; // Specify the table name if it's different from the default naming convention
    protected $fillable = [
        'program_id',
        'user_id',
    ];
}
