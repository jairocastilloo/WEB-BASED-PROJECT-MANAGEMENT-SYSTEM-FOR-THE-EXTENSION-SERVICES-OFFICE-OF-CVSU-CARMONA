<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmailLogs extends Model
{
    use HasFactory;
    protected $fillable = [
        'email',
        'message',
        'name',
        'sendername',
        'taskname',
        'taskdeadline',
        'senderemail',
    ];
}
