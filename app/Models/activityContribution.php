<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class activityContribution extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table = 'activity_contributions';

    protected $fillable = [
        'activity_id',
        'startdate',
        'enddate',
        'hours_rendered',
        'approval',
        'submitter_id',
        'notes',
        'relatedPrograms',
            'clientNumbers',
           'agency',
    ];

    public function users()
    {
        return $this->belongsToMany(User::class, 'activitycontributions_users', 'user_id', 'activitycontribution_id');
    }
}
