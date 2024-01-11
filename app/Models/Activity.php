<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;

class Activity extends Model
{
    use SoftDeletes;
    use HasFactory;
    protected $fillable = [
        'actname',
        'actobjectives',
        'actoutput',
        'actstartdate',
        'actenddate',
        'actbudget',
        'actsource',
        'totalhours_rendered',
        'subtask',
        'project_id',
        'actremark',

    ];
    public function project()
    {
        return $this->belongsTo(Project::class);
    }
    public function users()
    {
        return $this->belongsToMany(User::class);
    }
    public function subtasks()
    {
        return $this->hasMany(Subtask::class);
    }
    public function expectedoutputs()
    {
        return $this->hasMany(ExpectedOutput::class);
    }
    public function activitybudgets()
    {
        return $this->hasMany(ActivityBudget::class);
    }
}
