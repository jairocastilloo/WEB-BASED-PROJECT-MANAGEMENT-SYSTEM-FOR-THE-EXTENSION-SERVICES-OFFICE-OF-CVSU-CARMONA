<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;
    protected $fillable = [
        'projecttitle',
        'projectleader',
        'programtitle',
        'programleader',
        'projectstartdate',
        'projectenddate',
    ];
    public function users()
    {
        return $this->belongsToMany(User::class, 'project_user');
    }
    public function objectives()
    {
        return $this->hasMany(Objective::class);
    }
    public function activities()
    {
        return $this->hasMany(Activity::class);
    }
}
