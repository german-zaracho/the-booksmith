<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Book extends Model
{

    // use HasFactory;
    protected $table = "books";
    protected $primaryKey = "book_id";
    protected $fillable = ['title', 'synopsis', 'editorial', 'price', 'image', 'author', 'genre_fk'];

    public const CREATE_RULES = [
        'title' => 'required|min:2',
        'synopsis' => 'required',
        'editorial' => 'required',
        'price' => 'required|numeric',
        'image' => 'required',
        'author' => 'required',
        'genre_fk' => 'required',
    ];

    public const CREATE_MESSAGES = [
        'title.required' => 'The title cannot be empty.',
        'title.min' => 'The title must be at least 2 characters.',
        'synopsis.required' => 'The synopsis cannot be empty.',
        'price.required' => 'The price cannot be empty.',
        'price.numeric' => 'The price must be a numerical value.',
        'image.required' => 'You have to add an image.',
        'author.required' => 'You must specify the author.',
        'genre_fk.required' => 'You have to choose the genre.',
    ];

    protected function price(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => $value / 100,
            set: fn ($value) => $value * 100
        );
    }


    public function genre(): BelongsTo
    {
        return $this->belongsTo(Genre::class, 'genre_fk', 'genre_id');
    }

}

