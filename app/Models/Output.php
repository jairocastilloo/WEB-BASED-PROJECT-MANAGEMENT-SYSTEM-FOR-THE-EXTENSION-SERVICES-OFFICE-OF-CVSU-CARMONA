<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Output extends Model
{
    use HasFactory;
    protected $table = 'outputs';

    protected $fillable = [
        'output_name',
        'output_type',
        'activity_id',
        'totaloutput_submitted',
        'expectedoutput',
    ];

    public function activity()
    {
        return $this->belongsTo(Activity::class);
    }
    public function project()
    {
        return $this->belongsTo(Project::class);
    }
    public function users()
    {
        return $this->belongsToMany(User::class);
    }
}
