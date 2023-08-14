<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ActivitycontributionsUser extends Model
{
    use HasFactory;

    protected $table = 'activitycontributions_users';

    protected $fillable = [
        'activitycontribution_id',
        'user_id',
    ];

    public function activitycontribution()
    {
        return $this->belongsTo(activityContribution::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
