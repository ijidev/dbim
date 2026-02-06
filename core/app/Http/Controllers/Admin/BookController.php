<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\BookChapter;
use App\Models\Setting;
use Illuminate\Http\Request;

class BookController extends Controller
{
    public function index()
    {
        $books = Book::latest()->paginate(15);
        return view('admin.books.index', compact('books'));
    }

    public function create()
    {
        return view('admin.books.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'description' => 'nullable|string',
            'content' => 'required|string',
            'cover_image' => 'nullable|image|max:2048',
            'price' => 'required_if:is_free,0|numeric|min:0',
            'category' => 'nullable|string|max:255',
            'pages' => 'nullable|integer|min:1',
        ]);

        $data = $request->only(['title', 'author', 'description', 'content', 'category', 'pages', 'price']);
        $data['slug'] = \Str::slug($request->title);
        $data['status'] = $request->has('status') || $request->has('is_published');
        $data['is_free'] = $request->is_free == 1;

        if ($request->hasFile('cover_image')) {
            $path = base_path('../assets/images/books');
            if (!file_exists($path)) {
                mkdir($path, 0777, true);
            }
            $imageName = time().'.'.$request->cover_image->extension();  
            $request->cover_image->move($path, $imageName);
            $data['cover_image'] = 'assets/images/books/'.$imageName;
        }

        $book = Book::create($data);

        return redirect()->route('admin.books.edit', $book->id)->with('success', 'Manuscript initialized! Now you can add chapters.');
    }

    public function edit(Book $book)
    {
        return view('admin.books.edit', compact('book'));
    }

    public function update(Request $request, Book $book)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'description' => 'nullable|string',
            'content' => 'required|string',
            'cover_image' => 'nullable|image|max:2048',
            'price' => 'required_if:is_free,0|numeric|min:0',
            'category' => 'nullable|string|max:255',
            'pages' => 'nullable|integer|min:1',
        ]);

        $data = $request->only(['title', 'author', 'description', 'content', 'category', 'pages', 'price']);
        $data['slug'] = \Str::slug($request->title);
        $data['status'] = $request->has('status') || $request->has('is_published');
        $data['is_free'] = $request->has('is_free');

        if ($request->hasFile('cover_image')) {
            $path = base_path('../assets/images/books');
            if (!file_exists($path)) {
                mkdir($path, 0777, true);
            }
            $imageName = time().'.'.$request->cover_image->extension();  
            $request->cover_image->move($path, $imageName);
            $data['cover_image'] = 'assets/images/books/'.$imageName;
        }

        $book->update($data);

        return redirect()->route('admin.books.index')->with('success', 'Book updated successfully!');
    }

    public function destroy(Book $book)
    {
        $book->delete();
        return redirect()->route('admin.books.index')->with('success', 'Book deleted.');
    }

    // Chapter Management
    public function storeChapter(Request $request, Book $book)
    {
        $request->validate(['title' => 'required|string|max:255']);
        
        $order = $book->chapters()->max('order') + 1;
        $chapter = $book->chapters()->create([
            'title' => $request->title,
            'slug' => \Str::slug($request->title),
            'order' => $order,
            'content' => '',
        ]);

        return response()->json($chapter);
    }

    public function updateChapter(Request $request, BookChapter $chapter)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'nullable|string',
        ]);

        $chapter->update([
            'title' => $request->title,
            'slug' => \Str::slug($request->title),
            'content' => $request->content,
        ]);

        return response()->json(['success' => true]);
    }

    public function deleteChapter(BookChapter $chapter)
    {
        $chapter->delete();
        return response()->json(['success' => true]);
    }

    public function getChapter(BookChapter $chapter)
    {
        return response()->json($chapter);
    }

    public function reorderChapters(Request $request)
    {
        $request->validate(['orders' => 'required|array']);
        
        foreach ($request->orders as $id => $order) {
            BookChapter::where('id', $id)->update(['order' => $order]);
        }

        return response()->json(['success' => true]);
    }

    public function settings()
    {
        $wisdom = Setting::where('key', 'library_wisdom_text')->first()?->value ?? '';
        $author = Setting::where('key', 'library_wisdom_author')->first()?->value ?? '';
        return view('admin.books.settings', compact('wisdom', 'author'));
    }

    public function updateSettings(Request $request)
    {
        $request->validate([
            'wisdom_text' => 'required|string',
            'wisdom_author' => 'required|string',
        ]);

        Setting::updateOrCreate(['key' => 'library_wisdom_text'], ['value' => $request->wisdom_text]);
        Setting::updateOrCreate(['key' => 'library_wisdom_author'], ['value' => $request->wisdom_author]);

        return redirect()->back()->with('success', 'Library settings updated.');
    }
}
