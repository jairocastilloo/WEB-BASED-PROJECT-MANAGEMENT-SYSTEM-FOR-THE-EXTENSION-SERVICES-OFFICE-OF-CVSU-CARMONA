<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;
    protected $fillable = [
        'project_title',
        'project_leader',
        'program_title',
        'program_leader',
        'project_startdate',
        'project_enddate',
    ];
    public function users()
    {
        return $this->belongsToMany(User::class, 'project_user');
    }
    public function objectives()
    {
        return $this->hasMany(Objective::class);
    }
}
