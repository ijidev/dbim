<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;

class LibraryController extends Controller
{
    public function index(Request $request)
    {
        $query = Book::where('status', true);

        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('title', 'like', '%' . $request->search . '%')
                  ->orWhere('author', 'like', '%' . $request->search . '%')
                  ->orWhere('description', 'like', '%' . $request->search . '%');
            });
        }

        if ($request->filled('category') && $request->category !== 'all') {
            $query->where('category', $request->category);
        }

        $books = $query->latest()->paginate(12);
        return view('frontend.library.index', compact('books'));
    }

    public function read($slug)
    {
        $book = Book::where('slug', $slug)->firstOrFail();
        return view('frontend.library.read', compact('book'));
    }
}
