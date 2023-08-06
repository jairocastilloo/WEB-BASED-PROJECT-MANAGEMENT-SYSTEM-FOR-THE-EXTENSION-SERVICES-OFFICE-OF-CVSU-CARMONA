<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubtaskUser extends Model
{
    use HasFactory;
    protected $table = 'subtask_user';

    protected $fillable = [
        'subtask_id',
        'user_id',
    ];

    public function subtask()
    {
        return $this->belongsTo(Subtask::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
