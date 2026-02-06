<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $fillable = [
        'title',
        'description',
        'image',
        'location',
        'time',
        'date',
        'day',
        'month',
        'year',
        'status',
        'end_time',
        'end_date',
        'recurrence',
        'type',
        'extra_dates',
        'loop_extra_dates'
    ];
    use HasFactory;

    public function registrations()
    {
        return $this->hasMany(EventRegistration::class);
    }
}
