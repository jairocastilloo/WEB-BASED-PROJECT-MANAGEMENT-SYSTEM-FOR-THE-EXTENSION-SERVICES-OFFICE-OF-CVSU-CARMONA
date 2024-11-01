<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Project extends Model
{
    protected $table = 'projects';
    use SoftDeletes;
    use HasFactory;
    protected $fillable = [
        'projecttitle',
        'projectleader',
        'program_id',
        'projectstartdate',
        'projectenddate',
        'department',
        'calendaryear',
        'fiscalyear',
        'projectstatus'
    ];
    public function users()
    {
        return $this->belongsToMany(User::class, 'project_user');
    }
    public function objectives()
    {
        return $this->hasMany(Objective::class);
    }
    public function activities()
    {
        return $this->hasMany(Activity::class);
    }
    public function projects()
    {
        return $this->hasMany(Project::class);
    }
    public function projectleaders()
    {
        return $this->belongsToMany(User::class, 'project_leaders');
    }
    public function programleaders()
    {
        return $this->belongsToMany(User::class, 'program_leaders');
    }
}
