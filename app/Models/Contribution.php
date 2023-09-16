<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Contribution extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table = 'contributions';

    protected $fillable = [
        'subtask_id',
        'date',
        'hours_rendered',
        'approval',
        'contributor_id',
        'submitter_id',

    ];

    public function users()
    {
        return $this->belongsToMany(User::class, 'subtaskcontributions_users');
    }

    public function subtask()
    {
        return $this->belongsTo(Subtask::class, 'subtasks');
    }
}
