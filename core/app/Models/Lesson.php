<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lesson extends Model
{
    use HasFactory;

    protected $fillable = [
        'module_id',
        'title',
        'type',
        'video_url',
        'content',
        'live_url',
        'is_free',
        'order',
    ];

    public function module()
    {
        return $this->belongsTo(Module::class);
    }
}
