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
        'visibility',
        'price',
        'max_participants',
        'allowed_student_ids',
        'attended_student_ids',
    ];

    protected $casts = [
        'scheduled_at' => 'datetime',
        'allowed_student_ids' => 'array',
        'attended_student_ids' => 'array',
    ];

    public function isPaid($user)
    {
        if (!$user) return false;
        if ($this->price <= 0) return true;
        if ($this->host_id === $user->id) return true;
        return in_array($user->id, $this->allowed_student_ids ?? []);
    }

    public function isLive()
    {
        return $this->status === 'active';
    }

    public function hasExpired()
    {
        // Expired if scheduled time passed and meeting not active/ended
        return $this->scheduled_at && $this->scheduled_at->isPast() && !in_array($this->status, ['active', 'ended']);
    }

    public function wasAttended($user)
    {
        if (!$user) return false;
        return in_array($user->id, $this->attended_student_ids ?? []);
    }

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
