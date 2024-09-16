<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Category;
use Illuminate\Http\Request;

class BookController extends Controller
{
    public function index()
    {
        $books = Book::all();
        return view('book', ['books' => $books]);
    }

    public function add()
    {
        $categories = Category::all();
        return view('book-add', ['categories' => $categories]);
    }

    public function store(Request $request)
    {
        // MELIHAT DATA dd($request->all());
        // supaya code buku tidak boleh sama : unique tabel (books)
        $validated = $request->validate([
            'book_code' => 'required|unique:books|max:255',
            'title' => 'required|max:255'
        ]);

        $newName = '';
        if($request->file('image')) { 

            // menentukan ekstensi file
            $extension = $request->file('image')->getClientOriginalExtension();
            // menamai file photo dengan timestamp
            $newName = $request->title.'-'.now()->timestamp.'.'.$extension;
            // upload file simpen kedalam folder cover
            $request->file('image')->storeAs('cover', $newName);
        }

        // menyimpan file ke kolom cover
        $request['cover'] = $newName;
        $book = Book::create($request->all());
        $book->categories()->sync($request->categories);
        return redirect('books') ->with('status', 'Books Added Successfully');
    }

    public function edit($slug)
    {
        $book = Book::where('slug', $slug)->first();
        // buat category untuk view
        $categories = Category::all();

        // kirim ke view categoriesnya menggunakan array
        return view('book-edit', ['categories' => $categories, 'book' => $book]);
    }

    public function update(Request $request, $slug)
    {
        if($request->file('image')) { 
            $extension = $request->file('image')->getClientOriginalExtension();
            $newName = $request->title.'-'.now()->timestamp.'.'.$extension;
            $request->file('image')->storeAs('cover', $newName);
            $request['cover'] = $newName;
        }        


        $book = Book::where('slug', $slug)->first();
        $book->update($request->all());

        if($request->categories) {
            // jika admin pilih category
            $book->categories()->sync($request->categories);
        }
            // jika admin tidak pilih category
            return redirect('books') ->with('status', 'Books Updated Successfully');
    }

    public function delete($slug)
    {
        $book = Book::where('slug', $slug)->first();
        return view('book-delete', ['book' => $book]);
    }

    public function destroy($slug)
    {
        $book = Book::where('slug', $slug)->first();
        $book->delete();
        return redirect('books') ->with('status', 'Book Deleted Successfully');
    }

    public function deletedBook()
    {
        $deletedBooks = Book::onlyTrashed()->get();
        return view('book-deleted-list', ['deletedBooks' => $deletedBooks]);
    }

    public function restore($slug)
    {
        $book = Book::withTrashed()->where('slug', $slug)->first();
        $book->restore();
        return redirect('books') ->with('status', 'Book Restored Successfully');
    }
}
