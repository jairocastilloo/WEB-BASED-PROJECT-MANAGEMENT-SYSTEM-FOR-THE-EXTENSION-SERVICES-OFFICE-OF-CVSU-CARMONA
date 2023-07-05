<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Output extends Model
{
    use HasFactory;
    protected $table = 'outputs';

    public function activity()
    {
        return $this->belongsTo(Activity::class);
    }
    public function project()
    {
        return $this->belongsTo(Project::class);
    }
}
