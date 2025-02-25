<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Book;
use Illuminate\Support\Facades\Storage;

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

    public function booksManagement()
    {
        $books = Book::all();
        return view('shop.book_management', [
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
                'image' => 'required',
                'author' => 'required',
                'genre_fk' => 'required',
            ],
            [
                'title.required' => 'The title cannot be empty.',
                'title.min' => 'The title must be at least 2 characters.',
                'synopsis.required' => 'The synopsis cannot be empty.',
                'price.required' => 'The price cannot be empty.',
                'price.numeric' => 'The price must be a numerical value.',
                'image.required' => 'You have to add an image.',
                'author.required' => 'You must specify the author.',
            ]
        );

        $input = $request->all();

        // so we can store images
        // if ($request->hasFile('image')) {
        //     $input['image'] = $request->file('image')->store('images', 'public');
        // }

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $fileName = $file->hashName(); // Genera un nombre único
            $file->storeAs('books', $fileName); // Guarda en storage/app/public/images
            $input['image'] = $fileName; // Guarda solo el nombre en la BD
        }

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

    public function destroy(int $id)
    {
        $books = Book::findOrFail($id);

        if ($books->image && Storage::exists('books/' . $books->image)) {
            Storage::delete('books/' . $books->image);
        }

        $books->delete($id);

        // if (
        //     $books->image &&
        //     Storage::has($books->image)
        // ) {
        //     Storage::delete($books->image);
        // }

        return redirect()
            ->route('shop.management')
            ->with('feedback.message', 'The book <b>"' . e($books['title']) . '"</b> was deleted successfully');
    }

    public function delete(int $id)
    {
        return view('shop.book_delete', [
            'books' => Book::findOrFail($id),
        ]);
    }

    public function edit(int $id)
    {
        return view('shop.book_edit', [
            'books' => Book::findOrFail($id),
        ]);
    }

    public function update(Request $request, int $id)
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
                'genre_fk.required' => 'You have to choose the genre.',
            ]
        );

        $books = Book::findOrFail($id);

        $input = $request->except(['_token', '_method']);
        $oldImage = $books->image;

        // if ($request->hasFile('image')) {
        //     $input['image'] = $request->file('image')->store('images', 'public');
        // }

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $fileName = $file->hashName();
            $file->storeAs('books', $fileName);
            $input['image'] = $fileName;

            if ($oldImage && Storage::exists('books/' . $oldImage)) {
                Storage::delete('books/' . $oldImage);
            }
        }

        $books->update($input);
        //check this later
        // $books->genre()->sync($request->input('genre_id', []));

        // if (
        //     $request->hasFile('image') &&
        //     $oldImage &&
        //     Storage::has($oldImage)
        // ) {
        //     Storage::delete($oldImage);
        // }

        return redirect()
            ->route('shop.management')
            ->with('feedback.message', 'The Book <b>"' . e($books->title) . '"</b> was updated successfully');
    }
}
