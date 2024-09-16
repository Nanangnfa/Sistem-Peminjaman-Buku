<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Category;
use Illuminate\Http\Request;

class PublicController extends Controller
{
    public function index(Request $request)
    {
        // ambli kategori untuk filter search
        $categories = Category::all();

        // sorting by pencarian
        if ($request->category || $request->title) {
            // pencarian berdasarkan title
            $books = Book::where('title', 'like', '%'.$request->title.'%')
                        // pencarian berdasarkan categori
                        ->orWhereHas('categories', function($q) use($request) {
                            $q->where('categories.id', $request->category);
                        })
                        ->get();
        }
        else {
            // tanpa pencarian buku muncul semua
            $books = Book::all();
        }

        // oper ke blade(tampilan) diisi dengan variabel books/data yang akan dibuat dinamis
        return view('book-list', ['books' => $books, 'categories' => $categories]);
    }
}
