<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Meeting extends Model
{
    protected $fillable = [
        'host_id',
        'title',
        'description',
        'room_code',
        'scheduled_at',
        'type',
        'status',
        'is_public',
    ];

    protected $casts = [
        'scheduled_at' => 'datetime',
    ];

    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($meeting) {
            if (empty($meeting->room_code)) {
                $meeting->room_code = strtoupper(Str::random(3) . '-' . Str::random(4) . '-' . Str::random(3));
            }
        });
    }

    public function host()
    {
        return $this->belongsTo(User::class, 'host_id');
    }
}
