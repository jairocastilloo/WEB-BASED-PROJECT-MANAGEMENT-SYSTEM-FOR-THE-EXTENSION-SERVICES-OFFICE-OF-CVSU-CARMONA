<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',    // User who receives the notification
        'message',    // Notification message
        'read_at',    // Timestamp when the notification is read
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
