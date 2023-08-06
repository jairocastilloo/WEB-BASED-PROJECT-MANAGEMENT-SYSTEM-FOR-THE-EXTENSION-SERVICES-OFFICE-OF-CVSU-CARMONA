<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubtaskContributor extends Model
{
    use HasFactory;
    protected $table = 'subtask_contributor';

    protected $fillable = [
        'subtask_id',
        'user_id',
        'activity_id',
        'hours_rendered',
    ];

    public function subtask()
    {
        return $this->belongsTo(Subtask::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
