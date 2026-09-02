<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Queue extends Model
{
    protected $table = 'queues';

    protected $fillable = [
        'user_id',
        'department',
        'ticket_number',
        'status',
        'is_active'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
