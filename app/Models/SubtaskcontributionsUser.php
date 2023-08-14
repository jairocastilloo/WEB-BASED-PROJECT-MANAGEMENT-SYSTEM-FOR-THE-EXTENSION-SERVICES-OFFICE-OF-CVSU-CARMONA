<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubtaskcontributionsUser extends Model
{
    use HasFactory;
    protected $table = 'subtaskcontributions_users';

    protected $fillable = [
        'contribution_id',
        'user_id',
    ];

    public function subtaskcontributions()
    {
        return $this->belongsTo(Contribution::class);
    }

    public function users()
    {
        return $this->belongsTo(User::class);
    }
}
