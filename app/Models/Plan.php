<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Plan extends Model
{

    // use HasFactory;
    protected $table = 'book_plans';
    protected $primaryKey = 'book_plan_id';
    protected $fillable = ['total_price', 'name', 'description'];

    public const CREATE_RULES = [
        'total_price' => 'required|numeric',
        'name' => 'required|min:2',
        'description' => 'required',
    ];

    public const CREATE_MESSAGES = [
        'total_price.required' => 'The price cannot be empty.',
        'total_price.numeric' => 'The price must be a numerical value.',
        'name.required' => 'The name cannot be empty.',
        'name.min' => 'The name must be at least 2 characters.',
        'description.required' => 'The description cannot be empty.',
    ];
}