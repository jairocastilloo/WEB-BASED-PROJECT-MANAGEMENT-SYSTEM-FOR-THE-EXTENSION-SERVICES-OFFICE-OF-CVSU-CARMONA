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
    ];

    public function output()
    {
<<<<<<< HEAD
        return $this->belongsTo(Output::class);
=======
        return $this->belongsTo(Output::class, 'output_id');
>>>>>>> origin/main
    }

    public function user()
    {
<<<<<<< HEAD
        return $this->belongsTo(User::class);
=======
        return $this->belongsTo(User::class, 'user_id');
>>>>>>> origin/main
    }
}
