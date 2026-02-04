<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;

class LibraryController extends Controller
{
    public function index()
    {
        $books = Book::where('status', true)->paginate(12);
        return view('frontend.library.index', compact('books'));
    }

    public function read($slug)
    {
        $book = Book::where('slug', $slug)->firstOrFail();
        return view('frontend.library.read', compact('book'));
    }
}
