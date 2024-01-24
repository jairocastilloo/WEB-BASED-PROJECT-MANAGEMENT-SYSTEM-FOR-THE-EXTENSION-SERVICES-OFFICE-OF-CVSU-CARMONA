<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Program extends Model
{
    use SoftDeletes;
    use HasFactory;
    protected $fillable = [
        'startDate',
        'endDate',
        'programName',
        'status',
        'department'
    ];
    public function projects()
    {
        return $this->hasMany(Project::class);
    }
    public function program()
{
    return $this->belongsTo(Program::class);
}
    public function programleaders()
    {
        return $this->belongsToMany(User::class, 'program_leaders');
    }
}
