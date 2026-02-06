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

    public function book()
    {
        return $this->belongsTo(Book::class);
    }
}
