<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Department extends Model
{
    protected $table = 'departments';

    protected $fillable = [
        'hospital_id',
        'name',
        'code',
        'location',
        'icon_type',
        'patients_ahead',
        'user_waitTime',
        'wait_status',
    ];

    public function hospital(): BelongsTo
    {
        return $this->belongsTo(Hospital::class);
    }
}
