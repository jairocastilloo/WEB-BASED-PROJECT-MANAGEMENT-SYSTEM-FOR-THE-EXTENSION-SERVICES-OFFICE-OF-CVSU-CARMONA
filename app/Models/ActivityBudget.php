<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ActivityBudget extends Model
{
    use HasFactory;
    protected $fillable = [
        'item',
        'price',
        'activity_id',
    ];

    public function activity()
    {
        return $this->belongsTo(Activity::class);
    }
}
