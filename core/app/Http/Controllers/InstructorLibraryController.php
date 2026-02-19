<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class InstructorLibraryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $books = Book::where('instructor_id', Auth::id())
            ->withCount('chapters')
            ->latest()
            ->paginate(12);

        return view('frontend.instructor.library.index', compact('books'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('frontend.instructor.library.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'description' => 'nullable|string',
            'cover_image' => 'nullable|image|max:2048',
            'price' => 'nullable|numeric|min:0',
            'pages' => 'nullable|integer|min:0',
            'category' => 'nullable|string',
        ]);

        $book = new Book();
        $book->fill($request->only(['title', 'author', 'description', 'price', 'pages', 'category']));
        $book->instructor_id = Auth::id();
        $book->slug = Str::slug($request->title) . '-' . Str::random(6);
        $book->is_free = $request->has('is_free');
        $book->status = $request->has('status');

        if ($request->hasFile('cover_image')) {
            $path = $request->file('cover_image')->store('books/covers', 'library');
            $book->cover_image = $path;
        }

        $book->save();

        // Phase 2: Auto-create predefined first chapter "Introduction"
        $book->chapters()->create([
            'title' => 'Introduction',
            'slug' => 'introduction-' . Str::random(6),
            'content' => '<p>Welcome to <strong>' . $book->title . '</strong>. Start your journey here...</p>',
            'order' => 1,
        ]);

        if ($request->action === 'next') {
            return redirect()->route('instructor.library.chapters', $book->id)->with('success', 'Book created! Now let\'s build chapters.');
        }

        return redirect()->route('instructor.library.index')->with('success', 'Book saved as draft.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $book = Book::where('instructor_id', Auth::id())->findOrFail($id);
        return view('frontend.instructor.library.edit', compact('book'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $book = Book::where('instructor_id', Auth::id())->findOrFail($id);

        $request->validate([
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'category' => 'required|string',
            'pages' => 'required|integer|min:1',
            'cover_image' => 'nullable|image|max:2048',
        ]);

        $book->fill($request->only(['title', 'author', 'description', 'price', 'pages', 'category']));
        $book->is_free = $request->has('is_free');
        $book->status = $request->has('status');

        if ($request->hasFile('cover_image')) {
            if ($book->cover_image) {
                Storage::disk('library')->delete($book->cover_image);
            }
            $path = $request->file('cover_image')->store('books/covers', 'library');
            $book->cover_image = $path;
        }

        $book->save();

        if ($request->action === 'next') {
            return redirect()->route('instructor.library.chapters', $book->id)->with('success', 'Changes saved! Transitioning to Chapter Builder.');
        }

        return redirect()->route('instructor.library.index')->with('success', 'Book updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $book = Book::where('instructor_id', Auth::id())->findOrFail($id);

        if ($book->cover_image) {
            Storage::disk('library')->delete($book->cover_image);
        }

        $book->delete();

        return redirect()->back()->with('success', 'Book and associated data deleted.');
    }

    public function publish($id)
    {
        $book = Book::where('instructor_id', Auth::id())->findOrFail($id);
        
        if ($book->chapters()->count() === 0) {
            return redirect()->back()->with('error', 'You cannot publish a book with no chapters.');
        }

        $book->update(['status' => true]);

        return redirect()->route('instructor.library.index')->with('success', 'Congratulations! Your book has been published.');
    }

    /**
     * Manage book chapters.
     */
    public function chapters($id)
    {
        $book = Book::where('instructor_id', Auth::id())
            ->with(['chapters' => function($query) {
                $query->orderBy('order', 'asc');
            }])
            ->findOrFail($id);

        return view('frontend.instructor.library.chapters', compact('book'));
    }

    public function storeChapter(Request $request, $bookId)
    {
        $book = Book::where('instructor_id', Auth::id())->findOrFail($bookId);

        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'nullable|string',
            'order' => 'required|integer',
        ]);

        $chapterCount = $book->chapters()->count();
        $chapterNumber = $chapterCount; // Since Introduction is Chapter 0 or just 1st in order
        
        // Enforce naming sequence: "Chapter {no}: {title}"
        // If it's the first one after Introduction (which is order 1), it's Chapter One
        $numberWords = ['One', 'Two', 'Three', 'Four', 'Five', 'Six', 'Seven', 'Eight', 'Nine', 'Ten'];
        $noLabel = ($chapterNumber <= 10) ? $numberWords[$chapterNumber - 1] : $chapterNumber;
        
        $finalTitle = "Chapter {$noLabel}: " . $request->title;

        $chapter = $book->chapters()->create([
            'title' => $finalTitle,
            'slug' => Str::slug($finalTitle) . '-' . Str::random(6),
            'content' => $request->content,
            'order' => $request->order,
        ]);

        if ($request->expectsJson()) {
            return response()->json(['success' => true, 'chapter' => $chapter]);
        }

        return redirect()->back()->with('success', 'Chapter added successfully.');
    }

    public function updateChapter(Request $request, $bookId, $chapterId)
    {
        $book = Book::where('instructor_id', Auth::id())->findOrFail($bookId);
        $chapter = $book->chapters()->findOrFail($chapterId);

        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'nullable|string',
            'order' => 'required|integer',
        ]);

        $chapter->update([
            'title' => $request->title,
            'content' => $request->content,
            'order' => $request->order,
        ]);

        if ($request->expectsJson()) {
            return response()->json(['success' => true, 'chapter' => $chapter]);
        }

        return redirect()->back()->with('success', 'Chapter updated successfully.');
    }

    public function destroyChapter($bookId, $chapterId)
    {
        $book = Book::where('instructor_id', Auth::id())->findOrFail($bookId);
        $chapter = $book->chapters()->findOrFail($chapterId);

        $chapter->delete();

        if (request()->expectsJson()) {
            return response()->json(['success' => true]);
        }

        return redirect()->back()->with('success', 'Chapter deleted successfully.');
    }
}
