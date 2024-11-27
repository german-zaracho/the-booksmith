<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class News extends Model
{

    // use HasFactory;
    protected $table = 'news';
    protected $primaryKey = 'news_id';
    protected $fillable = ['title', 'description', 'img'];

    public const CREATE_RULES = [
        'title' => 'required|min:2',
        'description' => 'required',
        'img' => 'required',
    ];

    public const CREATE_MESSAGES = [
        'title.required' => 'The title cannot be empty.',
        'title.min' => 'The title must be at least 2 characters.',
        'description.required' => 'The description cannot be empty.',
        'img.required' => 'You have to add an image.',
    ];

}
