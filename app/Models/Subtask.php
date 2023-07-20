<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subtask extends Model
{
    use HasFactory;
    protected $fillable = ['subtask_name', 'activity_id', 'project_id'];

    public function activity()
    {
        return $this->belongsTo(Activity::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'subtask_user');
    }

    public function project()
    {
        return $this->belongsTo(Project::class);
    }
}
