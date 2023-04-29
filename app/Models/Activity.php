<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    use HasFactory;
    protected $fillable = [
        'actname',
        'actobjectives',
        'actoutput',
        'actstartdate',
        'actenddate',
        'actbudget',
        'actsource'
    ];
    public function project()
    {
        return $this->belongsTo(Project::class);
    }
}
