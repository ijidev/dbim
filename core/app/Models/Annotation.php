<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Annotation extends Model
{
    protected $fillable = [
        'user_id',
        'book_id',
        'chapter_id',
        'annotation_id',
        'type',
        'text',
        'note',
        'color',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function book()
    {
        return $this->belongsTo(Book::class);
    }

    public function chapter()
    {
        return $this->belongsTo(BookChapter::class, 'chapter_id');
    }
}
