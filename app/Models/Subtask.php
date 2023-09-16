<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subtask extends Model
{
    use HasFactory;
<<<<<<< HEAD
    protected $fillable = ['subtask_name', 'activity_id', 'substartdate', 'subenddate'];
=======
    protected $fillable = ['subtask_name', 'activity_id', 'subduedate'];
>>>>>>> origin/main

    public function activity()
    {
        return $this->belongsTo(Activity::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'subtask_user');
    }
}
