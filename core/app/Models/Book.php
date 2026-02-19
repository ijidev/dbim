<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Book extends Model
{
    use HasFactory;

    protected $fillable = [
        'instructor_id',
        'title',
        'slug',
        'author',
        'description',
        'cover_image',
        'content',
        'price',
        'is_free',
        'category',
        'pages',
        'status',
        'product_id',
    ];

    public function collections()
    {
        return $this->hasMany(UserBookCollection::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function isOwnedBy($user)
    {
        if (!$user) return false;
        if ($this->is_free) {
            return $this->collections()->where('user_id', $user->id)->exists();
        }
        return $this->collections()->where('user_id', $user->id)->where('purchased', true)->exists();
    }

    public function instructor()
    {
        return $this->belongsTo(User::class, 'instructor_id');
    }

    protected $casts = [
        'price' => 'decimal:2',
        'is_free' => 'boolean',
        'status' => 'boolean',
    ];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($book) {
            if (empty($book->slug)) {
                $book->slug = Str::slug($book->title);
            }
        });
    }

    public function chapters()
    {
        return $this->hasMany(BookChapter::class)->orderBy('order');
    }

    /**
     * Get the cover image URL, handling both 'library' disk and legacy admin uploads.
     */
    public function getCoverUrlAttribute(): ?string
    {
        if (!$this->cover_image) return null;
        // Admin BookController stores as "assets/images/books/file.jpg" (relative to public)
        if (str_starts_with($this->cover_image, 'assets/')) {
            return asset($this->cover_image);
        }
        // InstructorLibraryController stores via 'library' disk => /assets/books/covers/...
        return asset('assets/' . ltrim($this->cover_image, '/'));
    }

    public function progress()
    {
        return $this->hasMany(UserBookProgress::class);
    }

    public function getProgressPercentage($user): int
    {
        if (!$user) return 0;
        $progress = $this->progress()->where('user_id', $user->id)->first();
        return $progress ? $progress->percentage_complete : 0;
    }
}
