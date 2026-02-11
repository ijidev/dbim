<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'thumbnail',
        'price',
        'instructor_id',
        'is_published',
    ];

    public function instructor()
    {
        return $this->belongsTo(User::class, 'instructor_id');
    }

    public function modules()
    {
        return $this->hasMany(Module::class)->orderBy('order');
    }

    public function enrollments()
    {
        return $this->hasMany(Enrollment::class);
    }
    
    public function students()
    {
        return $this->belongsToMany(User::class, 'enrollments');
    }

    public function getThumbnailUrlAttribute()
    {
        if ($this->thumbnail && (str_starts_with($this->thumbnail, 'http') || file_exists(public_path($this->thumbnail)))) {
            return str_starts_with($this->thumbnail, 'http') ? $this->thumbnail : asset($this->thumbnail);
        }
        
        return 'https://images.unsplash.com/photo-1544716278-ca5e3f4abd8c?w=600&h=400&fit=crop';
    }
}
