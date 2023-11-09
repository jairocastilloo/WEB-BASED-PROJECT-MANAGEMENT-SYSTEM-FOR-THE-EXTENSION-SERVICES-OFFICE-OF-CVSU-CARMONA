<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ScheduledTasks extends Model
{

    use HasFactory;
    protected $table = 'scheduled_tasks'; // Specify the table name if it's different from the default naming convention
    protected $fillable = [
        'subtask_id',
        'user_id',
        'scheduledDate'
    ];
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function subtask()
    {
        return $this->belongsTo(Subtask::class, 'subtask_id');
    }
}
