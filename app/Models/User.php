<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */

    protected $fillable = [
        'name',
        'username',
        'email',
        'password',
        'department',
        'middle_name',
        'last_name',
        'approval',
        'role'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    public function projects()
    {
        return $this->belongsToMany(Project::class, 'project_user');
    }
    public function activities()
    {
        return $this->belongsToMany(Activity::class);
    }
    public function outputs()
    {
        return $this->belongsToMany(Output::class);
    }
    public function subtasks()
    {
        return $this->belongsToMany(Subtask::class, 'subtask_user');
    }
    public function contributions()
    {
        return $this->belongsToMany(Contribution::class, 'subtaskcontributions_users');
    }

    public function activitycontributions()
    {
        return $this->belongsToMany(activityContribution::class, 'activitycontributions_users', 'user_id', 'activitycontribution_id');
    }
    // User.php
    public function notifications()
    {
        return $this->hasMany(Notification::class);
    }
    public function leadingprojects()
    {
        return $this->belongsToMany(Project::class, 'project_leaders');
    }
    public function leadingprograms()
    {
        return $this->belongsToMany(Project::class, 'program_leaders');
    }
    public function scheduledSubtasks()
    {
        return $this->belongsToMany(Subtask::class, 'scheduled_tasks')
            ->withPivot('scheduledDate');
    }
}
