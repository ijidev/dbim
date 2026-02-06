<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Setting;
use App\Models\UserBookProgress;
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
        
        $wisdomText = Setting::where('key', 'library_wisdom_text')->first()?->value ?? 'Thou hast made us for thyself, O Lord, and our heart is restless until it finds its rest in thee.';
        $wisdomAuthor = Setting::where('key', 'library_wisdom_author')->first()?->value ?? 'ST. AUGUSTINE';
        
        $recentRead = null;
        if (auth()->check()) {
            $recentRead = UserBookProgress::where('user_id', auth()->id())
                ->with('book')
                ->latest('updated_at')
                ->first();
        }

        return view('frontend.library.index', compact('books', 'wisdomText', 'wisdomAuthor', 'recentRead'));
    }

    public function read($slug)
    {
        $book = Book::where('slug', $slug)->with('chapters')->firstOrFail();
        return view('frontend.library.read', compact('book'));
    }

    public function updateProgress(Request $request, Book $book)
    {
        if (!auth()->check()) return response()->json(['error' => 'Unauthorized'], 401);

        $request->validate([
            'chapter_id' => 'required|exists:book_chapters,id',
            'percentage' => 'required|numeric|min:0|max:100',
        ]);

        UserBookProgress::updateOrCreate(
            ['user_id' => auth()->id(), 'book_id' => $book->id],
            [
                'last_chapter_id' => $request->chapter_id,
                'percentage_complete' => $request->percentage,
            ]
        );

        return response()->json(['success' => true]);
    }

    public function getChapterContent($id)
    {
        $chapter = \App\Models\BookChapter::with('book')->findOrFail($id);
        if (!$chapter->book->status) return response()->json(['error' => 'Draft'], 403);
        
        return response()->json($chapter);
    }
}
