<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Book;

class ShopController extends Controller
{
    public function shop()
    {
        $books = Book::all();
        return view('shop.shop', [
            'books' => $books
        ]);
    }

    public function bookDetails($id)
    {
        $books = Book::findOrFail($id);
        return view('shop.book_details', [
            'books' => $books
        ]);
    }

    public function create()
    {
        return view('shop.shop_create');
    }

    public function store(Request $request)
    {
        $request->validate(
            [
                'title' => 'required|min:2',
                'synopsis' => 'required',
                'editorial' => 'required',
                'price' => 'required|numeric',
                'image' => 'nullable',
                'author' => 'required',
                'genre_fk' => 'required',
            ],
            [
                'title.required' => 'The title cannot be empty.',
                'title.min' => 'The title must be at least 2 characters.',
                'synopsis.required' => 'The synopsis cannot be empty.',
                'price.required' => 'The price cannot be empty.',
                'price.numeric' => 'The price must be a numerical value.',
                // 'image.required' => 'You have to add an image.',
                'author.required' => 'You must specify the author.',
            ]
        );

        $input = $request->all();

        Book::create($input);
        // $book = new Book();
        // $book->title = $input['title'];
        // $book->synopsis = $input['synopsis'];
        // $book->editorial = $input['editorial'];
        // $book->price = $input['price'];
        // $book->image = $input['image'];
        // $book->author = $input['author'];
        // $book->genre_fk = $input['genre_fk'];
        // $book->save();

        return redirect()
            ->route('shop')
            ->with('feedback.message', 'The book <b>' . e($input['title']) . '</b> was uploaded successfully');
    }
}
