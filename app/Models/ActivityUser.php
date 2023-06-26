<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ActivityUser extends Model
{
    use HasFactory;

    protected $table = 'activity_user';

    protected $fillable = [
        'activity_id',
        'user_id',
        'project_id',
        'assignees_name',
    ];

    public function activity()
    {
        return $this->belongsTo(Activity::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
