<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OutputUser extends Model
{
    use HasFactory;

    protected $table = 'output_user';

    protected $fillable = [
        'output_id',
        'user_id',
        'output_submitted',
        'approval',
        'actcontribution_id'
    ];

    public function output()
    {
        return $this->belongsTo(Output::class, 'output_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
