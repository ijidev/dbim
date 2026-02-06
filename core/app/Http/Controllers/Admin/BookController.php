<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Book;
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

        Book::create($data);

        return redirect()->route('admin.books.index')->with('success', 'Book added successfully!');
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
}
