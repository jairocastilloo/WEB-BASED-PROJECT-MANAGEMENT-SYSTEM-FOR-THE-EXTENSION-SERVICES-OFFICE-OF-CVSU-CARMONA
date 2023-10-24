<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Objective extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'project_id',
        'objectiveset_id'
    ];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }
}
