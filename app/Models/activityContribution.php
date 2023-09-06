<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class activityContribution extends Model
{
    use HasFactory;

    protected $table = 'activity_contributions';

    protected $fillable = [
        'activity_id',
        'startdate',
        'enddate',
        'hours_rendered',
        'approval',
        'submitter_id'
    ];

    public function users()
    {
        return $this->belongsToMany(User::class, 'activitycontributions_users', 'user_id', 'activitycontribution_id');
    }
}
