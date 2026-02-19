<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookChapter extends Model
{
    use HasFactory;

    protected $fillable = [
        'book_id',
        'title',
        'slug',
        'content',
        'order',
    ];

    public function getWordCountAttribute(): int
    {
        return str_word_count(strip_tags($this->content));
    }

    public function getPageCountAttribute(): int
    {
        $words = $this->word_count;
        return max(1, ceil($words / 270));
    }

    public function book()
    {
        return $this->belongsTo(Book::class);
    }
}
